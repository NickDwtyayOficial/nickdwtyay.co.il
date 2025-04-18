<?php
require_once __DIR__ . '/db_connect.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data && isset($data['ip'])) {
        $result = db_query("visitors?ip=eq.{$data['ip']}&order=visit_time.desc&limit=1", [
            "browser" => $data['browser'],
            "os" => $data['os'],
            "device_vendor" => $data['device_vendor'],
            "device_model" => $data['device_model'],
            "device_type" => $data['device_type'],
            "device_category" => $data['device_category'],
            "latitude" => $data['latitude'],
            "longitude" => $data['longitude'],
            "network_type" => $data['network_type'] ?? null,
            "downlink" => $data['downlink'] ?? null,
            "referrer" => $data['referrer'],
            "source" => $data['source'],
            "is_facebook" => $data['is_facebook']
            "is_bitly" => $data['is_bitly']
        ], 'PATCH');

        if (isset($result['error'])) {
            error_log("Erro ao atualizar no Supabase: " . json_encode($result));
            echo json_encode(["error" => "Failed to update: " . $result['error']]);
        } else {
            echo json_encode(["success" => true]);
        }
    } else {
        echo json_encode(["error" => "Invalid data"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
