<?php
require_once __DIR__ . '/vendor/autoload.php'; // Carrega o Composer

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

$supabase_url = getenv('SUPABASE_URL');
$supabase_key = getenv('SUPABASE_ANON_KEY');
error_log("Fora da função - SUPABASE_URL: '$supabase_url', SUPABASE_ANON_KEY: '" . substr($supabase_key, 0, 10) . "...'");
if (empty($supabase_url) || empty($supabase_key)) {
    error_log("Erro: SUPABASE_URL ou SUPABASE_ANON_KEY estão vazias ou não definidas no início do script.");
}

function db_query($query, $params = [], $method = null) {
    global $supabase_url, $supabase_key;

    error_log("Dentro da função - SUPABASE_URL: '$supabase_url', SUPABASE_ANON_KEY: '" . substr($supabase_key, 0, 10) . "...'");
    error_log("Comprimento da SUPABASE_ANON_KEY: " . strlen($supabase_key));

    if (empty($supabase_url) || empty($supabase_key)) {
        error_log("Erro: SUPABASE_URL ou SUPABASE_ANON_KEY estão vazias ou não definidas na função.");
        error_log("SUPABASE_URL: '$supabase_url'");
        error_log("SUPABASE_ANON_KEY: '" . substr($supabase_key, 0, 10) . "...'");
        return ["error" => "Configuração do Supabase inválida"];
    }

    $url = rtrim($supabase_url, '/') . '/rest/v1/' . ltrim($query, '/');
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
    error_log("Tentando consultar Supabase: URL=$url, Method=" . ($method ?: (empty($params) ? "GET" : "POST")));
    $response = file_get_contents($url, false, $context);
    if ($response === false) {
        error_log("Erro na requisição ao Supabase - URL: $url, Headers: " . print_r($http_response_header, true));
        return ["error" => "Falha na requisição ao Supabase", "headers" => $http_response_header];
    }
    return json_decode($response, true);
}
