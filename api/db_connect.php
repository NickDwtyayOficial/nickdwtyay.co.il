<?php
require_once __DIR__ . '/vendor/autoload.php'; // Carrega o Composer

use Dotenv\Dotenv;

// Carrega o .env apenas localmente (no Vercel, as variáveis já estarão disponíveis)
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}
$supabase_url = getenv('SUPABASE_URL');
$supabase_key = getenv('SUPABASE_PUBLIC_KEY');
if (!$supabase_url || !$supabase_key) {
    error_log("Erro: SUPABASE_URL ou SUPABASE_PUBLIC_KEY não definidos.");
    return ["error" => "Configuração do Supabase inválida"];
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

    // Monta a URL completa para a requisição
    $url = rtrim($supabase_url, '/') . '/rest/v1/' . ltrim($query, '/');

    // Configura os headers da requisição
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ];

    // Configura as opções da requisição HTTP
    $options = [
        "http" => [
            "method" => $method ?: (empty($params) ? "GET" : "POST"),
            "header" => implode("\r\n", $headers),
            "ignore_errors" => true
        ]
    ];

    // Adiciona o corpo da requisição se houver parâmetros
    if (!empty($params)) {
        $options["http"]["content"] = json_encode($params);
    }

    // Cria o contexto da requisição
    $context = stream_context_create($options);

    // Faz a requisição ao Supabase
    $response = file_get_contents($url, false, $context);

    // Verifica se a requisição foi bem-sucedida
    if ($response === false) {
        error_log("Erro na requisição ao Supabase: " . print_r($http_response_header, true));
        return ["error" => "Falha na requisição ao Supabase", "headers" => $http_response_header];
    }
$response = file_get_contents($url, false, $context);
if ($response === false) {
    error_log("Erro na requisição ao Supabase: " . print_r($http_response_header, true));
    return ["error" => "Falha na requisição ao Supabase", "headers" => $http_response_header];
}
    // Retorna a resposta decodificada
    return json_decode($response, true);
}
?>
