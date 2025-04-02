<?php
require_once __DIR__ . '/api/db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data && isset($data['ip'])) {
        $result = db_query("visitors?ip=eq.{$data['ip']}&order=visit_time.desc&limit=1", [
            "browser" => $data['browser'],
            "os" => $data['os'],
            "device_vendor" => $data['device_vendor'],
            "device_model" => $data['device_model'],
            "device_type" => $data['device_type']
        ], 'PATCH');
        echo json_encode(isset($result['error']) ? ["error" => "Failed"] : ["success" => true]);
    }
}
?>
