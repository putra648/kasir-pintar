(function () {
    'use strict';

    var STORAGE_KEY = 'kp-theme';
    var root = document.documentElement;
    var toggle = document.getElementById('themeToggle');
    var icon = document.getElementById('themeToggleIcon');
    var meta = document.getElementById('metaThemeColor');

    function readStored() {
        try {
            return localStorage.getItem(STORAGE_KEY);
        } catch (e) {
            return null;
        }
    }

    function apply(mode) {
        var dark = mode === 'dark';

        root.classList.toggle('dark', dark);

        if (icon) {
            icon.classList.toggle('fa-moon', !dark);
            icon.classList.toggle('fa-sun', dark);
        }

        if (toggle) {
            toggle.setAttribute('aria-pressed', dark ? 'true' : 'false');
            toggle.setAttribute('title', dark ? 'Mode terang' : 'Mode gelap');
        }

        if (meta) {
            meta.setAttribute('content', dark ? '#0b1020' : '#4f46e5');
        }
    }

    apply(readStored() === 'dark' ? 'dark' : 'light');

    if (toggle) {
        toggle.addEventListener('click', function () {
            var next = root.classList.contains('dark') ? 'light' : 'dark';

            try {
                localStorage.setItem(STORAGE_KEY, next);
            } catch (e) {
                /* storage unavailable; theme still applies for this page */
            }

            apply(next);
        });
    }
})();
