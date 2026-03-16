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
<title>Branding — Induzi</title>
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
            <h1>Branding</h1>
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

        <!-- 1. Essencia da Marca -->
        <div class="doc-section" id="section-essencia">
            <div class="doc-section-header" onclick="toggleSection('essencia')">
                <span class="doc-section-badge" id="badge-essencia">0/5</span>
                <h3>Essencia da Marca</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina o nucleo da marca: por que ela existe, para onde vai e no que acredita.</p>
                <div class="doc-field"><label>Missao</label><div id="comp-essencia-missao"></div></div>
                <div class="doc-field"><label>Visao</label><div id="comp-essencia-visao"></div></div>
                <div class="doc-field"><label>Valores</label><div id="comp-essencia-valores"></div></div>
                <div class="doc-field"><label>Proposito</label><div id="comp-essencia-proposito"></div></div>
                <div class="doc-field"><label>Manifesto da marca</label><div id="comp-essencia-manifesto"></div></div>
            </div>
        </div>

        <!-- 2. Personalidade da Marca -->
        <div class="doc-section" id="section-personalidade">
            <div class="doc-section-header" onclick="toggleSection('personalidade')">
                <span class="doc-section-badge" id="badge-personalidade">0/4</span>
                <h3>Personalidade da Marca</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Se a marca fosse uma pessoa, como ela seria? Defina os tracos de personalidade que guiam toda a comunicacao.</p>
                <div class="doc-field"><label>Arquetipos de marca</label><div id="comp-personalidade-arquetipos"></div></div>
                <div class="doc-field"><label>Adjetivos da marca</label><div id="comp-personalidade-adjetivos"></div></div>
                <div class="doc-field"><label>Tom emocional</label><div id="comp-personalidade-tom_emocional"></div></div>
                <div class="doc-field"><label>Pilares de comunicacao</label><div id="comp-personalidade-pilares"></div></div>
            </div>
        </div>

        <!-- 3. Naming e Tagline -->
        <div class="doc-section" id="section-naming">
            <div class="doc-section-header" onclick="toggleSection('naming')">
                <span class="doc-section-badge" id="badge-naming">0/4</span>
                <h3>Naming e Tagline</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente o nome da marca, seu significado e o slogan que a acompanha.</p>
                <div class="doc-field"><label>Nome da marca</label><div id="comp-naming-nome"></div></div>
                <div class="doc-field"><label>Tagline / Slogan</label><div id="comp-naming-tagline"></div></div>
                <div class="doc-field"><label>Significado e origem do nome</label><div id="comp-naming-significado"></div></div>
                <div class="doc-field"><label>Variantes do nome</label><div id="comp-naming-variantes"></div></div>
            </div>
        </div>

        <!-- 4. Logo -->
        <div class="doc-section" id="section-logo">
            <div class="doc-section-header" onclick="toggleSection('logo')">
                <span class="doc-section-badge" id="badge-logo">0/4</span>
                <h3>Logo</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Especifique as regras de uso do logotipo para garantir consistencia em todas as aplicacoes.</p>
                <div class="doc-field"><label>Descricao do logo</label><div id="comp-logo-descricao"></div></div>
                <div class="doc-field"><label>Variantes do logo</label><div id="comp-logo-variantes"></div></div>
                <div class="doc-field"><label>Area de protecao e tamanho minimo</label><div id="comp-logo-area_protecao"></div></div>
                <div class="doc-field"><label>Usos incorretos</label><div id="comp-logo-usos_incorretos"></div></div>
            </div>
        </div>

        <!-- 5. Paleta de Cores -->
        <div class="doc-section" id="section-cores">
            <div class="doc-section-header" onclick="toggleSection('cores')">
                <span class="doc-section-badge" id="badge-cores">0/4</span>
                <h3>Paleta de Cores</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina as cores oficiais da marca com seus codigos e regras de aplicacao.</p>
                <div class="doc-field"><label>Cores primarias</label><div id="comp-cores-primarias"></div></div>
                <div class="doc-field"><label>Cores secundarias</label><div id="comp-cores-secundarias"></div></div>
                <div class="doc-field"><label>Cores neutras</label><div id="comp-cores-neutras"></div></div>
                <div class="doc-field"><label>Regras de aplicacao</label><div id="comp-cores-aplicacao"></div></div>
            </div>
        </div>

        <!-- 6. Tipografia -->
        <div class="doc-section" id="section-tipografia">
            <div class="doc-section-header" onclick="toggleSection('tipografia')">
                <span class="doc-section-badge" id="badge-tipografia">0/4</span>
                <h3>Tipografia</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Especifique as fontes oficiais e como elas sao usadas nos diferentes contextos da marca.</p>
                <div class="doc-field"><label>Fonte principal (titulos)</label><div id="comp-tipografia-principal"></div></div>
                <div class="doc-field"><label>Fonte secundaria (corpo)</label><div id="comp-tipografia-secundaria"></div></div>
                <div class="doc-field"><label>Hierarquia tipografica</label><div id="comp-tipografia-hierarquia"></div></div>
                <div class="doc-field"><label>Regras de uso</label><div id="comp-tipografia-regras"></div></div>
            </div>
        </div>

        <!-- 7. Elementos Visuais -->
        <div class="doc-section" id="section-visuais">
            <div class="doc-section-header" onclick="toggleSection('visuais')">
                <span class="doc-section-badge" id="badge-visuais">0/4</span>
                <h3>Elementos Visuais</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina os elementos graficos complementares que compoem a linguagem visual da marca.</p>
                <div class="doc-field"><label>Estilo de iconografia</label><div id="comp-visuais-icones"></div></div>
                <div class="doc-field"><label>Ilustracoes e grafismos</label><div id="comp-visuais-ilustracoes"></div></div>
                <div class="doc-field"><label>Direcao de fotografia</label><div id="comp-visuais-fotografia"></div></div>
                <div class="doc-field"><label>Grafismos e patterns</label><div id="comp-visuais-patterns"></div></div>
            </div>
        </div>

        <!-- 8. Aplicacoes da Marca -->
        <div class="doc-section" id="section-aplicacoes">
            <div class="doc-section-header" onclick="toggleSection('aplicacoes')">
                <span class="doc-section-badge" id="badge-aplicacoes">0/4</span>
                <h3>Aplicacoes da Marca</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente como a marca se materializa em pecas fisicas e materiais impressos.</p>
                <div class="doc-field"><label>Cartao de visita</label><div id="comp-aplicacoes-cartao"></div></div>
                <div class="doc-field"><label>Papelaria e documentos</label><div id="comp-aplicacoes-papelaria"></div></div>
                <div class="doc-field"><label>Embalagens</label><div id="comp-aplicacoes-embalagens"></div></div>
                <div class="doc-field"><label>Uniformes e sinalizacao</label><div id="comp-aplicacoes-uniformes"></div></div>
            </div>
        </div>

        <!-- 9. Presenca Digital -->
        <div class="doc-section" id="section-digital">
            <div class="doc-section-header" onclick="toggleSection('digital')">
                <span class="doc-section-badge" id="badge-digital">0/4</span>
                <h3>Presenca Digital</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Como a marca se apresenta nos canais digitais, garantindo consistencia online.</p>
                <div class="doc-field"><label>Redes sociais</label><div id="comp-digital-redes"></div></div>
                <div class="doc-field"><label>Site e landing pages</label><div id="comp-digital-site"></div></div>
                <div class="doc-field"><label>Email marketing</label><div id="comp-digital-email"></div></div>
                <div class="doc-field"><label>Templates e assets</label><div id="comp-digital-templates"></div></div>
            </div>
        </div>

        <!-- 10. Manual e Governanca -->
        <div class="doc-section" id="section-manual">
            <div class="doc-section-header" onclick="toggleSection('manual')">
                <span class="doc-section-badge" id="badge-manual">0/4</span>
                <h3>Manual e Governanca</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Regras gerais de uso da marca e processo de atualizacao do brandbook.</p>
                <div class="doc-field"><label>O que FAZER (do's)</label><div id="comp-manual-dos"></div></div>
                <div class="doc-field"><label>O que NAO fazer (don'ts)</label><div id="comp-manual-donts"></div></div>
                <div class="doc-field"><label>Exemplos de aplicacao correta</label><div id="comp-manual-exemplos"></div></div>
                <div class="doc-field"><label>Processo de atualizacao</label><div id="comp-manual-atualizacao"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziBranding';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets.branding) || {};

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
        var exportData = { _induzi: true, modulo: 'Branding', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-branding-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-essencia-missao', 'essencia.missao', 'Adicionar missao da empresa...');
        g('comp-essencia-visao', 'essencia.visao', 'Adicionar visao de futuro...');
        g('comp-essencia-valores', 'essencia.valores', 'Adicionar valor da marca...');
        g('comp-essencia-proposito', 'essencia.proposito', 'Adicionar proposito da marca...');
        g('comp-essencia-manifesto', 'essencia.manifesto', 'Adicionar manifesto da marca...');

        g('comp-personalidade-arquetipos', 'personalidade.arquetipos', 'Adicionar arquetipo de marca...');
        g('comp-personalidade-adjetivos', 'personalidade.adjetivos', 'Adicionar adjetivo da marca...');
        g('comp-personalidade-tom_emocional', 'personalidade.tom_emocional', 'Adicionar tom emocional...');
        g('comp-personalidade-pilares', 'personalidade.pilares', 'Adicionar pilar de comunicacao...');

        g('comp-naming-nome', 'naming.nome', 'Adicionar nome da marca...');
        g('comp-naming-tagline', 'naming.tagline', 'Adicionar tagline ou slogan...');
        g('comp-naming-significado', 'naming.significado', 'Adicionar significado do nome...');
        g('comp-naming-variantes', 'naming.variantes', 'Adicionar variante do nome...');

        g('comp-logo-descricao', 'logo.descricao', 'Adicionar descricao do logo...');
        g('comp-logo-variantes', 'logo.variantes', 'Adicionar variante do logo...');
        g('comp-logo-area_protecao', 'logo.area_protecao', 'Adicionar regra de area de protecao...');
        g('comp-logo-usos_incorretos', 'logo.usos_incorretos', 'Adicionar uso incorreto...');

        g('comp-cores-primarias', 'cores.primarias', 'Adicionar cor primaria...');
        g('comp-cores-secundarias', 'cores.secundarias', 'Adicionar cor secundaria...');
        g('comp-cores-neutras', 'cores.neutras', 'Adicionar cor neutra...');
        g('comp-cores-aplicacao', 'cores.aplicacao', 'Adicionar regra de aplicacao...');

        g('comp-tipografia-principal', 'tipografia.principal', 'Adicionar fonte principal...');
        g('comp-tipografia-secundaria', 'tipografia.secundaria', 'Adicionar fonte secundaria...');
        g('comp-tipografia-hierarquia', 'tipografia.hierarquia', 'Adicionar nivel tipografico...');
        g('comp-tipografia-regras', 'tipografia.regras', 'Adicionar regra de uso...');

        g('comp-visuais-icones', 'visuais.icones', 'Adicionar estilo de icone...');
        g('comp-visuais-ilustracoes', 'visuais.ilustracoes', 'Adicionar estilo de ilustracao...');
        g('comp-visuais-fotografia', 'visuais.fotografia', 'Adicionar diretriz de fotografia...');
        g('comp-visuais-patterns', 'visuais.patterns', 'Adicionar grafismo ou pattern...');

        g('comp-aplicacoes-cartao', 'aplicacoes.cartao', 'Adicionar spec do cartao de visita...');
        g('comp-aplicacoes-papelaria', 'aplicacoes.papelaria', 'Adicionar item de papelaria...');
        g('comp-aplicacoes-embalagens', 'aplicacoes.embalagens', 'Adicionar spec de embalagem...');
        g('comp-aplicacoes-uniformes', 'aplicacoes.uniformes', 'Adicionar item de sinalizacao...');

        g('comp-digital-redes', 'digital.redes', 'Adicionar diretriz de redes sociais...');
        g('comp-digital-site', 'digital.site', 'Adicionar diretriz do site...');
        g('comp-digital-email', 'digital.email', 'Adicionar template de email...');
        g('comp-digital-templates', 'digital.templates', 'Adicionar template ou asset...');

        g('comp-manual-dos', 'manual.dos', 'Adicionar boa pratica...');
        g('comp-manual-donts', 'manual.donts', 'Adicionar pratica proibida...');
        g('comp-manual-exemplos', 'manual.exemplos', 'Adicionar exemplo de aplicacao...');
        g('comp-manual-atualizacao', 'manual.atualizacao', 'Adicionar processo de atualizacao...');

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
