<?php
require_once __DIR__ . '/db_connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head> <link rel="icon" href="dwtyay_favicon.gif" type="image/gif">
    <title>About - Nick Dwtyay, Ltd.</title>
 <link rel="icon" type="image/gif" href="/api/static/dwtyay_favicon.gif">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; height: 100vh; overflow-x: hidden; }
        .background-image { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-image: url('https://codingdatatoday.co/wp-content/uploads/2024/06/Os-Principais-Tipos-de-Analise-de-Dados-e-Suas-Aplicacoes.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; z-index: -1; filter: brightness(70%); }
        .top-nav { display: flex; justify-content: center; background-color: rgba(51, 51, 51, 0.9); padding: 10px 0; position: relative; z-index: 1; }
        .nav-link { padding: 10px 20px; color: #fff; text-decoration: none; transition: background-color 0.3s ease; }
        .nav-link:hover { background-color: #555; }
        .container { max-width: 800px; margin: 50px auto; background-color: rgba(255, 255, 255, 0.95); border: 1px solid #ccc; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); position: relative; z-index: 1; }
        h2 { text-align: center; color: #333; }
        .footer { background-color: rgba(51, 51, 51, 0.9); padding: 20px; text-align: center; font-size: 14px; color: #fff; width: 100%; position: relative; bottom: 0; z-index: 1; }
        .footer a { color: #fff; text-decoration: none; margin: 0 5px; }
        .footer a:hover { text-decoration: underline; }
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
<section class="about-hero">
    <div class="container">
        <h1>About Nick Dwtyay</h1>
        <p class="lead">Pioneering telecommunications and cybersecurity solutions across the Americas and Middle East since 2006.</p>
    </div>
</section>

<section class="about-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Our Story</h2>
                <p>Welcome to <strong>Nick Dwtyay Ltd</strong>, a global innovator in <strong>telecommunications, cybersecurity, and technology</strong> solutions operating across the Americas and the Middle East.</p>
                
                <p>Founded in <strong>2006</strong> by <strong>Nicássio Guimarães</strong>, the brand began as a creative pseudonym on Orkut and has evolved into a comprehensive ecosystem of innovation, media, and technology that empowers communities through digital solutions.</p>
                
                <div class="info-box">
                    <h3>Company Overview</h3>
                    <ul class="fa-ul">
                        <li><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> <strong>Headquarters:</strong> Brazil & Israel</li>
                        <li><span class="fa-li"><i class="fas fa-calendar-alt"></i></span> <strong>Founded:</strong> 2006</li>
                        <li><span class="fa-li"><i class="fas fa-envelope"></i></span> <strong>Contact:</strong> <a href="mailto:contato@nickdwtyay.com.br">contato@nickdwtyay.com.br</a></li>
                        <li><span class="fa-li"><i class="fas fa-globe"></i></span> <strong>Website:</strong> <a href="https://nickdwtyay.com.br">nickdwtyay.com.br</a></li>
                    </ul>
                </div>
                
                <h2>Our Journey</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-year">2006</div>
                        <div class="timeline-content">
                            <p>Emerged on Orkut as a pseudonym to protect Nicássio's identity.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2010-2012</div>
                        <div class="timeline-content">
                            <p>Transitioned to Facebook, maintaining anonymity while expanding reach.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2014-2017</div>
                        <div class="timeline-content">
                            <p>Launched the <a href="https://www.youtube.com/nickdwtyay" target="_blank">YouTube channel</a>, with a viral video hitting <strong>100K views</strong>.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2017</div>
                        <div class="timeline-content">
                            <p>Created the community-focused blog <strong>Candeal Notícia</strong> (hosted on Blogger). <a href="https://web.archive.org/web/20181122114420/http://candealbanoticias.blogspot.com/" target="_blank">View archived version</a>.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2018-2021</div>
                        <div class="timeline-content">
                            <p>Expanded to series and content on <strong>Kwai/TikTok</strong>, with videos surpassing <strong>1M views</strong>.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2021-2025</div>
                        <div class="timeline-content">
                            <p>Grew Kwai to <strong>10K+ followers</strong>; launched <a href="https://nickdwtyay.com.br">nickdwtyay.com.br</a> using modern web technologies.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2025</div>
                        <div class="timeline-content">
                            <p>Released cybersecurity tools like the <strong>DNS Cleanup Tool (v2.2)</strong>.</p>
                        </div>
                    </div>
                </div>
                
                <h2>Key Projects</h2>
                <div class="projects-grid">
                    <div class="project-card">
                        <h3>Community Server</h3>
                        <p>Python scripts for network monitoring and analysis.</p>
                        <a href="https://github.com/NickDwtyayOficial/community-server" class="btn btn-outline-primary" target="_blank">View Project</a>
                    </div>
                    
                    <div class="project-card">
                        <h3>Cache & DNS Cleanup Tool</h3>
                        <p>Optimizes system performance via cache/DNS flushing.</p>
                        <a href="https://github.com/NickDwtyayOficial/nickdwtyay.co.il/blob/main/Command-ipconfig-Nick-Dwtyay-Ltd.bat" class="btn btn-outline-primary" target="_blank">View Project</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="sidebar-widget">
                    <h3>Quick Facts</h3>
                    <div class="fact-item">
                        <div class="fact-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="fact-content">
                            <h4>10K+</h4>
                            <p>Social Media Followers</p>
                        </div>
                    </div>
                    
                    <div class="fact-item">
                        <div class="fact-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="fact-content">
                            <h4>100K+</h4>
                            <p>YouTube Views</p>
                        </div>
                    </div>
                    
                    <div class="fact-item">
                        <div class="fact-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="fact-content">
                            <h4>6+</h4>
                            <p>Programming Languages</p>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-widget">
                    <h3>Connect With Us</h3>
                    <div class="social-links">
                        <a href="https://www.youtube.com/nickdwtyay" target="_blank" class="social-link youtube"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.kwai.com/@NICK_DWTYAY" target="_blank" class="social-link kwai"><i class="fas fa-video"></i></a>
                        <a href="https://x.com/dwtyayp" target="_blank" class="social-link twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/nickdwtyay" target="_blank" class="social-link instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://il.linkedin.com/in/nic%C3%A1ssio-guimar%C3%A3es-b0660223b" target="_blank" class="social-link linkedin"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="partners-section">
    <div class="container">
        <h2>Our Partners</h2>
        <div class="partners-grid">
            <div class="partner-logo">
                <a href="https://contabil-d.com.br" target="_blank">
                    <img src="images/contabil-d-logo.png" alt="Contabil-D">
                </a>
            </div>
            <!-- More partner logos can be added here -->
        </div>
        <p class="text-muted">More partners coming soon.</p>
    </div>
</section>
    
     <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
