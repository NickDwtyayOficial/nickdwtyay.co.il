<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 $first_name = $_POST['first_name'];
 $last_name = $_POST['last_name'];
 $address = $_POST['address'];
 $phone = $_POST['phone'];
 $email = $_POST['email'];
 $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha

 // Verifica se o e-mail já existe
 $check_email = db_query("SELECT * FROM users WHERE email=eq.$email");
 if (!empty($check_email)) {
 $error = "E-mail já registrado!";
 } else {
 // Insere o novo usuário
 $data = [
 'first_name' => $first_name,
 'last_name' => $last_name,
 'address' => $address,
 'phone' => $phone,
 'email' => $email,
 'password' => $password
 ];
 $result = db_query("", $data);
 
 if ($result) {
 header("Location: index.php");
 exit();
 } else {
 $error = "Erro ao criar conta!";
 }
 }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
 <title>Criar Conta - Nick Dwtyay, Ltd.</title>
 <link rel="stylesheet" href="style.css">
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
 <input type="text" name="address" required>
 </div>
 <div class="form-group">
 <label>Telefone:</label>
 <input type="text" name="phone" required>
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
 <button type="submit">Criar Conta</button>
 </div>
 </form>
 <p>Já tem conta? <a href="index.php">Faça login</a></p>
 </div>
</body>
</html>
