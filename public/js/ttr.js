/* TTR · comportamiento mínimo (sin dependencias) */
(function () {
    'use strict';

    var raiz = document.documentElement;

    /* ---- Tema claro/oscuro (respeta el sistema; el botón lo sobrescribe) ---- */
    var botonTema = document.querySelector('.btn-tema');
    if (botonTema) {
        botonTema.addEventListener('click', function () {
            var actual = raiz.dataset.tema ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            var nuevo = actual === 'dark' ? 'light' : 'dark';
            raiz.dataset.tema = nuevo;
            try { localStorage.setItem('ttr-tema', nuevo); } catch (e) { /* almacenamiento bloqueado */ }
        });
    }

    /* ---- Menú móvil ---- */
    var toggle = document.querySelector('.nav-toggle');
    var menu = document.getElementById('menu-principal');
    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            var abierto = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!abierto));
            menu.classList.toggle('abierto', !abierto);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menu.classList.contains('abierto')) {
                toggle.setAttribute('aria-expanded', 'false');
                menu.classList.remove('abierto');
                toggle.focus();
            }
        });
    }

    /* ---- Fachada de video: el iframe externo se crea solo al hacer clic ---- */
    document.querySelectorAll('.video-fachada[data-embed]').forEach(function (boton) {
        boton.addEventListener('click', function () {
            var iframe = document.createElement('iframe');
            var url = boton.dataset.embed;
            iframe.src = url + (url.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1';
            iframe.title = boton.dataset.titulo || 'Video';
            iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen';
            iframe.setAttribute('allowfullscreen', '');
            iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
            iframe.className = 'video-fachada__iframe';
            boton.replaceWith(iframe);
            iframe.focus();
        });
    });

    /* ---- Confirmación antes de acciones destructivas ---- */
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm(form.dataset.confirm)) { e.preventDefault(); }
        });
    });
})();
