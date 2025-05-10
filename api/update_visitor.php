<?php
require_once __DIR__ . '/db_connect.php';

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    error_log("Arquivo .env não encontrado em " . __DIR__);
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data && isset($data['ip'])) {
        error_log("Recebido POST para update_visitor.php: " . json_encode($data));
        $result = db_query("visitors?ip=eq.{$data['ip']}&order=visit_time.desc&limit=1", [
            "browser" => $data['browser'] ?? 'Unknown',
            "os" => $data['os'] ?? 'Unknown',
            "device_vendor" => $data['device_vendor'] ?? 'Not identified',
            "device_model" => $data['device_model'] ?? 'Not identified',
            "device_type" => $data['device_type'] ?? 'Unknown',
            "device_category" => $data['device_category'] ?? 'Unknown',
            "latitude" => $data['latitude'] ?? null,
            "longitude" => $data['longitude'] ?? null,
            "network_type" => $data['network_type'] ?? null,
            "downlink" => $data['downlink'] ?? null,
            "referrer" => $data['referrer'] ?? 'Nenhum referrer detectado',
            "source" => $data['source'] ?? 'direct',
            "is_facebook" => $data['is_facebook'] ?? false,
            "is_bitly" => $data['is_bitly'] ?? false
        ], 'PATCH');

        if (isset($result['error'])) {
            error_log("Erro ao atualizar no Supabase: " . json_encode($result));
            echo json_encode(["error" => "Failed to update: " . $result['error']]);
        } else {
            error_log("Atualização bem-sucedida no Supabase para IP: " . $data['ip']);
            echo json_encode(["success" => true]);
        }
    } else {
        error_log("Dados inválidos recebidos: " . json_encode($data));
        echo json_encode(["error" => "Invalid data"]);
    }
} else {
    error_log("Método de requisição inválido: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(["error" => "Invalid request method"]);
}
?>