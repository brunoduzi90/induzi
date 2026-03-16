/**
 * SPA Router — Induzi
 */
var SpaRouter = {
    _cache: {},
    _currentRoute: null,
    _currentStyleEl: null,
    _loading: false,
    _pendingRoute: null,

    ROUTES: {
        'painel':        { url: 'pages/index.php',          title: 'Painel',          requireProject: true,  isModule: true },
        'branding':      { url: 'pages/branding.php',       title: 'Branding',        requireProject: true,  isModule: true },
        'copywriter':    { url: 'pages/copywriter.php',     title: 'Copywriter',      requireProject: true,  isModule: true },
        'estrutura':     { url: 'pages/estrutura.php',      title: 'Estrutura',       requireProject: true,  isModule: true },
        'seguranca':     { url: 'pages/seguranca.php',      title: 'Seguranca',       requireProject: true,  isModule: true },
        'seo':           { url: 'pages/seo.php',            title: 'SEO',             requireProject: true,  isModule: true },
        'google-ads':    { url: 'pages/google-ads.php',     title: 'Google Ads',      requireProject: true,  isModule: true },
        'shopee':        { url: 'pages/shopee.php',         title: 'Shopee',          requireProject: true,  isModule: true },
        'performance':   { url: 'pages/performance.php',    title: 'Performance',     requireProject: true,  isModule: true },
        'analytics':     { url: 'pages/analytics.php',      title: 'Analytics',       requireProject: true,  isModule: true },
        'ux-design':     { url: 'pages/ux-design.php',      title: 'UX Design',       requireProject: true,  isModule: true },
        'acessibilidade':{ url: 'pages/acessibilidade.php', title: 'Acessibilidade',  requireProject: true,  isModule: true },
        'conteudo':      { url: 'pages/conteudo.php',       title: 'Conteudo',        requireProject: true,  isModule: true },
        'cro':           { url: 'pages/cro.php',            title: 'CRO',             requireProject: true,  isModule: true },
        'email-marketing':{ url: 'pages/email-marketing.php',title: 'Email Marketing', requireProject: true,  isModule: true },
        'redes-sociais': { url: 'pages/redes-sociais.php',  title: 'Redes Sociais',   requireProject: true,  isModule: true },
        'meta-ads':      { url: 'pages/meta-ads.php',       title: 'Meta Ads',        requireProject: true,  isModule: true },
        'infraestrutura':{ url: 'pages/infraestrutura.php', title: 'Infraestrutura',  requireProject: true,  isModule: true },
        'icones':        { url: 'pages/icones.php',         title: 'Icones SVG',      requireProject: false, isModule: false },
        'projetos':      { url: 'pages/projetos.php',       title: 'Projetos',        requireProject: false, isModule: false },
        'configuracoes': { url: 'pages/configuracoes.php',  title: 'Configuracoes',   requireProject: false, isModule: false },
        'atividades':    { url: 'pages/atividades.php',     title: 'Atividades',      requireProject: true,  isModule: false },
        'site-audit':    { url: 'pages/site-audit.php',    title: 'Site Audit',      requireProject: true,  isModule: false },
        'mercado-livre': { url: 'pages/mercado-livre.php', title: 'Mercado Livre',   requireProject: true,  isModule: true },
        'atualizacao':   { url: 'pages/atualizacao.php',  title: 'Atualizacao',     requireProject: false, isModule: false },
    },

    _noCache: ['projetos', 'site-audit', 'atualizacao'],

    init() {
        window.addEventListener('popstate', (e) => this._onPopState(e));
        document.addEventListener('click', (e) => {
            var a = e.target.closest('a[href^="#"]');
            if (a) {
                var route = a.getAttribute('href').substring(1);
                if (this.ROUTES[route]) { e.preventDefault(); this.go(route); }
                return;
            }
            a = e.target.closest('a[href]');
            if (a && !a.target && !a.hasAttribute('download')) {
                var href = a.getAttribute('href');
                for (var rn in this.ROUTES) {
                    if (this.ROUTES[rn].url === href) { e.preventDefault(); this.go(rn); return; }
                }
            }
        });

        var initial = null;
        if (history.state && history.state.route && this.ROUTES[history.state.route]) {
            initial = history.state.route;
        }
        if (!initial && window.location.hash) {
            var h = window.location.hash.substring(1).split('?')[0];
            if (this.ROUTES[h]) initial = h;
        }
        if (!initial) {
            initial = InduziAuth.hasProjectSelected() ? 'painel' : 'projetos';
        }

        var cleanPath = window.location.pathname.replace(/app\.php$/, '');
        history.replaceState({ route: initial }, '', cleanPath);
        this.navigateTo(initial);
    },

    go(routeName) {
        if (!this.ROUTES[routeName]) return;
        if (routeName === this._currentRoute && !this._loading) return;
        if (this._loading) { this._pendingRoute = routeName; return; }
        history.pushState({ route: routeName }, '');
        this.navigateTo(routeName);
    },

    _onPopState(e) {
        if (e.state && e.state.route && this.ROUTES[e.state.route]) this.navigateTo(e.state.route);
    },

    async navigateTo(routeName) {
        var route = this.ROUTES[routeName];
        if (!route || this._loading) return;

        if (route.requireProject && !InduziAuth.hasProjectSelected()) {
            history.replaceState({ route: 'projetos' }, '');
            this.navigateTo('projetos');
            return;
        }

        this._loading = true;
        var contentEl = document.getElementById('spaContent');
        var loadingEl = document.getElementById('spaLoading');

        this._cleanup();
        contentEl.classList.add('spa-fade-out');
        if (loadingEl) loadingEl.classList.add('active');

        // Inject skeleton while loading
        setTimeout(function() {
            if (contentEl.classList.contains('spa-fade-out')) {
                contentEl.innerHTML = '<div class="skeleton-page">' +
                    '<div class="skeleton skeleton-title"></div>' +
                    '<div class="skeleton-grid">' +
                    '<div class="skeleton skeleton-card"></div>' +
                    '<div class="skeleton skeleton-card"></div>' +
                    '<div class="skeleton skeleton-card"></div>' +
                    '</div>' +
                    '<div class="skeleton skeleton-row w75"></div>' +
                    '<div class="skeleton skeleton-row w60"></div>' +
                    '<div class="skeleton skeleton-row w50"></div>' +
                    '</div>';
                contentEl.classList.remove('spa-fade-out');
            }
        }, 160);

        try {
            var data = await this._loadFragment(route.url, routeName);
            if (!data || !data.ok) { window.location.href = route.url; return; }

            await new Promise(r => setTimeout(r, 150));

            if (this._currentStyleEl) { this._currentStyleEl.remove(); this._currentStyleEl = null; }
            if (data.styles) {
                var styleEl = document.createElement('style');
                styleEl.setAttribute('data-spa-page', routeName);
                styleEl.textContent = data.styles;
                document.head.appendChild(styleEl);
                this._currentStyleEl = styleEl;
            }

            contentEl.innerHTML = data.html;
            document.title = route.title + ' — Induzi';
            this._updateSidebar(routeName, route);
            this._currentRoute = routeName;

            contentEl.classList.remove('spa-fade-out');
            contentEl.classList.add('spa-fade-in');
            if (loadingEl) loadingEl.classList.remove('active');

            if (data.scripts) this._execScripts(data.scripts);
            setTimeout(() => contentEl.classList.remove('spa-fade-in'), 300);
            contentEl.scrollTop = 0;
            window.scrollTo(0, 0);
            window.dispatchEvent(new CustomEvent('spa:routechange', { detail: { route: routeName } }));

        } catch (err) {
            console.error('SPA navigation error:', err);
            window.location.href = route.url;
        } finally {
            this._loading = false;
            if (this._pendingRoute) {
                var pending = this._pendingRoute;
                this._pendingRoute = null;
                this.go(pending);
            }
        }
    },

    async _loadFragment(url, routeName) {
        if (!this._noCache.includes(routeName) && this._cache[url]) return this._cache[url];
        var sep = url.includes('?') ? '&' : '?';
        var resp = await fetch(url + sep + 'fragment=1', { cache: 'no-store', credentials: 'same-origin' });
        if (!resp.ok) return null;
        var data = await resp.json();
        if (data.ok && !this._noCache.includes(routeName)) this._cache[url] = data;
        return data;
    },

    _cleanup() {
        if (typeof window._spaCleanup === 'function') { try { window._spaCleanup(); } catch (e) {} }
        window._spaCleanup = null;
    },

    _execScripts(code) {
        try {
            var script = document.createElement('script');
            script.textContent = code;
            document.getElementById('spaContent').appendChild(script);
        } catch (e) { console.error('SPA script error:', e); }
    },

    _updateSidebar(routeName, route) {
        var sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.querySelectorAll('a.active').forEach(a => a.classList.remove('active'));
            var activeLink = sidebar.querySelector('a[href="#' + routeName + '"]');
            if (activeLink) activeLink.classList.add('active');
        }
        var iconStrip = document.getElementById('iconStrip');
        if (iconStrip) {
            iconStrip.querySelectorAll('a.active').forEach(a => a.classList.remove('active'));
            var activeIcon = iconStrip.querySelector('a[href="#' + routeName + '"]');
            if (activeIcon) activeIcon.classList.add('active');
        }
        var modulosSection = document.getElementById('modulosSection');
        var modulosToggle = document.querySelector('.icon-strip-toggle');
        if (route.isModule && InduziAuth.hasProjectSelected()) {
            document.body.classList.remove('no-modules-sidebar');
            if (modulosSection) modulosSection.style.display = '';
            if (modulosToggle) modulosToggle.style.display = '';
        } else {
            document.body.classList.add('no-modules-sidebar');
            if (modulosSection) modulosSection.style.display = 'none';
            if (modulosToggle) modulosToggle.style.display = 'none';
        }
    },

    clearCache(url) {
        if (url) delete this._cache[url];
        else this._cache = {};
    }
};
