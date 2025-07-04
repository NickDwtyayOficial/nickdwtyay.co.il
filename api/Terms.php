<?php
session_start();
require_once __DIR__ . '/./db_connect.php';

$page_title = "Terms of Service - Nick Dwtyay, Ltd.";
$current_page = "terms";
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
<link rel="icon" href="/api/static/dwtyay_favicon.gif" type="image/gif">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
        }
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
            z-index: -1;
            filter: brightness(70%);
        }
        .top-nav {
            display: flex;
            justify-content: center;
            background-color: rgba(51, 51, 51, 0.9);
            padding: 10px 0;
            position: relative;
            z-index: 1;
        }
        .nav-link {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .nav-link:hover {
            background-color: #555;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        p {
            line-height: 1.6;
            color: #555;
        }
        .footer {
            background-color: rgba(51, 51, 51, 0.9);
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #fff;
            width: 100%;
            position: relative;
            bottom: 0;
            z-index: 1;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }
        .footer a:hover {
            text-decoration: underline;
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
        <a href="/" class="nav-link">Home</a>
        <a href="/videos.php" class="nav-link">Videos</a>
        <a href="/about.php" class="nav-link">About</a>
        <a href="/contact.php" class="nav-link">Contact</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/profile.php" class="nav-link">Perfil</a>
            <a href="/logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="/" class="nav-link">Login</a>
        <?php endif; ?>
    </div>
<div class="terms-content">
        <div class="big-title">Terms of Use and Property Rights</div>
        <p><strong>Last updated:</strong> [insert preferred date]</p>
        <p>Welcome to Nickdwtyay.com.br (“Website”), operated by Nick Dwtyay Ltd. (“we,” “our,” or “the Company”).</p>
        <p>These Terms of Use set forth the legally binding rules and responsibilities governing your access to and use of the Website. By accessing or using the Website, you fully accept these Terms. If you do not agree, please refrain from using the Website.</p>
        
        <div class="section-title">1. Jurisdiction and Governing Law</div>
        <p>These Terms are governed by the laws of the State of Israel, without regard to its conflict of law principles. Any dispute arising under or in connection with this Website or these Terms shall be subject to the exclusive jurisdiction of the competent courts located in Tel Aviv, Israel, unless otherwise agreed upon in writing.</p>
        
        <div class="section-title">2. Changes to the Terms</div>
        <p>We reserve the right to modify these Terms at any time, at our sole discretion. Any changes become effective immediately upon publication. It is your responsibility to review these Terms regularly.</p>
        
        <div class="section-title">3. Intellectual Property Rights</div>
        <p>All content on this Website — including, but not limited to, texts, images, graphics, logos, trademarks, videos, software, interface structures, and data architecture — is protected by Israeli copyright, intellectual property laws, and international treaties.</p>
        <p>You do not acquire any ownership rights by accessing or using the content. No content may be copied, distributed, modified, reproduced, published, or transmitted without prior written consent from the Company, except as allowed under the doctrine of fair use under Israeli law.</p>
        
        <div class="section-title">4. Permitted Use</div>
        <p>You agree to use this Website only for lawful and legitimate purposes, including:</p>
        <ul>
            <li>Complying with the laws of Israel and your country of residence;</li>
            <li>Respecting the Company’s and third parties’ intellectual property rights;</li>
            <li>Maintaining the integrity and security of the Website.</li>
        </ul>
        <p>Prohibited actions include:</p>
        <ul>
            <li>Attempting to access servers or databases without authorization;</li>
            <li>Reverse engineering, scraping, data mining, or any unauthorized commercial use.</li>
        </ul>
        
        <div class="section-title">5. User-Generated Content</div>
        <p>If the Website allows comments, uploads, forums, or other forms of user-generated content:</p>
        <ul>
            <li>You grant the Company an irrevocable, perpetual, worldwide, royalty-free license to use, reproduce, translate, adapt, distribute, and publicly display such content.</li>
            <li>You affirm that you own or have the rights to post such content and that it does not infringe upon the rights of others.</li>
        </ul>
        <p>The Company reserves the right to remove any offensive, illegal, or inappropriate content at its sole discretion.</p>
        
        <div class="section-title">6. Privacy and Data Protection</div>
        <p>The Company is committed to processing user data in compliance with the Israeli Protection of Privacy Law – 1981, and, where applicable, in accordance with international regulations such as the General Data Protection Regulation (GDPR).</p>
        <p>By using this Website, you consent to the collection and use of your information as outlined in our Privacy Policy.</p>
        
        <div class="section-title">7. Disclaimer of Warranties and Limitation of Liability</div>
        <p>The Website is provided "as is" and "as available," with no warranties of any kind, express or implied.</p>
        <p>The Company shall not be liable for:</p>
        <ul>
            <li>Technical issues or service interruptions;</li>
            <li>Financial or commercial losses resulting from the use or unavailability of the Website;</li>
            <li>Third-party content accessed via external links.</li>
        </ul>
        <p>You understand and agree that use of the Website is at your own risk.</p>
        
        <div class="section-title">8. Indemnification</div>
        <p>You agree to indemnify, defend, and hold harmless the Company from any claims, damages, liabilities, costs, or expenses (including legal fees) arising out of:</p>
        <ul>
            <li>Your violation of these Terms;</li>
            <li>Your misuse of the Website;</li>
            <li>Any content you submit or share through the Website.</li>
        </ul>
        
        <div class="section-title">9. Termination and Restricted Access</div>
        <p>The Company may, at its sole discretion, suspend, restrict, or terminate your access to the Website, with or without notice, if you breach these Terms or any applicable legal obligations.</p>
        
        <div class="section-title">10. Contact Information</div>
        <p>
            For questions, legal notices, or formal requests, please contact us at:<br>
            <strong>Nick Dwtyay Ltd.</strong><br>
            📧 Email: contato@nickdwtyay.com.br
        </p>
            </div>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
