/**
 * InduziTheme - Motor de temas (claro/escuro/auto)
 */
var InduziTheme = {
    _pref: 'auto',
    _resolved: 'claro',
    _mediaQuery: null,
    _mediaHandler: null,

    applyFromCache() {
        var pref = 'auto';
        try { pref = localStorage.getItem('induzi_tema') || 'auto'; } catch(e) {}
        this._pref = pref;
        this._resolve(pref);
    },

    async init() {
        var backendPref = InduziAuth.getPreferencia('tema', null);
        if (backendPref && ['claro', 'escuro', 'auto'].indexOf(backendPref) !== -1) {
            this._pref = backendPref;
            try { localStorage.setItem('induzi_tema', backendPref); } catch(e) {}
        } else {
            var localPref = 'auto';
            try { localPref = localStorage.getItem('induzi_tema') || 'auto'; } catch(e) {}
            this._pref = localPref;
            if (InduziAuth.isLoggedIn()) {
                InduziAuth.salvarPreferencias({ tema: localPref });
            }
        }
        this._resolve(this._pref);
        this._setupMediaListener();
    },

    set(pref) {
        if (['claro', 'escuro', 'auto'].indexOf(pref) === -1) return;
        this._pref = pref;
        try { localStorage.setItem('induzi_tema', pref); } catch(e) {}
        this._resolve(pref);
        this.updateToggle();
        if (InduziAuth.isLoggedIn()) {
            InduziAuth.salvarPreferencias({ tema: pref });
        }
    },

    cycle() {
        var order = ['claro', 'escuro', 'auto'];
        var idx = order.indexOf(this._pref);
        var next = order[(idx + 1) % 3];
        this.set(next);
        return next;
    },

    _resolve(pref) {
        var theme;
        if (pref === 'auto') {
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            theme = prefersDark ? 'escuro' : 'claro';
        } else {
            theme = pref;
        }
        this._resolved = theme;
        document.documentElement.setAttribute('data-theme', theme);
    },

    _setupMediaListener() {
        if (this._mediaQuery && this._mediaHandler) {
            this._mediaQuery.removeEventListener('change', this._mediaHandler);
        }
        this._mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        this._mediaHandler = function() {
            if (InduziTheme._pref === 'auto') {
                InduziTheme._resolve('auto');
                InduziTheme.updateToggle();
            }
        };
        this._mediaQuery.addEventListener('change', this._mediaHandler);
    },

    updateToggle() {
        var icons = {
            claro:  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>',
            escuro: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>',
            auto:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>'
        };
        var titles = { claro: 'Tema: Claro', escuro: 'Tema: Escuro', auto: 'Tema: Auto (sistema)' };
        var pref = this._pref;
        var icon = icons[pref] || icons.auto;
        var sidebarBtn = document.getElementById('sidebarThemeToggle');
        if (sidebarBtn) { sidebarBtn.innerHTML = icon; sidebarBtn.title = titles[pref]; }
        var loginBtn = document.getElementById('loginThemeToggle');
        if (loginBtn) { loginBtn.innerHTML = icon; loginBtn.title = titles[pref]; }
    }
};
InduziTheme.applyFromCache();
