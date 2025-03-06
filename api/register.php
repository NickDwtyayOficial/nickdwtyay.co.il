<?php
require_once __DIR__ . '/db_connect.php';

error_log("Iniciando register.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-mail inválido!";
    } elseif (strlen($password) < 8) {
        $error = "Senha deve ter pelo menos 8 caracteres!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        error_log("Hash gerado: $hashed_password");

        $params = [
            "first_name" => "Teste",
            "last_name" => "Usuario",
            "email" => $email,
            "password" => $hashed_password,
            "created_at" => date("c"),
            "updated_at" => date("c"),
            "is_active" => true,
            "role" => "user"
        ];

        error_log("Chamando db_query com params: " . json_encode($params));
        $result = db_query("users", $params, "POST");

        if (is_array($result) && !empty($result)) {
            error_log("Registro bem-sucedido: " . json_encode($result));
            header("Location: /");
            exit;
        } else {
            $error = "Erro ao criar conta: " . htmlspecialchars(print_r($result, true));
            error_log("Erro no registro: " . json_encode($result));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>
    <div class="container">
        <h2>Criar Conta</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" novalidate>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Senha (mín. 8 caracteres):</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            <div class="form-group">
                <button type="submit">Criar</button>
            </div>
        </form>
        <p>Já tem conta? <a href="/">Login</a></p>
    </div>
</body>
</html>
