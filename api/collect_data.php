<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db_connect.php';

use Dotenv\Dotenv;

// Carrega variáveis de ambiente
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    error_log("Arquivo .env não encontrado em " . __DIR__);
}

// Define ambiente de desenvolvimento
$is_dev = getenv('ENV') === 'development';

// Captura IP do visitante
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

// Requisições às APIs externas
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ipinfo_data = @file_get_contents($ipinfo_url);
if ($ipinfo_data === false) {
    error_log("Falha na API IPinfo para IP $visitor_ip: " . error_get_last()['message']);
}
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
$initial_latitude = $ipinfo_json['loc'] ? floatval(explode(',', $ipinfo_json['loc'])[0]) : null;
$initial_longitude = $ipinfo_json['loc'] ? floatval(explode(',', $ipinfo_json['loc'])[1]) : null;

$ipqs_key = getenv('IPQS_KEY');
$ipqs_url = "https://ipqualityscore.com/api/json/ip/{$ipqs_key}?ip={$visitor_ip}";
$ipqs_data = @file_get_contents($ipqs_url);
if ($ipqs_data === false) {
    error_log("Falha na API IPQS para IP $visitor_ip: " . error_get_last()['message']);
}
$ipqs_json = $ipqs_data ? json_decode($ipqs_data, true) : [];

$proxycheck_key = getenv('PROXYCHECK_KEY');
$proxycheck_url = "https://proxycheck.io/v2/{$visitor_ip}?key={$proxycheck_key}&vpn=1";
$proxycheck_data = @file_get_contents($proxycheck_url);
if ($proxycheck_data === false) {
    error_log("Falha na API ProxyCheck para IP $visitor_ip: " . error_get_last()['message']);
}
$proxycheck_json = $proxycheck_data ? json_decode($proxycheck_data, true) : [];

$tor_data = @file_get_contents('https://check.torproject.org/exit-addresses');
if ($tor_data === false) {
    error_log("Falha ao verificar Tor exit nodes");
}
$is_tor_confirmed = $tor_data && strpos($tor_data, $visitor_ip) !== false ? "Yes (confirmed by exit node)" : "No";

// Monta informações do visitante
$visitor_info = [
    "ip" => $visitor_ip,
    "location" => isset($ipinfo_json['city']) ? "{$ipinfo_json['city']}, {$ipinfo_json['region']}, {$ipinfo_json['country']}" : "Unknown",
    "is_vpn_or_proxy_ipqs" => isset($ipqs_json['proxy']) && ($ipqs_json['proxy'] || $ipqs_json['vpn']) ? "Yes" : "No",
    "is_vpn_or_proxy_proxycheck" => isset($proxycheck_json[$visitor_ip]["proxy"]) && $proxycheck_json[$visitor_ip]["proxy"] === "yes" ? "Yes" : "No",
    "is_tor" => isset($ipqs_json['tor']) && $ipqs_json['tor'] ? "Yes" : $is_tor_confirmed,
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "browser" => "Unknown",
    "os" => "Unknown",
    "device_vendor" => "Not identified",
    "device_model" => "Not identified",
    "device_type" => "Unknown",
    "device_category" => "Unknown",
    "latitude" => $initial_latitude,
    "longitude" => $initial_longitude,
    "network_type" => null,
    "downlink" => null,
    "referrer" => $referrer,
    "is_facebook" => $is_facebook,
    "is_bitly" => $is_bitly,
    "visit_time" => date('c'),
    "source" => $source
];

// Salva no Supabase
$result = db_query('visitors', $visitor_info, 'POST');
if (isset($result['error'])) {
    error_log("Erro ao salvar no Supabase: " . json_encode($result));
} else {
    error_log("Dados salvos no Supabase: " . json_encode($visitor_info));
}

// Armazena dados na sessão
$_SESSION['visitor_info'] = $visitor_info;

// Exibe uma tela de carregamento antes de redirecionar para o login
$redirect_url = "/api/index.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=<?php echo htmlspecialchars($redirect_url, ENT_QUOTES); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando...</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: radial-gradient(circle at top, #1a1a2e 0%, #0f3460 50%, #0b132b 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            text-align: center;
        }
        .spinner {
            width: 64px;
            height: 64px;
            border: 6px solid rgba(255, 255, 255, 0.2);
            border-top-color: #4caf50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .message {
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="loader">
        <img src="/api/static/dwtyay_favicon.gif" alt="Nick Dwtyay" class="logo">
        <div class="spinner" aria-label="Carregando"></div>
        <div class="message">Carregando, aguarde...</div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = <?php echo json_encode($redirect_url); ?>;
        }, 2000);
    </script>
</body>
</html>
