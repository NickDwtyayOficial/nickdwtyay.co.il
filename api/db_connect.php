<?php
require_once __DIR__ . '/vendor/autoload.php'; // Carrega o Composer

use Dotenv\Dotenv;

// Carrega o .env apenas localmente (no Vercel, as variáveis já estarão disponíveis)
if (file_exists(__DIR__ . '/.env')) {
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
}

// Obtém as variáveis de ambiente uma vez, fora da função
$supabase_url = getenv('SUPABASE_URL');
$supabase_key = getenv('SUPABASE_PUBLIC_KEY');
if (!$supabase_url || !$supabase_key) {
error_log("Erro: SUPABASE_URL ou SUPABASE_PUBLIC_KEY não definidos no início do script.");
// Não retornamos aqui, pois estamos fora da função; apenas logamos
}

function db_query($query, $params = [], $method = null) {
// Usa as variáveis globais definidas acima
global $supabase_url, $supabase_key;

// Loga as variáveis para depuração
error_log("Variáveis Supabase - URL: $supabase_url, Key: " . substr($supabase_key, 0, 10) . "...");

// Verifica se as variáveis estão definidas
if (!$supabase_url || !$supabase_key) {
error_log("Erro: SUPABASE_URL ou SUPABASE_PUBLIC_KEY não definidos na função.");

  error_log("SUPABASE_URL: " . $supabase_url);
error_log("SUPABASE_PUBLIC_KEY: " . substr($supabase_key, 0, 10) . "...");
 
return ["error" => "Configuração do Supabase inválida"];
}

// Monta a URL completa
$url = rtrim($supabase_url, '/') . '/rest/v1/' . ltrim($query, '/');

// Configura os headers
$headers = [
"apikey: $supabase_key",
"Authorization: Bearer $supabase_key",
"Content-Type: application/json",
"Prefer: return=representation"
];

// Configura as opções da requisição
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

// Loga a tentativa de consulta
error_log("Tentando consultar Supabase: URL=$url, Method=" . ($method ?: (empty($params) ? "GET" : "POST")));

// Faz a requisição ao Supabase
$response = file_get_contents($url, false, $context);

// Verifica se houve falha
if ($response === false) {
error_log("Erro na requisição ao Supabase - URL: $url, Headers: " . print_r($http_response_header, true));
return ["error" => "Falha na requisição ao Supabase", "headers" => $http_response_header];
}

// Retorna a resposta decodificada
return json_decode($response, true);
}
