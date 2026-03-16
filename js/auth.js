/**
 * InduziAuth — Autenticacao e Gerenciamento de Sessao
 */
const InduziAuth = {
    _user: null,
    _project: null,
    _projectId: null,
    _readOnly: false,
    _initialized: false,

    _getApiBase() { return InduziDB._getApiBase(); },
    _getBasePath() { return window.location.pathname.includes('/pages/') ? '../' : ''; },

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
                    if (resp.status === 403 && !_retried) { await InduziDB._refreshCsrfToken(); return this._fetch(originalUrl, options, true); }
                    errResult._httpStatus = resp.status;
                    return errResult;
                } catch (e) {
                    if (resp.status === 403 && !_retried) { await InduziDB._refreshCsrfToken(); return this._fetch(originalUrl, options, true); }
                    return { ok: false, msg: 'HTTP ' + resp.status, _httpStatus: resp.status };
                }
            }
            return await resp.json();
        } catch (e) {
            return { ok: false, msg: 'Erro de conexao.' };
        }
    },

    async init() {
        if (this._initialized) return;
        var base = this._getApiBase();
        var result = await this._fetch(base + 'auth/session.php');
        if (result.csrfToken) InduziDB._csrfToken = result.csrfToken;
        if (result.ok && result.loggedIn) {
            this._user = result.user;
            this._project = result.project;
            this._projectId = result.projectId;
            this._readOnly = result.readOnly || false;
        } else {
            this._user = null;
            this._project = null;
            this._projectId = null;
            this._readOnly = false;
        }
        this._initialized = true;
    },

    async login(identificador, senha) {
        var base = this._getApiBase();
        var result = await this._fetch(base + 'auth/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ identificador: identificador, senha: senha })
        });
        if (result.ok) {
            this._user = result.user;
            if (result.csrfToken) InduziDB._csrfToken = result.csrfToken;
            this._initialized = false;
        }
        return result;
    },

    async logout() {
        var base = this._getApiBase();
        await this._fetch(base + 'auth/logout.php', { method: 'POST' });
        this._user = null; this._project = null; this._projectId = null; this._initialized = false;
        if (window.SpaRouter) SpaRouter.clearCache();
        window.location.href = (window.SpaRouter ? '' : this._getBasePath()) + 'login.php';
    },

    isLoggedIn() { return !!(this._user && this._user.id); },
    hasProjectSelected() { return !!(this._user && this._projectId); },
    getCurrentUser() { return this._user; },
    getCurrentProject() { return this._project; },
    isAdmin() { return !!(this._user && this._user.role === 'admin'); },
    isReadOnly() { return !this._user ? true : this._readOnly; },

    getPreferencia(chave, padrao) {
        if (!this._user || !this._user.preferencias) return padrao !== undefined ? padrao : null;
        var val = this._user.preferencias[chave];
        return val !== undefined ? val : (padrao !== undefined ? padrao : null);
    },

    async salvarPreferencias(prefs) {
        if (!this._user) return { ok: false };
        var base = this._getApiBase();
        var result = await this._fetch(base + 'auth/update-prefs.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ preferencias: prefs })
        });
        if (result.ok && this._user) {
            if (!this._user.preferencias) this._user.preferencias = {};
            Object.assign(this._user.preferencias, prefs);
        }
        return result;
    },

    async selectProject(projectId) {
        var base = this._getApiBase();
        var result = await this._fetch(base + 'projects/select.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ projectId: projectId })
        });
        if (result.ok) {
            this._projectId = projectId;
            this._project = result.project || null;
            this._initialized = false;
            InduziDB.clearCache();
            if (window.SpaRouter) SpaRouter.clearCache();
            window.dispatchEvent(new CustomEvent('spa:projectchange', { detail: { projectId: projectId } }));
        }
        return result;
    },

    async switchProject() {
        var base = this._getApiBase();
        await this._fetch(base + 'projects/select.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ projectId: null })
        });
        this._project = null; this._projectId = null; this._initialized = false;
        InduziDB.clearCache();
        if (window.SpaRouter) { SpaRouter.clearCache(); SpaRouter.go('projetos'); }
        else { window.location.href = this._getBasePath() + 'pages/projetos.php'; }
    },

    async getProjects() {
        var base = this._getApiBase();
        var result = await this._fetch(base + 'projects/list.php');
        return result.ok ? result.projects : [];
    },

    async createProject(nome, descricao) {
        var base = this._getApiBase();
        var result = await this._fetch(base + 'projects/create.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nome: nome, descricao: descricao || '' })
        });
        return result.ok ? result.project : null;
    },

    async updateProject(projectId, nome, descricao) {
        var base = this._getApiBase();
        return this._fetch(base + 'projects/update.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ projectId: projectId, nome: nome, descricao: descricao || '' })
        });
    },

    async deleteProject(projectId) {
        var base = this._getApiBase();
        return this._fetch(base + 'projects/delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ projectId: projectId })
        });
    },

    requireAuth() {
        if (!this.isLoggedIn()) { window.location.href = (window.SpaRouter ? '' : this._getBasePath()) + 'login.php'; return false; }
        return true;
    },

    requireProject() {
        if (!this.isLoggedIn()) { window.location.href = (window.SpaRouter ? '' : this._getBasePath()) + 'login.php'; return false; }
        if (!this.hasProjectSelected()) {
            if (window.SpaRouter) SpaRouter.go('projetos');
            else window.location.href = this._getBasePath() + 'pages/projetos.php';
            return false;
        }
        return true;
    },

    async shareProject(projectId, email, permissao, action) {
        var base = this._getApiBase();
        return this._fetch(base + 'projects/share.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ projectId: projectId, email: email, permissao: permissao || 'editar', action: action || 'add' })
        });
    },

    async getSharedUsers(projectId) {
        var base = this._getApiBase();
        return this._fetch(base + 'projects/shared-users.php?projectId=' + projectId);
    },

    async removeSharedUser(projectId, email) {
        return this.shareProject(projectId, email, 'editar', 'remove');
    },

    async duplicateProject(projectId) {
        var base = this._getApiBase();
        return this._fetch(base + 'projects/duplicate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ projectId: projectId })
        });
    },

    async toggleFavorito(route) {
        var prefs = (this._user && this._user.preferencias) ? this._user.preferencias : {};
        var favs = prefs.favoritos || [];
        var idx = favs.indexOf(route);
        if (idx >= 0) favs.splice(idx, 1);
        else favs.push(route);
        await this.salvarPreferencias({ favoritos: favs });
        return favs;
    },

    getFavoritos() {
        return this.getPreferencia('favoritos', []);
    },

    populateSidebar() {
        var project = this._project;
        var user = this._user;
        var el = document.getElementById('sidebarProjectName');
        if (el && project) el.textContent = project.nome;
        var topNome = document.getElementById('topBarNome');
        if (topNome && user) topNome.textContent = user.nome;
        var topAvatar = document.getElementById('topBarAvatar');
        if (topAvatar && user) {
            var ini = user.nome.split(' ').map(function(p){return p[0]}).slice(0,2).join('').toUpperCase();
            topAvatar.textContent = ini;
        }
        var gearUser = document.getElementById('gearUserName');
        if (gearUser && user) gearUser.textContent = user.nome;
        if (window.InduziTheme) InduziTheme.updateToggle();
        this._renderFavoritos();
    },

    _renderFavoritos() {
        var favs = this.getFavoritos();
        var section = document.getElementById('favoritosSection');
        var list = document.getElementById('favoritosList');
        if (!section || !list) return;
        if (!favs || !favs.length) { section.style.display = 'none'; return; }

        var routeLabels = { painel: 'Painel', branding: 'Branding', copywriter: 'Copywriter', estrutura: 'Estrutura', seguranca: 'Seguranca', seo: 'SEO', 'google-ads': 'Google Ads', shopee: 'Shopee', icones: 'Icones', configuracoes: 'Configuracoes', atividades: 'Atividades', projetos: 'Projetos' };
        var html = '';
        for (var i = 0; i < favs.length; i++) {
            var r = favs[i];
            var label = routeLabels[r] || r;
            html += '<li><a href="#' + r + '"><span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span> ' + label + '</a></li>';
        }
        list.innerHTML = html;
        section.style.display = '';
    }
};
