<?php
// Configuração do Supabase
$supabase_url = 'https://zeqmcwtwhjzqhcvfsvli.supabase.co'; // Ex.: https://seu-projeto.supabase.co
$supabase_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InplcW1jd3R3aGp6cWhjdmZzdmxpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDExMjcxOTgsImV4cCI6MjA1NjcwMzE5OH0.p7Tchk4aVnSNmfrIMwQLdvwZRQvGTQUz0Du8W56MkXM'; // Anon key do Supabase

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
