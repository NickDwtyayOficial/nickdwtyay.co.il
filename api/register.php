<?php
require_once __DIR__ . '/db_connect.php';

error_log("Iniciando register.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    // Validações básicas
    if (empty($first_name) || strlen($first_name) < 2) {
        $error = "Nome deve ter pelo menos 2 caracteres!";
    } elseif (empty($last_name) || strlen($last_name) < 2) {
        $error = "Sobrenome deve ter pelo menos 2 caracteres!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "E-mail inválido!";
    } elseif (strlen($password) < 8) {
        $error = "Senha deve ter pelo menos 8 caracteres!";
    } elseif (!empty($phone) && !preg_match('/^[0-9]{8,15}$/', $phone)) {
        $error = "Telefone deve ter entre 8 e 15 dígitos!";
    } else {
        // Verifica se o e-mail já existe
        $check_email = db_query("users?email=eq.$email");
        error_log("Resultado da verificação de email: " . json_encode($check_email));

        if (is_array($check_email) && !empty($check_email)) {
            $error = "E-mail já registrado!";
        } else {
            // Gera o hash da senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            error_log("Hash gerado: $hashed_password");

            // Dados para inserção
            $data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'address' => $address,
                'phone' => $phone,
                'email' => $email,
                'password' => $hashed_password,
                'created_at' => date('c'),
                'updated_at' => date('c'),
                'is_active' => true,
                'role' => 'user'
            ];

            // Insere o novo usuário
            $result = db_query("users", $data, "POST");
            error_log("Resultado da inserção: " . json_encode($result));

            if (is_array($result) && !empty($result) && isset($result[0]['email'])) {
                header("Location: /");
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
        <p>Já tem conta? <a href="/">Faça login</a></p>
    </div>
</body>
</html>
