<?php
function db_query($query, $params = [], $method = null) {
    $supabase_url = getenv("SUPABASE_URL") ?: "https://zeqmcwtwhjzqhcvfsvli.supabase.co"; // Substitua pelo seu URL real
    $supabase_key = getenv("SUPABASE_KEY") ?: "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InplcW1jd3R3aGp6cWhjdmZzdmxpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDExMjcxOTgsImV4cCI6MjA1NjcwMzE5OH0.p7Tchk4aVnSNmfrIMwQLdvwZRQvGTQUz0Du8W56MkXM"; // Substitua pela sua chave anon real
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
