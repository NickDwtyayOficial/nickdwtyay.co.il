<?php
session_start();
require_once __DIR__ . '/api/db_connect.php'; // Ajuste o caminho se necessário

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica se o usuário tá logado (opcional, tire se quiser acesso público)
if (!isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = db_query("users?id=eq.$user_id&is_active=eq.true");
if (!$user || !is_array($user) || count($user) === 0) {
    header("Location: /login.php?error=session_invalid");
    exit();
}

$user_data = $user[0];
$pdf_path = '/api/covid_report.pdf'; // Caminho relativo na raiz
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Primeiro Relatório COVID-19 - Análise de Dados - Por Nicássio Guimarães</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f4f4f4; 
        }
        nav { 
            background: #333; 
            color: white; 
            padding: 10px; 
            text-align: center; 
        }
        nav ul { 
            list-style: none; 
            margin: 0; 
            padding: 0; 
            display: flex; 
            justify-content: center; 
        }
        nav ul li { 
            margin-right: 20px; 
        }
        nav ul li a { 
            color: white; 
            text-decoration: none; 
            font-weight: bold; 
        }
        nav ul li a:hover { 
            text-decoration: underline; 
        }
        .container { 
            max-width: 1200px; 
            margin: 20px auto; 
            padding: 0 20px; 
        }
        embed { 
            width: 100%; 
            height: 80vh; 
            border: none; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #333; 
        }
        p { 
            color: #555; 
        }
        .footer { 
            text-align: center; 
            padding: 20px; 
            background: #333; 
            color: white; 
            position: relative; 
            bottom: 0; 
            width: 100%; 
            margin-top: 20px; 
        }
        .footer a { 
            color: #fff; 
            text-decoration: none; 
        }
        .footer a:hover { 
            text-decoration: underline; 
        }
        .background-image { 
            display: none; /* Removido, pois não tá definido */ 
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/videos.php">Videos</a></li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/contact.php">Contact</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Primeiro Relatório COVID-19 - Análise de Dados</h1>
        <p>Por Nicássio Guimarães</p>
        <embed src="<?php echo htmlspecialchars($pdf_path); ?>" type="application/pdf">
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
