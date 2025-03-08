<?php
require_once __DIR__ . '/db_connect.php';
session_start();

error_log("Iniciando reset_password.php");

$token = $_GET['token'] ?? '';
$error = $success = null;

if (empty($token)) {
    $error = "Token inválido!";
} else {
    $reset = db_query("password_resets?token=eq.$token&expires_at=gte." . date('c'));
    error_log("Busca por token: " . json_encode($reset));

    if (is_array($reset) && !empty($reset)) {
        $user_id = $reset[0]['user_id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = $_POST['new_password'] ?? '';
            if (strlen($new_password) < 8) {
                $error = "A senha deve ter pelo menos 8 caracteres!";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_data = ['password' => $hashed_password, 'updated_at' => date('c')];
                $update_result = db_query("users?id=eq.$user_id", $update_data, "PATCH");
                error_log("Atualização da senha: " . json_encode($update_result));

                if (is_array($update_result) && !empty($update_result)) {
                    db_query("password_resets?token=eq.$token", null, "DELETE");
                    $success = "Senha redefinida! <a href='/'>Faça login</a>";
                } else {
                    $error = "Erro ao redefinir a senha!";
                }
            }
        }
    } else {
        $error = "Token inválido ou expirado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Redefinir Senha - Nick Dwtyay, Ltd.</title>
     <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; height: 100vh; overflow-x: hidden; }
        .background-image { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-image: url('https://codingdatatoday.co/wp-content/uploads/2024/06/Os-Principais-Tipos-de-Analise-de-Dados-e-Suas-Aplicacoes.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; z-index: -1; filter: brightness(70%); }
        .top-nav { display: flex; justify-content: center; background-color: rgba(51, 51, 51, 0.9); padding: 10px 0; position: relative; z-index: 1; }
        .nav-link { padding: 10px 20px; color: #fff; text-decoration: none; transition: background-color 0.3s ease; }
        .nav-link:hover { background-color: #555; }
        .container { max-width: 800px; margin: 50px auto; background-color: rgba(255, 255, 255, 0.95); border: 1px solid #ccc; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); position: relative; z-index: 1; }
        h2 { text-align: center; color: #333; }
        .footer { background-color: rgba(51, 51, 51, 0.9); padding: 20px; text-align: center; font-size: 14px; color: #fff; width: 100%; position: relative; bottom: 0; z-index: 1; }
        .footer a { color: #fff; text-decoration: none; margin: 0 5px; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
   <div class="background-image"></div>
    <div class="top-nav">
        <a href="/home.php" class="nav-link">Home</a>
        <a href="/videos.php" class="nav-link">Videos</a>
        <a href="/about.php" class="nav-link">About</a>
        <a href="/contact.php" class="nav-link">Contact</a>
    </div>
    <div class="container">
        <h2>Redefinir Senha</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (!isset($success)) { ?>
            <form method="POST">
                <div class="form-group">
                    <label>Nova Senha:</label>
                    <input type="password" name="new_password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Redefinir</button>
                </div>
            </form>
        <?php } ?>
        <p><a href="/">Voltar ao Login</a></p>
    </div>
    <footer class="footer">
        NICK DWTYAY, LTD.<br>
        "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
        <a href="/Terms.php">Terms</a> |
        <a href="/Privacy_Policy.php">Privacy Policy</a> |
        All Rights Reserved | © 2006 - 2022 Nick Dwtyay, Ltd.
    </footer>
   <script>
        window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
    </script>
    <script src="/_vercel/insights/script.js" defer></script>
</head>
</body>
</html>
