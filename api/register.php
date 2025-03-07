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
            max-width: 400px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
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
        .error {
            color: red;
            text-align: center;
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
       <form method="POST" novalidate>
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Sobrenome:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Endereço:</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($address ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Criar Conta</button>
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
