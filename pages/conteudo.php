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
<title>Conteudo — Induzi</title>
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
            <h1>Conteudo</h1>
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

        <!-- 1. Estrategia de Conteudo -->
        <div class="doc-section" id="section-estrategia">
            <div class="doc-section-header" onclick="toggleSection('estrategia')">
                <span class="doc-section-badge" id="badge-estrategia">0/4</span>
                <h3>Estrategia de Conteudo</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Uma estrategia bem definida transforma conteudo em ativo de negocio. Sem planejamento, conteudo vira ruido.</p>
                <div class="doc-field"><label>Objetivos do conteudo</label><div id="comp-estrategia-objetivos"></div></div>
                <div class="doc-field"><label>Pillar pages</label><div id="comp-estrategia-pillar"></div></div>
                <div class="doc-field"><label>Topic clusters</label><div id="comp-estrategia-clusters"></div></div>
                <div class="doc-field"><label>Publico-alvo do conteudo</label><div id="comp-estrategia-publico"></div></div>
            </div>
        </div>

        <!-- 2. Calendario Editorial -->
        <div class="doc-section" id="section-calendario">
            <div class="doc-section-header" onclick="toggleSection('calendario')">
                <span class="doc-section-badge" id="badge-calendario">0/4</span>
                <h3>Calendario Editorial</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Consistencia e mais importante que volume. Um calendario editorial organiza a producao e garante regularidade.</p>
                <div class="doc-field"><label>Frequencia de publicacao</label><div id="comp-calendario-frequencia"></div></div>
                <div class="doc-field"><label>Temas e pautas</label><div id="comp-calendario-pautas"></div></div>
                <div class="doc-field"><label>Fluxo de producao</label><div id="comp-calendario-fluxo"></div></div>
                <div class="doc-field"><label>Ferramentas de gestao</label><div id="comp-calendario-ferramentas"></div></div>
            </div>
        </div>

        <!-- 3. Diretrizes de Redacao -->
        <div class="doc-section" id="section-redacao">
            <div class="doc-section-header" onclick="toggleSection('redacao')">
                <span class="doc-section-badge" id="badge-redacao">0/4</span>
                <h3>Diretrizes de Redacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Padronizar a escrita garante consistencia de marca e qualidade em todos os conteudos publicados.</p>
                <div class="doc-field"><label>Tom de voz</label><div id="comp-redacao-tom"></div></div>
                <div class="doc-field"><label>Estrutura do artigo</label><div id="comp-redacao-estrutura"></div></div>
                <div class="doc-field"><label>SEO no conteudo</label><div id="comp-redacao-seo"></div></div>
                <div class="doc-field"><label>Checklist de revisao</label><div id="comp-redacao-checklist"></div></div>
            </div>
        </div>

        <!-- 4. Formatos de Conteudo -->
        <div class="doc-section" id="section-formatos">
            <div class="doc-section-header" onclick="toggleSection('formatos')">
                <span class="doc-section-badge" id="badge-formatos">0/4</span>
                <h3>Formatos de Conteudo</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Diversificar formatos amplia o alcance e atende diferentes preferencias de consumo de conteudo.</p>
                <div class="doc-field"><label>Blog posts</label><div id="comp-formatos-blog"></div></div>
                <div class="doc-field"><label>Video</label><div id="comp-formatos-video"></div></div>
                <div class="doc-field"><label>Materiais ricos</label><div id="comp-formatos-ricos"></div></div>
                <div class="doc-field"><label>Podcast e audio</label><div id="comp-formatos-podcast"></div></div>
            </div>
        </div>

        <!-- 5. Distribuicao e Promocao -->
        <div class="doc-section" id="section-distribuicao">
            <div class="doc-section-header" onclick="toggleSection('distribuicao')">
                <span class="doc-section-badge" id="badge-distribuicao">0/4</span>
                <h3>Distribuicao e Promocao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Criar conteudo excelente e so metade do trabalho. A outra metade e garantir que ele chegue ao publico certo.</p>
                <div class="doc-field"><label>Canais de distribuicao</label><div id="comp-distribuicao-canais"></div></div>
                <div class="doc-field"><label>Reaproveitamento</label><div id="comp-distribuicao-reaproveitamento"></div></div>
                <div class="doc-field"><label>Email e newsletter</label><div id="comp-distribuicao-email"></div></div>
                <div class="doc-field"><label>Link building</label><div id="comp-distribuicao-linkbuilding"></div></div>
            </div>
        </div>

        <!-- 6. Metricas de Conteudo -->
        <div class="doc-section" id="section-metricas-conteudo">
            <div class="doc-section-header" onclick="toggleSection('metricas-conteudo')">
                <span class="doc-section-badge" id="badge-metricas-conteudo">0/4</span>
                <h3>Metricas de Conteudo</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Medir o desempenho de cada conteudo permite otimizar a estrategia e investir no que da resultado.</p>
                <div class="doc-field"><label>Metricas de trafego</label><div id="comp-metricas-conteudo-trafego"></div></div>
                <div class="doc-field"><label>Metricas de engajamento</label><div id="comp-metricas-conteudo-engajamento"></div></div>
                <div class="doc-field"><label>Metricas de conversao</label><div id="comp-metricas-conteudo-conversao"></div></div>
                <div class="doc-field"><label>Rotina de analise</label><div id="comp-metricas-conteudo-rotina"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziConteudo';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets.conteudo) || {};

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
        var exportData = { _induzi: true, modulo: 'Conteudo', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-conteudo-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-estrategia-objetivos', 'estrategia.objetivos', 'Adicionar objetivo de conteudo...');
        g('comp-estrategia-pillar', 'estrategia.pillar', 'Adicionar pillar page...');
        g('comp-estrategia-clusters', 'estrategia.clusters', 'Adicionar topic cluster...');
        g('comp-estrategia-publico', 'estrategia.publico', 'Adicionar perfil de publico...');

        g('comp-calendario-frequencia', 'calendario.frequencia', 'Adicionar frequencia de publicacao...');
        g('comp-calendario-pautas', 'calendario.pautas', 'Adicionar pauta ou tema...');
        g('comp-calendario-fluxo', 'calendario.fluxo', 'Adicionar etapa do fluxo...');
        g('comp-calendario-ferramentas', 'calendario.ferramentas', 'Adicionar ferramenta de gestao...');

        g('comp-redacao-tom', 'redacao.tom', 'Adicionar diretriz de tom de voz...');
        g('comp-redacao-estrutura', 'redacao.estrutura', 'Adicionar padrao de estrutura...');
        g('comp-redacao-seo', 'redacao.seo', 'Adicionar regra de SEO...');
        g('comp-redacao-checklist', 'redacao.checklist', 'Adicionar item de checklist...');

        g('comp-formatos-blog', 'formatos.blog', 'Adicionar tipo de blog post...');
        g('comp-formatos-video', 'formatos.video', 'Adicionar formato de video...');
        g('comp-formatos-ricos', 'formatos.ricos', 'Adicionar material rico...');
        g('comp-formatos-podcast', 'formatos.podcast', 'Adicionar formato de podcast...');

        g('comp-distribuicao-canais', 'distribuicao.canais', 'Adicionar canal de distribuicao...');
        g('comp-distribuicao-reaproveitamento', 'distribuicao.reaproveitamento', 'Adicionar formato de reuso...');
        g('comp-distribuicao-email', 'distribuicao.email', 'Adicionar config de newsletter...');
        g('comp-distribuicao-linkbuilding', 'distribuicao.linkbuilding', 'Adicionar estrategia de link...');

        g('comp-metricas-conteudo-trafego', 'metricas-conteudo.trafego', 'Adicionar metrica de trafego...');
        g('comp-metricas-conteudo-engajamento', 'metricas-conteudo.engajamento', 'Adicionar metrica de engajamento...');
        g('comp-metricas-conteudo-conversao', 'metricas-conteudo.conversao', 'Adicionar metrica de conversao...');
        g('comp-metricas-conteudo-rotina', 'metricas-conteudo.rotina', 'Adicionar rotina de analise...');

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
