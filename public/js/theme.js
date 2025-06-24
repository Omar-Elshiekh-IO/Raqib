// public/js/theme.js
// Global theme color and accent color handler for all pages (including auth)

(function() {
    // Helper: get CSS variable value
    function getCssVar(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name);
    }

    // Helper: set CSS variable value
    function setCssVar(name, value) {
        document.documentElement.style.setProperty(name, value);
    }

    // Map theme names to color values (should match your CSS)
    const themeColors = {
        'theme-1': '#7367F0',
        'theme-2': '#FF6F00',
        'theme-3': '#28C76F',
        'theme-4': '#EA5455',
        'theme-5': '#FF9F43',
        'theme-6': '#00CFE8',
        'theme-7': '#1E9FF2',
        'theme-8': '#7367F0',
        'theme-9': '#8F99F3',
        'theme-10': '#FFC0CB'
    };

    // Helper: get gradient for a theme (customize as needed)
    function getGradient(color) {
        return `linear-gradient(to right, ${color}, #2B8B68)`;
    }

    // Listen for theme color swatch clicks
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('themes-color-change')) {
            const theme = e.target.getAttribute('data-value');
            if (themeColors[theme]) {
                setCssVar('--accent-main', themeColors[theme]);
                setCssVar('--accent-color', themeColors[theme]);
                if (window.setAccentColor) window.setAccentColor({
                    main: themeColors[theme],
                    gradient: getGradient(themeColors[theme]),
                    bg: '#fff'
                });
            }
        }
    });

    // Listen for custom color picker changes
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('colorPicker')) {
            const color = e.target.value;
            setCssVar('--accent-main', color);
            setCssVar('--accent-color', color);
            if (window.setAccentColor) window.setAccentColor({
                main: color,
                gradient: getGradient(color),
                bg: '#fff'
            });
        }
    });

    // Optionally, handle dark mode and RTL toggles here if needed
    // ...

    // On page load, sync accent color with current theme
    document.addEventListener('DOMContentLoaded', function() {
        let color = getCssVar('--accent-main') || themeColors['theme-1'];
        if (window.setAccentColor) window.setAccentColor({
            main: color.trim(),
            gradient: getGradient(color.trim()),
            bg: '#fff'
        });
    });
})();
