<?php
require_once __DIR__ . '/api/db_connect.php';

// Captura o IP
$visitor_ip = $_SERVER['REMOTE_ADDR'];

// Dados básicos
$visitor_info = [
    "ip" => $visitor_ip,
    "location" => "Unknown", // Simplificado, adicione IPQualityScore se quiser
    "is_vpn_or_proxy" => "Not verified",
    "is_tor" => "Not verified",
    "user_agent" => $_SERVER['HTTP_USER_AGENT'],
    "browser" => "Unknown",
    "os" => "Unknown",
    "device_vendor" => "Not identified",
    "device_model" => "Not identified",
    "device_type" => "Unknown"
];

// Salva no Supabase
$result = db_query('visitors', $visitor_info, 'POST');
if (isset($result['error'])) {
    error_log("Erro ao salvar: " . json_encode($result));
}
?>
 <!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ultimate Car Deals - Unlock Exclusive Offers</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ua-parser-js/1.0.2/ua-parser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <!-- Seu CSS aqui (igual ao anterior) -->
</head>
<body>
    <header>
        <h1>Ultimate Car Deals</h1>
        <p class="intro">Discover exclusive offers on the hottest cars – just for you!</p>
        <button onclick="alert('Check your info below to claim your deal!')">Claim Your Offer</button>
    </header>
    <div class="info-box">
        <h2>Your Details</h2>
        <pre id="info">Loading your exclusive deal...</pre>
    </div>
    <footer>
        © 2025 Ultimate Car Deals | All rights reserved
    </footer>




<script>
    // Inicializa o cliente Supabase
    const supabase = Supabase.createClient(
        'SUA_URL_DO_SUPABASE', // Ex.: https://xyz.supabase.co
        'SUA_CHAVE_ANON' // Encontre em Settings > API > anon key
    );

    // Função para atualizar o display
    function updateInfo(data) {
        document.getElementById('info').innerHTML = JSON.stringify(data, null, 2);
    }

    // Objeto inicial de informações
    let visitorInfo = {
        ip: "Unknown",
        location: "Unknown",
        isVpnOrProxy: "Not verified",
        isTor: "Not verified",
        userAgent: navigator.userAgent,
        browser: "Unknown",
        os: "Unknown",
        device: { vendor: "Not identified", model: "Not identified", type: "Unknown" }
    };

    // Coleta e salva os dados
    async function collectAndSaveData() {
        try {
            // 1. Pega o IP
            const ipResponse = await fetch('https://api.ipify.org?format=json');
            const ipData = await ipResponse.json();
            visitorInfo.ip = ipData.ip;

            // 2. Pega localização e verifica VPN/Tor
            const ipqsResponse = await fetch(`https://ipqualityscore.com/api/json/ip/FxJTEBwf1TN9Elh78MZqTISQMYK0qdYk/USER_IP_HERE ip=${ipData.ip}`);
            const ipqs = await ipqsResponse.json();
            visitorInfo.location = `${ipqs.city || "Unknown"}, ${ipqs.region || "Unknown"}, ${ipqs.country_code || "Unknown"}`;
            visitorInfo.isVpnOrProxy = ipqs.proxy || ipqs.vpn ? "Yes" : "No";
            visitorInfo.isTor = ipqs.tor ? "Yes" : "No";

            // 3. Verifica Tor (opcional)
            const torResponse = await fetch('https://check.torproject.org/exit-addresses');
            const torData = await torResponse.text();
            if (torData.includes(ipData.ip)) visitorInfo.isTor = "Yes (confirmed by exit node)";

            // 4. Analisa User-Agent
            const parser = new UAParser();
            const result = parser.getResult();
            visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`;
            visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`;
            visitorInfo.device.vendor = result.device.vendor || "Not identified";
            visitorInfo.device.model = result.device.model || "Not identified";
            visitorInfo.device.type = result.device.type || "Unknown";

            // 5. Salva no Supabase
            const { error } = await supabase.from('visitors').insert([visitorInfo]);
            if (error) throw error;

            // Atualiza a tela
            updateInfo(visitorInfo);
        } catch (err) {
            console.error("Erro:", err);
            visitorInfo.ip = "Error retrieving data";
            updateInfo(visitorInfo);
        }
    }

    // Executa ao carregar a página
    collectAndSaveData();
</script>
</body>
</html>
