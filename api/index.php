<?php
session_start();
require_once __DIR__ . '/db_connect.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
// Captura o IP real do visitante no Vercel
$visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
if (strpos($visitor_ip, ',') !== false) {
    // Se houver múltiplos IPs no X-Forwarded-For, pega o primeiro (IP do cliente)
    $visitor_ip = explode(',', $visitor_ip)[0];
}
$visitor_ip = trim($visitor_ip); // Remove espaços

// Faz a requisição ao ipinfo.io com depuração
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ipinfo_data = @file_get_contents($ipinfo_url);
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
error_log("ipinfo.io URL: " . $ipinfo_url);
error_log("ipinfo.io response: " . ($ipinfo_data ?: "Falha na requisição"));
if (!$ipinfo_data) {
    error_log("Erro específico do ipinfo.io: " . error_get_last()['message']);
}

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

// Salva os dados no Supabase (sem exibir o resultado)
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
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; script-src-elem 'self' https://cdnjs.cloudflare.com; script-src-attr 'unsafe-inline'; connect-src 'self' https://*.vercel.app">
    <title>Ultimate Car Deals - Unlock Exclusive Offers</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ua-parser-js/1.0.2/ua-parser.min.js"></script>
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

        fetch('/update_visitor.php', {  // URL relativa, ajustada para Vercel
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(visitorInfo)
        })
        .then(response => response.json())
        .then(data => console.log('Update Result:', data))
        .catch(error => console.error('Erro no fetch:', error));
    </script>
</body>
</html>
