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
<title>Performance — Induzi</title>
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
            <h1>Performance</h1>
            <span class="page-header-stats" id="progressText">0 / 0 campos</span>
        </div>
        <div class="progress-bar" style="margin-bottom: 24px;">
            <div class="progress-fill" id="progressFill" style="width: 0%">0%</div>
        </div>

        <div class="doc-toolbar">
            <button class="btn-tool" onclick="exportarModulo()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Exportar JSON
            </button>
            <button class="btn-tool" onclick="document.getElementById('importFile').click()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                Importar JSON
            </button>
            <input type="file" id="importFile" class="doc-import-file" accept=".json" onchange="importarModulo(this)">
        </div>

        <!-- 1. Core Web Vitals -->
        <div class="doc-section" id="section-core-vitals">
            <div class="doc-section-header" onclick="toggleSection('core-vitals')">
                <span class="doc-section-badge" id="badge-core-vitals">0/4</span>
                <h3>Core Web Vitals</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">As metricas essenciais do Google para medir a experiencia do usuario. Impactam diretamente o ranking no Google.</p>
                <div class="doc-field"><label>LCP (Largest Contentful Paint)</label><div id="comp-core-vitals-lcp"></div></div>
                <div class="doc-field"><label>INP (Interaction to Next Paint)</label><div id="comp-core-vitals-inp"></div></div>
                <div class="doc-field"><label>CLS (Cumulative Layout Shift)</label><div id="comp-core-vitals-cls"></div></div>
                <div class="doc-field"><label>TTFB (Time to First Byte)</label><div id="comp-core-vitals-ttfb"></div></div>
            </div>
        </div>

        <!-- 2. Otimizacao de Imagens -->
        <div class="doc-section" id="section-imagens">
            <div class="doc-section-header" onclick="toggleSection('imagens')">
                <span class="doc-section-badge" id="badge-imagens">0/4</span>
                <h3>Otimizacao de Imagens</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Imagens costumam representar 50-70% do peso total de uma pagina. Otimiza-las e o ganho mais rapido de performance.</p>
                <div class="doc-field"><label>Formatos modernos</label><div id="comp-imagens-formatos"></div></div>
                <div class="doc-field"><label>Dimensionamento responsivo</label><div id="comp-imagens-responsivo"></div></div>
                <div class="doc-field"><label>Lazy loading</label><div id="comp-imagens-lazy"></div></div>
                <div class="doc-field"><label>CDN de imagens</label><div id="comp-imagens-cdn"></div></div>
            </div>
        </div>

        <!-- 3. Cache e CDN -->
        <div class="doc-section" id="section-cache">
            <div class="doc-section-header" onclick="toggleSection('cache')">
                <span class="doc-section-badge" id="badge-cache">0/4</span>
                <h3>Cache e CDN</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Estrategias de cache reduzem drasticamente o tempo de carregamento para visitantes recorrentes e diminuem a carga no servidor.</p>
                <div class="doc-field"><label>Cache do navegador</label><div id="comp-cache-browser"></div></div>
                <div class="doc-field"><label>CDN (Content Delivery Network)</label><div id="comp-cache-cdn"></div></div>
                <div class="doc-field"><label>Cache de pagina</label><div id="comp-cache-pagina"></div></div>
                <div class="doc-field"><label>Service Worker</label><div id="comp-cache-service_worker"></div></div>
            </div>
        </div>

        <!-- 4. Otimizacao de Codigo -->
        <div class="doc-section" id="section-codigo">
            <div class="doc-section-header" onclick="toggleSection('codigo')">
                <span class="doc-section-badge" id="badge-codigo">0/4</span>
                <h3>Otimizacao de Codigo</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Reducao do peso e complexidade dos arquivos CSS, JavaScript e HTML para carregamento mais rapido.</p>
                <div class="doc-field"><label>Minificacao e compressao</label><div id="comp-codigo-minificacao"></div></div>
                <div class="doc-field"><label>CSS critico e carregamento</label><div id="comp-codigo-css"></div></div>
                <div class="doc-field"><label>JavaScript otimizado</label><div id="comp-codigo-js"></div></div>
                <div class="doc-field"><label>Fontes web</label><div id="comp-codigo-fontes"></div></div>
            </div>
        </div>

        <!-- 5. Otimizacao de Servidor -->
        <div class="doc-section" id="section-servidor">
            <div class="doc-section-header" onclick="toggleSection('servidor')">
                <span class="doc-section-badge" id="badge-servidor">0/4</span>
                <h3>Otimizacao de Servidor</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Configuracoes no nivel do servidor que impactam diretamente o tempo de resposta e a capacidade de atender requisicoes.</p>
                <div class="doc-field"><label>HTTP/2 e HTTP/3</label><div id="comp-servidor-http"></div></div>
                <div class="doc-field"><label>Compressao de resposta</label><div id="comp-servidor-compressao"></div></div>
                <div class="doc-field"><label>Prefetch e preload</label><div id="comp-servidor-prefetch"></div></div>
                <div class="doc-field"><label>Banco de dados e backend</label><div id="comp-servidor-backend"></div></div>
            </div>
        </div>

        <!-- 6. Monitoramento e Metricas -->
        <div class="doc-section" id="section-monitoramento">
            <div class="doc-section-header" onclick="toggleSection('monitoramento')">
                <span class="doc-section-badge" id="badge-monitoramento">0/4</span>
                <h3>Monitoramento e Metricas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Ferramentas e processos para acompanhar a performance continuamente e identificar regressoes.</p>
                <div class="doc-field"><label>Google PageSpeed Insights</label><div id="comp-monitoramento-pagespeed"></div></div>
                <div class="doc-field"><label>Lighthouse e DevTools</label><div id="comp-monitoramento-lighthouse"></div></div>
                <div class="doc-field"><label>Monitoramento real (RUM)</label><div id="comp-monitoramento-rum"></div></div>
                <div class="doc-field"><label>Budget de performance</label><div id="comp-monitoramento-budget"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziPerformance';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets.performance) || {};

    function onChange() {
        for (var key in _components) {
            var p = key.split('.');
            if (!_data[p[0]]) _data[p[0]] = {};
            _data[p[0]][p[1]] = _components[key].getValue();
        }
        updateProgress();
        if (_saveTimer) clearTimeout(_saveTimer);
        _saveTimer = setTimeout(function() { InduziDB.save(DATA_KEY, _data); }, 1000);
    }

    function updateProgress() {
        var total = 0, filled = 0, sections = {};
        for (var key in _components) {
            var s = key.split('.')[0];
            if (!sections[s]) sections[s] = { total: 0, filled: 0 };
            sections[s].total++; total++;
            if (_components[key].isFilled()) { sections[s].filled++; filled++; }
        }
        var pct = total > 0 ? Math.round(filled / total * 100) : 0;
        var fillEl = document.getElementById('progressFill');
        var textEl = document.getElementById('progressText');
        if (fillEl) { fillEl.style.width = pct + '%'; fillEl.textContent = pct + '%'; }
        if (textEl) textEl.textContent = filled + ' / ' + total + ' campos';
        for (var sec in sections) {
            var badge = document.getElementById('badge-' + sec);
            if (badge) {
                badge.textContent = sections[sec].filled + '/' + sections[sec].total;
                badge.classList.toggle('complete', sections[sec].filled === sections[sec].total);
            }
        }
    }

    window.toggleSection = function(id) { var el = document.getElementById('section-' + id); if (el) el.classList.toggle('open'); };

    function populateAll() {
        for (var key in _components) {
            var p = key.split('.');
            if (_data[p[0]] && _data[p[0]][p[1]] != null) _components[key].setValue(_data[p[0]][p[1]]);
        }
    }

    function g(id, key, ph) {
        var el = document.getElementById(id);
        if (!el) return;
        _components[key] = InduziComponents.guided(el, Object.assign({ onChange: onChange, placeholder: ph }, presets[key] || {}));
    }

    window.exportarModulo = async function() {
        for (var key in _components) { var p = key.split('.'); if (!_data[p[0]]) _data[p[0]] = {}; _data[p[0]][p[1]] = _components[key].getValue(); }
        var projeto = InduziAuth.getCurrentProject();
        var exportData = { _induzi: true, modulo: 'Performance', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-performance-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-core-vitals-lcp', 'core-vitals.lcp', 'Adicionar estrategia LCP...');
        g('comp-core-vitals-inp', 'core-vitals.inp', 'Adicionar estrategia INP...');
        g('comp-core-vitals-cls', 'core-vitals.cls', 'Adicionar estrategia CLS...');
        g('comp-core-vitals-ttfb', 'core-vitals.ttfb', 'Adicionar estrategia TTFB...');

        g('comp-imagens-formatos', 'imagens.formatos', 'Adicionar formato de imagem...');
        g('comp-imagens-responsivo', 'imagens.responsivo', 'Adicionar tecnica responsiva...');
        g('comp-imagens-lazy', 'imagens.lazy', 'Adicionar tecnica de lazy loading...');
        g('comp-imagens-cdn', 'imagens.cdn', 'Adicionar config de CDN...');

        g('comp-cache-browser', 'cache.browser', 'Adicionar config de cache...');
        g('comp-cache-cdn', 'cache.cdn', 'Adicionar config de CDN...');
        g('comp-cache-pagina', 'cache.pagina', 'Adicionar config de cache...');
        g('comp-cache-service_worker', 'cache.service_worker', 'Adicionar config de service worker...');

        g('comp-codigo-minificacao', 'codigo.minificacao', 'Adicionar tecnica de minificacao...');
        g('comp-codigo-css', 'codigo.css', 'Adicionar otimizacao CSS...');
        g('comp-codigo-js', 'codigo.js', 'Adicionar otimizacao JS...');
        g('comp-codigo-fontes', 'codigo.fontes', 'Adicionar otimizacao de fonte...');

        g('comp-servidor-http', 'servidor.http', 'Adicionar config HTTP...');
        g('comp-servidor-compressao', 'servidor.compressao', 'Adicionar config de compressao...');
        g('comp-servidor-prefetch', 'servidor.prefetch', 'Adicionar tecnica de prefetch...');
        g('comp-servidor-backend', 'servidor.backend', 'Adicionar otimizacao de backend...');

        g('comp-monitoramento-pagespeed', 'monitoramento.pagespeed', 'Adicionar item de monitoramento...');
        g('comp-monitoramento-lighthouse', 'monitoramento.lighthouse', 'Adicionar auditoria Lighthouse...');
        g('comp-monitoramento-rum', 'monitoramento.rum', 'Adicionar config de RUM...');
        g('comp-monitoramento-budget', 'monitoramento.budget', 'Adicionar budget de performance...');

        var saved = await InduziDB.load(DATA_KEY);
        if (saved) { _data = saved; populateAll(); }
        updateProgress();
    }

    init();
    window._spaCleanup = function() {
        if (_saveTimer) clearTimeout(_saveTimer);
        for (var key in _components) _components[key].destroy();
    };
})();
</script>
<?php if (!isset($_GET['fragment'])): ?>
</div></body></html>
<?php endif; ?>
<?php spaFragmentEnd(); ?>
