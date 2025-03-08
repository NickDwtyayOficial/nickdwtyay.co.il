<?php
require_once __DIR__ . '/db_connect.php';
session_start();

error_log("Iniciando recover_password.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Digite um e-mail válido!";
    } else {
        $user = db_query("users?email=eq.$email&is_active=eq.true");
        error_log("Busca por email: " . json_encode($user));

        if (is_array($user) && !empty($user)) {
            $user_id = $user[0]['id'];
            $token = bin2hex(random_bytes(16)); // Token de 32 caracteres
            $expires_at = date('c', strtotime('+1 hour')); // Expira em 1 hora

            $reset_data = [
                'user_id' => $user_id,
                'token' => $token,
                'expires_at' => $expires_at,
                'created_at' => date('c')
            ];
            $result = db_query("password_resets", $reset_data, "POST");
            error_log("Inserção do token: " . json_encode($result));

            if (is_array($result) && !empty($result)) {
                $reset_link = "https://nickdwtyay.com.br/reset_password.php?token=$token";
                $subject = "Recuperação de Senha - Nick Dwtyay, Ltd.";
                $message = "Clique no link pra redefinir sua senha: $reset_link\nO link expira em 1 hora.";
                $headers = "From: no-reply@nickdwtyay.com.br";

                if (mail($email, $subject, $message, $headers)) {
                    $success = "Link de redefinição enviado pro seu e-mail!";
                } else {
                    $error = "Erro ao enviar o e-mail. Tente novamente.";
                    error_log("Falha ao enviar e-mail para $email");
                }
            } else {
                $error = "Erro ao gerar o token!";
            }
        } else {
            $error = "E-mail não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Recuperar Senha - Nick Dwtyay, Ltd.</title>
      <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; height: 100vh; overflow-x: hidden; }
        .background-image { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-image: url('https://codingdatatoday.co/wp-content/uploads/2024/06/Os-Principais-Tipos-de-Analise-de-Dados-e-Suas-Aplicacoes.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; z-index: -1; filter: brightness(70%); }
        .top-nav { display: flex; justify-content: center; background-color: rgba(51, 51, 51, 0.9); padding: 10px 0; position: relative; z-index: 1; }
        .nav-link { padding: 10px 20px; color: #fff; text-decoration: none; transition: background-color 0.3s ease; }
        .nav-link:hover { background-color: #555; }
        .container { max-width: 400px; margin: 50px auto; background-color: rgba(255, 255, 255, 0.95); border: 1px solid #ccc; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); position: relative; z-index: 1; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 20px; width: 100%; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box; }
        .form-group button { width: 100%; padding: 10px; font-size: 16px; background-color: #4caf50; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        .form-group button:hover { background-color: #45a049; }
        .error { color: red; text-align: center; }
        .success { color: green; text-align: center; }
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
        <h2>Recuperar Senha</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Enviar Link</button>
            </div>
        </form>
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
</body>
</html>

