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
<title>Shopee — Induzi</title>
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
            <h1>Shopee</h1>
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

        <!-- 1. Configuracao da Loja -->
        <div class="doc-section" id="section-loja">
            <div class="doc-section-header" onclick="toggleSection('loja')"><span class="doc-section-badge" id="badge-loja">0/5</span><h3>Configuracao da Loja</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Configure os dados essenciais da sua loja na Shopee: nome, descricao, identidade visual e politicas.</p>
                <div class="doc-field"><label>Nome da loja</label><div id="comp-loja-nome"></div></div>
                <div class="doc-field"><label>Descricao da loja</label><div id="comp-loja-descricao"></div></div>
                <div class="doc-field"><label>Imagens da loja (logo, banner)</label><div id="comp-loja-logo"></div></div>
                <div class="doc-field"><label>Politicas da loja</label><div id="comp-loja-politicas"></div></div>
                <div class="doc-field"><label>Categorias da loja</label><div id="comp-loja-categorias"></div></div>
            </div>
        </div>

        <!-- 2. Cadastro de Produtos -->
        <div class="doc-section" id="section-produtos">
            <div class="doc-section-header" onclick="toggleSection('produtos')"><span class="doc-section-badge" id="badge-produtos">0/4</span><h3>Cadastro de Produtos</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina os templates e padroes para cadastrar produtos de forma consistente e otimizada.</p>
                <div class="doc-field"><label>Elementos do titulo</label><div id="comp-produtos-template_titulo"></div></div>
                <div class="doc-field"><label>Secoes da descricao</label><div id="comp-produtos-template_descricao"></div></div>
                <div class="doc-field"><label>Variantes e SKUs</label><div id="comp-produtos-variantes"></div></div>
                <div class="doc-field"><label>Ficha tecnica</label><div id="comp-produtos-ficha_tecnica"></div></div>
            </div>
        </div>

        <!-- 3. Fotos e Videos -->
        <div class="doc-section" id="section-fotos">
            <div class="doc-section-header" onclick="toggleSection('fotos')"><span class="doc-section-badge" id="badge-fotos">0/4</span><h3>Fotos e Videos</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente os padroes visuais para fotos e videos dos seus produtos na Shopee.</p>
                <div class="doc-field"><label>Especificacoes de imagem</label><div id="comp-fotos-especificacoes"></div></div>
                <div class="doc-field"><label>Checklist de fotos por produto</label><div id="comp-fotos-estilo"></div></div>
                <div class="doc-field"><label>Videos do produto</label><div id="comp-fotos-videos"></div></div>
                <div class="doc-field"><label>Ferramentas de edicao</label><div id="comp-fotos-edicao"></div></div>
            </div>
        </div>

        <!-- 4. Precificacao -->
        <div class="doc-section" id="section-preco">
            <div class="doc-section-header" onclick="toggleSection('preco')"><span class="doc-section-badge" id="badge-preco">0/4</span><h3>Precificacao</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina sua estrategia de precificacao considerando custos, margens e concorrencia na Shopee.</p>
                <div class="doc-field"><label>Formula de precificacao</label><div id="comp-preco-formula"></div></div>
                <div class="doc-field"><label>Margem e custos</label><div id="comp-preco-margem"></div></div>
                <div class="doc-field"><label>Estrategia de promocoes</label><div id="comp-preco-promocoes"></div></div>
                <div class="doc-field"><label>Analise de precos concorrentes</label><div id="comp-preco-concorrencia"></div></div>
            </div>
        </div>

        <!-- 5. SEO na Shopee -->
        <div class="doc-section" id="section-seo">
            <div class="doc-section-header" onclick="toggleSection('seo')"><span class="doc-section-badge" id="badge-seo">0/4</span><h3>SEO na Shopee</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Otimize a visibilidade dos seus produtos na busca da Shopee com palavras-chave e tags estrategicas.</p>
                <div class="doc-field"><label>Palavras-chave principais</label><div id="comp-seo-palavras_chave"></div></div>
                <div class="doc-field"><label>Dicas de titulo otimizado</label><div id="comp-seo-titulo_otimizado"></div></div>
                <div class="doc-field"><label>Tags e atributos</label><div id="comp-seo-tags"></div></div>
                <div class="doc-field"><label>Estrategia de busca</label><div id="comp-seo-busca"></div></div>
            </div>
        </div>

        <!-- 6. Logistica e Envio -->
        <div class="doc-section" id="section-logistica">
            <div class="doc-section-header" onclick="toggleSection('logistica')"><span class="doc-section-badge" id="badge-logistica">0/4</span><h3>Logistica e Envio</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje as modalidades de envio, embalagem e estrategia de frete para sua operacao.</p>
                <div class="doc-field"><label>Modalidades de envio</label><div id="comp-logistica-modalidades"></div></div>
                <div class="doc-field"><label>Checklist de embalagem</label><div id="comp-logistica-embalagem"></div></div>
                <div class="doc-field"><label>Prazos por modalidade</label><div id="comp-logistica-prazo"></div></div>
                <div class="doc-field"><label>Regras de frete</label><div id="comp-logistica-frete"></div></div>
            </div>
        </div>

        <!-- 7. Atendimento ao Cliente -->
        <div class="doc-section" id="section-atendimento">
            <div class="doc-section-header" onclick="toggleSection('atendimento')"><span class="doc-section-badge" id="badge-atendimento">0/4</span><h3>Atendimento ao Cliente</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente seus processos de atendimento, respostas padrao e estrategias de pos-venda.</p>
                <div class="doc-field"><label>Respostas padrao</label><div id="comp-atendimento-respostas"></div></div>
                <div class="doc-field"><label>Tempos de resposta</label><div id="comp-atendimento-tempo"></div></div>
                <div class="doc-field"><label>Processo de trocas/devolucoes</label><div id="comp-atendimento-trocas"></div></div>
                <div class="doc-field"><label>Pos-venda</label><div id="comp-atendimento-pos_venda"></div></div>
            </div>
        </div>

        <!-- 8. Anuncios e Ads -->
        <div class="doc-section" id="section-anuncios">
            <div class="doc-section-header" onclick="toggleSection('anuncios')"><span class="doc-section-badge" id="badge-anuncios">0/4</span><h3>Anuncios e Ads</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje seus investimentos em anuncios na Shopee, segmentacao e otimizacao de campanhas.</p>
                <div class="doc-field"><label>Orcamento por campanha</label><div id="comp-anuncios-orcamento"></div></div>
                <div class="doc-field"><label>Regras de segmentacao</label><div id="comp-anuncios-segmentacao"></div></div>
                <div class="doc-field"><label>Tipos de anuncio</label><div id="comp-anuncios-tipos"></div></div>
                <div class="doc-field"><label>Otimizacao de campanhas</label><div id="comp-anuncios-otimizacao"></div></div>
            </div>
        </div>

        <!-- 9. Metricas e Analise -->
        <div class="doc-section" id="section-metricas">
            <div class="doc-section-header" onclick="toggleSection('metricas')"><span class="doc-section-badge" id="badge-metricas">0/4</span><h3>Metricas e Analise</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Acompanhe os indicadores de desempenho da sua loja e defina metas e planos de acao.</p>
                <div class="doc-field"><label>KPIs principais</label><div id="comp-metricas-kpis"></div></div>
                <div class="doc-field"><label>Metas mensais</label><div id="comp-metricas-metas"></div></div>
                <div class="doc-field"><label>Relatorios</label><div id="comp-metricas-relatorios"></div></div>
                <div class="doc-field"><label>Plano de acao</label><div id="comp-metricas-acoes"></div></div>
            </div>
        </div>

        <!-- 10. Estrategias de Crescimento -->
        <div class="doc-section" id="section-crescimento">
            <div class="doc-section-header" onclick="toggleSection('crescimento')"><span class="doc-section-badge" id="badge-crescimento">0/4</span><h3>Estrategias de Crescimento</h3><svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje estrategias para escalar suas vendas, parcerias e fidelizacao de clientes.</p>
                <div class="doc-field"><label>Estrategia de escala</label><div id="comp-crescimento-escala"></div></div>
                <div class="doc-field"><label>Parcerias e influenciadores</label><div id="comp-crescimento-parcerias"></div></div>
                <div class="doc-field"><label>Cross-sell e up-sell</label><div id="comp-crescimento-cross_sell"></div></div>
                <div class="doc-field"><label>Fidelizacao</label><div id="comp-crescimento-fidelizacao"></div></div>
            </div>
        </div>

    </div>
</div>
<script src="../js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script>
(function() {
    var DATA_KEY = 'induziShopee';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['shopee']) || {};

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
        var exportData = { _induzi: true, modulo: 'Shopee', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob); var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-shopee-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        _components['loja.nome'] = InduziComponents.guided(document.getElementById('comp-loja-nome'), Object.assign({ onChange: onChange, placeholder: 'Adicionar nome da loja... (Enter)' }, presets['loja.nome'] || {}));
        _components['loja.descricao'] = InduziComponents.guided(document.getElementById('comp-loja-descricao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar ponto da descricao...' }, presets['loja.descricao'] || {}));
        _components['loja.logo'] = InduziComponents.dropzone(document.getElementById('comp-loja-logo'), { accept: 'image/*', maxFiles: 5, onChange: onChange });
        _components['loja.politicas'] = InduziComponents.guided(document.getElementById('comp-loja-politicas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar politica...' }, presets['loja.politicas'] || {}));
        _components['loja.categorias'] = InduziComponents.guided(document.getElementById('comp-loja-categorias'), Object.assign({ onChange: onChange, placeholder: 'Adicionar categoria... (Enter)' }, presets['loja.categorias'] || {}));

        _components['produtos.template_titulo'] = InduziComponents.guided(document.getElementById('comp-produtos-template_titulo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento do titulo...' }, presets['produtos.template_titulo'] || {}));
        _components['produtos.template_descricao'] = InduziComponents.guided(document.getElementById('comp-produtos-template_descricao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar secao da descricao...' }, presets['produtos.template_descricao'] || {}));
        _components['produtos.variantes'] = InduziComponents.guided(document.getElementById('comp-produtos-variantes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar variante... (Enter)' }, presets['produtos.variantes'] || {}));
        _components['produtos.ficha_tecnica'] = InduziComponents.keyValue(document.getElementById('comp-produtos-ficha_tecnica'), { keyLabel: 'Atributo', valueLabel: 'Valor', onChange: onChange });

        _components['fotos.especificacoes'] = InduziComponents.guided(document.getElementById('comp-fotos-especificacoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar spec de imagem...' }, presets['fotos.especificacoes'] || {}));
        _components['fotos.estilo'] = InduziComponents.guided(document.getElementById('comp-fotos-estilo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tipo de foto...' }, presets['fotos.estilo'] || {}));
        _components['fotos.videos'] = InduziComponents.guided(document.getElementById('comp-fotos-videos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar spec de video...' }, presets['fotos.videos'] || {}));
        _components['fotos.edicao'] = InduziComponents.guided(document.getElementById('comp-fotos-edicao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar ferramenta... (Enter)' }, presets['fotos.edicao'] || {}));

        _components['preco.formula'] = InduziComponents.keyValue(document.getElementById('comp-preco-formula'), { keyLabel: 'Item', valueLabel: 'Valor/Percentual', onChange: onChange });
        _components['preco.margem'] = InduziComponents.keyValue(document.getElementById('comp-preco-margem'), { keyLabel: 'Custo', valueLabel: 'Valor', onChange: onChange });
        _components['preco.promocoes'] = InduziComponents.multiSelect(document.getElementById('comp-preco-promocoes'), {
            options: [{ value: 'Flash Sale', label: 'Flash Sale' }, { value: 'Cupons', label: 'Cupons' }, { value: 'Frete Gratis', label: 'Frete Gratis' }, { value: 'Combos', label: 'Combos' }, { value: 'Desconto Progressivo', label: 'Desconto Progressivo' }], onChange: onChange
        });
        _components['preco.concorrencia'] = InduziComponents.keyValue(document.getElementById('comp-preco-concorrencia'), { keyLabel: 'Concorrente', valueLabel: 'Preco', onChange: onChange });

        _components['seo.palavras_chave'] = InduziComponents.guided(document.getElementById('comp-seo-palavras_chave'), Object.assign({ onChange: onChange, placeholder: 'Adicionar keyword... (Enter)' }, presets['seo.palavras_chave'] || {}));
        _components['seo.titulo_otimizado'] = InduziComponents.guided(document.getElementById('comp-seo-titulo_otimizado'), Object.assign({ onChange: onChange, placeholder: 'Adicionar dica de titulo...' }, presets['seo.titulo_otimizado'] || {}));
        _components['seo.tags'] = InduziComponents.guided(document.getElementById('comp-seo-tags'), Object.assign({ onChange: onChange, placeholder: 'Adicionar tag... (Enter)' }, presets['seo.tags'] || {}));
        _components['seo.busca'] = InduziComponents.guided(document.getElementById('comp-seo-busca'), Object.assign({ onChange: onChange, placeholder: 'Adicionar estrategia de busca...' }, presets['seo.busca'] || {}));

        _components['logistica.modalidades'] = InduziComponents.multiSelect(document.getElementById('comp-logistica-modalidades'), {
            options: [{ value: 'Correios', label: 'Correios' }, { value: 'Transportadora', label: 'Transportadora' }, { value: 'Shopee Envios', label: 'Shopee Envios' }, { value: 'Retirada', label: 'Retirada' }, { value: 'Full', label: 'Full' }], onChange: onChange
        });
        _components['logistica.embalagem'] = InduziComponents.guided(document.getElementById('comp-logistica-embalagem'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item de embalagem...' }, presets['logistica.embalagem'] || {}));
        _components['logistica.prazo'] = InduziComponents.keyValue(document.getElementById('comp-logistica-prazo'), { keyLabel: 'Modalidade', valueLabel: 'Prazo', onChange: onChange });
        _components['logistica.frete'] = InduziComponents.guided(document.getElementById('comp-logistica-frete'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de frete...' }, presets['logistica.frete'] || {}));

        _components['atendimento.respostas'] = InduziComponents.keyValue(document.getElementById('comp-atendimento-respostas'), { keyLabel: 'Situacao', valueLabel: 'Resposta', onChange: onChange });
        _components['atendimento.tempo'] = InduziComponents.keyValue(document.getElementById('comp-atendimento-tempo'), { keyLabel: 'Situacao', valueLabel: 'Prazo', onChange: onChange });
        _components['atendimento.trocas'] = InduziComponents.guided(document.getElementById('comp-atendimento-trocas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar passo...' }, presets['atendimento.trocas'] || {}));
        _components['atendimento.pos_venda'] = InduziComponents.guided(document.getElementById('comp-atendimento-pos_venda'), Object.assign({ onChange: onChange, placeholder: 'Adicionar acao pos-venda...' }, presets['atendimento.pos_venda'] || {}));

        _components['anuncios.orcamento'] = InduziComponents.keyValue(document.getElementById('comp-anuncios-orcamento'), { keyLabel: 'Campanha', valueLabel: 'Valor', onChange: onChange });
        _components['anuncios.segmentacao'] = InduziComponents.guided(document.getElementById('comp-anuncios-segmentacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra de segmentacao...' }, presets['anuncios.segmentacao'] || {}));
        _components['anuncios.tipos'] = InduziComponents.multiSelect(document.getElementById('comp-anuncios-tipos'), {
            options: [{ value: 'Busca', label: 'Busca' }, { value: 'Discovery', label: 'Discovery' }, { value: 'Auto', label: 'Auto' }, { value: 'Lives', label: 'Lives' }], onChange: onChange
        });
        _components['anuncios.otimizacao'] = InduziComponents.guided(document.getElementById('comp-anuncios-otimizacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar acao de otimizacao...' }, presets['anuncios.otimizacao'] || {}));

        _components['metricas.kpis'] = InduziComponents.guided(document.getElementById('comp-metricas-kpis'), Object.assign({ onChange: onChange, placeholder: 'Adicionar KPI... (Enter)' }, presets['metricas.kpis'] || {}));
        _components['metricas.metas'] = InduziComponents.keyValue(document.getElementById('comp-metricas-metas'), { keyLabel: 'Metrica', valueLabel: 'Meta', onChange: onChange });
        _components['metricas.relatorios'] = InduziComponents.guided(document.getElementById('comp-metricas-relatorios'), Object.assign({ onChange: onChange, placeholder: 'Adicionar relatorio...' }, presets['metricas.relatorios'] || {}));
        _components['metricas.acoes'] = InduziComponents.guided(document.getElementById('comp-metricas-acoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar acao...' }, presets['metricas.acoes'] || {}));

        _components['crescimento.escala'] = InduziComponents.guided(document.getElementById('comp-crescimento-escala'), Object.assign({ onChange: onChange, placeholder: 'Adicionar estrategia de escala...' }, presets['crescimento.escala'] || {}));
        _components['crescimento.parcerias'] = InduziComponents.guided(document.getElementById('comp-crescimento-parcerias'), Object.assign({ onChange: onChange, placeholder: 'Adicionar parceiro/influenciador... (Enter)' }, presets['crescimento.parcerias'] || {}));
        _components['crescimento.cross_sell'] = InduziComponents.guided(document.getElementById('comp-crescimento-cross_sell'), Object.assign({ onChange: onChange, placeholder: 'Adicionar estrategia cross-sell...' }, presets['crescimento.cross_sell'] || {}));
        _components['crescimento.fidelizacao'] = InduziComponents.guided(document.getElementById('comp-crescimento-fidelizacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar acao de fidelizacao...' }, presets['crescimento.fidelizacao'] || {}));

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
