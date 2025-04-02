<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/ipinfo_api.php';

$ip = $_SERVER['REMOTE_ADDR'];
$ipInfo = getIpInfo($ip);
saveToFile($ipInfo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Geolocalização</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .info-card {
            background: #f0f8ff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="info-card">
        <h2>Dados do Visitante</h2>
        <p><strong>IP:</strong> <?= htmlspecialchars($ip) ?></p>
        <p><strong>Localização:</strong> 
            <?= htmlspecialchars($ipInfo['city'] ?? 'N/A') ?>, 
            <?= htmlspecialchars($ipInfo['region'] ?? 'N/A') ?>
        </p>
        <p><strong>Provedor:</strong> <?= htmlspecialchars($ipInfo['org'] ?? 'N/A') ?></p>
        
        <a href="visualizar.php">Ver Todos os Registros</a>
    </div>
</body>
</html>
