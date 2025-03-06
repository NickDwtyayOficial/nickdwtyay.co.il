<?php
function db_query($query, $params = [], $method = null) {
    $supabase_url = getenv("SUPABASE_URL") ?: "https://seu-projeto.supabase.co";
    $supabase_key = getenv("SUPABASE_KEY") ?: "sua-chave-anon";
    $url = $supabase_url . '/rest/v1/' . $query;

    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($method === "POST" || (!empty($params) && !$method)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $http_code >= 400) {
        error_log("Erro na requisição ao Supabase: HTTP $http_code - " . $response);
        return ["error" => "Falha na requisição ao Supabase", "http_code" => $http_code];
    }

    return json_decode($response, true);
}
?>
