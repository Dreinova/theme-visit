<!-- Footer Section -->
<footer class="footer">
  <div class="footer__container">
    <!-- Header: Logo y Redes Sociales en la misma fila -->
    <div class="footer__header">
      <!-- Logo y logos secundarios -->
      <div class="footer__logo-section">
        <div class="footer__logo-primary">
          <img src="/wp-content/uploads/2025/11/logo.png" alt="Visita Tenjo - Instituto Municipal de Cultura y Turismo" loading="lazy" decoding="async">
        </div>
        <div class="footer__logos-secondary">
          <img src="/wp-content/uploads/2025/12/logo-cultura.png"
            style="padding-right: 15px; border-right: 2px solid white;" alt="Cultura Tenjo" loading="lazy" decoding="async">
          <img src="/wp-content/uploads/2025/12/logo-alcaldia-tenjo.png" alt="Alcaldía de Tenjo" loading="lazy" decoding="async">
        </div>
      </div>
    </div>
    <div class="footer__main-info">
      <!-- Información de contacto -->
      <div class="footer__info">
        <!-- Social Media Icons -->
        <div class="footer__social">
          <?php if ($facebook = get_theme_mod('visit_facebook_url')): ?>
            <a href="<?php echo esc_url($facebook); ?>" class="footer__social-link" aria-label="Facebook Visita Tenjo" target="_blank" rel="noopener noreferrer">
              <img src="/wp-content/uploads/2025/11/icono_facebook.png" alt="" loading="lazy" decoding="async" />
            </a>
          <?php endif; ?>

          <?php if ($instagram = get_theme_mod('visit_instagram_url')): ?>
            <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="footer__social-link"
              aria-label="Instagram Visita Tenjo">
              <img src="/wp-content/uploads/2025/11/icono_instagram.png" alt="" loading="lazy" decoding="async" />
            </a>
          <?php endif; ?>

          <?php if ($youtube = get_theme_mod('visit_youtube_url')): ?>
            <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener noreferrer" class="footer__social-link" aria-label="YouTube Visita Tenjo">
              <img src="/wp-content/uploads/2025/11/icono_youtube.png" alt="" loading="lazy" decoding="async" />
            </a>
          <?php endif; ?>
          <?php if ($whatsapp = get_theme_mod('visit_whatsapp_url')): ?>
            <a href="<?php echo esc_url($whatsapp); ?>" class="footer__social-link" aria-label="WhatsApp Visita Tenjo" target="_blank" rel="noopener noreferrer">
              <img src="/wp-content/uploads/2025/11/icono_whatsapp.png" alt="" loading="lazy" decoding="async" />
            </a>
          <?php endif; ?>
        </div>

        <div class="footer__line"></div>

        <h3>Instituto Municipal de Cultura y Turismo de Tenjo</h3>
        <p>Centro Cultural Nhora Matallana,</p>
        <p>Km 1 Vía La Punta, Tenjo, Cundinamarca</p>
      </div>
      <!-- Enlaces -->
      <div class="footer__links">
        <a href="https://tenjoculturayturismo.gov.co/" class="footer__link" target="_blank" rel="noopener noreferrer">Sitio Institucional</a>
        <a href="https://www.tenjo-cundinamarca.gov.co/Paginas/default.aspx" class="footer__link" target="_blank" rel="noopener noreferrer">Alcaldía de Tenjo</a>
        <a href="https://situr.visitatenjo.com/" class="footer__link" target="_blank" rel="noopener noreferrer">Sistema De Información Turística - SITUR</a>
      </div>
    </div>
    <!-- Large Logo Watermark -->
    <div class="footer__watermark">
      <img src="/wp-content/uploads/2025/11/logo_gris.png" alt="" loading="lazy" decoding="async" />
    </div>
  </div>
</footer>
<?php wp_footer(); ?>