/**
 * SpaRouter — Navegacao SPA com History API (clean URLs) — INDUZI Admin
 */
var SpaRouter = (function() {
    var _cache = {};
    var _currentRoute = null;
    var _loading = false;
    var _basePath = '/';

    var _noCache = ['painel', 'mensagens', 'newsletter', 'leads', 'configuracoes', 'contas', 'atualizacao'];

    var ROUTES = {
        'painel':         { url: 'pages/index.php',          title: 'Painel' },
        'mensagens':      { url: 'pages/mensagens.php',      title: 'Contatos' },
        'newsletter':     { url: 'pages/newsletter.php',     title: 'Newsletter' },
        'leads':          { url: 'pages/leads.php',          title: 'Leads' },
        'configuracoes':  { url: 'pages/configuracoes.php',  title: 'Configuracoes' },
        'contas':         { url: 'pages/contas.php',         title: 'Contas' },
        'atualizacao':    { url: 'pages/atualizacao.php',    title: 'Atualizacao' },
    };

    var _spaContent = null;
    var _spaLoading = null;
    var _spaStyles = null;

    function _cleanup() {
        if (typeof window._spaCleanup === 'function') {
            try { window._spaCleanup(); } catch (e) { console.error('Cleanup error:', e); }
            window._spaCleanup = null;
        }
    }

    function _showLoading() { if (_spaLoading) _spaLoading.classList.add('active'); }
    function _hideLoading() { if (_spaLoading) _spaLoading.classList.remove('active'); }

    function _showSkeleton() {
        if (!_spaContent) return;
        _spaContent.innerHTML = '<div class="skeleton-page"><div class="skeleton skeleton-title"></div><div class="skeleton-grid"><div class="skeleton skeleton-card"></div><div class="skeleton skeleton-card"></div><div class="skeleton skeleton-card"></div></div></div>';
    }

    async function _loadFragment(route) {
        var config = ROUTES[route];
        if (!config) { console.error('Rota desconhecida:', route); return; }

        if (_loading) return;
        _loading = true;

        _cleanup();
        _showLoading();
        _showSkeleton();

        var url = config.url + '?fragment=1';
        var cached = (_noCache.indexOf(route) < 0) ? _cache[url] : null;

        if (!cached) {
            try {
                var res = await IgrisDB.fetch(url);
                var data = await res.json();
                if (!data.ok) throw new Error(data.msg || 'Erro ao carregar pagina');
                cached = data;
                if (_noCache.indexOf(route) < 0) _cache[url] = data;
            } catch (e) {
                console.error('SpaRouter load error:', e);
                if (_spaContent) _spaContent.innerHTML = '<div class="container"><h2>Erro ao carregar</h2><p>' + (e.message || 'Tente novamente.') + '</p></div>';
                _hideLoading();
                _loading = false;
                return;
            }
        }

        if (_spaStyles) _spaStyles.parentNode.removeChild(_spaStyles);
        if (cached.styles) {
            _spaStyles = document.createElement('style');
            _spaStyles.id = 'spa-page-styles';
            _spaStyles.textContent = cached.styles;
            document.head.appendChild(_spaStyles);
        }

        if (_spaContent) {
            _spaContent.style.opacity = '0';
            _spaContent.innerHTML = cached.html;
        }

        if (cached.scripts) {
            var script = document.createElement('script');
            script.textContent = cached.scripts;
            document.body.appendChild(script);
            document.body.removeChild(script);
        }

        if (_spaContent) {
            requestAnimationFrame(function() {
                _spaContent.style.opacity = '1';
            });
        }

        _hideLoading();
        _loading = false;
        _currentRoute = route;

        document.title = config.title + ' — INDUZI Admin';

        document.querySelectorAll('.icon-strip-btn[data-route]').forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.route === route);
        });
        document.querySelectorAll('.sidebar-menu a[data-route]').forEach(function(a) {
            a.classList.toggle('active', a.dataset.route === route);
        });

        document.dispatchEvent(new CustomEvent('spa:routechange', { detail: { route: route } }));
    }

    function navigateTo(route) {
        if (route === _currentRoute && _noCache.indexOf(route) < 0) return;
        history.pushState({ route: route }, '', _basePath + route);
        _loadFragment(route);
    }

    function _getRouteFromPath() {
        var path = location.pathname;
        if (path.indexOf(_basePath) === 0) {
            return path.substring(_basePath.length) || 'painel';
        }
        return 'painel';
    }

    return {
        ROUTES: ROUTES,

        init: function() {
            _spaContent = document.getElementById('spaContent');
            _spaLoading = document.getElementById('spaLoading');
            _basePath = window._adminBase || '/';

            if (_spaContent) {
                _spaContent.style.transition = 'opacity .15s ease';
            }

            document.addEventListener('click', function(e) {
                var link = e.target.closest('a[data-route]');
                if (!link) return;
                var route = link.dataset.route;
                if (ROUTES[route]) {
                    e.preventDefault();
                    navigateTo(route);
                }
            });

            window.addEventListener('popstate', function(e) {
                var route = (e.state && e.state.route) || _getRouteFromPath();
                if (ROUTES[route]) _loadFragment(route);
            });

            // Determine initial route: prefer server-side computed route, fallback to hash (backward compat)
            var initial = window._initialRoute || 'painel';
            if (location.hash && location.hash.length > 1) {
                var hashRoute = location.hash.replace('#', '');
                if (ROUTES[hashRoute]) initial = hashRoute;
            }
            if (!ROUTES[initial]) initial = 'painel';

            history.replaceState({ route: initial }, '', _basePath + initial);
            _loadFragment(initial);
        },

        navigateTo: navigateTo,
        clearCache: function() { _cache = {}; },
        getCurrentRoute: function() { return _currentRoute; }
    };
})();
