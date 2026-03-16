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
<title>Acessibilidade — Induzi</title>
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
            <h1>Acessibilidade</h1>
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

        <!-- 1. HTML Semantico e ARIA -->
        <div class="doc-section" id="section-semantica">
            <div class="doc-section-header" onclick="toggleSection('semantica')">
                <span class="doc-section-badge" id="badge-semantica">0/4</span>
                <h3>HTML Semantico e ARIA</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Usar HTML semantico corretamente e a base da acessibilidade. Elementos nativos ja possuem funcionalidades de acessibilidade embutidas.</p>
                <div class="doc-field"><label>Estrutura de headings</label><div id="comp-semantica-headings"></div></div>
                <div class="doc-field"><label>Landmarks e regioes</label><div id="comp-semantica-landmarks"></div></div>
                <div class="doc-field"><label>Atributos ARIA</label><div id="comp-semantica-aria"></div></div>
                <div class="doc-field"><label>Listas e tabelas</label><div id="comp-semantica-listas"></div></div>
            </div>
        </div>

        <!-- 2. Navegacao por Teclado -->
        <div class="doc-section" id="section-navegacao-a11y">
            <div class="doc-section-header" onclick="toggleSection('navegacao-a11y')">
                <span class="doc-section-badge" id="badge-navegacao-a11y">0/4</span>
                <h3>Navegacao por Teclado</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Muitos usuarios navegam exclusivamente pelo teclado. Todo elemento interativo deve ser acessivel e visivel ao receber foco.</p>
                <div class="doc-field"><label>Ordem de foco (tab order)</label><div id="comp-navegacao-a11y-tab_order"></div></div>
                <div class="doc-field"><label>Indicador de foco visivel</label><div id="comp-navegacao-a11y-foco"></div></div>
                <div class="doc-field"><label>Skip links</label><div id="comp-navegacao-a11y-skip"></div></div>
                <div class="doc-field"><label>Atalhos de teclado</label><div id="comp-navegacao-a11y-atalhos"></div></div>
            </div>
        </div>

        <!-- 3. Design Visual Acessivel -->
        <div class="doc-section" id="section-visual">
            <div class="doc-section-header" onclick="toggleSection('visual')">
                <span class="doc-section-badge" id="badge-visual">0/4</span>
                <h3>Design Visual Acessivel</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Garantir que o conteudo visual seja perceptivel por todos, incluindo pessoas com baixa visao ou daltonismo.</p>
                <div class="doc-field"><label>Contraste de cores</label><div id="comp-visual-contraste"></div></div>
                <div class="doc-field"><label>Tamanho e espacamento de texto</label><div id="comp-visual-texto"></div></div>
                <div class="doc-field"><label>Nao depender so de cor</label><div id="comp-visual-cor"></div></div>
                <div class="doc-field"><label>Modo escuro e preferencias</label><div id="comp-visual-preferencias"></div></div>
            </div>
        </div>

        <!-- 4. Imagens e Midia -->
        <div class="doc-section" id="section-midia">
            <div class="doc-section-header" onclick="toggleSection('midia')">
                <span class="doc-section-badge" id="badge-midia">0/4</span>
                <h3>Imagens e Midia</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Todo conteudo nao-textual precisa de alternativa acessivel para usuarios que nao podem ve-lo ou ouvi-lo.</p>
                <div class="doc-field"><label>Textos alternativos (alt)</label><div id="comp-midia-alt"></div></div>
                <div class="doc-field"><label>Videos e audio</label><div id="comp-midia-video"></div></div>
                <div class="doc-field"><label>Audio descricao</label><div id="comp-midia-audiodesc"></div></div>
                <div class="doc-field"><label>SVGs e icones</label><div id="comp-midia-svg"></div></div>
            </div>
        </div>

        <!-- 5. Formularios Acessiveis -->
        <div class="doc-section" id="section-formularios-a11y">
            <div class="doc-section-header" onclick="toggleSection('formularios-a11y')">
                <span class="doc-section-badge" id="badge-formularios-a11y">0/4</span>
                <h3>Formularios Acessiveis</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Formularios sao pontos criticos de interacao. Um formulario inacessivel impede conversoes e exclui usuarios.</p>
                <div class="doc-field"><label>Labels e instrucoes</label><div id="comp-formularios-a11y-labels"></div></div>
                <div class="doc-field"><label>Mensagens de erro</label><div id="comp-formularios-a11y-erros"></div></div>
                <div class="doc-field"><label>Campos obrigatorios</label><div id="comp-formularios-a11y-obrigatorios"></div></div>
                <div class="doc-field"><label>Autocomplete e sugestoes</label><div id="comp-formularios-a11y-autocomplete"></div></div>
            </div>
        </div>

        <!-- 6. Conformidade e Testes -->
        <div class="doc-section" id="section-conformidade">
            <div class="doc-section-header" onclick="toggleSection('conformidade')">
                <span class="doc-section-badge" id="badge-conformidade">0/4</span>
                <h3>Conformidade e Testes</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Auditar regularmente e documentar o nivel de conformidade garante que a acessibilidade seja mantida ao longo do tempo.</p>
                <div class="doc-field"><label>Nivel WCAG alvo</label><div id="comp-conformidade-nivel"></div></div>
                <div class="doc-field"><label>Ferramentas de teste</label><div id="comp-conformidade-ferramentas"></div></div>
                <div class="doc-field"><label>Testes com usuarios</label><div id="comp-conformidade-testes_usuarios"></div></div>
                <div class="doc-field"><label>Declaracao de acessibilidade</label><div id="comp-conformidade-declaracao"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziAcessibilidade';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets.acessibilidade) || {};

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
        var exportData = { _induzi: true, modulo: 'Acessibilidade', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-acessibilidade-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-semantica-headings', 'semantica.headings', 'Adicionar regra de headings...');
        g('comp-semantica-landmarks', 'semantica.landmarks', 'Adicionar landmark ou regiao...');
        g('comp-semantica-aria', 'semantica.aria', 'Adicionar atributo ARIA...');
        g('comp-semantica-listas', 'semantica.listas', 'Adicionar regra de listas/tabelas...');

        g('comp-navegacao-a11y-tab_order', 'navegacao-a11y.tab_order', 'Adicionar regra de tab order...');
        g('comp-navegacao-a11y-foco', 'navegacao-a11y.foco', 'Adicionar regra de foco visivel...');
        g('comp-navegacao-a11y-skip', 'navegacao-a11y.skip', 'Adicionar skip link...');
        g('comp-navegacao-a11y-atalhos', 'navegacao-a11y.atalhos', 'Adicionar atalho de teclado...');

        g('comp-visual-contraste', 'visual.contraste', 'Adicionar regra de contraste...');
        g('comp-visual-texto', 'visual.texto', 'Adicionar regra de texto...');
        g('comp-visual-cor', 'visual.cor', 'Adicionar indicador visual...');
        g('comp-visual-preferencias', 'visual.preferencias', 'Adicionar preferencia do usuario...');

        g('comp-midia-alt', 'midia.alt', 'Adicionar regra de texto alternativo...');
        g('comp-midia-video', 'midia.video', 'Adicionar regra de video/audio...');
        g('comp-midia-audiodesc', 'midia.audiodesc', 'Adicionar regra de audio descricao...');
        g('comp-midia-svg', 'midia.svg', 'Adicionar regra de SVG/icone...');

        g('comp-formularios-a11y-labels', 'formularios-a11y.labels', 'Adicionar regra de label...');
        g('comp-formularios-a11y-erros', 'formularios-a11y.erros', 'Adicionar regra de erro...');
        g('comp-formularios-a11y-obrigatorios', 'formularios-a11y.obrigatorios', 'Adicionar regra de campo obrigatorio...');
        g('comp-formularios-a11y-autocomplete', 'formularios-a11y.autocomplete', 'Adicionar regra de autocomplete...');

        g('comp-conformidade-nivel', 'conformidade.nivel', 'Adicionar nivel WCAG alvo...');
        g('comp-conformidade-ferramentas', 'conformidade.ferramentas', 'Adicionar ferramenta de teste...');
        g('comp-conformidade-testes_usuarios', 'conformidade.testes_usuarios', 'Adicionar teste com usuarios...');
        g('comp-conformidade-declaracao', 'conformidade.declaracao', 'Adicionar item da declaracao...');

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
