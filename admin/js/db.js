/**
 * IgrisDB — Fetch com CSRF auto-retry — INDUZI
 */
var IgrisDB = (function() {
    var _csrfToken = '';
    var _cache = {};

    async function _fetch(url, opts, _retried) {
        opts = opts || {};
        opts.headers = opts.headers || {};
        opts.headers['X-CSRF-Token'] = _csrfToken;
        opts.headers['X-Requested-With'] = 'XMLHttpRequest';
        opts.headers['Accept'] = 'application/json';
        if (!opts.cache) opts.cache = 'no-store';
        if (!opts.credentials) opts.credentials = 'same-origin';

        var res = await fetch(url, opts);

        if (res.status === 403 && !_retried) {
            await _refreshCsrfToken();
            opts.headers['X-CSRF-Token'] = _csrfToken;
            return _fetch(url, opts, true);
        }

        return res;
    }

    async function _refreshCsrfToken() {
        try {
            var res = await fetch('api/auth/session.php', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            var data = await res.json();
            if (data.csrfToken) _csrfToken = data.csrfToken;
        } catch (e) {
            console.error('IgrisDB: Falha ao refresh CSRF', e);
        }
    }

    return {
        init: function(token) {
            _csrfToken = token || '';
        },
        getToken: function() { return _csrfToken; },
        clearCache: function() { _cache = {}; },
        fetch: _fetch
    };
})();
