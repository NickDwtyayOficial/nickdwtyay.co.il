<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://static.cloudflareinsights.com https://pagead2.googlesyndication.com https://www.googletagmanager.com https://www.statcounter.com 'unsafe-inline'; connect-src 'self' https://*.vercel.app https://cloudflareinsights.com https://ipinfo.io https://ipqualityscore.com https://proxycheck.io https://www.google-analytics.com https://stats.g.doubleclick.net https://c.statcounter.com; style-src 'self' 'unsafe-inline'; img-src 'self' https://c.statcounter.com; font-src 'self';">

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
