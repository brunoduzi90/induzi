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
<title>Google Ads — Induzi</title>
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
            <h1>Google Ads</h1>
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

        <!-- 1. Estrategia e Objetivos -->
        <div class="doc-section" id="section-estrategia">
            <div class="doc-section-header" onclick="toggleSection('estrategia')">
                <span class="doc-section-badge" id="badge-estrategia">0/5</span>
                <h3>Estrategia e Objetivos</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina os objetivos de negocio, orcamento e metas que suas campanhas de Google Ads devem alcancar.</p>
                <div class="doc-field"><label>Objetivo principal das campanhas</label><div id="comp-estrategia-objetivo"></div></div>
                <div class="doc-field"><label>Orcamento mensal</label><div id="comp-estrategia-orcamento"></div></div>
                <div class="doc-field"><label>CPA / ROAS alvo</label><div id="comp-estrategia-cpa_alvo"></div></div>
                <div class="doc-field"><label>KPIs e metas mensais</label><div id="comp-estrategia-kpis"></div></div>
                <div class="doc-field"><label>Funil de conversao</label><div id="comp-estrategia-funil"></div></div>
            </div>
        </div>

        <!-- 2. Conta e Estrutura de Campanhas -->
        <div class="doc-section" id="section-conta">
            <div class="doc-section-header" onclick="toggleSection('conta')">
                <span class="doc-section-badge" id="badge-conta">0/4</span>
                <h3>Conta e Estrutura de Campanhas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Organize a estrutura da conta com campanhas, grupos de anuncios e convencoes de nomenclatura.</p>
                <div class="doc-field"><label>Estrutura de campanhas</label><div id="comp-conta-campanhas"></div></div>
                <div class="doc-field"><label>Convencao de nomenclatura</label><div id="comp-conta-nomenclatura"></div></div>
                <div class="doc-field"><label>Configuracoes de localizacao e idioma</label><div id="comp-conta-localizacao"></div></div>
                <div class="doc-field"><label>Programacao de anuncios</label><div id="comp-conta-programacao"></div></div>
            </div>
        </div>

        <!-- 3. Pesquisa de Palavras-Chave -->
        <div class="doc-section" id="section-palavras">
            <div class="doc-section-header" onclick="toggleSection('palavras')">
                <span class="doc-section-badge" id="badge-palavras">0/5</span>
                <h3>Pesquisa de Palavras-Chave</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Mapeie as palavras-chave que ativam seus anuncios e as que devem ser bloqueadas.</p>
                <div class="doc-field"><label>Palavras-chave principais (alta intencao)</label><div id="comp-palavras-principais"></div></div>
                <div class="doc-field"><label>Palavras-chave secundarias (consideracao)</label><div id="comp-palavras-secundarias"></div></div>
                <div class="doc-field"><label>Palavras-chave de cauda longa</label><div id="comp-palavras-long_tail"></div></div>
                <div class="doc-field">
                    <label>Palavras-chave negativas</label>
                    <div id="comp-palavras-negativas"></div>
                    <div class="field-hint">Fundamental para economizar orcamento e melhorar a qualidade dos cliques</div>
                </div>
                <div class="doc-field"><label>Tipos de correspondencia por grupo</label><div id="comp-palavras-correspondencia"></div></div>
            </div>
        </div>

        <!-- 4. Anuncios de Pesquisa (Search) -->
        <div class="doc-section" id="section-search">
            <div class="doc-section-header" onclick="toggleSection('search')">
                <span class="doc-section-badge" id="badge-search">0/5</span>
                <h3>Anuncios de Pesquisa (Search)</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Crie os textos dos anuncios responsivos de pesquisa (RSA). O Google combina ate 15 titulos e 4 descricoes.</p>
                <div class="doc-field">
                    <label>Headlines (titulos) — ate 30 caracteres cada</label>
                    <div id="comp-search-headlines"></div>
                    <div class="field-hint">Varie entre beneficios, keywords, numeros, CTAs, ofertas e diferenciais. Quanto mais variedade, melhor o Google otimiza.</div>
                </div>
                <div class="doc-field"><label>Descricoes — ate 90 caracteres cada</label><div id="comp-search-descricoes"></div></div>
                <div class="doc-field">
                    <label>Extensoes de anuncio (Assets)</label>
                    <div id="comp-search-extensoes"></div>
                    <div class="field-hint">Extensoes aumentam o CTR em ate 15%. Use todas as relevantes.</div>
                </div>
                <div class="doc-field"><label>Variacoes para teste A/B</label><div id="comp-search-testes"></div></div>
                <div class="doc-field"><label>Anuncios por grupo de anuncio</label><div id="comp-search-por_grupo"></div></div>
            </div>
        </div>

        <!-- 5. Google Shopping -->
        <div class="doc-section" id="section-shopping">
            <div class="doc-section-header" onclick="toggleSection('shopping')">
                <span class="doc-section-badge" id="badge-shopping">0/4</span>
                <h3>Google Shopping</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Configure campanhas de Shopping para exibir produtos com imagem, preco e nome diretamente na busca.</p>
                <div class="doc-field"><label>Feed de produtos (Merchant Center)</label><div id="comp-shopping-feed"></div></div>
                <div class="doc-field">
                    <label>Otimizacao de titulos do feed</label>
                    <div id="comp-shopping-titulos_feed"></div>
                    <div class="field-hint">Titulos otimizados no feed sao o fator #1 de performance no Shopping</div>
                </div>
                <div class="doc-field"><label>Estrutura de campanhas Shopping</label><div id="comp-shopping-campanhas_shopping"></div></div>
                <div class="doc-field"><label>Exclusoes e ajustes</label><div id="comp-shopping-exclusoes"></div></div>
            </div>
        </div>

        <!-- 6. Display e Remarketing -->
        <div class="doc-section" id="section-display">
            <div class="doc-section-header" onclick="toggleSection('display')">
                <span class="doc-section-badge" id="badge-display">0/4</span>
                <h3>Display e Remarketing</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Anuncios visuais na rede de display do Google e estrategias de remarketing para recuperar visitantes.</p>
                <div class="doc-field"><label>Banners e criativos</label><div id="comp-display-banners"></div></div>
                <div class="doc-field">
                    <label>Listas de remarketing</label>
                    <div id="comp-display-remarketing"></div>
                    <div class="field-hint">Remarketing costuma ter o melhor ROAS de todas as campanhas</div>
                </div>
                <div class="doc-field"><label>Segmentacao de publico (Display)</label><div id="comp-display-segmentacao"></div></div>
                <div class="doc-field"><label>Exclusoes de posicionamento</label><div id="comp-display-exclusoes_display"></div></div>
            </div>
        </div>

        <!-- 7. YouTube Ads -->
        <div class="doc-section" id="section-youtube">
            <div class="doc-section-header" onclick="toggleSection('youtube')">
                <span class="doc-section-badge" id="badge-youtube">0/4</span>
                <h3>YouTube Ads</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Anuncios em video no YouTube para awareness, consideracao e conversao.</p>
                <div class="doc-field"><label>Formatos de video</label><div id="comp-youtube-formatos"></div></div>
                <div class="doc-field">
                    <label>Roteiros de video</label>
                    <div id="comp-youtube-roteiros"></div>
                    <div class="field-hint">Os primeiros 5 segundos decidem se o usuario vai assistir ou pular</div>
                </div>
                <div class="doc-field"><label>Segmentacao de publico (YouTube)</label><div id="comp-youtube-segmentacao_yt"></div></div>
                <div class="doc-field"><label>Metricas e otimizacao de video</label><div id="comp-youtube-metricas_yt"></div></div>
            </div>
        </div>

        <!-- 8. Performance Max -->
        <div class="doc-section" id="section-pmax">
            <div class="doc-section-header" onclick="toggleSection('pmax')">
                <span class="doc-section-badge" id="badge-pmax">0/4</span>
                <h3>Performance Max</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Campanhas automatizadas que rodam em todos os canais Google (Search, Display, YouTube, Gmail, Maps, Discover).</p>
                <div class="doc-field"><label>Assets do grupo de recursos</label><div id="comp-pmax-assets"></div></div>
                <div class="doc-field">
                    <label>Sinais de publico (Audience Signals)</label>
                    <div id="comp-pmax-sinais"></div>
                    <div class="field-hint">Sinais orientam a IA do Google, mas nao limitam a veiculacao</div>
                </div>
                <div class="doc-field"><label>Metas de conversao</label><div id="comp-pmax-metas"></div></div>
                <div class="doc-field"><label>Exclusoes e controle</label><div id="comp-pmax-controle"></div></div>
            </div>
        </div>

        <!-- 9. Landing Pages e Conversao -->
        <div class="doc-section" id="section-landing">
            <div class="doc-section-header" onclick="toggleSection('landing')">
                <span class="doc-section-badge" id="badge-landing">0/4</span>
                <h3>Landing Pages e Conversao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">As landing pages sao tao importantes quanto os anuncios. Uma LP ruim desperdiça todo o investimento.</p>
                <div class="doc-field"><label>URLs de destino por campanha</label><div id="comp-landing-urls"></div></div>
                <div class="doc-field"><label>Elementos da landing page</label><div id="comp-landing-elementos"></div></div>
                <div class="doc-field"><label>Rastreamento de conversoes</label><div id="comp-landing-rastreamento"></div></div>
                <div class="doc-field"><label>Testes A/B de landing page</label><div id="comp-landing-testes_lp"></div></div>
            </div>
        </div>

        <!-- 10. Otimizacao e Escala -->
        <div class="doc-section" id="section-otimizacao">
            <div class="doc-section-header" onclick="toggleSection('otimizacao')">
                <span class="doc-section-badge" id="badge-otimizacao">0/5</span>
                <h3>Otimizacao e Escala</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Rotina de otimizacao continua para melhorar performance e escalar campanhas lucrativas.</p>
                <div class="doc-field"><label>Rotina de otimizacao (checklist semanal)</label><div id="comp-otimizacao-rotina"></div></div>
                <div class="doc-field"><label>Estrategia de lances</label><div id="comp-otimizacao-lances"></div></div>
                <div class="doc-field"><label>Quality Score e Ad Rank</label><div id="comp-otimizacao-quality_score"></div></div>
                <div class="doc-field"><label>Plano de escala</label><div id="comp-otimizacao-escala"></div></div>
                <div class="doc-field"><label>Analise de concorrentes</label><div id="comp-otimizacao-concorrentes"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziGoogleAds';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['google-ads']) || {};

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
        var exportData = { _induzi: true, modulo: 'Google Ads', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-google-ads-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-estrategia-objetivo', 'estrategia.objetivo', 'Adicionar objetivo de campanha...');
        g('comp-estrategia-orcamento', 'estrategia.orcamento', 'Adicionar orcamento mensal...');
        g('comp-estrategia-cpa_alvo', 'estrategia.cpa_alvo', 'Adicionar CPA ou ROAS alvo...');
        g('comp-estrategia-kpis', 'estrategia.kpis', 'Adicionar KPI ou meta...');
        g('comp-estrategia-funil', 'estrategia.funil', 'Adicionar etapa do funil...');

        g('comp-conta-campanhas', 'conta.campanhas', 'Adicionar campanha...');
        g('comp-conta-nomenclatura', 'conta.nomenclatura', 'Adicionar padrao de nomenclatura...');
        g('comp-conta-localizacao', 'conta.localizacao', 'Adicionar config de localizacao...');
        g('comp-conta-programacao', 'conta.programacao', 'Adicionar programacao de anuncio...');

        g('comp-palavras-principais', 'palavras.principais', 'Adicionar keyword principal...');
        g('comp-palavras-secundarias', 'palavras.secundarias', 'Adicionar keyword secundaria...');
        g('comp-palavras-long_tail', 'palavras.long_tail', 'Adicionar keyword de cauda longa...');
        g('comp-palavras-negativas', 'palavras.negativas', 'Adicionar keyword negativa...');
        g('comp-palavras-correspondencia', 'palavras.correspondencia', 'Adicionar tipo de correspondencia...');

        g('comp-search-headlines', 'search.headlines', 'Adicionar headline...');
        g('comp-search-descricoes', 'search.descricoes', 'Adicionar descricao de anuncio...');
        g('comp-search-extensoes', 'search.extensoes', 'Adicionar extensao de anuncio...');
        g('comp-search-testes', 'search.testes', 'Adicionar variacao para teste...');
        g('comp-search-por_grupo', 'search.por_grupo', 'Adicionar anuncio por grupo...');

        g('comp-shopping-feed', 'shopping.feed', 'Adicionar config do feed...');
        g('comp-shopping-titulos_feed', 'shopping.titulos_feed', 'Adicionar otimizacao de titulo...');
        g('comp-shopping-campanhas_shopping', 'shopping.campanhas_shopping', 'Adicionar campanha Shopping...');
        g('comp-shopping-exclusoes', 'shopping.exclusoes', 'Adicionar exclusao ou ajuste...');

        g('comp-display-banners', 'display.banners', 'Adicionar banner ou criativo...');
        g('comp-display-remarketing', 'display.remarketing', 'Adicionar lista de remarketing...');
        g('comp-display-segmentacao', 'display.segmentacao', 'Adicionar segmentacao de publico...');
        g('comp-display-exclusoes_display', 'display.exclusoes_display', 'Adicionar exclusao de posicionamento...');

        g('comp-youtube-formatos', 'youtube.formatos', 'Adicionar formato de video...');
        g('comp-youtube-roteiros', 'youtube.roteiros', 'Adicionar roteiro de video...');
        g('comp-youtube-segmentacao_yt', 'youtube.segmentacao_yt', 'Adicionar segmentacao YouTube...');
        g('comp-youtube-metricas_yt', 'youtube.metricas_yt', 'Adicionar metrica de video...');

        g('comp-pmax-assets', 'pmax.assets', 'Adicionar asset do grupo...');
        g('comp-pmax-sinais', 'pmax.sinais', 'Adicionar sinal de publico...');
        g('comp-pmax-metas', 'pmax.metas', 'Adicionar meta de conversao...');
        g('comp-pmax-controle', 'pmax.controle', 'Adicionar exclusao ou controle...');

        g('comp-landing-urls', 'landing.urls', 'Adicionar URL de destino...');
        g('comp-landing-elementos', 'landing.elementos', 'Adicionar elemento da LP...');
        g('comp-landing-rastreamento', 'landing.rastreamento', 'Adicionar config de rastreamento...');
        g('comp-landing-testes_lp', 'landing.testes_lp', 'Adicionar teste A/B de LP...');

        g('comp-otimizacao-rotina', 'otimizacao.rotina', 'Adicionar item da rotina...');
        g('comp-otimizacao-lances', 'otimizacao.lances', 'Adicionar estrategia de lance...');
        g('comp-otimizacao-quality_score', 'otimizacao.quality_score', 'Adicionar acao de Quality Score...');
        g('comp-otimizacao-escala', 'otimizacao.escala', 'Adicionar plano de escala...');
        g('comp-otimizacao-concorrentes', 'otimizacao.concorrentes', 'Adicionar analise de concorrente...');

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
