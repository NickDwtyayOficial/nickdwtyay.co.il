<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        h1 {
            font-size: 48px;
            color: #ff3333;
        }
        p {
            font-size: 18px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Erro 404</h1>
    <p>Ops! A página que você procura não foi encontrada.</p>
    <p><a href="/home.php">Voltar para a página inicial</a></p>
</body>
</html>
