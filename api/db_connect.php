<?php
function db_query($query, $params = []) {
    $supabase_url = getenv("SUPABASE_URL");
    $supabase_key = getenv("SUPABASE_KEY");
    $url = $supabase_url . '/rest/v1/' . $query;
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json"
    ];
    $options = [
        "http" => [
            "header" => implode("\r\n", $headers) . "\r\n",
            "method" => empty($params) ? "GET" : "POST",
            "ignore_errors" => true
        ]
    ];
    if (!empty($params)) {
        $options["http"]["content"] = json_encode($params);
    }
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    if ($response === false) {
        return ["error" => "Falha na requisição ao Supabase"];
    }
    return json_decode($response, true);
}
?>
