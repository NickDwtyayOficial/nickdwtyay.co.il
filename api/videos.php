<?php
session_start();
require_once __DIR__ . '/db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Corrigido de "error_reportin" pra "error_reporting"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>Videos - Nick Dwtyay, Ltd.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
            background-color: #f4f4f4;
        }
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            filter: brightness(70%);
            overflow: hidden;
        }
        .background-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 2%, transparent 2%) 0 0 / 20px 20px;
            opacity: 0.3;
            animation: pulse 10s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.05); opacity: 0.5; }
            100% { transform: scale(1); opacity: 0.3; }
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 24px;
            color: #333;
            text-align: center;
        }
        .hebrew {
            font-size: 20px;
            color: #555;
            text-align: center;
            margin-top: 10px;
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
        <a href="/videos.php" class="nav-link">Videos</a>
        <a href="/about.php" class="nav-link">About</a>
        <a href="/contact.php" class="nav-link">Contact</a>
        <a href="/" class="nav-link">Login</a>
    </div>
    <div class="container">
        <h2>Videos</h2>
        <div class="message">This page is under construction.</div>
        <div class="hebrew">דף זה נמצא בבנייה.</div>
    </div>
    <footer class="footer">
        NICK DWTYAY, LTD.<br>
        "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
        <a href="api/Terms.php">Terms</a> |
        <a href="api/Privacy_Policy.php">Privacy Policy</a> |
        All Rights Reserved | © 2006 - 2025 Nick Dwtyay, Ltd.
    </footer>
</body>
</html>
