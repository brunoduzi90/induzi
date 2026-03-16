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
<title>Analytics — Induzi</title>
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
.doc-field .field-hint { font-size: 0.73rem; color: var(--color-gray-light); margin-top: 4px; }
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
            <h1>Analytics</h1>
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

        <!-- 1. Configuracao Inicial -->
        <div class="doc-section" id="section-configuracao">
            <div class="doc-section-header" onclick="toggleSection('configuracao')">
                <span class="doc-section-badge" id="badge-configuracao">0/4</span>
                <h3>Configuracao Inicial</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Instalacao e configuracao das ferramentas essenciais de medicao. Sem tracking correto, todas as decisoes sao baseadas em achismo.</p>
                <div class="doc-field"><label>Google Analytics 4</label><div id="comp-configuracao-ga4"></div></div>
                <div class="doc-field"><label>Google Tag Manager</label><div id="comp-configuracao-gtm"></div></div>
                <div class="doc-field"><label>Google Search Console</label><div id="comp-configuracao-gsc"></div></div>
                <div class="doc-field"><label>Outras ferramentas</label><div id="comp-configuracao-outras"></div></div>
            </div>
        </div>

        <!-- 2. Eventos e Conversoes -->
        <div class="doc-section" id="section-eventos">
            <div class="doc-section-header" onclick="toggleSection('eventos')">
                <span class="doc-section-badge" id="badge-eventos">0/4</span>
                <h3>Eventos e Conversoes</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Tracking de acoes importantes dos usuarios para medir o que realmente importa para o negocio.</p>
                <div class="doc-field"><label>Eventos customizados</label><div id="comp-eventos-customizados"></div></div>
                <div class="doc-field"><label>Conversoes (goals)</label><div id="comp-eventos-conversoes"></div></div>
                <div class="doc-field"><label>E-commerce tracking</label><div id="comp-eventos-ecommerce"></div></div>
                <div class="doc-field"><label>Data Layer</label><div id="comp-eventos-datalayer"></div></div>
            </div>
        </div>

        <!-- 3. UTMs e Campanhas -->
        <div class="doc-section" id="section-campanhas">
            <div class="doc-section-header" onclick="toggleSection('campanhas')">
                <span class="doc-section-badge" id="badge-campanhas">0/4</span>
                <h3>UTMs e Campanhas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Padronizacao de parametros UTM para rastrear a origem de cada visitante e medir o ROI de cada canal.</p>
                <div class="doc-field"><label>Nomenclatura de UTMs</label><div id="comp-campanhas-nomenclatura"></div></div>
                <div class="doc-field"><label>Campanhas ativas</label><div id="comp-campanhas-ativas"></div></div>
                <div class="doc-field"><label>Ferramenta de geracao</label><div id="comp-campanhas-ferramenta"></div></div>
                <div class="doc-field"><label>Atribuicao</label><div id="comp-campanhas-atribuicao"></div></div>
            </div>
        </div>

        <!-- 4. Relatorios e KPIs -->
        <div class="doc-section" id="section-relatorios">
            <div class="doc-section-header" onclick="toggleSection('relatorios')">
                <span class="doc-section-badge" id="badge-relatorios">0/4</span>
                <h3>Relatorios e KPIs</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Dashboards e metricas-chave para acompanhar a saude do site e tomar decisoes baseadas em dados.</p>
                <div class="doc-field"><label>KPIs principais</label><div id="comp-relatorios-kpis"></div></div>
                <div class="doc-field"><label>Dashboards</label><div id="comp-relatorios-dashboards"></div></div>
                <div class="doc-field"><label>Relatorios periodicos</label><div id="comp-relatorios-periodicos"></div></div>
                <div class="doc-field"><label>Segmentacao</label><div id="comp-relatorios-segmentacao"></div></div>
            </div>
        </div>

        <!-- 5. Funis de Conversao -->
        <div class="doc-section" id="section-funis">
            <div class="doc-section-header" onclick="toggleSection('funis')">
                <span class="doc-section-badge" id="badge-funis">0/4</span>
                <h3>Funis de Conversao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Mapeamento das etapas que o usuario percorre ate converter, identificando gargalos e oportunidades.</p>
                <div class="doc-field"><label>Funil principal</label><div id="comp-funis-principal"></div></div>
                <div class="doc-field"><label>Funis secundarios</label><div id="comp-funis-secundarios"></div></div>
                <div class="doc-field"><label>Analise de abandono</label><div id="comp-funis-abandono"></div></div>
                <div class="doc-field"><label>Otimizacao do funil</label><div id="comp-funis-otimizacao"></div></div>
            </div>
        </div>

        <!-- 6. Integracoes e Dados -->
        <div class="doc-section" id="section-integracao">
            <div class="doc-section-header" onclick="toggleSection('integracao')">
                <span class="doc-section-badge" id="badge-integracao">0/4</span>
                <h3>Integracoes e Dados</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Conexao entre ferramentas de analytics, CRM, e-commerce e demais sistemas para uma visao unificada.</p>
                <div class="doc-field"><label>CRM e vendas</label><div id="comp-integracao-crm"></div></div>
                <div class="doc-field"><label>E-commerce / ERP</label><div id="comp-integracao-erp"></div></div>
                <div class="doc-field"><label>APIs e webhooks</label><div id="comp-integracao-apis"></div></div>
                <div class="doc-field"><label>Privacidade e consentimento</label><div id="comp-integracao-privacidade"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziAnalytics';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets.analytics) || {};

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
        var exportData = { _induzi: true, modulo: 'Analytics', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-analytics-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-configuracao-ga4', 'configuracao.ga4', 'Adicionar config do GA4...');
        g('comp-configuracao-gtm', 'configuracao.gtm', 'Adicionar config do GTM...');
        g('comp-configuracao-gsc', 'configuracao.gsc', 'Adicionar config do Search Console...');
        g('comp-configuracao-outras', 'configuracao.outras', 'Adicionar outra ferramenta...');

        g('comp-eventos-customizados', 'eventos.customizados', 'Adicionar evento customizado...');
        g('comp-eventos-conversoes', 'eventos.conversoes', 'Adicionar conversao...');
        g('comp-eventos-ecommerce', 'eventos.ecommerce', 'Adicionar evento de e-commerce...');
        g('comp-eventos-datalayer', 'eventos.datalayer', 'Adicionar variavel do dataLayer...');

        g('comp-campanhas-nomenclatura', 'campanhas.nomenclatura', 'Adicionar padrao de UTM...');
        g('comp-campanhas-ativas', 'campanhas.ativas', 'Adicionar campanha ativa...');
        g('comp-campanhas-ferramenta', 'campanhas.ferramenta', 'Adicionar ferramenta de geracao...');
        g('comp-campanhas-atribuicao', 'campanhas.atribuicao', 'Adicionar modelo de atribuicao...');

        g('comp-relatorios-kpis', 'relatorios.kpis', 'Adicionar KPI principal...');
        g('comp-relatorios-dashboards', 'relatorios.dashboards', 'Adicionar dashboard...');
        g('comp-relatorios-periodicos', 'relatorios.periodicos', 'Adicionar relatorio periodico...');
        g('comp-relatorios-segmentacao', 'relatorios.segmentacao', 'Adicionar segmento de usuarios...');

        g('comp-funis-principal', 'funis.principal', 'Adicionar etapa do funil...');
        g('comp-funis-secundarios', 'funis.secundarios', 'Adicionar funil secundario...');
        g('comp-funis-abandono', 'funis.abandono', 'Adicionar analise de abandono...');
        g('comp-funis-otimizacao', 'funis.otimizacao', 'Adicionar melhoria do funil...');

        g('comp-integracao-crm', 'integracao.crm', 'Adicionar integracao com CRM...');
        g('comp-integracao-erp', 'integracao.erp', 'Adicionar integracao com ERP...');
        g('comp-integracao-apis', 'integracao.apis', 'Adicionar integracao via API...');
        g('comp-integracao-privacidade', 'integracao.privacidade', 'Adicionar config de privacidade...');

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
