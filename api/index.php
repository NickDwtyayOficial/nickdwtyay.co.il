<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db_connect.php';

use Dotenv\Dotenv;

// Carrega variáveis de ambiente
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Define ambiente de desenvolvimento
$is_dev = getenv('ENV') === 'development';

// Se o usuário já está logado, redireciona para o dashboard
if (isset($_SESSION['user_id'])) {
    error_log("Usuário já logado - user_id: " . $_SESSION['user_id']);
    header("Location: /api/dashboard.php");
    exit();
}

// Processa o formulário de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields!";
    } else {
        error_log("Tentando login com email: $email");
        $user = db_query("users?email=eq.$email&is_active=eq.true&select=id,password");
        
        if (isset($user['error'])) {
            $error = "We are under maintenance!";
            error_log("Erro no Supabase: " . json_encode($user['error']));
        } elseif (is_array($user) && !empty($user) && password_verify($password, $user[0]['password'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            setcookie('user_id', $user[0]['id'], [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            session_write_close();
            error_log("Login bem-sucedido - user_id: " . $_SESSION['user_id']);
            header("Location: /api/dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
            error_log("Falha no login - Credenciais inválidas para email: $email");
        }
    }
}// Captura o IP real do visitante no Vercel
$visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
if (strpos($visitor_ip, ',') !== false) {
    $visitor_ip = explode(',', $visitor_ip)[0];
}
$visitor_ip = trim($visitor_ip);

// Captura referrer e source
$referrer = $_SERVER['HTTP_REFERER'] ?? 'Nenhum referrer detectado';
$utm_source = $_GET['utm_source'] ?? '';
$source = (stripos($referrer, 'facebook.com') !== false || $utm_source === 'facebook') ? 'facebook' : 'direct';
$is_facebook = ($source === 'facebook');
$is_bitly = (stripos($referrer, 'bitly.com') !== false || stripos($referrer, 'bit.ly') !== false);




// Faz a requisição ao ipinfo.io
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ipinfo_data = @file_get_contents($ipinfo_url);
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
error_log("ipinfo.io URL: " . $ipinfo_url);
error_log("ipinfo.io response: " . ($ipinfo_data ?: "Falha na requisição"));
$initial_latitude = $ipinfo_json['loc'] ? floatval(explode(',', $ipinfo_json['loc'])[0]) : null;
$initial_longitude = $ipinfo_json['loc'] ? floatval(explode(',', $ipinfo_json['loc'])[1]) : null;


// Faz a requisição ao IPQualityScore
$ipqs_key = getenv('IPQS_KEY');
$ipqs_url = "https://ipqualityscore.com/api/json/ip/{$ipqs_key}?ip={$visitor_ip}";
$ipqs_data = @file_get_contents($ipqs_url);
$ipqs_json = $ipqs_data ? json_decode($ipqs_data, true) : [];
error_log("IPQS URL: " . $ipqs_url);
error_log("IPQS response: " . ($ipqs_data ?: "Falha na requisição"));

// Faz a requisição ao ProxyCheck.io
$proxycheck_key = getenv('PROXYCHECK_KEY');
$proxycheck_url = "https://proxycheck.io/v2/{$visitor_ip}?key={$proxycheck_key}&vpn=1";
$proxycheck_data = @file_get_contents($proxycheck_url);
$proxycheck_json = $proxycheck_data ? json_decode($proxycheck_data, true) : [];
error_log("ProxyCheck URL: " . $proxycheck_url);
error_log("ProxyCheck response: " . ($proxycheck_data ?: "Falha na requisição"));

// Verifica Tor
$tor_data = @file_get_contents('https://check.torproject.org/exit-addresses');
$is_tor_confirmed = $tor_data && strpos($tor_data, $visitor_ip) !== false ? "Yes (confirmed by exit node)" : "No";

// Monta as informações iniciais
$visitor_info = [
    "ip" => $visitor_ip,
    "location" => isset($ipinfo_json['city']) ? "{$ipinfo_json['city']}, {$ipinfo_json['region']}, {$ipinfo_json['country']}" : ($ipinfo_data === false ? "ipinfo.io unavailable" : "Unknown"),
    "is_vpn_or_proxy_ipqs" => isset($ipqs_json['proxy']) && ($ipqs_json['proxy'] || $ipqs_json['vpn']) ? "Yes" : ($ipqs_data === false ? "IPQS unavailable" : "No"),
    "is_vpn_or_proxy_proxycheck" => isset($proxycheck_json[$visitor_ip]["proxy"]) && $proxycheck_json[$visitor_ip]["proxy"] === "yes" ? "Yes" : ($proxycheck_data === false ? "ProxyCheck unavailable" : "No"),
    "is_tor" => isset($ipqs_json['tor']) && $ipqs_json['tor'] ? "Yes" : $is_tor_confirmed,
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "browser" => "Unknown",
    "os" => "Unknown",
    "device_vendor" => "Not identified",
    "device_model" => "Not identified",
    "device_type" => "Unknown",
    "device_category" => "Unknown", // mobile, tablet, desktop
    "latitude" => $initial_latitude, // Inicial com IP, atualizado via JS se permitido
    "longitude" => $initial_longitude, // Inicial com IP, atualizado via JS se permitido
    "network_type" => null,
    "downlink" => null,
    "referrer" => $referrer, // Linha 65
    "is_facebook" => $is_facebook, // Linha 66
    "is_bitly" => $is_bitly,
    "visit_time" => date('c')
];

// Salva os dados iniciais no Supabase
$result = db_query('visitors', $visitor_info, 'POST');
if (isset($result['error'])) {
    error_log("Erro ao salvar no Supabase: " . json_encode($result));
}

// Recupera dados do visitante da sessão
$visitor_info = $_SESSION['visitor_info'] ?? [];
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sign in to access exclusive cybersecurity solutions from Nick Dwtyay, Ltd.">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com 'unsafe-inline'; connect-src 'self' https://*.vercel.app https://cloudflareinsights.com https://ipinfo.io https://ipqualityscore.com https://proxycheck.io https://www.google-analytics.com https://stats.g.doubleclick.net; style-src 'self' 'unsafe-inline'; img-src 'self'; font-src 'self';">
    <link rel="icon" href="/api/static/dwtyay_favicon.gif" type="image/gif">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Sign In - Nick Dwtyay, Ltd.</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ua-parser-js/1.0.37/ua-parser.min.js"></script>
    <?php if (!$is_dev): ?>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1922092235705770" crossorigin="anonymous"></script>
        <script defer src="https://static.cloudflareinsights.com/beacon.min.js" data-cf-beacon='{"token": "6d0cf27361a1479bb063deef0eab2482"}'></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-75819753-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-75819753-1');
        </script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5F4Q111FPX"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-5F4Q111FPX');
        </script>
    <?php endif; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
            background-color: #f4f4f4;
        }
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            filter: brightness(70%);
            overflow: hidden;
        }
        .background-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 2%, transparent 2%) 0 0 / 20px 20px;
            opacity: 0.3;
            animation: pulse 10s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.05); opacity: 0.5; }
            100% { transform: scale(1); opacity: 0.3; }
        }
        .top-nav {
            display: flex;
            justify-content: center;
            background-color: rgba(51, 51, 51, 0.9);
            padding: 10px 0;
            position: relative;
            z-index: 1;
        }
        .nav-link {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #555;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .error {
            font-size: 16px;
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: rgba(231, 76, 60, 0.1);
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        .form-group button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
        .form-links {
            text-align: center;
            margin-top: 15px;
        }
        .form-links a {
            color: #4caf50;
            text-decoration: none;
            margin: 0 10px;
        }
        .form-links a:hover {
            text-decoration: underline;
        }
        .footer {
            background-color: rgba(51, 51, 51, 0.9);
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #fff;
            width: 100%;
            position: relative;
            bottom: 0;
            z-index: 1;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px auto;
                padding: 15px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .form-group {
                max-width: 100%;
            }
            .top-nav {
                flex-direction: column;
                align-items: center;
            }
            .nav-link {
                width: 100%;
                text-align: center;
                padding: 12px;
            }
        }
    </style>
    <script>
        window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
    </script>
    <script src="/_vercel/insights/script.js" defer></script>
</head>
<body>
    <div class="background-image"></div>
    <nav class="top-nav">
        <a href="index.html" class="nav-link">home</a>
        <a href="/videos.php" class="nav-link">Videos</a>
        <a href="/about.php" class="nav-link">About</a>
        <a href="/contact.php" class="nav-link">Contact</a>
    </nav>
    <main class="container">
        <h2>Sign In</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="/api/index.php">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign In</button>
            </div>
        </form>
        <div class="form-links">
            <a href="/api/recover_password.php">Forgot your password?</a>
            <a href="/register.php">Create account</a>
        </div>
    </main>
    
<script src="https://cdn.jsdelivr.net/npm/@statsig/js-client@3/build/statsig-js-client+session-replay+web-analytics.min.js"></script>
    <script>

    <script>
        const visitorInfo = <?php echo json_encode($visitor_info, JSON_UNESCAPED_SLASHES); ?>;
        console.log('visitorInfo inicial:', visitorInfo);

        // Captura detalhes do dispositivo com UAParser
        try {
            const parser = new UAParser();
            const result = parser.getResult();
            visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`.trim();
            visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`.trim();
            visitorInfo.device_vendor = result.device.vendor || "Not identified";
            visitorInfo.device_model = result.device.model || "Not identified";
            visitorInfo.device_type = result.device.type || "Unknown";
            visitorInfo.device_category = (visitorInfo.device_type === "mobile" || visitorInfo.device_type === "tablet") ? "mobile" : "desktop";
            console.log('UAParser result:', result);
        } catch (e) {
            console.error('Erro no UAParser:', e);
            visitorInfo.device_category = "Unknown";
        }

        // Captura geolocalização
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    visitorInfo.latitude = position.coords.latitude;
                    visitorInfo.longitude = position.coords.longitude;
                    console.log('Geolocalização precisa:', visitorInfo.latitude, visitorInfo.longitude);
                    updateSupabase();
                },
                (error) => {
                    console.error('Erro na geolocalização:', error.message);
                    updateSupabase();
                },
                { timeout: 10000, enableHighAccuracy: true }
            );
        } else {
            console.log('Geolocalização não suportada');
            updateSupabase();
        }

        // Captura informações de rede
        if (navigator.connection) {
            visitorInfo.network_type = navigator.connection.effectiveType || "Unknown";
            visitorInfo.downlink = navigator.connection.downlink || "Unknown";
            console.log('Conexão:', visitorInfo.network_type, visitorInfo.downlink);
        } else {
            console.log('navigator.connection não suportado');
        }

        async function updateSupabase() {
            try {
                const response = await fetch('/update_visitor.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        ip: visitorInfo.ip,
                        browser: visitorInfo.browser,
                        os: visitorInfo.os,
                        device_vendor: visitorInfo.device_vendor,
                        device_model: visitorInfo.device_model,
                        device_type: visitorInfo.device_type,
                        device_category: visitorInfo.device_category,
                        latitude: visitorInfo.latitude ?? null,
                        longitude: visitorInfo.longitude ?? null,
                        network_type: visitorInfo.network_type ?? null,
                        downlink: visitorInfo.downlink ?? null,
                        referrer: visitorInfo.referrer,
                        source: visitorInfo.source,
                        is_facebook: visitorInfo.is_facebook
                    })
                });
                const data = await response.json();
                console.log('Update Result:', data);
            } catch (error) {
                console.error('Erro no fetch:', error);
            }
        }
    </script>

<!-- Cookie Consent Banner -->
<div class="cookie-consent">
    <p>We use first-party cookies to improve our services. 
        <a href="/api/Privacy_Policy.php">Learn more</a>
    </p>
    <div class="cookie-buttons">
        <button class="accept-btn">Accept</button>
        <button class="optout-btn">Opt out</button>
        <button class="privacy-btn">Privacy settings</button>
    </div>
</div>

<style>
.cookie-consent {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.9);
    color: white;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    z-index: 1000;
    font-size: 0.875rem;
}

.cookie-buttons {
    display: flex;
    gap: 0.5rem;
}

.accept-btn, .optout-btn, .privacy-btn {
    padding: 0.25rem 0.625rem;
    height: 1.625rem;
    font-size: 0.75rem;
    border-radius: 0.375rem;
    cursor: pointer;
}

.accept-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
}

.optout-btn {
    background: transparent;
    border: 1px solid #ccc;
    color: white;
}

.privacy-btn {
    background: transparent;
    border: none;
    color: #ccc;
    margin-left: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o usuário já fez uma escolha
    if (document.cookie.includes('cookie_consent=')) {
        document.querySelector('.cookie-consent').style.display = 'none';
        return;
    }

    // Lógica para aceitar cookies
    document.querySelector('.accept-btn').addEventListener('click', function() {
        document.cookie = "cookie_consent=accepted; path=/; max-age=31536000; SameSite=Strict";
        document.querySelector('.cookie-consent').style.display = 'none';
        // Ativa seus scripts de analytics/tracking aqui
    });
    
    // Lógica para recusar cookies
    document.querySelector('.optout-btn').addEventListener('click', function() {
        document.cookie = "cookie_consent=rejected; path=/; max-age=31536000; SameSite=Strict";
        document.querySelector('.cookie-consent').style.display = 'none';
        // Desativa seus scripts de analytics/tracking aqui
    });
    
    // Lógica para configurações de privacidade
    document.querySelector('.privacy-btn').addEventListener('click', function() {
        // Implemente a abertura de um modal com mais opções
        alert('Privacy settings would open here');
    });
});
</script>

 <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
