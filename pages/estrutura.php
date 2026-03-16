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
<title>Estrutura do Site — Induzi</title>
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
            <h1>Estrutura do Site</h1>
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

        <!-- 1. Arquitetura do Site -->
        <div class="doc-section" id="section-arquitetura">
            <div class="doc-section-header" onclick="toggleSection('arquitetura')"><span class="doc-section-badge" id="badge-arquitetura">0/4</span><h3>Arquitetura do Site</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina a estrutura geral do site, organizando paginas, URLs e fluxos de navegacao.</p>
                <div class="doc-field"><label>Mapa do site / paginas</label><div id="comp-arquitetura-mapa_site"></div></div>
                <div class="doc-field"><label>Hierarquia de paginas</label><div id="comp-arquitetura-hierarquia"></div></div>
                <div class="doc-field"><label>Padroes de URLs</label><div id="comp-arquitetura-urls"></div></div>
                <div class="doc-field"><label>Fluxo de navegacao</label><div id="comp-arquitetura-navegacao"></div></div>
            </div>
        </div>

        <!-- 2. Header e Navegacao -->
        <div class="doc-section" id="section-header">
            <div class="doc-section-header" onclick="toggleSection('header')"><span class="doc-section-badge" id="badge-header">0/4</span><h3>Header e Navegacao</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje os elementos do cabecalho e como o usuario navega pelo site em diferentes dispositivos.</p>
                <div class="doc-field"><label>Elementos do header</label><div id="comp-header-elementos"></div></div>
                <div class="doc-field"><label>Itens do menu principal</label><div id="comp-header-menu_itens"></div></div>
                <div class="doc-field"><label>Navegacao mobile</label><div id="comp-header-menu_mobile"></div></div>
                <div class="doc-field"><label>Breadcrumbs</label><div id="comp-header-breadcrumbs"></div></div>
            </div>
        </div>

        <!-- 3. Hero e Banners -->
        <div class="doc-section" id="section-hero">
            <div class="doc-section-header" onclick="toggleSection('hero')"><span class="doc-section-badge" id="badge-hero">0/4</span><h3>Hero e Banners</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina o conteudo da secao hero e banners que aparecem nas principais paginas do site.</p>
                <div class="doc-field"><label>Elementos do hero principal</label><div id="comp-hero-conteudo"></div></div>
                <div class="doc-field"><label>CTAs do hero</label><div id="comp-hero-cta_hero"></div></div>
                <div class="doc-field"><label>Banners secundarios</label><div id="comp-hero-banners"></div></div>
                <div class="doc-field"><label>Variantes por pagina</label><div id="comp-hero-variantes"></div></div>
            </div>
        </div>

        <!-- 4. Paginas Essenciais -->
        <div class="doc-section" id="section-paginas">
            <div class="doc-section-header" onclick="toggleSection('paginas')"><span class="doc-section-badge" id="badge-paginas">0/5</span><h3>Paginas Essenciais</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje o conteudo e a estrutura das paginas fundamentais do site.</p>
                <div class="doc-field"><label>Secoes da Home</label><div id="comp-paginas-home"></div></div>
                <div class="doc-field"><label>Sobre / Institucional</label><div id="comp-paginas-sobre"></div></div>
                <div class="doc-field"><label>Contato</label><div id="comp-paginas-contato"></div></div>
                <div class="doc-field"><label>Servicos / Produtos</label><div id="comp-paginas-servicos"></div></div>
                <div class="doc-field"><label>Blog / Conteudo</label><div id="comp-paginas-blog"></div></div>
            </div>
        </div>

        <!-- 5. Paleta de Cores -->
        <div class="doc-section" id="section-cores">
            <div class="doc-section-header" onclick="toggleSection('cores')"><span class="doc-section-badge" id="badge-cores">0/4</span><h3>Paleta de Cores</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina as cores do projeto e onde cada uma sera aplicada no design do site.</p>
                <div class="doc-field"><label>Cores primarias</label><div id="comp-cores-primaria"></div></div>
                <div class="doc-field"><label>Cores secundarias</label><div id="comp-cores-secundaria"></div></div>
                <div class="doc-field"><label>Cor de destaque/CTA</label><div id="comp-cores-destaque"></div></div>
                <div class="doc-field"><label>Aplicacao das cores</label><div id="comp-cores-paleta"></div></div>
            </div>
        </div>

        <!-- 6. Tipografia -->
        <div class="doc-section" id="section-tipografia">
            <div class="doc-section-header" onclick="toggleSection('tipografia')"><span class="doc-section-badge" id="badge-tipografia">0/4</span><h3>Tipografia</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Escolha as fontes e defina a escala tipografica para manter consistencia visual em todo o site.</p>
                <div class="doc-field"><label>Fontes dos titulos</label><div id="comp-tipografia-titulos"></div></div>
                <div class="doc-field"><label>Fontes do corpo</label><div id="comp-tipografia-corpo"></div></div>
                <div class="doc-field"><label>Escala de tamanhos</label><div id="comp-tipografia-escala"></div></div>
                <div class="doc-field"><label>Hierarquia visual</label><div id="comp-tipografia-hierarquia_visual"></div></div>
            </div>
        </div>

        <!-- 7. Componentes UI -->
        <div class="doc-section" id="section-componentes">
            <div class="doc-section-header" onclick="toggleSection('componentes')"><span class="doc-section-badge" id="badge-componentes">0/5</span><h3>Componentes UI</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente os componentes reutilizaveis da interface: botoes, cards, formularios e outros elementos visuais.</p>
                <div class="doc-field"><label>Botoes</label><div id="comp-componentes-botoes"></div></div>
                <div class="doc-field"><label>Cards</label><div id="comp-componentes-cards"></div></div>
                <div class="doc-field"><label>Formularios</label><div id="comp-componentes-formularios"></div></div>
                <div class="doc-field"><label>Modais e popups</label><div id="comp-componentes-modais"></div></div>
                <div class="doc-field"><label>Alertas e notificacoes</label><div id="comp-componentes-alertas"></div></div>
            </div>
        </div>

        <!-- 8. Layout e Grid -->
        <div class="doc-section" id="section-layout">
            <div class="doc-section-header" onclick="toggleSection('layout')"><span class="doc-section-badge" id="badge-layout">0/4</span><h3>Layout e Grid</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina o sistema de grid, breakpoints responsivos e espacamento padrao do layout.</p>
                <div class="doc-field"><label>Sistema de grid</label><div id="comp-layout-grid"></div></div>
                <div class="doc-field"><label>Breakpoints responsivos</label><div id="comp-layout-breakpoints"></div></div>
                <div class="doc-field"><label>Sistema de espacamento</label><div id="comp-layout-espacamento"></div></div>
                <div class="doc-field"><label>Containers e secoes</label><div id="comp-layout-containers"></div></div>
            </div>
        </div>

        <!-- 9. Performance -->
        <div class="doc-section" id="section-performance">
            <div class="doc-section-header" onclick="toggleSection('performance')"><span class="doc-section-badge" id="badge-performance">0/4</span><h3>Performance</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Estabeleca metas de desempenho e estrategias de otimizacao para garantir um site rapido.</p>
                <div class="doc-field"><label>Metas de performance</label><div id="comp-performance-metas"></div></div>
                <div class="doc-field"><label>Otimizacao de imagens</label><div id="comp-performance-imagens"></div></div>
                <div class="doc-field"><label>Estrategia de carregamento</label><div id="comp-performance-carregamento"></div></div>
                <div class="doc-field"><label>Cache e CDN</label><div id="comp-performance-cache"></div></div>
            </div>
        </div>

        <!-- 10. Acessibilidade -->
        <div class="doc-section" id="section-acessibilidade">
            <div class="doc-section-header" onclick="toggleSection('acessibilidade')"><span class="doc-section-badge" id="badge-acessibilidade">0/4</span><h3>Acessibilidade</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Garanta que o site seja acessivel para todos os usuarios, seguindo as diretrizes WCAG.</p>
                <div class="doc-field"><label>Nivel de conformidade</label><div id="comp-acessibilidade-nivel"></div></div>
                <div class="doc-field"><label>Padroes de alt text</label><div id="comp-acessibilidade-alt_texts"></div></div>
                <div class="doc-field"><label>Contraste e legibilidade</label><div id="comp-acessibilidade-contraste"></div></div>
                <div class="doc-field"><label>Navegacao por teclado e ARIA</label><div id="comp-acessibilidade-teclado"></div></div>
            </div>
        </div>

    </div>
</div>
<script src="../js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script>
(function() {
    var DATA_KEY = 'induziEstrutura';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['estrutura']) || {};

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
        var exportData = { _induzi: true, modulo: 'Estrutura', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob); var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-estrutura-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        _components['arquitetura.mapa_site'] = InduziComponents.guided(document.getElementById('comp-arquitetura-mapa_site'), Object.assign({ onChange: onChange, placeholder: 'Adicionar pagina...' }, presets['arquitetura.mapa_site'] || {}));
        _components['arquitetura.hierarquia'] = InduziComponents.guided(document.getElementById('comp-arquitetura-hierarquia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar nivel...' }, presets['arquitetura.hierarquia'] || {}));
        _components['arquitetura.urls'] = InduziComponents.guided(document.getElementById('comp-arquitetura-urls'), Object.assign({ onChange: onChange, placeholder: 'Adicionar padrao de URL...' }, presets['arquitetura.urls'] || {}));
        _components['arquitetura.navegacao'] = InduziComponents.guided(document.getElementById('comp-arquitetura-navegacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar fluxo...' }, presets['arquitetura.navegacao'] || {}));

        _components['header.elementos'] = InduziComponents.guided(document.getElementById('comp-header-elementos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento... (Enter)' }, presets['header.elementos'] || {}));
        _components['header.menu_itens'] = InduziComponents.guided(document.getElementById('comp-header-menu_itens'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item do menu...' }, presets['header.menu_itens'] || {}));
        _components['header.menu_mobile'] = InduziComponents.multiSelect(document.getElementById('comp-header-menu_mobile'), {
            options: [{ value: 'Hamburguer', label: 'Hamburguer' }, { value: 'Bottom Tab', label: 'Bottom Tab' }, { value: 'Drawer', label: 'Drawer' }, { value: 'Sidebar', label: 'Sidebar' }, { value: 'Off-canvas', label: 'Off-canvas' }], onChange: onChange
        });
        _components['header.breadcrumbs'] = InduziComponents.guided(document.getElementById('comp-header-breadcrumbs'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de breadcrumb...' }, presets['header.breadcrumbs'] || {}));

        _components['hero.conteudo'] = InduziComponents.guided(document.getElementById('comp-hero-conteudo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento do hero...' }, presets['hero.conteudo'] || {}));
        _components['hero.cta_hero'] = InduziComponents.guided(document.getElementById('comp-hero-cta_hero'), Object.assign({ onChange: onChange, placeholder: 'Adicionar CTA... (Enter)' }, presets['hero.cta_hero'] || {}));
        _components['hero.banners'] = InduziComponents.guided(document.getElementById('comp-hero-banners'), Object.assign({ onChange: onChange, placeholder: 'Adicionar banner...' }, presets['hero.banners'] || {}));
        _components['hero.variantes'] = InduziComponents.keyValue(document.getElementById('comp-hero-variantes'), { keyLabel: 'Pagina', valueLabel: 'Variante do hero', onChange: onChange });

        _components['paginas.home'] = InduziComponents.guided(document.getElementById('comp-paginas-home'), Object.assign({ onChange: onChange, placeholder: 'Adicionar secao...' }, presets['paginas.home'] || {}));
        _components['paginas.sobre'] = InduziComponents.guided(document.getElementById('comp-paginas-sobre'), Object.assign({ onChange: onChange, placeholder: 'Adicionar secao...' }, presets['paginas.sobre'] || {}));
        _components['paginas.contato'] = InduziComponents.guided(document.getElementById('comp-paginas-contato'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento...' }, presets['paginas.contato'] || {}));
        _components['paginas.servicos'] = InduziComponents.guided(document.getElementById('comp-paginas-servicos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar secao...' }, presets['paginas.servicos'] || {}));
        _components['paginas.blog'] = InduziComponents.guided(document.getElementById('comp-paginas-blog'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento do blog...' }, presets['paginas.blog'] || {}));

        _components['cores.primaria'] = InduziComponents.guided(document.getElementById('comp-cores-primaria'), Object.assign({ onChange: onChange, placeholder: 'Adicionar cor... (Enter)' }, presets['cores.primaria'] || {}));
        _components['cores.secundaria'] = InduziComponents.guided(document.getElementById('comp-cores-secundaria'), Object.assign({ onChange: onChange, placeholder: 'Adicionar cor... (Enter)' }, presets['cores.secundaria'] || {}));
        _components['cores.destaque'] = InduziComponents.guided(document.getElementById('comp-cores-destaque'), Object.assign({ onChange: onChange, placeholder: 'Adicionar cor... (Enter)' }, presets['cores.destaque'] || {}));
        _components['cores.paleta'] = InduziComponents.keyValue(document.getElementById('comp-cores-paleta'), { keyLabel: 'Cor', valueLabel: 'Aplicacao', onChange: onChange });

        _components['tipografia.titulos'] = InduziComponents.guided(document.getElementById('comp-tipografia-titulos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar fonte... (Enter)' }, presets['tipografia.titulos'] || {}));
        _components['tipografia.corpo'] = InduziComponents.guided(document.getElementById('comp-tipografia-corpo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar fonte... (Enter)' }, presets['tipografia.corpo'] || {}));
        _components['tipografia.escala'] = InduziComponents.keyValue(document.getElementById('comp-tipografia-escala'), { keyLabel: 'Elemento', valueLabel: 'Tamanho', onChange: onChange });
        _components['tipografia.hierarquia_visual'] = InduziComponents.guided(document.getElementById('comp-tipografia-hierarquia_visual'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra visual...' }, presets['tipografia.hierarquia_visual'] || {}));

        _components['componentes.botoes'] = InduziComponents.guided(document.getElementById('comp-componentes-botoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tipo de botao... (Enter)' }, presets['componentes.botoes'] || {}));
        _components['componentes.cards'] = InduziComponents.guided(document.getElementById('comp-componentes-cards'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tipo de card... (Enter)' }, presets['componentes.cards'] || {}));
        _components['componentes.formularios'] = InduziComponents.guided(document.getElementById('comp-componentes-formularios'), Object.assign({ onChange: onChange, placeholder: 'Adicionar spec de formulario...' }, presets['componentes.formularios'] || {}));
        _components['componentes.modais'] = InduziComponents.guided(document.getElementById('comp-componentes-modais'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tipo de modal... (Enter)' }, presets['componentes.modais'] || {}));
        _components['componentes.alertas'] = InduziComponents.guided(document.getElementById('comp-componentes-alertas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tipo de alerta... (Enter)' }, presets['componentes.alertas'] || {}));

        _components['layout.grid'] = InduziComponents.guided(document.getElementById('comp-layout-grid'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de grid...' }, presets['layout.grid'] || {}));
        _components['layout.breakpoints'] = InduziComponents.keyValue(document.getElementById('comp-layout-breakpoints'), { keyLabel: 'Breakpoint', valueLabel: 'Valor', onChange: onChange });
        _components['layout.espacamento'] = InduziComponents.keyValue(document.getElementById('comp-layout-espacamento'), { keyLabel: 'Nivel', valueLabel: 'Valor', onChange: onChange });
        _components['layout.containers'] = InduziComponents.guided(document.getElementById('comp-layout-containers'), Object.assign({ onChange: onChange, placeholder: 'Adicionar spec de container...' }, presets['layout.containers'] || {}));

        _components['performance.metas'] = InduziComponents.keyValue(document.getElementById('comp-performance-metas'), { keyLabel: 'Metrica', valueLabel: 'Meta', onChange: onChange });
        _components['performance.imagens'] = InduziComponents.guided(document.getElementById('comp-performance-imagens'), Object.assign({ onChange: onChange, placeholder: 'Adicionar spec de imagem...' }, presets['performance.imagens'] || {}));
        _components['performance.carregamento'] = InduziComponents.guided(document.getElementById('comp-performance-carregamento'), Object.assign({ onChange: onChange, placeholder: 'Adicionar otimizacao...' }, presets['performance.carregamento'] || {}));
        _components['performance.cache'] = InduziComponents.guided(document.getElementById('comp-performance-cache'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de cache...' }, presets['performance.cache'] || {}));

        _components['acessibilidade.nivel'] = InduziComponents.multiSelect(document.getElementById('comp-acessibilidade-nivel'), {
            options: [{ value: 'WCAG A', label: 'WCAG A' }, { value: 'WCAG AA', label: 'WCAG AA' }, { value: 'WCAG AAA', label: 'WCAG AAA' }, { value: 'Section 508', label: 'Section 508' }], onChange: onChange
        });
        _components['acessibilidade.alt_texts'] = InduziComponents.guided(document.getElementById('comp-acessibilidade-alt_texts'), Object.assign({ onChange: onChange, placeholder: 'Adicionar padrao de alt...' }, presets['acessibilidade.alt_texts'] || {}));
        _components['acessibilidade.contraste'] = InduziComponents.guided(document.getElementById('comp-acessibilidade-contraste'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de contraste...' }, presets['acessibilidade.contraste'] || {}));
        _components['acessibilidade.teclado'] = InduziComponents.guided(document.getElementById('comp-acessibilidade-teclado'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['acessibilidade.teclado'] || {}));

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
