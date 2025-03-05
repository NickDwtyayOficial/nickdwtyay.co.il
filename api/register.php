<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"] ?? "";
    $last_name = $_POST["last_name"] ?? "";
    $address = $_POST["address"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {
        $params = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "address" => $address,
            "phone" => $phone,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "created_at" => date("c")
        ];
        $result = db_query("users", $params);

        // Debug: Mostra o resultado completo do Supabase
        echo "Resposta do Supabase: <pre>" . print_r($result, true) . "</pre>";

        if (is_array($result) && isset($result["email"]) && $result["email"] == $email) {
            header("Location: /");
            exit;
        } else {
            $error = "Erro ao criar conta: " . print_r($result, true);
        }
    } else {
        $error = "Preencha todos os campos obrigatórios!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Criar Conta - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/style.css">
</head>
<body>
    <div class="container">
        <h2>Criar Conta</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Nome:</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label>Sobrenome:</label>
                <input type="text" name="last_name" required>
            </div>
            <div class="form-group">
                <label>Endereço:</label>
                <input type="text" name="address">
            </div>
            <div class="form-group">
                <label>Telefone:</label>
                <input type="text" name="phone">
            </div>
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Criar</button>
            </div>
        </form>
        <p>Já tem conta? <a href="/">Login</a></p>
    </div>
</body>
</html>
