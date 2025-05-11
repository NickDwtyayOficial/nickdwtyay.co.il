<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db_connect.php';

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    error_log("Arquivo .env não encontrado em " . __DIR__);
}

$visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
if (strpos($visitor_ip, ',') !== false) {
    $visitor_ip = explode(',', $visitor_ip)[0];
}
$visitor_ip = trim($visitor_ip);
error_log("IP capturado: " . $visitor_ip);

// Captura referrer e source
$referrer = $_SERVER['HTTP_REFERER'] ?? 'Nenhum referrer detectado';
$utm_source = $_GET['utm_source'] ?? '';
$source = (stripos($referrer, 'facebook.com') !== false || $utm_source === 'facebook') ? 'facebook' : 'direct';
$is_facebook = ($source === 'facebook');
$is_bitly = (stripos($referrer, 'bitly.com') !== false || stripos($referrer, 'bit.ly') !== false);
error_log("Referrer: " . $referrer . ", Source: " . $source);

// Requisições às APIs externas
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ipinfo_data = @file_get_contents($ipinfo_url);
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
error_log("IPinfo response: " . ($ipinfo_data ?: "Falha na requisição"));
$initial_latitude = $ipinfo_json['loc'] ? floatval(explode(',', $ipinfo_json['loc'])[0]) : null;
$initial_longitude = $ipinfo_json['loc'] ? floatval(explode(',', $ipinfo_json['loc'])[1]) : null;

$ipqs_key = getenv('IPQS_KEY');
$ipqs_url = "https://ipqualityscore.com/api/json/ip/{$ipqs_key}?ip={$visitor_ip}";
$ipqs_data = @file_get_contents($ipqs_url);
$ipqs_json = $ipqs_data ? json_decode($ipqs_data, true) : [];
error_log("IPQS response: " . ($ipqs_data ?: "Falha na requisição"));

$proxycheck_key = getenv('PROXYCHECK_KEY');
$proxycheck_url = "https://proxycheck.io/v2/{$visitor_ip}?key={$proxycheck_key}&vpn=1";
$proxycheck_data = @file_get_contents($proxycheck_url);
$proxycheck_json = $proxycheck_data ? json_decode($proxycheck_data, true) : [];
error_log("ProxyCheck response: " . ($proxycheck_data ?: "Falha na requisição"));

$tor_data = @file_get_contents('https://check.torproject.org/exit-addresses');
$is_tor_confirmed = $tor_data && strpos($tor_data, $visitor_ip) !== false ? "Yes (confirmed by exit node)" : "No";
error_log("Tor check: " . $is_tor_confirmed);

// Monta informações do visitante
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
error_log("visitor_info: " . json_encode($visitor_info));

// Salva no Supabase
$result = db_query('visitors', $visitor_info, 'POST');
if (isset($result['error'])) {
    error_log("Erro ao salvar no Supabase: " . json_encode($result));
} else {
    error_log("Dados salvos no Supabase: " . json_encode($visitor_info));
}

// Armazena dados na sessão para uso posterior
$_SESSION['visitor_info'] = $visitor_info;

// Redireciona para a nova página de login
header("Location: /api/index.php");
exit();
?>
