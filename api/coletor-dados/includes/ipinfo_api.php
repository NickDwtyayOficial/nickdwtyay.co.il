<?php
require_once __DIR__ . '/config.php';

function getIpInfo($ip) {
    $url = "https://ipinfo.io/{$ip}?token=" . TOKEN_IPINFO;
    $response = @file_get_contents($url);
    
    if ($response === FALSE) {
        return ['erro' => 'Falha na consulta à API'];
    }
    
    return json_decode($response, true);
}

function saveToFile($ipData) {
    $line = sprintf(
        "%s,%s,%s,%s,%s,%s,%s,%s\n",
        $ipData['ip'],
        date('d/m/Y'),
        date('H:i:s'),
        $ipData['city'] ?? 'N/A',
        $ipData['region'] ?? 'N/A',
        $ipData['country'] ?? 'N/A',
        $ipData['org'] ?? 'N/A',
        $ipData['loc'] ?? '0,0'
    );
    
    file_put_contents(LOG_FILE, $line, FILE_APPEND);
}
?>
