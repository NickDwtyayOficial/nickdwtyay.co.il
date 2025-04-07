<?php
session_start();
require_once __DIR__ . '/db_connect.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Define se está em ambiente de desenvolvimento
$is_dev = getenv('ENV') === 'development';

// Captura o IP real do visitante no Vercel
$visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
if (strpos($visitor_ip, ',') !== false) {
    $visitor_ip = explode(',', $visitor_ip)[0];
}
$visitor_ip = trim($visitor_ip);
// Garantir que $referrer e $is_facebook estejam definidas
$referrer = $_SERVER['HTTP_REFERER'] ?? 'Nenhum referrer detectado';
$is_facebook = (stripos($referrer, 'facebook.com') !== false);

// Faz a requisição ao ipinfo.io
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ipinfo_data = @file_get_contents($ipinfo_url);
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
error_log("ipinfo.io URL: " . $ipinfo_url);
error_log("ipinfo.io response: " . ($ipinfo_data ?: "Falha na requisição"));

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
    "latitude" => null,
    "longitude" => null,
    "network_type" => null,
    "downlink" => null,
    "referrer" => $referrer, // Linha 65
    "is_facebook" => $is_facebook, // Linha 66
    "visit_time" => date('c')
];

// Salva os dados iniciais no Supabase
$result = db_query('visitors', $visitor_info, 'POST');
if (isset($result['error'])) {
    error_log("Erro ao salvar no Supabase: " . json_encode($result));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com; script-src-elem 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com 'unsafe-inline'; script-src-attr 'unsafe-inline'; connect-src 'self' https://*.vercel.app https://cloudflareinsights.com https://ipinfo.io https://ipqualityscore.com https://proxycheck.io https://www.google-analytics.com https://stats.g.doubleclick.net; style-src 'self' 'unsafe-inline'; img-src 'self' https://source.unsplash.com">
    <title>Ultimate Car Deals - Unlock Exclusive Offers</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ua-parser-js/1.0.37/ua-parser.min.js"></script>
    
    <?php if (!$is_dev): ?>
        <!-- Google Ads -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1922092235705770" crossorigin="anonymous"></script>
        <!-- Cloudflare Web Analytics -->
        <script defer src="https://static.cloudflareinsights.com/beacon.min.js" data-cf-beacon='{"token": "6d0cf27361a1479bb063deef0eab2482"}'></script>
        <!-- Google Tag (gtag.js) UA -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-75819753-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-75819753-1');
        </script>
        <!-- Google Tag (gtag.js) G -->
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
            background: linear-gradient(to bottom, #1a1a1a, #4d4d4d);
            color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background: url('https://source.unsplash.com/1600x400/?car,racing') no-repeat center;
            background-size: cover;
            padding: 50px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 3em;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            text-shadow: 2px 2px 4px #000;
        }
        .intro {
            font-size: 1.2em;
            margin: 20px 0;
            text-shadow: 1px 1px 2px #000;
        }
        .info-box {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
        }
        pre {
            text-align: left;
            font-size: 1em;
            color: #ffcc00;
            white-space: pre-wrap;
        }
        button {
            background: #ff0000;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #cc0000;
        }
        footer {
            padding: 20px;
            font-size: 0.9em;
            color: #ccc;
        }
    </style>
</head>
<body>
    <header>
        <h1>Ultimate Car Deals</h1>
        <p class="intro">Discover exclusive offers on the hottest cars – just for you!</p>
        <button onclick="alert('Check your info below to claim your deal!')">Claim Your Offer</button>
    </header>
    <div class="info-box">
        <h2>Your Details</h2>
        <pre id="info"><?php echo json_encode($visitor_info, JSON_PRETTY_PRINT); ?></pre>
    </div>
    <footer>
        © 2025 Ultimate Car Deals | All rights reserved
    </footer>

    
<script>
    let visitorInfo = <?php echo json_encode($visitor_info); ?>;
    console.log('visitorInfo inicial:', visitorInfo);

    // Captura detalhes do dispositivo com UAParser
    try {
        const parser = new UAParser();
        const result = parser.getResult();
        visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`;
        visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`;
        visitorInfo.device_vendor = result.device.vendor || "Not identified";
        visitorInfo.device_model = result.device.model || "Not identified";
        visitorInfo.device_type = result.device.type || "Unknown";
        console.log('UAParser result:', result);
    } catch (e) {
        console.error('Erro no UAParser:', e);
    }

    // Captura geolocalização do navegador
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                visitorInfo.latitude = position.coords.latitude;
                visitorInfo.longitude = position.coords.longitude;
                console.log('Geolocalização obtida:', visitorInfo.latitude, visitorInfo.longitude);
                updateSupabase();
                updateDisplay(); // Atualiza o <pre> após geolocalização
            },
            function(error) {
                console.error('Erro na geolocalização:', error.message);
                updateSupabase(); // Atualiza mesmo sem geolocalização
            },
            { timeout: 10000, enableHighAccuracy: true } // Timeout de 10s e alta precisão
        );
    } else {
        console.log('Geolocalização não suportada pelo navegador');
        updateSupabase();
    }

    // Captura detalhes da conexão
    if (navigator.connection) {
        visitorInfo.network_type = navigator.connection.effectiveType || "Unknown";
        visitorInfo.downlink = navigator.connection.downlink || "Unknown";
        console.log('Conexão:', visitorInfo.network_type, visitorInfo.downlink);
    } else {
        console.log('navigator.connection não suportado');
    }

    // Função para atualizar a exibição no <pre>
    function updateDisplay() {
        document.getElementById('info').innerHTML = JSON.stringify(visitorInfo, null, 2);
    }

    // Exibe as informações iniciais no <pre>
    updateDisplay();

    // Função para atualizar o Supabase
    function updateSupabase() {
        fetch('/update_visitor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                ip: visitorInfo.ip,
                browser: visitorInfo.browser,
                os: visitorInfo.os,
                device_vendor: visitorInfo.device_vendor,
                device_model: visitorInfo.device_model,
                device_type: visitorInfo.device_type,
                latitude: visitorInfo.latitude || null,
                longitude: visitorInfo.longitude || null,
                network_type: visitorInfo.network_type || null,
                downlink: visitorInfo.downlink || null,
                referrer: visitorInfo.referrer, // Adicionado
                is_facebook: visitorInfo.is_facebook // Adicionado
            })
        })
        .then(response => response.json())
        .then(data => console.log('Update Result:', data))
        .catch(error => console.error('Erro no fetch:', error));
    }
</script>
</body>
</html>
