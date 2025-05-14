
<?php
http_response_code(404);
$requested_url = htmlspecialchars($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>
    <h1>404 - Página Não Encontrada</h1>
    <p>A URL <strong><?php echo $requested_url; ?></strong> não existe.</p>
    <p>Você será redirecionado para a página inicial em <span id="countdown">5</span> segundos...</p>

    <script>
        let seconds = 5;
        const countdown = document.getElementById('countdown');
        const timer = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = '/api/collect_data.php'; // Redireciona para a página desejada
            }
        }, 1000);
    </script>
</body>
</html>

<?php
http_response_code(404);
header("Refresh: 5; url=/api/collect_data.php");
$requested_url = htmlspecialchars($_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>
    <h1>404 - Página Não Encontrada</h1>
    <p>A URL <strong><?php echo $requested_url; ?></strong> não existe.</p>
    <p>Você será redirecionado em breve...</p>
</body>
</html>

<?php
http_response_code(404);
$requested_url = htmlspecialchars($_SERVER['REQUEST_URI']);
$host = $_SERVER['HTTP_HOST'];

// Integração com Supabase (opcional)
require 'vendor/autoload.php';
use Supabase\SupabaseClient;
$supabase = new SupabaseClient(getenv('SUPABASE_URL'), getenv('SUPABASE_KEY'));
$supabase->from('404_logs')->insert([
    'url' => $requested_url,
    'host' => $host,
    'accessed_at' => date('Y-m-d H:i:s')
])->execute();

// Sugestões de páginas relacionadas
$suggested_pages = [
    '/about.php' => 'Sobre Nós',
    '/contact.php' => 'Contato',
    '/api/collect_data.php' => 'Página Inicial'
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include 'includes/head.php'; ?>
<body>
    <h1>404 - Página Não Encontrada</h1>
    <p>A URL <strong><?php echo $requested_url; ?></strong> não existe em <?php echo $host; ?>.</p>
    <p>Talvez você esteja procurando por:</p>
    <ul>
        <?php foreach ($suggested_pages as $url => $title): ?>
            <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <p>Você será redirecionado para a página inicial em <span id="countdown">5</span> segundos...</p>

    <script>
        let seconds = 5;
        const countdown = document.getElementById('countdown');
        const timer = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = '/api/collect_data.php';
            }
        }, 1000);
    </script>
</body>
</html>
