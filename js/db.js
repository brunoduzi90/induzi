/**
 * InduziDB — Camada de Dados (PHP/MySQL via fetch)
 */
const InduziDB = {
    _apiBase: '',
    _cache: {},
    _csrfToken: '',

    _getApiBase() {
        if (this._apiBase) return this._apiBase;
        var path = window.location.pathname;
        this._apiBase = path.includes('/pages/') ? '../api/' : 'api/';
        return this._apiBase;
    },

    async _refreshCsrfToken() {
        try {
            var base = this._getApiBase();
            var resp = await fetch(base + 'auth/session.php?_t=' + Date.now(), { cache: 'no-store', credentials: 'same-origin' });
            if (resp.ok) {
                var data = await resp.json();
                if (data.csrfToken) this._csrfToken = data.csrfToken;
            }
        } catch (e) {}
    },

    async _fetch(originalUrl, options, _retried) {
        try {
            options = options || {};
            var url = originalUrl;
            if (!options.method || options.method === 'GET') {
                url = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_t=' + Date.now();
            }
            if (options.method === 'POST') {
                options.headers = options.headers || {};
                options.headers['X-Requested-With'] = 'XMLHttpRequest';
            }
            options.cache = 'no-store';
            options.credentials = 'same-origin';
            var resp = await fetch(url, options);
            if (!resp.ok) {
                try {
                    var errResult = await resp.json();
                    if (resp.status === 403 && !_retried) { await this._refreshCsrfToken(); return this._fetch(originalUrl, options, true); }
                    errResult._httpStatus = resp.status;
                    return errResult;
                } catch (e) {
                    if (resp.status === 403 && !_retried) { await this._refreshCsrfToken(); return this._fetch(originalUrl, options, true); }
                    return { ok: false, msg: 'HTTP ' + resp.status, _httpStatus: resp.status };
                }
            }
            var result = await resp.json();
            result._httpStatus = resp.status;
            return result;
        } catch (e) {
            console.error('InduziDB fetch error:', e);
            return { ok: false, msg: 'Erro de conexao.' };
        }
    },

    async load(key, defaultData) {
        if (this._cache.hasOwnProperty(key)) return this._cache[key];
        try {
            var base = this._getApiBase();
            var result = await this._fetch(base + 'data/load.php?key=' + encodeURIComponent(key));
            if (result.ok && result.value !== null && result.value !== undefined) {
                this._cache[key] = result.value;
                return result.value;
            }
            return defaultData;
        } catch (e) { return defaultData; }
    },

    _encodeB64(str) {
        var b64 = btoa(unescape(encodeURIComponent(str)));
        return b64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
    },

    async save(key, data) {
        this._cache[key] = data;
        try {
            var base = this._getApiBase();
            var encoded = this._encodeB64(JSON.stringify({ key: key, value: data }));
            var result = await this._fetch(base + 'data/save.php', {
                method: 'POST',
                headers: { 'Content-Type': 'text/plain' },
                body: encoded
            });
            if (!result.ok) {
                delete this._cache[key];
                console.error('InduziDB.save FALHOU [' + key + ']:', result.msg);
            }
            return result.ok || false;
        } catch (e) {
            delete this._cache[key];
            return false;
        }
    },

    clearCache(key) {
        if (key) delete this._cache[key];
        else this._cache = {};
    }
};
