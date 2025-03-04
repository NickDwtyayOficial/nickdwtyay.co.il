<?php
require_once 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
 header("Location: index.php");
 exit();
}

$user_id = $_SESSION['user_id'];
$user = db_query("SELECT * FROM users WHERE id=eq.$user_id")[0];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
 <title>Perfil - Nick Dwtyay, Ltd.</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
 <div class="container">
 <h2>Seu Perfil</h2>
 <p><strong>Nome:</strong> <?php echo $user['first_name']; ?></p>
 <p><strong>Sobrenome:</strong> <?php echo $user['last_name']; ?></p>
 <p><strong>Endereço:</strong> <?php echo $user['address']; ?></p>
 <p><strong>Telefone:</strong> <?php echo $user['phone']; ?></p>
 <p><strong>E-mail:</strong> <?php echo $user['email']; ?></p>
 <a href="logout.php">Sair</a>
 </div>
</body>
</html>
