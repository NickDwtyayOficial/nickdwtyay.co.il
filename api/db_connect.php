<?php
require_once __DIR__ . '/vendor/autoload.php'; // Carrega o Composer

use Dotenv\Dotenv;

// Carrega o .env apenas localmente (no Vercel, as variáveis já estarão disponíveis)
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

function db_query($query, $params = [], $method = null) {
    // Obtém as variáveis de ambiente
    $supabase_url = getenv('SUPABASE_URL');
    $supabase_key = getenv('SUPABASE_PUBLIC_KEY'); // Alinhado com o .env que você criou

    // Verifica se as variáveis estão definidas
    if (!$supabase_url || !$supabase_key) {
        error_log("Erro: SUPABASE_URL ou SUPABASE_PUBLIC_KEY não definidos.");
        return ["error" => "Configuração do Supabase inválida"];
    }

    $url = $supabase_url . '/rest/v1/' . $query;

    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ];

    $options = [
        "http" => [
            "method" => $method ?: (empty($params) ? "GET" : "POST"),
            "header" => implode("\r\n", $headers),
            "ignore_errors" => true
        ]
    ];

    if (!empty($params)) {
        $options["http"]["content"] = json_encode($params);
    }

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        error_log("Erro na requisição ao Supabase: " . print_r($http_response_header, true));
        return ["error" => "Falha na requisição ao Supabase", "headers" => $http_response_header];
    }

    return json_decode($response, true);
}
?>
