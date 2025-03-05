<?php
// Função para conectar e executar queries
function db_query($query, $params = []) {
    // Pega as variáveis de ambiente do Vercel
    $supabase_url = getenv("SUPABASE_URL"); // https://zeqmcwtwhjzqhcvfsvli.supabase.co
    $supabase_key = getenv("SUPABASE_KEY"); // Chave anon adicionada no Vercel

    // Monta a URL completa com o endpoint
    $url = $supabase_url . '/rest/v1/' . $query;

    // Configura os cabeçalhos
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json"
    ];

    // Configura o contexto HTTP
    $options = [
        "http" => [
            "header" => implode("\r\n", $headers) . "\r\n",
            "method" => empty($params) ? "GET" : "POST",
            "ignore_errors" => true // Captura erros como 404 ou 400
        ]
    ];

    // Se houver parâmetros (POST), adiciona o corpo da requisição
    if (!empty($params)) {
        $options["http"]["content"] = json_encode($params);
    }

    // Cria o contexto e faz a requisição
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    // Verifica se houve erro na requisição
    if ($response === false) {
        return ["error" => "Falha na requisição ao Supabase"];
    }

    // Retorna a resposta decodificada como array
    return json_decode($response, true);
}
?>
