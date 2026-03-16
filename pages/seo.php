<?php require_once __DIR__ . '/../includes/fragment.php'; spaFragmentStart(); ?>
<?php require_once __DIR__ . '/../includes/db.php'; ?>
<?php require_once __DIR__ . '/../includes/helpers.php'; ?>
<?php require_once __DIR__ . '/../includes/auth.php'; ?>
<?php require_once __DIR__ . '/../version.php'; ?>
<?php $sbInPages = true; $sbPrefix = ''; $sbRoot = '../'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SEO — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<link rel="stylesheet" href="../css/components.css?v=<?= INDUZI_VERSION ?>">
<style>
.page-header-compact { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 8px; }
.page-header-compact h1 { font-size: 1.3rem; font-weight: 700; color: var(--color-black); margin: 0; }
.page-header-stats { font-size: 0.82rem; color: var(--color-gray); font-weight: 500; }
.doc-section { background: var(--color-white); border: 1px solid var(--color-border); border-radius: 8px; margin-bottom: 12px; }
.doc-section-header { padding: 16px 20px; cursor: pointer; display: flex; align-items: center; gap: 12px; user-select: none; transition: background 0.15s; }
.doc-section-header:hover { background: var(--color-bg); }
.doc-section-header h3 { flex: 1; font-size: 0.95rem; font-weight: 600; color: var(--color-black); margin: 0; }
.doc-section-header .chevron { width: 20px; height: 20px; color: var(--color-gray-light); transition: transform 0.2s; flex-shrink: 0; }
.doc-section.open .chevron { transform: rotate(180deg); }
.doc-section-badge { min-width: 40px; padding: 2px 10px; border-radius: 10px; font-size: 0.7rem; font-weight: 600; background: var(--color-bg); color: var(--color-gray); text-align: center; flex-shrink: 0; }
.doc-section-badge.complete { background: rgba(46,125,50,0.1); color: var(--color-success, #2e7d32); }
.doc-section-body { padding: 0 20px 20px; display: none; }
.doc-section.open .doc-section-body { display: block; }
.doc-section-desc { font-size: 0.84rem; color: var(--color-gray); margin-bottom: 20px; line-height: 1.6; }
.doc-field { margin-bottom: 18px; }
.doc-field:last-child { margin-bottom: 0; }
.doc-field label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--color-gray-dark, #444); margin-bottom: 6px; }
.doc-toolbar { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
.doc-toolbar .btn-tool { display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px; border: 1px solid var(--color-border); border-radius: 6px; background: var(--color-white); color: var(--color-gray-dark, #444); font-size: 0.82rem; font-weight: 500; font-family: inherit; cursor: pointer; transition: all 0.15s; }
.doc-toolbar .btn-tool:hover { border-color: var(--color-accent, #7c3aed); color: var(--color-accent, #7c3aed); }
.doc-toolbar .btn-tool svg { width: 15px; height: 15px; flex-shrink: 0; }
.doc-import-file { display: none; }
</style>
</head>
<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="container">

        <div class="page-header-compact">
            <h1>SEO</h1>
            <span class="page-header-stats" id="progressText">0 / 0 campos</span>
        </div>
        <div class="progress-bar" style="margin-bottom: 24px;">
            <div class="progress-fill" id="progressFill" style="width: 0%">0%</div>
        </div>

        <div class="doc-toolbar">
            <button class="btn-tool" onclick="exportarModulo()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Exportar JSON</button>
            <button class="btn-tool" onclick="document.getElementById('importFile').click()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg> Importar JSON</button>
            <input type="file" id="importFile" class="doc-import-file" accept=".json" onchange="importarModulo(this)">
        </div>

        <!-- 1. Pesquisa de Palavras-Chave -->
        <div class="doc-section" id="section-palavras">
            <div class="doc-section-header" onclick="toggleSection('palavras')"><span class="doc-section-badge" id="badge-palavras">0/4</span><h3>Pesquisa de Palavras-Chave</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Mapeie as palavras-chave estrategicas do negocio, incluindo variantes semanticas, long tail e analise competitiva.</p>
                <div class="doc-field"><label>Palavras-chave principais</label><div id="comp-palavras-principais"></div></div>
                <div class="doc-field"><label>Palavras-chave secundarias</label><div id="comp-palavras-secundarias"></div></div>
                <div class="doc-field"><label>Long tail keywords</label><div id="comp-palavras-long_tail"></div></div>
                <div class="doc-field"><label>Keywords dos concorrentes</label><div id="comp-palavras-concorrentes"></div></div>
            </div>
        </div>

        <!-- 2. SEO On-Page -->
        <div class="doc-section" id="section-onpage">
            <div class="doc-section-header" onclick="toggleSection('onpage')"><span class="doc-section-badge" id="badge-onpage">0/5</span><h3>SEO On-Page</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente os padroes de otimizacao on-page para cada tipo de pagina do site.</p>
                <div class="doc-field"><label>Title tags por pagina</label><div id="comp-onpage-title_tags"></div></div>
                <div class="doc-field"><label>Meta descriptions por pagina</label><div id="comp-onpage-meta_descriptions"></div></div>
                <div class="doc-field"><label>Estrutura de headings (H1-H6)</label><div id="comp-onpage-headings"></div></div>
                <div class="doc-field"><label>Padroes de URLs</label><div id="comp-onpage-urls"></div></div>
                <div class="doc-field"><label>Estrategia de links internos</label><div id="comp-onpage-internal_links"></div></div>
            </div>
        </div>

        <!-- 3. Estrategia de Conteudo -->
        <div class="doc-section" id="section-conteudo">
            <div class="doc-section-header" onclick="toggleSection('conteudo')"><span class="doc-section-badge" id="badge-conteudo">0/4</span><h3>Estrategia de Conteudo</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje a producao de conteudo com foco em SEO, definindo pilares, formatos e calendario editorial.</p>
                <div class="doc-field"><label>Pilares de conteudo</label><div id="comp-conteudo-estrategia"></div></div>
                <div class="doc-field"><label>Calendario editorial</label><div id="comp-conteudo-calendario"></div></div>
                <div class="doc-field"><label>Formatos de conteudo</label><div id="comp-conteudo-formatos"></div></div>
                <div class="doc-field"><label>Guidelines de redacao SEO</label><div id="comp-conteudo-guidelines"></div></div>
            </div>
        </div>

        <!-- 4. SEO Tecnico -->
        <div class="doc-section" id="section-tecnico">
            <div class="doc-section-header" onclick="toggleSection('tecnico')"><span class="doc-section-badge" id="badge-tecnico">0/5</span><h3>SEO Tecnico</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Registre as configuracoes tecnicas de SEO: sitemap, robots, schema markup, canonical e indexacao.</p>
                <div class="doc-field"><label>Sitemap XML</label><div id="comp-tecnico-sitemap"></div></div>
                <div class="doc-field"><label>Robots.txt</label><div id="comp-tecnico-robots"></div></div>
                <div class="doc-field"><label>Schema Markup / Dados Estruturados</label><div id="comp-tecnico-schema"></div></div>
                <div class="doc-field"><label>Canonical tags</label><div id="comp-tecnico-canonical"></div></div>
                <div class="doc-field"><label>Indexacao</label><div id="comp-tecnico-indexacao"></div></div>
            </div>
        </div>

        <!-- 5. Link Building -->
        <div class="doc-section" id="section-links">
            <div class="doc-section-header" onclick="toggleSection('links')"><span class="doc-section-badge" id="badge-links">0/4</span><h3>Link Building</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina a estrategia de aquisicao de backlinks, parceiros e perfil de links atual.</p>
                <div class="doc-field"><label>Taticas de link building</label><div id="comp-links-estrategia"></div></div>
                <div class="doc-field"><label>Sites parceiros e prospects</label><div id="comp-links-parceiros"></div></div>
                <div class="doc-field"><label>Guest posts</label><div id="comp-links-guest_posts"></div></div>
                <div class="doc-field"><label>Perfil de backlinks</label><div id="comp-links-backlinks"></div></div>
            </div>
        </div>

        <!-- 6. SEO Local -->
        <div class="doc-section" id="section-local">
            <div class="doc-section-header" onclick="toggleSection('local')"><span class="doc-section-badge" id="badge-local">0/4</span><h3>SEO Local</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente a presenca local do negocio: Google Meu Negocio, citacoes, avaliacoes e consistencia NAP.</p>
                <div class="doc-field"><label>Google Meu Negocio</label><div id="comp-local-gmb"></div></div>
                <div class="doc-field"><label>NAP (Nome, Endereco, Telefone)</label><div id="comp-local-nap"></div></div>
                <div class="doc-field"><label>Avaliacoes e reviews</label><div id="comp-local-avaliacoes"></div></div>
                <div class="doc-field"><label>Citacoes locais</label><div id="comp-local-citacoes"></div></div>
            </div>
        </div>

        <!-- 7. Core Web Vitals e Performance -->
        <div class="doc-section" id="section-performance">
            <div class="doc-section-header" onclick="toggleSection('performance')"><span class="doc-section-badge" id="badge-performance">0/4</span><h3>Core Web Vitals e Performance</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Acompanhe as metricas de performance do site e documente otimizacoes implementadas e planejadas.</p>
                <div class="doc-field"><label>LCP (Largest Contentful Paint)</label><div id="comp-performance-lcp"></div></div>
                <div class="doc-field"><label>FID / INP (Interaction to Next Paint)</label><div id="comp-performance-fid"></div></div>
                <div class="doc-field"><label>CLS (Cumulative Layout Shift)</label><div id="comp-performance-cls"></div></div>
                <div class="doc-field"><label>Otimizacoes implementadas</label><div id="comp-performance-otimizacoes"></div></div>
            </div>
        </div>

        <!-- 8. Mobile SEO -->
        <div class="doc-section" id="section-mobile">
            <div class="doc-section-header" onclick="toggleSection('mobile')"><span class="doc-section-badge" id="badge-mobile">0/3</span><h3>Mobile SEO</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente a estrategia mobile do site: responsividade, experiencia do usuario e testes realizados.</p>
                <div class="doc-field"><label>Responsividade</label><div id="comp-mobile-responsividade"></div></div>
                <div class="doc-field"><label>UX Mobile</label><div id="comp-mobile-ux_mobile"></div></div>
                <div class="doc-field"><label>Testes e ferramentas</label><div id="comp-mobile-testes"></div></div>
            </div>
        </div>

        <!-- 9. Imagens e Midia -->
        <div class="doc-section" id="section-imagens">
            <div class="doc-section-header" onclick="toggleSection('imagens')"><span class="doc-section-badge" id="badge-imagens">0/4</span><h3>Imagens e Midia</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina padroes de otimizacao de imagens e midia para SEO: formatos, alt text, lazy loading e nomeacao.</p>
                <div class="doc-field"><label>Formatos e compressao</label><div id="comp-imagens-formatos"></div></div>
                <div class="doc-field"><label>Padroes de alt text</label><div id="comp-imagens-alt_text"></div></div>
                <div class="doc-field"><label>Lazy loading e CDN</label><div id="comp-imagens-lazy_loading"></div></div>
                <div class="doc-field"><label>Padroes de nomeacao</label><div id="comp-imagens-nomeacao"></div></div>
            </div>
        </div>

        <!-- 10. Analytics e Monitoramento -->
        <div class="doc-section" id="section-analytics">
            <div class="doc-section-header" onclick="toggleSection('analytics')"><span class="doc-section-badge" id="badge-analytics">0/4</span><h3>Analytics e Monitoramento</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Configure e documente as ferramentas de analytics, KPIs e rotinas de monitoramento de SEO.</p>
                <div class="doc-field"><label>Google Analytics 4</label><div id="comp-analytics-ga4"></div></div>
                <div class="doc-field"><label>Google Search Console</label><div id="comp-analytics-search_console"></div></div>
                <div class="doc-field"><label>KPIs e metas</label><div id="comp-analytics-metas"></div></div>
                <div class="doc-field"><label>Relatorios e frequencia</label><div id="comp-analytics-relatorios"></div></div>
            </div>
        </div>

    </div>
</div>
<script src="../js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script>
(function() {
    var DATA_KEY = 'induziSeo';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['seo']) || {};

    function onChange() {
        for (var key in _components) { var p = key.split('.'); if (!_data[p[0]]) _data[p[0]] = {}; _data[p[0]][p[1]] = _components[key].getValue(); }
        updateProgress();
        if (_saveTimer) clearTimeout(_saveTimer);
        _saveTimer = setTimeout(function() { InduziDB.save(DATA_KEY, _data); }, 1000);
    }

    function updateProgress() {
        var total = 0, filled = 0, sections = {};
        for (var key in _components) { var s = key.split('.')[0]; if (!sections[s]) sections[s] = { total: 0, filled: 0 }; sections[s].total++; total++; if (_components[key].isFilled()) { sections[s].filled++; filled++; } }
        var pct = total > 0 ? Math.round(filled / total * 100) : 0;
        var fillEl = document.getElementById('progressFill'); var textEl = document.getElementById('progressText');
        if (fillEl) { fillEl.style.width = pct + '%'; fillEl.textContent = pct + '%'; }
        if (textEl) textEl.textContent = filled + ' / ' + total + ' campos';
        for (var sec in sections) { var badge = document.getElementById('badge-' + sec); if (badge) { badge.textContent = sections[sec].filled + '/' + sections[sec].total; badge.classList.toggle('complete', sections[sec].filled === sections[sec].total); } }
    }

    window.toggleSection = function(id) { var el = document.getElementById('section-' + id); if (el) el.classList.toggle('open'); };

    function populateAll() { for (var key in _components) { var p = key.split('.'); if (_data[p[0]] && _data[p[0]][p[1]] != null) _components[key].setValue(_data[p[0]][p[1]]); } }

    window.exportarModulo = async function() {
        for (var key in _components) { var p = key.split('.'); if (!_data[p[0]]) _data[p[0]] = {}; _data[p[0]][p[1]] = _components[key].getValue(); }
        var projeto = InduziAuth.getCurrentProject();
        var exportData = { _induzi: true, modulo: 'SEO', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob); var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-seo-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
        a.click(); URL.revokeObjectURL(url); Igris.toast('Dados exportados!', 'success');
    };

    window.importarModulo = async function(input) {
        var file = input.files[0]; if (!file) return;
        try {
            var text = await file.text(); var importData = JSON.parse(text);
            var dados = importData.dados || importData;
            if (typeof dados !== 'object') { Igris.toast('JSON invalido', 'error'); input.value = ''; return; }
            var ok = await Igris.confirm('Importar dados de "' + file.name + '"? Os dados atuais serao substituidos.');
            if (!ok) { input.value = ''; return; }
            _data = dados; await InduziDB.save(DATA_KEY, _data); populateAll(); updateProgress();
            Igris.toast('Dados importados!', 'success');
        } catch (e) { Igris.toast('Erro ao ler arquivo: ' + e.message, 'error'); }
        input.value = '';
    };

    async function init() {
        _components['palavras.principais'] = InduziComponents.guided(document.getElementById('comp-palavras-principais'), Object.assign({ onChange: onChange, placeholder: 'Adicionar keyword... (Enter)' }, presets['palavras.principais'] || {}));
        _components['palavras.secundarias'] = InduziComponents.guided(document.getElementById('comp-palavras-secundarias'), Object.assign({ onChange: onChange, placeholder: 'Adicionar keyword secundaria... (Enter)' }, presets['palavras.secundarias'] || {}));
        _components['palavras.long_tail'] = InduziComponents.guided(document.getElementById('comp-palavras-long_tail'), Object.assign({ onChange: onChange, placeholder: 'Adicionar long tail... (Enter)' }, presets['palavras.long_tail'] || {}));
        _components['palavras.concorrentes'] = InduziComponents.guided(document.getElementById('comp-palavras-concorrentes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar keyword do concorrente... (Enter)' }, presets['palavras.concorrentes'] || {}));

        _components['onpage.title_tags'] = InduziComponents.keyValue(document.getElementById('comp-onpage-title_tags'), { keyLabel: 'Tipo de pagina', valueLabel: 'Padrao de title', onChange: onChange });
        _components['onpage.meta_descriptions'] = InduziComponents.keyValue(document.getElementById('comp-onpage-meta_descriptions'), { keyLabel: 'Tipo de pagina', valueLabel: 'Template', onChange: onChange });
        _components['onpage.headings'] = InduziComponents.guided(document.getElementById('comp-onpage-headings'), Object.assign({ onChange: onChange, placeholder: 'Adicionar padrao de heading...' }, presets['onpage.headings'] || {}));
        _components['onpage.urls'] = InduziComponents.guided(document.getElementById('comp-onpage-urls'), Object.assign({ onChange: onChange, placeholder: 'Adicionar padrao de URL...' }, presets['onpage.urls'] || {}));
        _components['onpage.internal_links'] = InduziComponents.guided(document.getElementById('comp-onpage-internal_links'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de link interno...' }, presets['onpage.internal_links'] || {}));

        _components['conteudo.estrategia'] = InduziComponents.guided(document.getElementById('comp-conteudo-estrategia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar pilar de conteudo...' }, presets['conteudo.estrategia'] || {}));
        _components['conteudo.calendario'] = InduziComponents.guided(document.getElementById('comp-conteudo-calendario'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item ao calendario...' }, presets['conteudo.calendario'] || {}));
        _components['conteudo.formatos'] = InduziComponents.multiSelect(document.getElementById('comp-conteudo-formatos'), {
            options: [
                { value: 'Blog Posts', label: 'Blog Posts' }, { value: 'Guias', label: 'Guias' }, { value: 'Infograficos', label: 'Infograficos' },
                { value: 'Videos', label: 'Videos' }, { value: 'Podcasts', label: 'Podcasts' }, { value: 'E-books', label: 'E-books' },
                { value: 'Webinars', label: 'Webinars' }, { value: 'Ferramentas', label: 'Ferramentas' }
            ], onChange: onChange
        });
        _components['conteudo.guidelines'] = InduziComponents.guided(document.getElementById('comp-conteudo-guidelines'), Object.assign({ onChange: onChange, placeholder: 'Adicionar guideline...' }, presets['conteudo.guidelines'] || {}));

        _components['tecnico.sitemap'] = InduziComponents.guided(document.getElementById('comp-tecnico-sitemap'), Object.assign({ onChange: onChange, placeholder: 'Adicionar config do sitemap...' }, presets['tecnico.sitemap'] || {}));
        _components['tecnico.robots'] = InduziComponents.guided(document.getElementById('comp-tecnico-robots'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra robots.txt...' }, presets['tecnico.robots'] || {}));
        _components['tecnico.schema'] = InduziComponents.guided(document.getElementById('comp-tecnico-schema'), Object.assign({ onChange: onChange, placeholder: 'Adicionar schema...' }, presets['tecnico.schema'] || {}));
        _components['tecnico.canonical'] = InduziComponents.guided(document.getElementById('comp-tecnico-canonical'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra canonical...' }, presets['tecnico.canonical'] || {}));
        _components['tecnico.indexacao'] = InduziComponents.guided(document.getElementById('comp-tecnico-indexacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de indexacao...' }, presets['tecnico.indexacao'] || {}));

        _components['links.estrategia'] = InduziComponents.guided(document.getElementById('comp-links-estrategia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tatica...' }, presets['links.estrategia'] || {}));
        _components['links.parceiros'] = InduziComponents.keyValue(document.getElementById('comp-links-parceiros'), { keyLabel: 'Site', valueLabel: 'DR/DA', onChange: onChange });
        _components['links.guest_posts'] = InduziComponents.guided(document.getElementById('comp-links-guest_posts'), Object.assign({ onChange: onChange, placeholder: 'Adicionar guest post...' }, presets['links.guest_posts'] || {}));
        _components['links.backlinks'] = InduziComponents.keyValue(document.getElementById('comp-links-backlinks'), { keyLabel: 'Metrica', valueLabel: 'Valor', onChange: onChange });

        _components['local.gmb'] = InduziComponents.guided(document.getElementById('comp-local-gmb'), Object.assign({ onChange: onChange, placeholder: 'Adicionar config do GMB...' }, presets['local.gmb'] || {}));
        _components['local.nap'] = InduziComponents.keyValue(document.getElementById('comp-local-nap'), { keyLabel: 'Campo', valueLabel: 'Informacao', onChange: onChange });
        _components['local.avaliacoes'] = InduziComponents.guided(document.getElementById('comp-local-avaliacoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar estrategia de review...' }, presets['local.avaliacoes'] || {}));
        _components['local.citacoes'] = InduziComponents.guided(document.getElementById('comp-local-citacoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar diretorio... (Enter)' }, presets['local.citacoes'] || {}));

        _components['performance.lcp'] = InduziComponents.keyValue(document.getElementById('comp-performance-lcp'), { keyLabel: 'Item', valueLabel: 'Valor', onChange: onChange });
        _components['performance.fid'] = InduziComponents.keyValue(document.getElementById('comp-performance-fid'), { keyLabel: 'Item', valueLabel: 'Valor', onChange: onChange });
        _components['performance.cls'] = InduziComponents.keyValue(document.getElementById('comp-performance-cls'), { keyLabel: 'Item', valueLabel: 'Valor', onChange: onChange });
        _components['performance.otimizacoes'] = InduziComponents.guided(document.getElementById('comp-performance-otimizacoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar otimizacao...' }, presets['performance.otimizacoes'] || {}));

        _components['mobile.responsividade'] = InduziComponents.guided(document.getElementById('comp-mobile-responsividade'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['mobile.responsividade'] || {}));
        _components['mobile.ux_mobile'] = InduziComponents.guided(document.getElementById('comp-mobile-ux_mobile'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item UX...' }, presets['mobile.ux_mobile'] || {}));
        _components['mobile.testes'] = InduziComponents.guided(document.getElementById('comp-mobile-testes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar teste/ferramenta...' }, presets['mobile.testes'] || {}));

        _components['imagens.formatos'] = InduziComponents.multiSelect(document.getElementById('comp-imagens-formatos'), {
            options: [{ value: 'WebP', label: 'WebP' }, { value: 'AVIF', label: 'AVIF' }, { value: 'JPEG', label: 'JPEG' }, { value: 'PNG', label: 'PNG' }, { value: 'SVG', label: 'SVG' }, { value: 'GIF', label: 'GIF' }], onChange: onChange
        });
        _components['imagens.alt_text'] = InduziComponents.guided(document.getElementById('comp-imagens-alt_text'), Object.assign({ onChange: onChange, placeholder: 'Adicionar padrao de alt text...' }, presets['imagens.alt_text'] || {}));
        _components['imagens.lazy_loading'] = InduziComponents.guided(document.getElementById('comp-imagens-lazy_loading'), Object.assign({ onChange: onChange, placeholder: 'Adicionar config de loading...' }, presets['imagens.lazy_loading'] || {}));
        _components['imagens.nomeacao'] = InduziComponents.guided(document.getElementById('comp-imagens-nomeacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar padrao de nome...' }, presets['imagens.nomeacao'] || {}));

        _components['analytics.ga4'] = InduziComponents.guided(document.getElementById('comp-analytics-ga4'), Object.assign({ onChange: onChange, placeholder: 'Adicionar config GA4...' }, presets['analytics.ga4'] || {}));
        _components['analytics.search_console'] = InduziComponents.guided(document.getElementById('comp-analytics-search_console'), Object.assign({ onChange: onChange, placeholder: 'Adicionar config GSC...' }, presets['analytics.search_console'] || {}));
        _components['analytics.metas'] = InduziComponents.keyValue(document.getElementById('comp-analytics-metas'), { keyLabel: 'Metrica', valueLabel: 'Meta', onChange: onChange });
        _components['analytics.relatorios'] = InduziComponents.guided(document.getElementById('comp-analytics-relatorios'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item de relatorio...' }, presets['analytics.relatorios'] || {}));

        var saved = await InduziDB.load(DATA_KEY);
        if (saved) { _data = saved; populateAll(); }
        updateProgress();
    }

    init();
    window._spaCleanup = function() { if (_saveTimer) clearTimeout(_saveTimer); for (var key in _components) _components[key].destroy(); };
})();
</script>
<?php if (!isset($_GET['fragment'])): ?>
</div></body></html>
<?php endif; ?>
<?php spaFragmentEnd(); ?>
