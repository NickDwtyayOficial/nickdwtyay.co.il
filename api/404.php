<?php
session_start();
require_once __DIR__ . '/db_connect.php';
// Configurações para evitar cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$redirectTime = 5; // Tempo de redirecionamento em segundos
?>
<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>אתר בתחזוקה</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            text-align: center;
            padding: 30px;
            direction: rtl;
            background-color: #f4f4f4;
            margin: 0;
        }
        h1 {
            color: #333;
            font-size: 2.2em;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            font-size: 1.1em;
            margin: 10px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-size: 1em;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 600px) {
            h1 { font-size: 1.8em; }
            p { font-size: 1em; }
            .container { margin: 10px; padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>אתר בתחזוקה</h1>
        <p>אנו מבצעים שיפורים באתר. תועבר לדף הבית בעוד <span id="countdown"><?php echo $redirectTime; ?></span> שניות.</p>
        <p><a href="/api/index.php">לחץ כאן כדי לעבור כעת</a></p> <!-- ALTERADO: de /home.php para /home.html -->
        <noscript>
            <p>נראה ש-JavaScript מושבת. <a href="/api/index.php">לחץ כאן</a> כדי לעבור לדף הבית.</p> <!-- ALTERADO: de /api/index.php para /home.html -->
        </noscript>
    </div>

    <script>
        let seconds = <?php echo $redirectTime; ?>;
        const countdownElement = document.getElementById('countdown');

        const updateCountdown = () => {
            if (countdownElement) {
                countdownElement.textContent = seconds;
                seconds--;
                if (seconds < 0) {
                    window.location.href = '/api/index.php'; // ALTERADO: de /home.php para /home.html
                }
            }
        };

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
