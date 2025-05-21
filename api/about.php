<?php
require_once __DIR__ . '/db_connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>About - Nick Dwtyay, Ltd.</title>```html
<meta name="description" content="About Nick Dwtyay, Ltd. - Founded in 2006, we are leaders in telecommunications, cybersecurity, and technology, connecting communities across the Americas and the Middle East with innovative solutions.">
```
    <link rel="icon" type="image/gif" href="/api/static/dwtyay_favicon.gif">
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
        h2 {
            text-align: center;
            color: #333;
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
        .texto-branco {
            color: #fff;
        }
        /* Improved Box Styling */
        .meu-box {
            max-width: 90%;
            width: 100%;
            background: rgba(255, 255, 255, 0.98); /* Slightly more opaque for contrast */
            border: 2px solid #333;
            border-radius: 12px;
            padding: 25px;
            margin: 20px auto;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Stronger shadow */
            color: #222; /* Slightly darker text for readability */
            transition: transform 0.3s ease; /* Smooth hover effect */
        }
        .meu-box:hover {
            transform: translateY(-5px); /* Subtle lift on hover */
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
        <main>
            <section class="meu-box">
                <h2>Welcome</h2>
                <p>Welcome to the official repository of <strong>Nick Dwtyay</strong>, an initiative by <strong>Nick Dwtyay, Ltd.</strong>, a pioneer company in <strong>telecommunications, cybersecurity, and technology</strong>, operating across the <strong>Americas and the Middle East</strong>.</p>
                <p>Founded in <strong>2006</strong> by <strong>Nicássio Guimarães</strong>, the brand originated as a creative pseudonym on Orkut and evolved into a <strong>global ecosystem of innovation, media, and technology</strong> that empowers communities with digital solutions.</p>
            </section>

            <section>
                <h2>General Information</h2>
                <ul>
                    <li><strong>Headquarters:</strong> Unknown</li>
                    <li><strong>Founded:</strong> 2006</li>
                    <li><strong>Contact:</strong> <a href="mailto:contato@nickdwtyay.com.br">contato@nickdwtyay.com.br</a></li>
                    <li><strong>Website:</strong> <a href="https://nickdwtyay.com.br">nickdwtyay.com.br</a></li>
                </ul>
            </section>

            <section>
                <h2>Our Journey</h2>
                <ul>
                    <li><strong>2006</strong> – Started on Orkut as a pseudonym to protect Nicássio’s identity.</li>
                    <li><strong>2010–2012</strong> – Moved to Facebook, keeping anonymity and growing reach.</li>
                    <li><strong>2014–2017</strong> – Launched a YouTube channel with a viral video reaching <strong>100k views</strong>.</li>
                    <li><strong>2017</strong> – Created the community-focused blog <em>Candeal Notícia</em> hosted on Blogger. Learned <strong>HTML and CSS</strong>.</li>
                    <li><strong>2018</strong> – Blog closed with a positive legacy for the community. You can check it here <a href="https://web.archive.org/web/20181122114420/http://candealbanoticias.blogspot.com/">https://web.archive.org/web/20181122114420/http://candealbanoticias.blogspot.com/</a></li>
                    <li><strong>2018–2021</strong> – Expanded to <strong>Kwai</strong> and <strong>TikTok</strong>, with videos reaching over <strong>1 million views</strong>.</li>
                    <li><strong>2021–2025</strong> – Solidified on Kwai with <strong>10k+ followers</strong> and <strong>300+ videos</strong>. Website created on <strong>GitHub Pages</strong> using <strong>Canvas, SVG, PHP, and Supabase</strong>.</li>
                    <li><strong>2025</strong> – Launched cybersecurity tools like the <strong>DNS Cleanup Tool</strong> (v2.2 in testing).</li>
                </ul>
            </section>

            <section>
                <h2>Main Projects</h2>
                <ul>
                    <li><a href="https://github.com/NickDwtyayOficial/community-server" target="_blank">Community Server</a>: Python scripts for network monitoring.</li>
                    <li><a href="https://github.com/NickDwtyayOficial/Full-Network-Reset-Tool/blob/main/reset_network.bat" target="_blank">Cache & DNS Cleanup Tool</a>: System optimization with cache and DNS flushing.</li>
                </ul>
            </section>

            <section>
                <h2>Getting Started</h2>
                <p><strong>Requirements:</strong></p>
                <ul>
                    <li>Systems: Windows, Linux, macOS</li>
                    <li>Languages: Python 3.8+, PHP, HTML, CSS, JavaScript</li>
                    <li>Tools: Scapy, GCC, pip, Vercel, Supabase, Cloudflare, WordPress</li>
                </ul>
                <p><section>
    <h2>Installation</h2>
    <ol>
        <li>Clone the repository:
            <pre><code>git clone https://github.com/NickDwtyayOficial/Full-Network-Reset-Tool.git
cd Full-Network-Reset-Tool
pip install -r requirements.txt
cp .env.example .env
python main.py</code></pre>
        </li>
    </ol>
                </section>

            <section>
    <h2>How to Use</h2>
    <p>Windows Script – Cache/DNS Cleanup:</p>
    <pre><code>@echo off
:: Full Network Reset Tool v2.2
:: Copyright (c) 2025 Nick Dwtyay Ltd.

echo [1/5] Flushing DNS cache...
ipconfig /flushdns

echo [2/5] Resetting TCP/IP stack...
netsh int ip reset reset.log

echo [3/5] Clearing temp files...
del /q /s %temp%\*

echo [4/5] Renewing IP address...
ipconfig /release && ipconfig /renew

echo [5/5] Rebooting interfaces...
netsh interface set interface "Ethernet" admin=disable
netsh interface set interface "Ethernet" admin=enable
</code></pre>
    <p>More examples in <a href="docs/usage.md">docs/usage.md</a>.</p>
            </section>
            <section>
                <h2>Contributing</h2>
                <ol>
                    <li>Read the <a href="CONTRIBUTING.md">Contribution Guidelines</a></li>
                    <li>Create your branch:
                        <pre><code>git checkout -b my-feature</code></pre>
                    </li>
                    <li>Submit a clear Pull Request</li>
                    <li>Report issues in <a href="https://github.com/NickDwtyayOficial/nickdwtyay/issues">Issues</a></li>
                </ol>
            </section>

            <section>
                <h2>License</h2>
                <p>This software is licensed as follows:</p>
                <ul>
                    <li><strong>Permissions:</strong> Personal or commercial use (non-exclusive, non-transferable)</li>
                    <li><strong>Restrictions:</strong> Copying, modifying, distributing, or sublicensing without formal authorization is prohibited.</li>
                    <li><strong>Copyright:</strong> All rights reserved to <strong>Nick DwtyAy Ltd.</strong></li>
                </ul>
                <p>Full details in <code>LICENSE</code>.</p>
            </section>

            <section>
                <h2>Author</h2>
                <p><strong>Nicássio Guimarães</strong> (Pseudonym: Nick DwtyAy)</p>
                <ul>
                    <li><a href="https://il.linkedin.com/in/nic%C3%A1ssio-guimar%C3%A3es-b0660223b" target="_blank">LinkedIn</a></li>
                    <li><a href="https://www.instagram.com/nic2ss7o" target="_blank">Instagram</a></li>
                    <li><a href="https://www.tiktok.com/@nick.dwtyay" target="_blank">TikTok</a></li>
                </ul>
            </section>

            <section>
                <h2>Connect With Us</h2>
                <ul>
                    <li><a href="https://nickdwtyay.com.br">Official Site</a> — <strong>6,000+ monthly visitors (2024)</strong></li>
                    <li><a href="https://nickdwtyayltd.business.site">Google Business</a></li>
                    <li><a href="https://www.kwai.com/@NICK_DWTYAY">Kwai</a> — <strong>10k+ followers, 17k views/month</strong></li>
                    <li><a href="https://soundcloud.com/nick-dwtyay">SoundCloud</a></li>
                    <li><a href="https://open.spotify.com/user/22seuxxasmpnyt5gsobxyzfty">Spotify</a></li>
                    <li><a href="https://x.com/dwtyayp">Twitter</a></li>
                    <li><a href="https://www.instagram.com/nickdwtyay">Instagram</a></li>
                    <li><a href="https://www.youtube.com/nickdwtyay">YouTube</a> — <strong>100k+ views</strong></li>
                    <li><a href="https://www.pensador.com/colecao/nicassiocguimaraes/">Pensador</a></li>
                </ul>
            </section>

            <section>
                <h2>Partnerships</h2>
                <ul>
                    <li><a href="https://contabil-d.com.br">Contabil-D</a></li>
                    <li><em>More partners coming soon.</em></li>
                </ul>
            </section>
        </main>
    </div>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
    </html>
