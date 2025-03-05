<?php
// Configuração do Supabase
$supabase_url = 'SUA_URL_DO_SUPABASE'; // Ex.: https://seu-projeto.supabase.co
$supabase_key = 'SUA_CHAVE_API_PUBLICA'; // Anon key do Supabase

// Função para conectar e executar queries
function db_query($query, $params = []) {
    global $supabase_url, $supabase_key;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $supabase_url . '/rest/v1/users');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $supabase_key,
        'Authorization: Bearer ' . $supabase_key,
        'Content-Type: application/json'
    ]);
    
    if (!empty($params)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    } else {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    }
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}
?>
