 <!-- Footer Section -->
    <footer class="footer">
      <div class="footer__container">
        <!-- Header: Logo y Redes Sociales en la misma fila -->
        <div class="footer__header">
          <!-- Logo -->
          <div class="footer__logo">
            <a href="/">
              <img src="/wp-content/uploads/2025/11/logo.png" alt="Visita Tenjo" />
            </a>
          </div>

          <!-- Social Media Icons -->
          <div class="footer__social">
            <?php if ($facebook = get_theme_mod('visit_facebook_url')) : ?>
                 <a href="<?php echo esc_url($facebook); ?>" class="footer__social-link" aria-label="Facebook">
              <img
                src="/wp-content/uploads/2025/11/icono_facebook.png"
                alt="icono de Facebook"
                target="_blank"
              />
            </a>
            <?php endif; ?>

            <?php if ($instagram = get_theme_mod('visit_instagram_url')) : ?>
                 <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="footer__social-link" aria-label="Instagram">
              <img
                src="/wp-content/uploads/2025/11/icono_instagram.png"
                alt="icono de Instagram"
                target="_blank"
              />
            </a>
            <?php endif; ?>

            <?php if ($youtube = get_theme_mod('visit_youtube_url')) : ?>
                 <a href="<?php echo esc_url($youtube); ?>" target="_blank" class="footer__social-link" aria-label="YouTube">
              <img
                src="/wp-content/uploads/2025/11/icono_youtube.png"
                alt="icono de YouTube"
                target="_blank"
              />
            </a>
            <?php endif; ?>
            <?php if ($whatsapp = get_theme_mod('visit_whatsapp_url')) : ?>
                <a href="<?php echo esc_url($whatsapp); ?>" class="footer__social-link" aria-label="WhatsApp" target="_blank">
              <img
                src="/wp-content/uploads/2025/11/icono_whatsapp.png"
                alt="icono de WhatsApp"
                target="_blank"
              />
            </a>
            <?php endif; ?>
          </div>
        </div>
        <!-- Línea blanca debajo de redes sociales -->
        <div class="footer__line"></div>

        <!-- Info Section -->
        <div class="footer__info">
          <!-- Address -->
          <div class="footer__address">
            <p>
              <?=get_theme_mod('visit_direccion')?>
            </p>
          </div>

          <!-- Contact Columns -->
          <div class="footer__contact">
            <div class="footer__contact-item">
              <h3>Subdirección de Cultura</h3>
              <p><?=get_theme_mod('visit_subCulTel')?></p>
            </div>
            <div class="footer__contact-item">
              <h3>Subdirección de Turismo</h3>
              <p><?=get_theme_mod('visit_subTur')?></p>
            </div>
            <div class="footer__contact-item">
              <h3>Línea anticorrupción</h3>
              <p><?=get_theme_mod('visit_lineaCorr')?></p>
            </div>
          </div>
        </div>

        <!-- Large Logo Watermark -->
        <div class="footer__watermark">
          <img src="/wp-content/uploads/2025/11/logo_gris.png" alt="logo de Tenjo gris" />
        </div>
      </div>
    </footer>
    <?php wp_footer(); ?>
