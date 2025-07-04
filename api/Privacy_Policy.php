<?php
session_start();
require_once __DIR__ . '/./db_connect.php';

$page_title = "Privacy Policy - Nick Dwtyay, Ltd.";
$current_page = "privacy";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title><?php echo $page_title; ?></title>
    <link rel="icon" href="/api/static/dwtyay_favicon.gif" type="image/gif">
   
 <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .background-image {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: 0;
            background: url('/caminho/para/sua-imagem.jpg') center center/cover no-repeat;
        }
        .top-nav {
            width: 100%;
            text-align: center;
            padding: 20px 0 10px 0;
            background: rgba(51, 51, 51, 0.80);
            position: relative;
            z-index: 2;
        }
        .nav-link {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border-radius: 5px;
            margin: 0 4px;
        }
        .nav-link:hover {
            background-color: #555;
        }
        .container {
            max-width: 850px;
            margin: 50px auto 30px auto;
            background-color: rgba(255,255,255,0.97);
            border-radius: 15px;
            border: 1px solid #e4e4e4;
            padding: 38px 28px;
            box-shadow: 0 0 20px rgba(0,0,0,0.10);
            position: relative;
            z-index: 3;
        }
        h1, h2 {
            color: #2a4580;
            text-align: center;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 0.2em;
        }
        h2 {
            font-size: 1.2em;
            margin-top: 2em;
        }
        p, ul {
            font-size: 1.08em;
            line-height: 1.7;
            color: #555;
        }
        ul { padding-left: 1.5em; }
        .footer {
            background-color: rgba(51,51,51,0.9);
            padding: 18px;
            text-align: center;
            font-size: 14px;
            color: #fff;
            width: 100%;
            position: relative;
            bottom: 0;
            z-index: 2;
            margin-top: 30px;
            border-radius: 0 0 10px 10px;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }
        .footer a:hover { text-decoration: underline; }
        @media (max-width: 600px) {
            .container { padding: 12px 2vw; }
            h1 { font-size: 1.2em; }
            .top-nav { font-size: 0.95em; }
        }
    </style>
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

    
<div class="container">
    <div class="switcher">
      <!-- Language Switcher Placeholder -->
      <button onclick="switchLang('en')">EN</button>
      <button onclick="switchLang('pt')">PT</button>
    </div>
    <h1>Privacy Policy</h1>
    <p style="text-align: center; font-size: 1.1em; margin-bottom: 0;">Nickdwtyay.com.br</p>
    <p style="text-align: center; font-size: 0.95em; margin-top: 0;">Last updated: June 30, 2025</p>

    <p>
      Nick Dwtyay Ltd. (“Company”, “we”, “our”) is committed to protecting your privacy and handling your data in accordance with applicable law, including the <strong>Protection of Privacy Law, 5741-1981 (Israel)</strong>, and when applicable, international frameworks such as the <strong>General Data Protection Regulation (GDPR)</strong>.
    </p>
    <p>
      This Privacy Policy explains how we collect, use, store, and protect your personal information when you interact with our website, services, or API.
    </p>

    <h2>1. Legal Basis</h2>
    <p>
      This policy is governed by the <strong>Israeli Protection of Privacy Law (1981)</strong> and its associated regulations. Where relevant, and in case of data subjects from outside Israel, we also align with <strong>international privacy principles</strong>, including consent, purpose limitation, and proportionality.
    </p>

    <h2>2. Information We Collect</h2>
    <ul>
      <li><strong>Personal Data</strong>
        <ul>
          <li>Full name</li>
          <li>Email address</li>
          <li>IP address and geolocation data</li>
          <li>Phone number (if submitted)</li>
          <li>User-generated content (e.g., messages, form entries)</li>
        </ul>
      </li>
      <li><strong>Technical and Usage Data</strong>
        <ul>
          <li>Device and browser type</li>
          <li>Operating system</li>
          <li>Pages visited and time spent</li>
          <li>Referrer URLs and session logs</li>
          <li>Cookies and tracking data</li>
        </ul>
      </li>
    </ul>

    <h2>3. Purpose of Data Collection</h2>
    <ul>
      <li>To provide and operate our services</li>
      <li>To respond to your inquiries or support requests</li>
      <li>To improve user experience through analytics</li>
      <li>To enforce our terms and protect against fraud or abuse</li>
      <li>To comply with legal obligations or requests from Israeli authorities</li>
    </ul>

    <h2>4. Consent and Your Rights</h2>
    <p>
      By using our services, you consent to the collection and use of your personal data as described in this policy.
    </p>
    <ul>
      <li><strong>Access:</strong> You may request a copy of your personal data.</li>
      <li><strong>Correction:</strong> You may request that we correct inaccurate data.</li>
      <li><strong>Deletion:</strong> You may request that we delete your data (subject to legal limitations).</li>
      <li><strong>Objection:</strong> You may object to certain data uses, especially direct marketing.</li>
      <li><strong>Withdrawal of Consent:</strong> Where processing is based on consent, you may withdraw it at any time.</li>
    </ul>
    <p>To exercise these rights, please contact us at: <a href="mailto:contato@nickdwtyay.com.br">contato@nickdwtyay.com.br</a></p>

    <h2>5. Data Retention</h2>
    <p>
      We retain your data only as long as it is necessary for the purposes described in this policy, or as required by Israeli law, including data retention obligations under tax or corporate law.
    </p>

    <h2>6. Data Security</h2>
    <p>
      We implement reasonable and industry-standard technical and organizational safeguards, including:
    </p>
    <ul>
      <li>TLS/SSL encryption</li>
      <li>Firewalls and monitoring tools</li>
      <li>Restricted administrative access</li>
      <li>Regular security audits</li>
    </ul>
    <p>
      However, no method of transmission over the internet is 100% secure. We do our best to protect your data, but we cannot guarantee absolute security.
    </p>

    <h2>7. Data Sharing and Disclosure</h2>
    <p>
      We do <strong>not sell or rent</strong> your personal data.
    </p>
    <ul>
      <li>With service providers acting on our behalf under data processing agreements</li>
      <li>To comply with legal obligations or court orders from Israeli authorities</li>
      <li>To protect rights, safety, or enforce our legal terms</li>
    </ul>

    <h2>8. International Transfers</h2>
    <p>
      If we transfer your data outside Israel (for example, for cloud hosting), we ensure adequate protection measures are in place, including:
    </p>
    <ul>
      <li>Transfers to countries with recognized data protection standards, or</li>
      <li>Standard contractual clauses (SCCs) approved by the Israeli Privacy Protection Authority or under GDPR.</li>
    </ul>

    <h2>9. Cookies and Tracking</h2>
    <p>
      We use cookies and similar technologies to improve website performance, personalize content, and analyze user behavior.
    </p>
    <p>
      You can manage cookie preferences in your browser settings. For more details, refer to our <strong>Cookie Policy</strong>.
    </p>

    <h2>10. Children’s Privacy</h2>
    <p>
      Our services are not intended for children under the age of 13. We do not knowingly collect or process personal data from minors. If you believe we have done so inadvertently, please contact us immediately.
    </p>

    <h2>11. Changes to This Policy</h2>
    <p>
      We may update this Privacy Policy to reflect changes in our practices or legal obligations. The most current version will always be available at <strong>nickdwtyay.com.br/privacy</strong>. Continued use of the service implies acceptance of the updated terms.
    </p>

    <h2>12. Contact Us</h2>
    <div class="contact">
      Nick Dwtyay Ltd.<br>
      📧 Email: <a href="mailto:contato@nickdwtyay.com.br">contato@nickdwtyay.com.br</a>
    </div>
  </div>
  <script>
    // Basic switcher placeholder for future multilingual support
    function switchLang(lang) {
      alert('Language switching not implemented yet.');
      // In production: Load and swap content for EN/PT here
    }
</script>
   <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
