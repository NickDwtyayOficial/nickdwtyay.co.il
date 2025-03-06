<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";

    if (strlen($first_name) < 2) {
        $error = "Nome deve ter pelo menos 2 caracteres!";
    } elseif (strlen($last_name) < 2) {
        $error = "Sobrenome deve ter pelo menos 2 caracteres!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-mail inválido!";
    } elseif (strlen($password) < 8) {
        $error = "Senha deve ter pelo menos 8 caracteres!";
    } elseif (!empty($phone) && !preg_match('/^[0-9]{8,15}$/', $phone)) {
        $error = "Telefone deve ter entre 8 e 15 dígitos!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Log temporário para debug
        error_log("Hash gerado para $email: $hashed_password");

        $params = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "address" => $address,
            "phone" => $phone,
            "email" => $email,
            "password" => $hashed_password,
            "created_at" => date("c"),
            "updated_at" => date("c"),
            "is_active" => true,
            "role" => "user"
        ];
        $result = db_query("users", $params, "POST");

        if (is_array($result) && !empty($result) && isset($result[0]["email"]) && $result[0]["email"] === $email) {
            header("Location: /");
            exit;
        } else {
            $error = "Erro ao criar conta: " . htmlspecialchars(print_r($result, true));
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
                <label for="first_name">Nome:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Sobrenome:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Endereço:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{8,15}" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
            </div>
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
