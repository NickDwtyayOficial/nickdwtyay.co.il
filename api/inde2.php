<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Sign In - Nick Dwtyay, Ltd.</title><link rel="stylesheet" href="/api/styles.css">
<style>
:root {
  --primary-color: #4caf50;
  --primary-hover: #45a049;
  --dark-bg: rgba(51, 51, 51, 0.9);
  --light-bg: rgba(255, 255, 255, 0.95);
  --text-dark: #333;
  --text-light: #fff;
  --error-color: #e74c3c;
  --border-radius: 5px;
  --box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  --transition: all 0.3s ease;
  /* Adicionando variáveis do index.php para consistência */
  --gradient-dark: linear-gradient(to bottom, #1a1a1a, #4d4d4d);
  --highlight-color: #ff0000;
  --highlight-hover: #cc0000;
}

/* Reset e Base (index2.php) */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  font-size: 16px;
  scroll-behavior: smooth;
}

body {
  font-family: 'Arial', sans-serif;
  line-height: 1.6;
  color: var(--text-dark);
  background: var(--gradient-dark); /* Usando o gradiente do index.php */
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  overflow-x: hidden;
  text-align: center; /* Mantendo centralização do index.php */
}

/* Imagem de Fundo (index2.php) */
.background-image {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('https://codingdatatoday.co/wp-content/uploads/2024/06/Os-Principais-Tipos-de-Analise-de-Dados-e-Suas-Aplicacoes.webp');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  z-index: -1;
  filter: brightness(70%);
}

/* Navegação (index2.php) */
.top-nav {
  display: flex;
  justify-content: center;
  background-color: var(--dark-bg);
  padding: 1rem 0;
  position: relative;
  z-index: 1;
  flex-wrap: wrap;
}

.nav-link {
  padding: 0.5rem 1.25rem;
  color: var(--text-light);
  text-decoration: none;
  transition: var(--transition);
  font-size: 1rem;
  margin: 0.25rem;
}

.nav-link:hover {
  background-color: #555;
  border-radius: var(--border-radius);
}

/* Container Principal (index2.php) */
.container {
  width: 90%;
  max-width: 1200px;
  margin: 2rem auto;
  background-color: var(--light-bg);
  border: 1px solid #ccc;
  padding: 1.5rem;
  box-shadow: var(--box-shadow);
  border-radius: var(--border-radius);
  position: relative;
  z-index: 1;
}

/* Tipografia (index2.php) */
h1, h2, h3, h4 {
  margin-bottom: 1rem;
  line-height: 1.2;
}

h2 {
  text-align: center;
  color: var(--text-dark);
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
}

/* Formulários (index2.php) */
.form-group {
  margin-bottom: 1.25rem;
  width: 100%;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
  font-size: 1rem;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  font-size: 1rem;
  border-radius: var(--border-radius);
  border: 1px solid #ccc;
  transition: var(--transition);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}

.form-group button {
  width: 100%;
  padding: 0.75rem;
  font-size: 1rem;
  background-color: var(--primary-color);
  color: var(--text-light);
  border: none;
  border-radius: var(--border-radius);
  cursor: pointer;
  transition: var(--transition);
  font-weight: bold;
}

.form-group button:hover {
  background-color: var(--primary-hover);
  transform: translateY(-2px);
}

/* Rodapé (index2.php, ajustado com estilo do index.php) */
.footer {
  background-color: var(--dark-bg);
  padding: 1.5rem;
  text-align: center;
  font-size: 0.9em;
  color: #ccc; /* Cor do index.php */
  width: 100%;
  position: relative;
  margin-top: auto;
  z-index: 1;
}

.footer a {
  color: var(--text-light);
  text-decoration: none;
  margin: 0 0.5rem;
  transition: var(--transition);
}

.footer a:hover {
  text-decoration: underline;
  color: var(--primary-color);
}

/* Mensagens de Erro (index2.php) */
.error {
  color: var(--error-color);
  text-align: center;
  margin-bottom: 1rem;
  padding: 0.5rem;
  background-color: rgba(231, 76, 60, 0.1);
  border-radius: var(--border-radius);
}

/* Estilos do index.php (integrados) */
header.car-header { /* Renomeado para evitar conflitos */
  background: url('https://source.unsplash.com/1600x400/?car,racing') no-repeat center;
  background-size: cover;
  padding: 50px 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
}

header.car-header h1 {
  font-size: 3em;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0;
  text-shadow: 2px 2px 4px #000;
  color: var(--text-light); /* Ajustado para consistência */
}

header.car-header .intro {
  font-size: 1.2em;
  margin: 20px 0;
  text-shadow: 1px 1px 2px #000;
  color: var(--text-light);
}

.info-box {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  padding: 20px;
  margin: 20px auto;
  max-width: 600px;
  box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
}

.info-box pre {
  text-align: left;
  font-size: 1em;
  color: #ffcc00;
  white-space: pre-wrap;
}

.car-button { /* Renomeado para evitar conflitos */
  background: var(--highlight-color);
  color: var(--text-light);
  border: none;
  padding: 15px 30px;
  font-size: 1.2em;
  border-radius: var(--border-radius);
  cursor: pointer;
  transition: var(--transition);
}

.car-button:hover {
  background: var(--highlight-hover);
}

/* Layout Responsivo (index2.php) */
@media (max-width: 768px) {
  html {
    font-size: 14px;
  }
  
  .container {
    width: 95%;
    padding: 1rem;
  }
  
  .top-nav {
    flex-direction: column;
    align-items: center;
    padding: 0.5rem 0;
  }
  
  .nav-link {
    width: 100%;
    text-align: center;
    padding: 0.75rem;
  }
  
  .form-group button {
    padding: 1rem;
  }
}

@media (max-width: 480px) {
  .container {
    margin: 1rem auto;
  }
  
  h2 {
    font-size: 1.5rem;
  }
  
  .footer {
    padding: 1rem;
    font-size: 0.75rem;
  }
}

/* Utilitários (index2.php) */
.text-center {
  text-align: center;
}

.mt-1 { margin-top: 0.5rem; }
.mt-2 { margin-top: 1rem; }
.mt-3 { margin-top: 1.5rem; }
.mt-4 { margin-top: 2rem; }

.p-1 { padding: 0.5rem; }
.p-2 { padding: 1rem; }
.p-3 { padding: 1.5rem; }

/* Efeitos de Hover (index2.php) */
.hover-scale {
  transition: var(--transition);
}

.hover-scale:hover {
  transform: scale(1.02);
}

/* Grid Responsivo (index2.php) */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
  margin: 1.5rem 0;
}

/* Cards (index2.php) */
.card {
  background: var(--light-bg);
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  padding: 1.5rem;
  transition: var(--transition);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
      </style>
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


<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db_connect.php';

use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Se o usuário já está logado, redireciona para o dashboard
if (isset($_SESSION['user_id'])) {
    error_log("Usuário já logado - user_id: " . $_SESSION['user_id']);
    header("Location: /api/dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Preencha todos os campos!";
    } else {
        error_log("Tentando login com email: $email");
        $user = db_query("users?email=eq.$email&is_active=eq.true&select=id,password");
        
        if (isset($user['error'])) {
            $error = "Estamos em manutenção!";
            error_log("Erro no Supabase: " . $user['error']);
        } elseif (is_array($user) && !empty($user) && password_verify($password, $user[0]['password'])) {
            $_SESSION['user_id'] = $user[0]['id'];
            setcookie('user_id', $user[0]['id'], time() + 3600, '/', '', true, true);
            session_write_close();
            error_log("Login bem-sucedido - user_id: " . $_SESSION['user_id']);
            header("Location: /api/dashboard.php");
            exit();
        } else {
            $error = "Credenciais inválidas!";
            error_log("Falha no login - Credenciais inválidas para email: $email");
        }
    }
}

// Recupera dados do visitante da sessão
$visitor_info = $_SESSION['visitor_info'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Sign In - Nick Dwtyay, Ltd.</title>
    <link rel="stylesheet" href="/api/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ua-parser-js/1.0.37/ua-parser.min.js"></script>
    <style>
        /* CSS do api/index2.php (copie o CSS original aqui) */
        :root {
            --primary-color: #4caf50;
            --primary-hover: #45a049;
            /* ... resto do CSS ... */
        }
        /* Insira o CSS completo do api/index2.php */
    </style>
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

    <script>
        let visitorInfo = <?php echo json_encode($visitor_info); ?>;
        console.log('visitorInfo inicial:', visitorInfo);

        // Captura detalhes do dispositivo com UAParser
        try {
            const parser = new UAParser();
            const result = parser.getResult();
            visitorInfo.browser = `${result.browser.name || "Unknown"} ${result.browser.version || ""}`;
            visitorInfo.os = `${result.os.name || "Unknown"} ${result.os.version || ""}`;
            visitorInfo.device_vendor = result.device.vendor || "Not identified";
            visitorInfo.device_model = result.device.model || "Not identified";
            visitorInfo.device_type = result.device.type || "Unknown";
            visitorInfo.device_category = (visitorInfo.device_type === "mobile" || visitorInfo.device_type === "tablet") ? "mobile" : "desktop";
            console.log('UAParser result:', result);
        } catch (e) {
            console.error('Erro no UAParser:', e);
            visitorInfo.device_category = "Unknown";
        }

        // Captura geolocalização
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    visitorInfo.latitude = position.coords.latitude;
                    visitorInfo.longitude = position.coords.longitude;
                    console.log('Geolocalização precisa:', visitorInfo.latitude, visitorInfo.longitude);
                    updateSupabase();
                },
                function(error) {
                    console.error('Erro na geolocalização:', error.message);
                    updateSupabase();
                },
                { timeout: 10000, enableHighAccuracy: true }
            );
        } else {
            console.log('Geolocalização não suportada, usando IP');
            updateSupabase();
        }

        // Captura informações de rede
        if (navigator.connection) {
            visitorInfo.network_type = navigator.connection.effectiveType || "Unknown";
            visitorInfo.downlink = navigator.connection.downlink || "Unknown";
            console.log('Conexão:', visitorInfo.network_type, visitorInfo.downlink);
        } else {
            console.log('navigator.connection não suportado');
        }

        function updateSupabase() {
            fetch('/update_visitor.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    ip: visitorInfo.ip,
                    browser: visitorInfo.browser,
                    os: visitorInfo.os,
                    device_vendor: visitorInfo.device_vendor,
                    device_model: visitorInfo.device_model,
                    device_type: visitorInfo.device_type,
                    device_category: visitorInfo裝置_category,
                    latitude: visitorInfo.latitude,
                    longitude: visitorInfo.longitude,
                    network_type: visitorInfo.network_type || null,
                    downlink: visitorInfo.downlink || null,
                    referrer: visitorInfo.referrer,
                    source: visitorInfo.source,
                    is_facebook: visitorInfo.is_facebook
                })
            })
            .then(response => response.json())
            .then(data => console.log('Update Result:', data))
            .catch(error => console.error('Erro no fetch:', error));
        }
    </script>
</body>
</html>

