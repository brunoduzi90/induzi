/**
 * IgrisTheme — Sistema de temas (claro/escuro) + customizacao visual — INDUZI
 */
var IgrisTheme = (function() {
    var KEY = 'igris_tema';
    var CUSTOM_KEY = 'igris_custom_theme';
    var current = localStorage.getItem(KEY) || 'escuro';
    if (current !== 'claro' && current !== 'escuro') current = 'escuro';

    var radiusPresets = {
        sharp:   { sm: '2px',  md: '4px',  lg: '6px',  full: '8px' },
        rounded: { sm: '4px',  md: '8px',  lg: '12px', full: '9999px' },
        pill:    { sm: '10px', md: '20px', lg: '24px', full: '9999px' }
    };

    var fontMap = {
        'System':          '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Space Grotesk':   '"Space Grotesk", sans-serif',
        'Inter':           '"Inter", sans-serif',
        'Poppins':         '"Poppins", sans-serif',
        'Roboto':          '"Roboto", sans-serif',
        'JetBrains Mono':  '"JetBrains Mono", monospace',
        'Nunito':          '"Nunito", sans-serif'
    };

    var icons = {
        escuro: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>',
        claro:  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>'
    };

    function updateIcon() {
        var btn = document.getElementById('btnThemeToggle');
        if (!btn) return;
        btn.innerHTML = icons[current] || icons.escuro;
        btn.title = current === 'escuro' ? 'Tema escuro' : 'Tema claro';
    }

    var _loadedFonts = {};

    function loadGoogleFont(name) {
        if (name === 'System' || _loadedFonts[name]) return;
        _loadedFonts[name] = true;
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.id = 'igris-gfont-' + name.replace(/\s+/g, '-');
        link.href = 'https://fonts.googleapis.com/css2?family=' + encodeURIComponent(name) + ':wght@400;500;600;700&display=swap';
        document.head.appendChild(link);
    }

    function apply(mode) {
        current = mode;
        localStorage.setItem(KEY, mode);
        document.documentElement.setAttribute('data-theme', mode);
    }

    function applyCustom(prefs) {
        if (!prefs) return;
        var root = document.documentElement;

        if (prefs.primaryColor) {
            root.style.setProperty('--icon-strip-bg', prefs.primaryColor);
            root.style.setProperty('--sidebar-bg', prefs.primaryColor + '18');
            root.style.setProperty('--sidebar-border', prefs.primaryColor + '40');
            root.style.setProperty('--sidebar-hover', prefs.primaryColor + '30');
        }

        if (prefs.accentColor) {
            root.style.setProperty('--color-accent', prefs.accentColor);
            root.style.setProperty('--color-accent-hover', prefs.accentColor + 'dd');
            root.style.setProperty('--color-accent-light', prefs.accentColor + '20');
        }

        if (prefs.fontFamily && fontMap[prefs.fontFamily]) {
            loadGoogleFont(prefs.fontFamily);
            root.style.setProperty('--font-family-custom', fontMap[prefs.fontFamily]);
            document.body.style.fontFamily = fontMap[prefs.fontFamily];
        }

        if (prefs.borderRadius && radiusPresets[prefs.borderRadius]) {
            var r = radiusPresets[prefs.borderRadius];
            root.style.setProperty('--radius-sm', r.sm);
            root.style.setProperty('--radius-md', r.md);
            root.style.setProperty('--radius-lg', r.lg);
            root.style.setProperty('--radius-full', r.full);
        }

        localStorage.setItem(CUSTOM_KEY, JSON.stringify(prefs));
    }

    function resetCustom() {
        var root = document.documentElement;
        ['--icon-strip-bg','--sidebar-bg','--sidebar-border','--sidebar-hover',
         '--color-accent','--color-accent-hover','--color-accent-light',
         '--font-family-custom','--radius-sm','--radius-md','--radius-lg','--radius-full'
        ].forEach(function(p) { root.style.removeProperty(p); });
        document.body.style.fontFamily = '';
        localStorage.removeItem(CUSTOM_KEY);
    }

    apply(current);

    try {
        var saved = JSON.parse(localStorage.getItem(CUSTOM_KEY) || 'null');
        if (saved) applyCustom(saved);
    } catch (e) {}

    return {
        init: function() {
            apply(current);
            updateIcon();
        },
        toggle: function() {
            var next = current === 'escuro' ? 'claro' : 'escuro';
            apply(next);
            updateIcon();
            try {
                var saved = JSON.parse(localStorage.getItem(CUSTOM_KEY) || 'null');
                if (saved) applyCustom(saved);
            } catch (e) {}
            if (window.IgrisAuth && IgrisAuth._session) {
                IgrisAuth.salvarPreferencias({ tema: next });
            }
        },
        get: function() { return current; },
        applyCustom: applyCustom,
        resetCustom: resetCustom,
        radiusPresets: radiusPresets,
        fontMap: fontMap
    };
})();
