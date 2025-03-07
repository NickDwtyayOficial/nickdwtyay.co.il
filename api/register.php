<?php
require_once __DIR__ . '/db_connect.php';
session_start();

error_log("Iniciando register.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = "Preencha todos os campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-mail inválido!";
    } elseif (strlen($password) < 8) {
        $error = "Senha deve ter pelo menos 8 caracteres!";
    } else {
        $check_email = db_query("users?email=eq.$email");
        if (is_array($check_email) && !empty($check_email)) {
            $error = "E-mail já registrado!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $hashed_password,
                'created_at' => date('c'),
                'updated_at' => date('c'),
                'is_active' => true,
                'role' => 'user'
            ];
            $result = db_query("users", $data, "POST");
            error_log("Resultado da inserção: " . json_encode($result));

            if (is_array($result) && !empty($result) && isset($result[0]['email'])) {
                $_SESSION['user_id'] = $result[0]['id'];
                header("Location: /profile.php");
                exit();
            } else {
                $error = "Erro ao criar conta!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Sign Up - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css"><style>
 body {
 font-family: Arial, sans-serif;
 margin: 0;
 padding: 0;
 height: 100vh; /* Garante que o body ocupe toda a altura da tela */
 overflow-x: hidden; /* Evita rolagem horizontal */
 }

 /* Estilo da Imagem de Fundo /
 .background-image {
 position: fixed; / Fixa a imagem no fundo /
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 background-image: url('https://codingdatatoday.co/wp-content/uploads/2024/06/Os-Principais-Tipos-de-Analise-de-Dados-e-Suas-Aplicacoes.webp'); / Substitua pelo caminho da imagem /
 background-size: cover; / Cobre toda a tela /
 background-position: center; / Centraliza a imagem /
 background-repeat: no-repeat; / Evita repetição /
 z-index: -1; / Coloca a imagem atrás de todo o conteúdo /
 filter: brightness(70%); / Reduz o brilho para legibilidade do texto (ajuste conforme necessário) */
 } /* Estilos da Barra de Navegação (Topo) /
 .top-nav {
 display: flex;
 justify-content: center;
 background-color: rgba(51, 51, 51, 0.9); / Fundo semi-transparente /
 padding: 10px 0;
 position: relative; / Garante que fique acima do fundo */
 z-index: 1;
 } .nav-link {
 padding: 10px 20px;
 color: #fff;
 text-decoration: none;
 transition: background-color 0.3s ease;
 } .nav-link:hover {
 background-color: #555;
 } /* Estilos do Conteúdo Principal /
 .container {
 max-width: 400px;
 margin: 50px auto;
 background-color: rgba(255, 255, 255, 0.95); / Fundo branco semi-transparente para legibilidade /
 border: 1px solid #ccc;
 padding: 20px;
 box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
 flex: 1;
 display: flex;
 flex-direction: column;
 align-items: center;
 justify-content: center;
 position: relative; / Garante que fique acima do fundo */
 z-index: 1;
 } h2 {
 text-align: center;
 color: #333;
 } .form-group {
 margin-bottom: 20px;
 width: 100%;
 } .form-group label {
 display: block;
 font-weight: bold;
 margin-bottom: 5px;
 } .form-group input {
 width: 100%;
 padding: 10px;
 font-size: 16px;
 border-radius: 5px;
 border: 1px solid #ccc;
 box-sizing: border-box;
 } .form-group button {
 width: 100%;
 padding: 10px;
 font-size: 16px;
 background-color: #4caf50;
 color: #fff;
 border: none;
 border-radius: 5px;
 cursor: pointer;
 } .form-group button:hover {
 background-color: #45a049;
 } /* Estilos do Rodapé /
 .footer {
 background-color: rgba(51, 51, 51, 0.9); / Fundo semi-transparente */
 padding: 20px;
 text-align: center;
 font-size: 14px;
 color: #fff;
 width: 100%;
 position: relative;
 bottom: 0;
 z-index: 1;
 } .footer a {
 color: #fff;
 text-decoration: none;
 margin: 0 5px;
 } .footer a:hover {
 text-decoration: underline;
 }
 </style>


    <!-- Vercel Analytics -->
    <script>
        window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
    </script>
    <script src="/_vercel/insights/script.js" defer></script>
</head>
<body>
    <!-- Imagem de Fundo -->
    <div class="background-image"></div>

    <!-- Barra de Navegação (Topo) -->
    <div class="top-nav">
        <a href="https://www.nickdwtyay.com.br/index.html" class="nav-link">Home</a>
        <a href="https://www.nickdwtyay.com.br/videos.html" class="nav-link">Videos</a>
        <a href="https://www.nickdwtyay.com.br/about.html" class="nav-link">About</a>
        <a href="https://www.nickdwtyay.com.br/contact.html" class="nav-link">Contact</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h2>Sign Up - Nick Dwtyay, Ltd.</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign Up</button>
            </div>
        </form>
        <p>Já tem conta? <a href="/">Sign In</a></p>
    </div>

    <!-- Rodapé -->
    <footer class="footer">
        NICK DWTYAY LTD<br>
        "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
        <a href="https://www.nickdwtyay.com.br/Terms.html">Terms</a> |
        <a href="https://www.nickdwtyay.com.br/Privacy_Policy.html">Privacy Policy</a> |
        All Rights Reserved | © 2006 - 2025 NICK DWTYAY
    </footer>
</body>
</html>
