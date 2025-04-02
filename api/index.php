<?php
session_start();
require_once __DIR__ . '/db_connect.php';

// Carrega o .env explicitamente
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Captura o IP do visitante
$visitor_ip = $_SERVER['REMOTE_ADDR'];

// Faz a requisição ao ipinfo.io usando file_get_contents
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ipinfo_data = @file_get_contents($ipinfo_url);
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
error_log("ipinfo.io response: " . ($ipinfo_data ?: "Falha na requisição"));

// Faz a requisição à API IPQualityScore
$ipqs_key = getenv('IPQS_KEY');
$ipqs_url = "https://ipqualityscore.com/api/json/ip/{$ipqs_key}?ip={$visitor_ip}";
$ipqs_data = @file_get_contents($ipqs_url);
$ipqs_json = $ipqs_data ? json_decode($ipqs_data, true) : [];

// Verifica Tor
$tor_data = @file_get_contents('https://check.torproject.org/exit-addresses');
$is_tor_confirmed = $tor_data && strpos($tor_data, $visitor_ip) !== false ? "Yes (confirmed by exit node)" : "No";

// Monta as informações iniciais
$visitor_info = [
    "ip" => $visitor_ip,
    "location" => isset($ipinfo_json['city']) ? "{$ipinfo_json['city']}, {$ipinfo_json['region']}, {$ipinfo_json['country']}" : "Unknown",
    "is_vpn_or_proxy" => isset($ipqs_json['proxy']) && ($ipqs_json['proxy'] || $ipqs_json['vpn']) ? "Yes" : "No",
    "is_tor" => isset($ipqs_json['tor']) && $ipqs_json['tor'] ? "Yes" : $is_tor_confirmed,
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "browser" => "Unknown",
    "os" => "Unknown",
    "device_vendor" => "Not identified",
    "device_model" => "Not identified",
    "device_type" => "Unknown"
];

// Salva os dados no Supabase com depuração
$result = db_query('visitors', $visitor_info, 'POST');
echo "<pre>Supabase Result: ";
var_dump($result);
echo "</pre>";
if (isset($result['error'])) {
    error_log("Erro ao salvar no Supabase: " . json_encode($result));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; script-src-elem 'self' https://cdnjs.cloudflare.com; script-src-attr 'unsafe-inline'; connect-src 'self' https://nickdwtyay.com.br">
    <title>Ultimate Car Deals - Unlock Exclusive Offers</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ua-parser-js/1.0.2/ua-parser.min.js"></script>
</head>
<body>
    <header>
        <h1>Ultimate Car Deals</h1>
        <p>Discover exclusive offers on the hottest cars – just for you!</p>
        <button onclick="alert('Check your info below to claim your deal!')">Claim Your Offer</button>
    </header>
    <div>
        <h2>Your Details</h2>
        <pre id="info"><?php echo json_encode($visitor_info, JSON_PRETTY_PRINT); ?></pre>
    </div>
    <footer>
        © 2025 Ultimate Car Deals | All rights reserved
    </footer>

    <script>
        const parser = new UAParser();
        const result = parser.getResult();
        let visitorInfo = <?php echo json_encode($visitor_info); ?>;
        visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`;
        visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`;
        visitorInfo.device_vendor = result.device.vendor || "Not identified";
        visitorInfo.device_model = result.device.model || "Not identified";
        visitorInfo.device_type = result.device.type || "Unknown";
        document.getElementById('info').innerHTML = JSON.stringify(visitorInfo, null, 2);

        fetch('https://nickdwtyay.com.br/update_visitor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(visitorInfo)
        }).catch(error => console.error('Erro no fetch:', error));
    </script>
</body>
</html>
