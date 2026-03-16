/**
 * Export Documentacao — Induzi
 * Gera Markdown legivel a partir dos dados preenchidos nos modulos.
 * Uso: InduziExportDoc.exportarModuloDownload() — modulo atual (le labels do DOM)
 *      InduziExportDoc.exportarProjeto()        — todos os modulos preenchidos
 */
var InduziExportDoc = {

    MODULES: [
        { route: 'branding',         key: 'induziBranding',         title: 'Branding' },
        { route: 'copywriter',       key: 'induziCopywriter',       title: 'Copywriter' },
        { route: 'estrutura',        key: 'induziEstrutura',        title: 'Estrutura do Site' },
        { route: 'seguranca',        key: 'induziSeguranca',        title: 'Seguranca' },
        { route: 'seo',              key: 'induziSeo',              title: 'SEO' },
        { route: 'google-ads',       key: 'induziGoogleAds',        title: 'Google Ads' },
        { route: 'shopee',           key: 'induziShopee',           title: 'Shopee' },
        { route: 'mercado-livre',    key: 'induziMercadoLivre',     title: 'Mercado Livre' },
        { route: 'performance',      key: 'induziPerformance',      title: 'Performance' },
        { route: 'analytics',        key: 'induziAnalytics',        title: 'Analytics' },
        { route: 'ux-design',        key: 'induziUxDesign',         title: 'UX Design' },
        { route: 'acessibilidade',   key: 'induziAcessibilidade',   title: 'Acessibilidade' },
        { route: 'conteudo',         key: 'induziConteudo',         title: 'Conteudo' },
        { route: 'cro',              key: 'induziCro',              title: 'CRO' },
        { route: 'email-marketing',  key: 'induziEmailMarketing',   title: 'Email Marketing' },
        { route: 'redes-sociais',    key: 'induziRedesSociais',     title: 'Redes Sociais' },
        { route: 'meta-ads',         key: 'induziMetaAds',          title: 'Meta Ads' },
        { route: 'infraestrutura',   key: 'induziInfraestrutura',   title: 'Infraestrutura' }
    ],

    _UPCASE: ['seo','cpa','roas','kpi','kpis','ml','sku','skus','url','urls','lp','pmax','cro','ux','cta','ctas','html','css','api','ssl','cdn','dns','svg','ab','dda','lgpd','http','https','rpc','smtp','ftp','ssh','waf','ddos','xss','sql'],

    /* ── helpers ─────────────────────────────────────────── */

    _humanize: function(str) {
        var up = this._UPCASE;
        return str.replace(/_/g, ' ').replace(/\b\w+/g, function(word) {
            if (up.indexOf(word.toLowerCase()) >= 0) return word.toUpperCase();
            return word.charAt(0).toUpperCase() + word.slice(1);
        });
    },

    _formatValue: function(val) {
        if (!val) return '';
        if (Array.isArray(val)) {
            if (val.length === 0) return '';
            if (typeof val[0] === 'object' && val[0] !== null) {
                // keyValue → "- **key**: value"
                if ('key' in val[0] && 'value' in val[0]) {
                    var kv = val.filter(function(p) { return (p.key && p.key.trim()) || (p.value && p.value.trim()); });
                    if (kv.length === 0) return '';
                    return kv.map(function(p) { return '- **' + (p.key || '').trim() + '**: ' + (p.value || '').trim(); }).join('\n');
                }
                // guided / checklist → "- text"
                if ('text' in val[0]) {
                    var tx = val.filter(function(it) { return it.text && it.text.trim(); });
                    if (tx.length === 0) return '';
                    return tx.map(function(it) { return '- ' + it.text.trim(); }).join('\n');
                }
                // dropzone → "- [Arquivo] name"
                if ('name' in val[0]) {
                    var fi = val.filter(function(f) { return f.name && f.name.trim(); });
                    if (fi.length === 0) return '';
                    return fi.map(function(f) { return '- [Arquivo] ' + f.name; }).join('\n');
                }
            }
            // tagList / multiSelect → "- string"
            var st = val.filter(function(s) { return s && String(s).trim(); });
            if (st.length === 0) return '';
            return st.map(function(s) { return '- ' + String(s).trim(); }).join('\n');
        }
        if (typeof val === 'string') return val.trim() || '';
        return String(val);
    },

    /* ── exportar modulo atual (le labels do DOM) ────────── */

    exportarModulo: async function() {
        var route = SpaRouter._currentRoute;
        var mod = null;
        for (var i = 0; i < this.MODULES.length; i++) {
            if (this.MODULES[i].route === route) { mod = this.MODULES[i]; break; }
        }
        if (!mod) return null;

        var data = await InduziDB.load(mod.key);
        if (!data) data = {};

        var projeto = InduziAuth.getCurrentProject();
        var md = '# ' + mod.title + '\n\n';
        md += '> Modulo do projeto: ' + (projeto ? projeto.nome : 'Sem projeto') + '  \n';
        md += '> Gerado pelo Induzi em ' + new Date().toLocaleString('pt-BR') + '\n\n';

        var self = this;
        var sections = document.querySelectorAll('.doc-section');
        sections.forEach(function(sec) {
            var titleEl = sec.querySelector('.doc-section-header h3');
            if (!titleEl) return;

            var descEl = sec.querySelector('.doc-section-desc');
            var fields = sec.querySelectorAll('.doc-field');
            var fieldMd = '';

            fields.forEach(function(field) {
                var labelEl = field.querySelector('label');
                var compEl = field.querySelector('[id^="comp-"]');
                if (!labelEl || !compEl) return;

                var afterComp = compEl.id.substring(5); // remove "comp-"
                var dashIdx = afterComp.indexOf('-');
                if (dashIdx < 0) return;
                var section = afterComp.substring(0, dashIdx);
                var fieldName = afterComp.substring(dashIdx + 1);

                var value = (data[section] && data[section][fieldName]) || null;
                var formatted = self._formatValue(value);
                if (formatted) {
                    fieldMd += '### ' + labelEl.textContent.trim() + '\n';
                    fieldMd += formatted + '\n\n';
                }
            });

            if (fieldMd) {
                md += '## ' + titleEl.textContent.trim() + '\n';
                if (descEl) md += '> ' + descEl.textContent.trim() + '\n';
                md += '\n' + fieldMd;
            }
        });

        return md;
    },

    exportarModuloDownload: async function() {
        var md = await this.exportarModulo();
        if (!md || md.split('\n').length <= 5) {
            Igris.toast('Nenhum dado preenchido para exportar', 'error');
            return;
        }

        var route = SpaRouter._currentRoute;
        var mod = null;
        for (var i = 0; i < this.MODULES.length; i++) {
            if (this.MODULES[i].route === route) { mod = this.MODULES[i]; break; }
        }
        var projeto = InduziAuth.getCurrentProject();
        var slug = (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-');
        this._download(md, 'doc-' + mod.route + '-' + slug + '.md');
        Igris.toast('Documentacao exportada!', 'success');
    },

    /* ── exportar projeto completo ───────────────────────── */

    exportarProjeto: async function() {
        var projeto = InduziAuth.getCurrentProject();
        var config = (await InduziDB.load('induziConfig')) || {};

        var md = '# Documentacao do Projeto' + (projeto ? ': ' + projeto.nome : '') + '\n\n';
        md += '> Gerado pelo Induzi em ' + new Date().toLocaleString('pt-BR') + '\n\n';

        if (config.url || config.nicho || config.notas) {
            md += '## Informacoes do Projeto\n\n';
            if (config.url) md += '- **URL**: ' + config.url + '\n';
            if (config.nicho) md += '- **Nicho**: ' + config.nicho + '\n';
            if (config.notas) md += '- **Notas**: ' + config.notas + '\n';
            md += '\n';
        }

        var self = this;
        var hasAny = false;

        for (var i = 0; i < this.MODULES.length; i++) {
            var mod = this.MODULES[i];
            var data = await InduziDB.load(mod.key);
            if (!data) continue;

            var moduleMd = '';
            for (var section in data) {
                if (typeof data[section] !== 'object' || data[section] === null) continue;
                var sectionMd = '';
                for (var field in data[section]) {
                    var formatted = self._formatValue(data[section][field]);
                    if (formatted) {
                        sectionMd += '### ' + self._humanize(field) + '\n';
                        sectionMd += formatted + '\n\n';
                    }
                }
                if (sectionMd) {
                    moduleMd += '## ' + self._humanize(section) + '\n\n';
                    moduleMd += sectionMd;
                }
            }

            if (moduleMd) {
                if (hasAny) md += '---\n\n';
                md += '# ' + mod.title + '\n\n';
                md += moduleMd;
                hasAny = true;
            }
        }

        if (!hasAny) {
            Igris.toast('Nenhum modulo preenchido para exportar', 'error');
            return;
        }

        var slug = (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-');
        this._download(md, 'documentacao-' + slug + '.md');
        Igris.toast('Documentacao do projeto exportada!', 'success');
    },

    /* ── utilidades ──────────────────────────────────────── */

    _download: function(content, filename) {
        var blob = new Blob([content], { type: 'text/markdown;charset=utf-8' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    },

    _injectButton: function() {
        var route = SpaRouter._currentRoute;
        if (!route) return;
        var routeConfig = SpaRouter.ROUTES[route];
        if (!routeConfig || !routeConfig.isModule) return;

        var toolbar = document.querySelector('.doc-toolbar');
        if (!toolbar || toolbar.querySelector('.btn-export-doc')) return;

        var btn = document.createElement('button');
        btn.className = 'btn-tool btn-export-doc';
        btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Exportar Documentacao';
        btn.addEventListener('click', function() { InduziExportDoc.exportarModuloDownload(); });
        toolbar.appendChild(btn);
    },

    init: function() {
        var self = this;
        window.addEventListener('spa:routechange', function() {
            setTimeout(function() { self._injectButton(); }, 100);
        });
    }
};
