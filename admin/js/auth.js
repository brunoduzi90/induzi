/**
 * IgrisAuth — Sessao e autenticacao — INDUZI
 */
var IgrisAuth = (function() {
    var _session = null;

    return {
        _session: null,

        init: async function() {
            if (window._igrisSession) {
                _session = window._igrisSession;
                this._session = _session;
                IgrisDB.init(_session.csrfToken);
                this._updateUI();
                return;
            }

            try {
                var res = await fetch('api/auth/session.php', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                var data = await res.json();
                if (data.ok && data.loggedIn) {
                    _session = {
                        userId: data.user.id,
                        nome: data.user.nome,
                        email: data.user.email,
                        role: data.user.role,
                        csrfToken: data.csrfToken,
                    };
                    this._session = _session;
                    IgrisDB.init(data.csrfToken);
                }
            } catch (e) {
                console.error('IgrisAuth.init error:', e);
            }
        },

        isLoggedIn: function() { return !!_session; },
        getUser: function() { return _session; },

        _updateUI: function() {
            var version = document.getElementById('sidebarVersion');
            if (version) version.textContent = 'INDUZI v' + (window.INDUZI_VERSION || '2.0.0');
        },

        salvarPreferencias: async function(prefs) {
            try {
                await IgrisDB.fetch('api/auth/update-prefs.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(prefs)
                });
            } catch (e) { /* silencioso */ }
        },

        logout: async function() {
            try {
                await IgrisDB.fetch('api/auth/logout.php', { method: 'POST' });
            } catch (e) { /* continua */ }
            window.location.href = 'login.php';
        }
    };
})();
