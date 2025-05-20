<?php
// api/includes/footer.php
?>
<footer class="footer" style="background:#222; color:#fff; padding:20px 0; text-align:center;">
    <div class="footer-social" style="margin: 20px 0;">
        <span>Siga-nos:</span>
        <a href="https://facebook.com/nikc.dwtyay" target="_blank" style="margin:0 10px; color:#3b5998;" title="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.kwai.com/@NICK_DWTYAY" target="_blank" style="margin:0 10px;" title="Kwai">
            <img src="https://cdn-static.kwai.net/kos/s101/nlav11312/icon/kwai/2/favicon.ico" alt="Kwai" style="width:18px;vertical-align:middle;">
        </a>
        <a href="https://instagram.com/nickdwtyay" target="_blank" style="margin:0 10px; color:#E1306C;" title="Instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://il.linkedin.com/in/nic%C3%A1ssio-guimar%C3%A3es-b0660223b" target="_blank" style="margin:0 10px; color:#0077b5;" title="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
        </a>
        <a href="https://www.tiktok.com/@nick.dwtyay" target="_blank" style="margin:0 10px; color:#010101;" title="TikTok">
            <i class="fab fa-tiktok"></i>
        </a>
        <a href="https://x.com/dwtyayp" target="_blank" style="margin:0 10px; color:#000;" title="X (Twitter)">
            <i class="fab fa-x-twitter"></i>
        </a>
    </div>
    NICK DWTYAY, LTD.<br>
    "Americas and Middle East Cybersecurity Software and Technology Solutions Development Company."<br>
    <a href="/Terms.php">Terms</a> |
    <a href="/Privacy_Policy.php">Privacy Policy</a> |
    All Rights Reserved © 2006 - 2025 Nick Dwtyay, Ltd.
</footer>
<!-- Scripts extras (se realmente forem necessários para todas as páginas) -->
<script>
    window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
</script>
<script src="/_vercel/insights/script.js" defer></script>
<!-- Cookie Consent Banner -->
<div class="cookie-consent">
    <p>We use first-party cookies to improve our services. 
        <a href="/api/Privacy_Policy.php#cookies">Learn more</a>
    </p>
    <div class="cookie-buttons">
        <button class="accept-btn">Accept</button>
        <button class="optout-btn">Opt out</button>
        <button class="privacy-btn">Privacy settings</button>
    </div>
</div>

<style>
.cookie-consent {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.9);
    color: white;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    z-index: 1000;
    font-size: 0.875rem;
}

.cookie-buttons {
    display: flex;
    gap: 0.5rem;
}

.accept-btn, .optout-btn, .privacy-btn {
    padding: 0.25rem 0.625rem;
    height: 1.625rem;
    font-size: 0.75rem;
    border-radius: 0.375rem;
    cursor: pointer;
}

.accept-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
}

.optout-btn {
    background: transparent;
    border: 1px solid #ccc;
    color: white;
}

.privacy-btn {
    background: transparent;
    border: none;
    color: #ccc;
    margin-left: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o usuário já fez uma escolha
    if (document.cookie.includes('cookie_consent=')) {
        document.querySelector('.cookie-consent').style.display = 'none';
        return;
    }

    // Lógica para aceitar cookies
    document.querySelector('.accept-btn').addEventListener('click', function() {
        document.cookie = "cookie_consent=accepted; path=/; max-age=31536000; SameSite=Strict";
        document.querySelector('.cookie-consent').style.display = 'none';
        // Ativa seus scripts de analytics/tracking aqui
    });
    
    // Lógica para recusar cookies
    document.querySelector('.optout-btn').addEventListener('click', function() {
        document.cookie = "cookie_consent=rejected; path=/; max-age=31536000; SameSite=Strict";
        document.querySelector('.cookie-consent').style.display = 'none';
        // Desativa seus scripts de analytics/tracking aqui
    });
    
    // Lógica para configurações de privacidade
    document.querySelector('.privacy-btn').addEventListener('click', function() {
        // Implemente a abertura de um modal com mais opções
        alert('Privacy settings would open here');
    });
});
</script>

