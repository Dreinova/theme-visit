<?php get_header(); ?>
   <?php 
   $description = get_the_content($post->ID); 
   $image = get_the_post_thumbnail_url($post->ID);
   ?>
            
  <div class="interna__shadow"></div>

  <div class="interna__container">
    <!-- Botón Volver -->
    <a href="banco-imagenes.html" class="interna__btn-volver">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M19 12H5M12 19l-7-7 7-7" />
      </svg>
      VOLVER A LA BÚSQUEDA
    </a>

    <!-- Layout principal (TARJETA) -->
    <div class="interna__layout">
      <!-- Imagen a la izquierda -->
      <div class="interna__image-wrapper">
        <img id="internaImagen" src="<?=$image?>" alt="imagen oso polar" class="interna__image" />
      </div>

      <!-- Panel lateral derecho -->
      <div class="interna__panel">
        <h1 class="interna__title">¡Obtén esta imagen / video GRATIS!</h1>
        <?= $description ?>
        <a href="#" id="btnDescargar" class="interna__btn-descargar" download>
          DESCARGAR IMAGEN
        </a>
      </div>
    </div>
  </div>

  <!-- Modal de descarga -->
  <div id="modalDescarga" class="modal">
    <div class="modal__overlay"></div>
    <div class="modal__content">
      <button class="modal__close" aria-label="Cerrar modal">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M18 6L6 18M6 6l12 12" />
        </svg>
      </button>

      <h2 class="modal__title">¡Ya casi tienes tu foto!</h2>

      <p class="modal__description">
        Para descargarla, escribe tu nombre y apellido, el correo al cual
        llegará el link de descarga, acepta los términos y condiciones, y
        confirma. Recuerda que solo te solicitaremos estos datos la primera
        vez que realices una descarga en un dispositivo nuevo.
      </p>

      <div class="modal__form">
        <!-- Campo Nombre -->
        <div class="modal__field-wrapper">
          <input type="text" class="modal__input" placeholder="NOMBRE*" id="nombre" required />
          <div class="modal__error" id="errorNombre">Campo obligatorio</div>
        </div>

        <!-- Campo Apellidos -->
        <div class="modal__field-wrapper">
          <input type="text" class="modal__input" placeholder="APELLIDOS*" id="apellidos" required />
          <div class="modal__error" id="errorApellidos">
            Campo obligatorio
          </div>
        </div>

        <!-- Campo Cédula -->
        <div class="modal__field-wrapper">
          <input type="text" class="modal__input" placeholder="CÉDULA*" id="cedula" required />
          <div class="modal__error" id="errorCedula">Campo obligatorio</div>
        </div>

        <!-- Campo Correo -->
        <div class="modal__field-wrapper">
          <input type="email" class="modal__input" placeholder="CORREO ELECTRÓNICO*" id="correo" required />
          <div class="modal__error" id="errorCorreo">Campo obligatorio</div>
        </div>

        <!-- Checkbox políticas -->
        <div class="modal__checkbox-group">
          <label class="modal__checkbox">
            <input type="checkbox" id="politicas" required checked disabled />
            <span class="modal__checkbox-label">
              He leído y acepto la
              <a href="#" target="_blank">política de tratamiento de datos
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                  <polyline points="15 3 21 3 21 9"></polyline>
                  <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
              </a>
            </span>
          </label>

          <label class="modal__checkbox">
            <input type="checkbox" id="condiciones" required checked disabled />
            <span class="modal__checkbox-label">
              He leído y acepto las condiciones de uso de la imagen.
              <a href="#" target="_blank">Resolución 239 del 5 de noviembre de 2021
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                  <polyline points="15 3 21 3 21 9"></polyline>
                  <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
              </a>
            </span>
          </label>
        </div>

        <!-- Texto legal -->
        <div class="modal__legal">
          <h4>Ley de Protección de Datos Personales:</h4>
          <p>
            "La autorización suministrada en el presente formulario faculta al
            Instituto de Turismo de Tenjo para que dé a sus datos aquí
            recopilados el tratamiento señalado en la "Política de Privacidad
            para el Tratamiento de Datos Personales" de la entidad, el cual
            incluye, entre otras, el envío de información, así como la
            invitación a eventos. El titular de los datos podrá, en cualquier
            momento, solicitar que la información sea modificada, actualizada
            o retirada de las bases de datos del Instituto de Turismo de
            Tenjo."
          </p>
        </div>

        <!-- Botón confirmar -->
        <button class="modal__btn-confirmar" id="btnConfirmarDescarga">
          CONFIRMAR DESCARGA
        </button>
      </div>
    </div>
  </div>

<?php get_footer(); ?>
