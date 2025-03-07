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
