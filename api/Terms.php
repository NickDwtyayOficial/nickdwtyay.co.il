<?php
session_start(); // Inclui sessão pra consistência com outras páginas
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Termos de Serviço - Nick Dwtyay, Ltd.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
        }
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://codingdatatoday.co/wp-content/uploads/2024/06/Os-Principais-Tipos-de-Analise-de-Dados-e-Suas-Aplicacoes.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            filter: brightness(70%);
        }
        .top-nav {
            display: flex;
            justify-content: center;
            background-color: rgba(51, 51, 51, 0.9);
            padding: 10px 0;
            position: relative;
            z-index: 1;
        }
        .nav-link {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #555;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        .footer {
            background-color: rgba(51, 51, 51, 0.9);
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #fff;
            width: 100%;
            position: relative;
            bottom: 0;
            z-index: 1;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
    </script>
    <script src="/_vercel/insights/script.js" defer></script>
</head>
<body>
    <div class="background-image"></div>
    <div class="top-nav">
        <a href="/" class="nav-link">Home</a>
        <a href="/videos.php" class="nav-link">Videos</a>
        <a href="/about.php" class="nav-link">About</a>
        <a href="/contact.php" class="nav-link">Contact</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/profile.php" class="nav-link">Perfil</a>
            <a href="/logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="/" class="nav-link">Login</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1>Termos de Serviço</h1>
        <h2>Nick Dwtyay, Ltd.</h2>
        <p>Estes Termos de Serviço regem o uso do site e serviços fornecidos pela Nick Dwtyay, Ltd. Ao acessar ou usar nosso site, você concorda com os termos aqui descritos.</p>
        <h3>1. Aceitação dos Termos</h3>
        <p>Ao criar uma conta ou usar nossos serviços, você aceita cumprir estes termos. Caso não concorde, não utilize o site.</p>
        <h3>2. Uso Permitido</h3>
        <p>Você concorda em usar nossos serviços apenas para fins legais e de acordo com as leis aplicáveis.</p>
        <h3>3. Propriedade Intelectual</h3>
        <p>Todo o conteúdo do site é propriedade da Nick Dwtyay, Ltd. e protegido por leis de direitos autorais.</p>
        <h3>4. Limitação de Responsabilidade</h3>
        <p>Não nos responsabilizamos por danos indiretos ou interrupções no serviço causadas por fatores fora de nosso controle.</p>
        <p>Última atualização: 07 de Março de 2025.</p>
        <p><a href="/">Voltar ao Login</a></p>
    </div>
   <footer class="footer">
    NICK DWTYAY, LTD.<br>
    "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
    <a href="/Terms.php">Terms</a> |
    <a href="/Privacy_Policy.php">Privacy Policy</a> |
    All Rights Reserved | © 2006 - 2025 Nick Dwtyay, Ltd.
</footer>
</body>
</html>
