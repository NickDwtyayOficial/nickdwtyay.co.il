<?php
session_start();
require_once __DIR__ . '/db_connect.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Define se está em ambiente de desenvolvimento (baseado em ENV)
$is_dev = getenv('ENV') === 'development';

// Captura o IP real do visitante no Vercel
$visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
if (strpos($visitor_ip, ',') !== false) {
    $visitor_ip = explode(',', $visitor_ip)[0];
}
$visitor_ip = trim($visitor_ip);

// Faz a requisição ao ipinfo.io com cURL
$ipinfo_token = getenv('IPINFO_TOKEN');
$ipinfo_url = "https://ipinfo.io/{$visitor_ip}?token={$ipinfo_token}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ipinfo_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$ipinfo_data = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

$ipinfo_json = $ipinfo_data ? json_decode($ipinfo_data, true) : [];
error_log("ipinfo.io URL: " . $ipinfo_url);
error_log("ipinfo.io response: " . ($ipinfo_data ?: "Falha na requisição"));
if (!$ipinfo_data) {
    error_log("Erro cURL no ipinfo.io: " . $curl_error);
}

// Faz a requisição à API IPQualityScore
$ipqs_key = getenv('IPQS_KEY');
$ipqs_url = "https://ipqualityscore.com/api/json/ip/{$ipqs_key}?ip={$visitor_ip}";
$ipqs_ch = curl_init();
curl_setopt($ipqs_ch, CURLOPT_URL, $ipqs_url);
curl_setopt($ipqs_ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ipqs_ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ipqs_ch, CURLOPT_TIMEOUT, 10);
$ipqs_data = curl_exec($ipqs_ch);
$ipqs_error = curl_error($ipqs_ch);
curl_close($ipqs_ch);

$ipqs_json = $ipqs_data ? json_decode($ipqs_data, true) : [];
error_log("IPQS URL: " . $ipqs_url);
error_log("IPQS response: " . ($ipqs_data ?: "Falha na requisição"));
if (!$ipqs_data) {
    error_log("Erro cURL no IPQS: " . $ipqs_error);
}

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

// Salva os dados no Supabase
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
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com; script-src-elem 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com 'unsafe-inline'; script-src-attr 'unsafe-inline'; connect-src 'self' https://*.vercel.app https://cloudflareinsights.com https://ipinfo.io https://www.google-analytics.com https://stats.g.doubleclick.net; style-src 'self' 'unsafe-inline'; img-src 'self' https://source.unsplash.com">
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
        const parser = new UAParser();
        const result = parser.getResult();
        let visitorInfo = <?php echo json_encode($visitor_info); ?>;
        visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`;
        visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`;
        visitorInfo.device_vendor = result.device.vendor || "Not identified";
        visitorInfo.device_model = result.device.model || "Not identified";
        visitorInfo.device_type = result.device.type || "Unknown";
        document.getElementById('info').innerHTML = JSON.stringify(visitorInfo, null, 2);

        fetch('/update_visitor.php', {
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
