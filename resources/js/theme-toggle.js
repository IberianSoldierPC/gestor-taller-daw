// filepath: c:\Users\JED\Desktop\gestor-taller-daw\resources\js\theme-toggle.js
(() => {
    const htmlElement = document.documentElement;
    const THEME_KEY = 'color-theme';

    // Aplicar tema al <html>
    const applyTheme = (isDark) => {
        if (isDark) {
            htmlElement.classList.add('dark');
            localStorage.setItem(THEME_KEY, 'dark');
        } else {
            htmlElement.classList.remove('dark');
            localStorage.setItem(THEME_KEY, 'light');
        }
    };

    // Inicializar tema ANTES de que se renderice el contenido
    const initTheme = () => {
        const savedTheme = localStorage.getItem(THEME_KEY);
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            applyTheme(true);
        } else {
            applyTheme(false);
        }
    };

    // Inicializar inmediatamente (antes de DOMContentLoaded)
    initTheme();

    // Configurar evento de los botones cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', () => {
        const toggles = document.querySelectorAll('[data-theme-toggle]');

        if (toggles && toggles.length) {
            toggles.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const isCurrentlyDark = htmlElement.classList.contains('dark');
                    applyTheme(!isCurrentlyDark);
                });
            });
        }
    });
})();