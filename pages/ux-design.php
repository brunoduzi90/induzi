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
<title>UX Design — Induzi</title>
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
            <h1>UX Design</h1>
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

        <!-- 1. Pesquisa de Usuario -->
        <div class="doc-section" id="section-pesquisa">
            <div class="doc-section-header" onclick="toggleSection('pesquisa')">
                <span class="doc-section-badge" id="badge-pesquisa">0/4</span>
                <h3>Pesquisa de Usuario</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Entender quem sao os usuarios, o que precisam e como se comportam e a base de todo bom design.</p>
                <div class="doc-field"><label>Personas</label><div id="comp-pesquisa-personas"></div></div>
                <div class="doc-field"><label>Jornada do usuario</label><div id="comp-pesquisa-jornada"></div></div>
                <div class="doc-field"><label>Jobs to be Done</label><div id="comp-pesquisa-jtbd"></div></div>
                <div class="doc-field"><label>Pesquisas realizadas</label><div id="comp-pesquisa-pesquisas"></div></div>
            </div>
        </div>

        <!-- 2. Navegacao e Arquitetura -->
        <div class="doc-section" id="section-navegacao">
            <div class="doc-section-header" onclick="toggleSection('navegacao')">
                <span class="doc-section-badge" id="badge-navegacao">0/4</span>
                <h3>Navegacao e Arquitetura</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Uma navegacao clara e intuitiva e a diferenca entre um usuario que encontra o que precisa e um que abandona o site.</p>
                <div class="doc-field"><label>Menu principal</label><div id="comp-navegacao-menu"></div></div>
                <div class="doc-field"><label>Hierarquia de paginas</label><div id="comp-navegacao-hierarquia"></div></div>
                <div class="doc-field"><label>Breadcrumbs e orientacao</label><div id="comp-navegacao-breadcrumbs"></div></div>
                <div class="doc-field"><label>Busca interna</label><div id="comp-navegacao-busca"></div></div>
            </div>
        </div>

        <!-- 3. Layout e Hierarquia Visual -->
        <div class="doc-section" id="section-layout">
            <div class="doc-section-header" onclick="toggleSection('layout')">
                <span class="doc-section-badge" id="badge-layout">0/4</span>
                <h3>Layout e Hierarquia Visual</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">O layout guia o olhar do usuario e comunica importancia. Uma boa hierarquia visual facilita a leitura e a acao.</p>
                <div class="doc-field"><label>Grid e espacamento</label><div id="comp-layout-grid"></div></div>
                <div class="doc-field"><label>Hierarquia visual</label><div id="comp-layout-visual"></div></div>
                <div class="doc-field"><label>Responsividade</label><div id="comp-layout-responsividade"></div></div>
                <div class="doc-field"><label>Whitespace e respiro</label><div id="comp-layout-whitespace"></div></div>
            </div>
        </div>

        <!-- 4. Componentes e Padroes -->
        <div class="doc-section" id="section-componentes">
            <div class="doc-section-header" onclick="toggleSection('componentes')">
                <span class="doc-section-badge" id="badge-componentes">0/4</span>
                <h3>Componentes e Padroes</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Padronizar componentes garante consistencia, acelera o desenvolvimento e melhora a experiencia do usuario.</p>
                <div class="doc-field"><label>Botoes e CTAs</label><div id="comp-componentes-botoes"></div></div>
                <div class="doc-field"><label>Formularios</label><div id="comp-componentes-formularios"></div></div>
                <div class="doc-field"><label>Cards e listas</label><div id="comp-componentes-cards"></div></div>
                <div class="doc-field"><label>Modais e notificacoes</label><div id="comp-componentes-modais"></div></div>
            </div>
        </div>

        <!-- 5. Experiencia Mobile -->
        <div class="doc-section" id="section-mobile">
            <div class="doc-section-header" onclick="toggleSection('mobile')">
                <span class="doc-section-badge" id="badge-mobile">0/4</span>
                <h3>Experiencia Mobile</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Mais de 60% do trafego web vem de dispositivos moveis. A experiencia mobile deve ser prioridade, nao adaptacao.</p>
                <div class="doc-field"><label>Mobile-first</label><div id="comp-mobile-mobile_first"></div></div>
                <div class="doc-field"><label>Touch targets</label><div id="comp-mobile-touch"></div></div>
                <div class="doc-field"><label>Performance mobile</label><div id="comp-mobile-perf_mobile"></div></div>
                <div class="doc-field"><label>Navegacao mobile</label><div id="comp-mobile-nav_mobile"></div></div>
            </div>
        </div>

        <!-- 6. Testes e Validacao -->
        <div class="doc-section" id="section-testes">
            <div class="doc-section-header" onclick="toggleSection('testes')">
                <span class="doc-section-badge" id="badge-testes">0/4</span>
                <h3>Testes e Validacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Testar com usuarios reais e a unica forma de validar se as decisoes de design estao corretas.</p>
                <div class="doc-field"><label>Testes de usabilidade</label><div id="comp-testes-usabilidade"></div></div>
                <div class="doc-field"><label>Testes A/B</label><div id="comp-testes-ab"></div></div>
                <div class="doc-field"><label>Heatmaps e gravacoes</label><div id="comp-testes-heatmaps"></div></div>
                <div class="doc-field"><label>Feedback do usuario</label><div id="comp-testes-feedback"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziUxDesign';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['ux-design']) || {};

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
        var exportData = { _induzi: true, modulo: 'UX Design', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-ux-design-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-pesquisa-personas', 'pesquisa.personas', 'Adicionar persona de usuario...');
        g('comp-pesquisa-jornada', 'pesquisa.jornada', 'Adicionar etapa da jornada...');
        g('comp-pesquisa-jtbd', 'pesquisa.jtbd', 'Adicionar job to be done...');
        g('comp-pesquisa-pesquisas', 'pesquisa.pesquisas', 'Adicionar pesquisa realizada...');

        g('comp-navegacao-menu', 'navegacao.menu', 'Adicionar item do menu...');
        g('comp-navegacao-hierarquia', 'navegacao.hierarquia', 'Adicionar nivel de hierarquia...');
        g('comp-navegacao-breadcrumbs', 'navegacao.breadcrumbs', 'Adicionar regra de breadcrumb...');
        g('comp-navegacao-busca', 'navegacao.busca', 'Adicionar config de busca...');

        g('comp-layout-grid', 'layout.grid', 'Adicionar regra de grid...');
        g('comp-layout-visual', 'layout.visual', 'Adicionar regra de hierarquia visual...');
        g('comp-layout-responsividade', 'layout.responsividade', 'Adicionar breakpoint ou regra...');
        g('comp-layout-whitespace', 'layout.whitespace', 'Adicionar regra de espacamento...');

        g('comp-componentes-botoes', 'componentes.botoes', 'Adicionar estilo de botao...');
        g('comp-componentes-formularios', 'componentes.formularios', 'Adicionar padrao de formulario...');
        g('comp-componentes-cards', 'componentes.cards', 'Adicionar padrao de card...');
        g('comp-componentes-modais', 'componentes.modais', 'Adicionar padrao de modal...');

        g('comp-mobile-mobile_first', 'mobile.mobile_first', 'Adicionar estrategia mobile-first...');
        g('comp-mobile-touch', 'mobile.touch', 'Adicionar regra de touch target...');
        g('comp-mobile-perf_mobile', 'mobile.perf_mobile', 'Adicionar otimizacao mobile...');
        g('comp-mobile-nav_mobile', 'mobile.nav_mobile', 'Adicionar padrao de navegacao mobile...');

        g('comp-testes-usabilidade', 'testes.usabilidade', 'Adicionar teste de usabilidade...');
        g('comp-testes-ab', 'testes.ab', 'Adicionar hipotese de teste A/B...');
        g('comp-testes-heatmaps', 'testes.heatmaps', 'Adicionar config de heatmap...');
        g('comp-testes-feedback', 'testes.feedback', 'Adicionar canal de feedback...');

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
