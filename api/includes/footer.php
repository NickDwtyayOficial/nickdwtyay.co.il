<?php
// api/includes/footer.php
?>
<footer class="footer" style="background:#222; color:#fff; padding:20px 0; text-align:center;">
    <div class="footer-social" style="margin: 20px 0;">
        <span>Follow us:</span>
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
   
    <a href="/Terms.php">Terms</a> |
    <a href="/Privacy_Policy.php">Privacy Policy</a> |
    All Rights Reserved © 2006 - 2026 Nick Dwtyay, Ltd.
</footer>
<!-- Scripts extras (se realmente forem necessários para todas as páginas) -->
<script>
    window.va = window.va || function (...args) { (window.vaq = window.vaq || []).push(args); };
</script>
<script src="/_vercel/insights/script.js" defer></script>


<script>
(() => {
  const RELOAD_MS = 180000; // 3 minutos
  let timer = null;

  function hardReload() {
    // Adiciona/atualiza um parâmetro de cache-buster para forçar carregamento da rede
    const url = new URL(window.location.href);
    url.searchParams.set('_r', Date.now());
    // Usamos replace para não criar entrada extra no histórico
    window.location.replace(url.toString());
  }

  function schedule() {
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (document.visibilityState === 'visible') {
        // garante recarga completa (scripts, ads, tracking serão executados do zero)
        hardReload();
      } else {
        // se aba estiver oculta, espera até ficar visível para recarregar
        const onVis = () => {
          if (document.visibilityState === 'visible') {
            document.removeEventListener('visibilitychange', onVis);
            hardReload();
          }
        };
        document.addEventListener('visibilitychange', onVis);
      }
    }, RELOAD_MS);
  }

  // Reseta o temporizador ao detectar atividade do utilizador (evita recargas no meio de interação)
  ['mousemove','keydown','scroll','touchstart'].forEach(evt =>
    document.addEventListener(evt, () => {
      schedule();
    }, { passive: true })
  );

  // Se a página já estiver carregada, starta o agendamento
  if (document.readyState === 'complete') schedule();
  else window.addEventListener('load', schedule);
})();
</script>





