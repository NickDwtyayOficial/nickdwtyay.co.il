
<?php
require_once __DIR__ . '/includes/config.php';

$logs = [];
if (file_exists(LOG_FILE)) {
    $lines = file(LOG_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $header = str_getcsv(array_shift($lines));
    
    foreach ($lines as $line) {
        $logs[] = array_combine($header, str_getcsv($line));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dados Coletados</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Registros de Acesso (Últimos 100)</h1>
    <table>
        <thead>
            <tr>
                <?php foreach ($header as $col): ?>
                    <th><?= htmlspecialchars(ucfirst($col)) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach (array_slice(array_reverse($logs), 0, 100) as $log): ?>
                <tr>
                    <?php foreach ($log as $value): ?>
                        <td><?= htmlspecialchars($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
