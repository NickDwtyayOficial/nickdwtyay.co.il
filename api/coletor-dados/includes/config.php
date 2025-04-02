<?php
// Configurações de segurança
define('TOKEN_IPINFO', 'b9926cf26ae3ac'); // Substitua pelo seu token real
define('LOG_FILE', __DIR__ . '/../storage/dados.csv');

// Cria o arquivo de log se não existir
if (!file_exists(LOG_FILE)) {
    file_put_contents(LOG_FILE, "IP,Data,Hora,Cidade,Regiao,Pais,Provedor,LatLong\n");
}
?>
