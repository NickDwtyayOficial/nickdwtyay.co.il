<?php
session_start(); // Inicia a sessão

require_once __DIR__ . '/vendor/autoload.php'; // Carrega o Composer
require_once __DIR__ . '/db_connect.php'; // Inclui a função db_query

use Dotenv\Dotenv;

// Carrega o .env apenas localmente (no Vercel, as variáveis já estarão disponíveis)
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Se o usuário já está logado, redireciona para profile.php
if (isset($_SESSION['user_id'])) {
    error_log("Usuário já logado - user_id: " . $_SESSION['user_id']);
    header("Location: /api/dashboard.php"); // Ajuste aqui
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Preencha todos os campos!";
    } else {
        // Log para depuração
        error_log("Tentando login com email: $email");

        // Consulta ao Supabase
        $user = db_query("users?email=eq.$email&is_active=eq.true&select=id,password");
        
        if (isset($user['error'])) {
            $error = "אנחנו עוברים תחזוקה!";
            error_log("Erro no Supabase: " . $user['error']);
        } elseif (is_array($user) && !empty($user) && password_verify($password, $user[0]['password'])) {
            // Login bem-sucedido
            $_SESSION['user_id'] = $user[0]['id'];
            
            // Adiciona cookie como fallback para Vercel
            setcookie('user_id', $user[0]['id'], time() + 3600, '/', '', true, true); // Cookie seguro, expira em 1h
            
            // Força a gravação da sessão
            session_write_close();
            
            error_log("Login bem-sucedido - Sessão iniciada com user_id: " . $_SESSION['user_id']);
            header("Location:/api/dashboard.php");
            exit();
        } else {
            $error = "Credenciais inválidas!";
            error_log("Falha no login - Credenciais inválidas para email: $email");
        }
    }
}
?>
    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Sign In - Nick Dwtyay, Ltd.</title><link rel="stylesheet" href="styles.css">
    <script>
        window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
    </script>
    <script src="/_vercel/insights/script.js" defer></script>
</head>
<body>
    <div class="background-image"></div>
    <div class="top-nav">
        
        <a href="/videos.php" class="nav-link">Videos</a>
        <a href="/about.php" class="nav-link">About</a>
        <a href="/contact.php" class="nav-link">Contact</a>
    </div>
    <div class="container">
        <h2>Sign In</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Sign In</button>
            </div>
        </form>
        <p><a href="/recover_password.php">Forgot your password?</a></p>
        <p>Don't have an account? <a href="/register.php">Create account</a></p>
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
