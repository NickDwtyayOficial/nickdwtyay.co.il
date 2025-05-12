<?php
session_start();
require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/vendor/autoload.php'; // Para SendGrid

use SendGrid\Mail\Mail;

error_log("Iniciando recover_password.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    error_log("E-mail recebido: $email");

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Digite um e-mail válido!";
        error_log("Erro: E-mail inválido");
    } else {
        // Buscar usuário no Supabase
        $user = db_query("users?email=eq.$email&is_active=eq.true");
        error_log("Busca por email '$email': " . json_encode($user));

        if (is_array($user) && !empty($user)) {
            $user_id = $user[0]['id'] ?? null;
            if (!$user_id) {
                error_log("Erro: user_id não encontrado para email $email");
                $error = "Erro interno. Tente novamente.";
            } else {
                $token = bin2hex(random_bytes(16)); // Token de 32 caracteres
                $expires_at = date('c', strtotime('+1 hour')); // Expira em 1 hora

                // Usar user_id
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

                    // Enviar e-mail via SendGrid
                    $sendgrid = new Mail();
                    $from_email = getenv('FROM_EMAIL');
                    $from_name = getenv('FROM_NAME');
                    error_log("Enviando e-mail de $from_email para $email");
                    $sendgrid->setFrom($from_email, $from_name);
                    $sendgrid->setSubject("Recuperação de Senha - Nick Dwtyay, Ltd.");
                    $sendgrid->addTo($email);
                    $sendgrid->addContent("text/plain", "Clique no link para redefinir sua senha: $reset_link\nO link expira em 1 hora.");
                    $sg = new \SendGrid(getenv('SENDGRID_API_KEY'));

                    try {
                        $response = $sg->send($sendgrid);
                        error_log("SendGrid response: " . $response->statusCode() . " - " . json_encode($response->body()));
                        if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
                            $_SESSION['success'] = "Link de redefinição enviado para o seu e-mail!";
                            header("Location: /");
                            exit();
                        } else {
                            $error = "Erro ao enviar o e-mail. Tente novamente.";
                            error_log("Falha ao enviar e-mail para $email: " . json_encode($response->body()));
                        }
                    } catch (Exception $e) {
                        $error = "Erro ao enviar o e-mail. Tente novamente.";
                        error_log("Exceção SendGrid: " . $e->getMessage());
                    }
                } else {
                    $error = "Erro ao gerar o token!";
                    error_log("Falha na inserção do token: " . json_encode($result));
                }
            }
        } else {
            $error = "E-mail não encontrado!";
            error_log("Nenhum usuário encontrado para $email");
        }
    }
} else {
    error_log("Método não é POST: " . $_SERVER['REQUEST_METHOD']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://www.statcounter.com 'unsafe-inline'; connect-src 'self' https://*.vercel.app https://c.statcounter.com; style-src 'self' 'unsafe-inline'; img-src 'self' https://c.statcounter.com; font-src 'self';">
    <link rel="icon" href="/dwtyay_favicon.gif" type="image/gif">
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
            <form method="POST" action="/api/recover_password.php">
                <label>E-mail:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Enviar Link</button>
            </div>
        </form>
        <p><a href="/">Voltar ao Login</a></p>
    </div>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <script>
        window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
    </script>
    <script src="/_vercel/insights/script.js" defer></script>
</body>
</html>
