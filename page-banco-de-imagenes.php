<?php get_header(); ?>
<!-- Hero del Banco de Imágenes -->
<section
  class="banco-hero"
  style="background-image: url('/wp-content/uploads/2025/11/banco-imagenes-bg.jpg')"
>
  <div class="banco-hero__overlay"></div>
  <div class="banco-hero__content" data-aos="fade-right">
    <!-- Buscador -->
    <div class="banco-hero__search">
      <div class="banco-hero__search-wrapper">
        <img src="/wp-content/uploads/2025/11/lupa.png" alt="Buscar" class="banco-hero__search-icon" />
        <input
          type="search"
          id="searchInput"
          name="search"
          class="banco-hero__search-input"
          placeholder="Escribe aquí lo que estas buscando"
          aria-label="Buscar imágenes"
          autocomplete="off"
        />
      </div>

      <!-- Separador vertical -->
      <div class="banco-hero__divider"></div>

      <!-- Select de categorías -->
      <div class="banco-hero__select-wrapper">
        <select
          class="banco-hero__select"
          id="categorySelect"
          name="category"
          class="banco-hero__select"
          aria-label="Seleccionar categoría"
        >
          <option value="">CATEGORÍAS</option>
          <option value="naturaleza">Naturaleza</option>
          <option value="cultura">Cultura</option>
          <option value="gastronomia">Gastronomía</option>
          <option value="eventos">Eventos</option>
          <option value="arquitectura">Arquitectura</option>
        </select>
      </div>
      <!-- Botón oculto para enviar con Enter -->
      <button type="submit" class="visually-hidden">Buscar</button>
    </div>
  </div>
</section>

<!-- Sección Galería de Imágenes -->
<section class="galeria">
  <div class="galeria__container">
    <!-- Imagen 1 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-1" class="galeria__checkbox" />
      <label for="lightbox-1" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/tenjo-2.webp"
          alt="Oso polar en el hielo"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <!-- Lightbox -->
      <div class="galeria__lightbox">
        <label for="lightbox-1" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-2.webp"
            alt="Oso polar en el hielo"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 2 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-2" class="galeria__checkbox" />
      <label for="lightbox-2" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/tenjo-3.jpg"
          alt="Velero al atardecer"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-2" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-3.jpg"
            alt="Velero al atardecer"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 3 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-3" class="galeria__checkbox" />
      <label for="lightbox-3" class="galeria__image-wrapper">
        <img src="/wp-content/uploads/2025/11/tenjo-4.jpg" alt="Río en la selva" class="galeria__image" />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-3" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-4.jpg"
            alt="Río en la selva"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 4 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-4" class="galeria__checkbox" />
      <label for="lightbox-4" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/tenjo-5.jpeg"
          alt="Volcán en erupción"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-4" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-5.jpeg"
            alt="Volcán en erupción"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 5 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-5" class="galeria__checkbox" />
      <label for="lightbox-5" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/tenjo-6.jpg"
          alt="Persona brindando"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-5" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-6.jpg"
            alt="Persona brindando"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 6 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-6" class="galeria__checkbox" />
      <label for="lightbox-6" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/tenjo-7.webp"
          alt="Castillo en la montaña"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-6" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-7.webp"
            alt="Castillo en la montaña"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 7 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-7" class="galeria__checkbox" />
      <label for="lightbox-7" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/tenjo-8.jpg"
          alt="Camino al atardecer"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-7" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-8.jpg"
            alt="Camino al atardecer"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 8 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-8" class="galeria__checkbox" />
      <label for="lightbox-8" class="galeria__image-wrapper">
        <img src="/wp-content/uploads/2025/11/tenjo-9.webp" alt="Bosque otoñal" class="galeria__image" />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-8" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/tenjo-9.webp"
            alt="Bosque otoñal"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 9 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-9" class="galeria__checkbox" />
      <label for="lightbox-9" class="galeria__image-wrapper">
        <img src="/wp-content/uploads/2025/11/volcan-1.jpg" alt="Van en el bosque" class="galeria__image" />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-9" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/volcan-1.jpg"
            alt="Van en el bosque"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 10 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-10" class="galeria__checkbox" />
      <label for="lightbox-10" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/velero.jpg"
          alt="Montaña rocosa"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-10" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/velero.jpg"
            alt="Montaña rocosa"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 11 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-11" class="galeria__checkbox" />
      <label for="lightbox-11" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/van-1.jpg"
          alt="Surfista en la ola"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-11" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/van-1.jpg"
            alt="Surfista en la ola"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>

    <!-- Imagen 12 -->
    <div class="galeria__item" data-categoria="naturaleza">
      <input type="checkbox" id="lightbox-12" class="galeria__checkbox" />
      <label for="lightbox-12" class="galeria__image-wrapper">
        <img
          src="/wp-content/uploads/2025/11/volcan-scaled.jpg"
          alt="Ciclistas en carrera"
          class="galeria__image"
        />
        <div class="galeria__overlay">
          <span class="galeria__btn-view" aria-label="Ver imagen">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </span>
        </div>
      </label>
      <div class="galeria__lightbox">
        <label for="lightbox-12" class="galeria__lightbox-close">×</label>
        <div class="galeria__lightbox-content">
          <img
            src="/wp-content/uploads/2025/11/volcan-scaled.jpg"
            alt="Ciclistas en carrera"
            class="galeria__lightbox-image"
          />
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
