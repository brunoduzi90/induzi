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
<title>Meta Ads — Induzi</title>
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
            <h1>Meta Ads</h1>
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

        <!-- 1. Pixel e Configuracao -->
        <div class="doc-section" id="section-pixel-config">
            <div class="doc-section-header" onclick="toggleSection('pixel-config')">
                <span class="doc-section-badge" id="badge-pixel-config">0/4</span>
                <h3>Pixel e Configuracao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">O Meta Pixel e a base de todo anuncio eficaz. Sem tracking correto, voce esta jogando dinheiro fora.</p>
                <div class="doc-field">
                    <label>Instalacao do Pixel</label>
                    <div id="comp-pixel-config-pixel"></div>
                </div>
                <div class="doc-field">
                    <label>Eventos padrao</label>
                    <div id="comp-pixel-config-eventos"></div>
                </div>
                <div class="doc-field">
                    <label>API de Conversoes (CAPI)</label>
                    <div id="comp-pixel-config-capi"></div>
                </div>
                <div class="doc-field">
                    <label>Dominio verificado</label>
                    <div id="comp-pixel-config-dominio"></div>
                </div>
            </div>
        </div>

        <!-- 2. Publicos e Segmentacao -->
        <div class="doc-section" id="section-publicos">
            <div class="doc-section-header" onclick="toggleSection('publicos')">
                <span class="doc-section-badge" id="badge-publicos">0/4</span>
                <h3>Publicos e Segmentacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">O segredo do Meta Ads e mostrar o anuncio certo para a pessoa certa. Publicos bem construidos sao meio caminho andado.</p>
                <div class="doc-field">
                    <label>Custom Audiences</label>
                    <div id="comp-publicos-custom"></div>
                </div>
                <div class="doc-field">
                    <label>Lookalike Audiences</label>
                    <div id="comp-publicos-lookalike"></div>
                </div>
                <div class="doc-field">
                    <label>Interesses e comportamento</label>
                    <div id="comp-publicos-interesses"></div>
                </div>
                <div class="doc-field">
                    <label>Exclusoes</label>
                    <div id="comp-publicos-exclusoes"></div>
                </div>
            </div>
        </div>

        <!-- 3. Estrutura de Campanhas -->
        <div class="doc-section" id="section-estrutura-camp">
            <div class="doc-section-header" onclick="toggleSection('estrutura-camp')">
                <span class="doc-section-badge" id="badge-estrutura-camp">0/4</span>
                <h3>Estrutura de Campanhas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Uma boa estrutura de campanha facilita a otimizacao, o controle de orcamento e a analise de resultados.</p>
                <div class="doc-field">
                    <label>Objetivos de campanha</label>
                    <div id="comp-estrutura-camp-objetivos"></div>
                </div>
                <div class="doc-field">
                    <label>Organizacao de conjuntos</label>
                    <div id="comp-estrutura-camp-conjuntos"></div>
                </div>
                <div class="doc-field">
                    <label>Orcamento e lances</label>
                    <div id="comp-estrutura-camp-orcamento"></div>
                </div>
                <div class="doc-field">
                    <label>Nomenclatura</label>
                    <div id="comp-estrutura-camp-nomenclatura"></div>
                </div>
            </div>
        </div>

        <!-- 4. Criativos e Copies -->
        <div class="doc-section" id="section-criativos">
            <div class="doc-section-header" onclick="toggleSection('criativos')">
                <span class="doc-section-badge" id="badge-criativos">0/4</span>
                <h3>Criativos e Copies</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">O criativo e o que o usuario ve. Um bom criativo pode reduzir o custo por resultado em 50% ou mais.</p>
                <div class="doc-field">
                    <label>Formatos de anuncio</label>
                    <div id="comp-criativos-formatos"></div>
                </div>
                <div class="doc-field">
                    <label>Copies de anuncio</label>
                    <div id="comp-criativos-copies"></div>
                </div>
                <div class="doc-field">
                    <label>Criativos visuais</label>
                    <div id="comp-criativos-visuais"></div>
                </div>
                <div class="doc-field">
                    <label>Testes de criativo</label>
                    <div id="comp-criativos-testes_criativo"></div>
                </div>
            </div>
        </div>

        <!-- 5. Otimizacao e Metricas -->
        <div class="doc-section" id="section-otimizacao-ads">
            <div class="doc-section-header" onclick="toggleSection('otimizacao-ads')">
                <span class="doc-section-badge" id="badge-otimizacao-ads">0/4</span>
                <h3>Otimizacao e Metricas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Anuncios precisam de monitoramento constante. Otimizar baseado em dados e o que separa campanhas lucrativas de prejuizo.</p>
                <div class="doc-field">
                    <label>KPIs principais</label>
                    <div id="comp-otimizacao-ads-kpis"></div>
                </div>
                <div class="doc-field">
                    <label>Otimizacao diaria</label>
                    <div id="comp-otimizacao-ads-diaria"></div>
                </div>
                <div class="doc-field">
                    <label>Escalabilidade</label>
                    <div id="comp-otimizacao-ads-escala"></div>
                </div>
                <div class="doc-field">
                    <label>Diagnostico de problemas</label>
                    <div id="comp-otimizacao-ads-diagnostico"></div>
                </div>
            </div>
        </div>

        <!-- 6. Remarketing e Retargeting -->
        <div class="doc-section" id="section-remarketing">
            <div class="doc-section-header" onclick="toggleSection('remarketing')">
                <span class="doc-section-badge" id="badge-remarketing">0/4</span>
                <h3>Remarketing e Retargeting</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">97% dos visitantes nao convertem na primeira visita. Remarketing traz de volta quem ja demonstrou interesse.</p>
                <div class="doc-field">
                    <label>Funil de remarketing</label>
                    <div id="comp-remarketing-funil"></div>
                </div>
                <div class="doc-field">
                    <label>Sequencia de anuncios</label>
                    <div id="comp-remarketing-sequencia"></div>
                </div>
                <div class="doc-field">
                    <label>Cross-sell e upsell</label>
                    <div id="comp-remarketing-crosssell"></div>
                </div>
                <div class="doc-field">
                    <label>DPA (Dynamic Product Ads)</label>
                    <div id="comp-remarketing-dpa"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziMetaAds';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['meta-ads']) || {};

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
        var exportData = { _induzi: true, modulo: 'Meta Ads', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-meta-ads-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-pixel-config-pixel', 'pixel-config.pixel', 'ID do Pixel, metodo de instalacao (GTM, codigo direto, plugin), verificacao no Events Manager, Pixel Helper instalado...');
        g('comp-pixel-config-eventos', 'pixel-config.eventos', 'Eventos configurados: PageView, ViewContent, AddToCart, InitiateCheckout, Purchase, Lead, CompleteRegistration. Parametros enviados...');
        g('comp-pixel-config-capi', 'pixel-config.capi', 'Server-side tracking via Conversions API, deduplicacao com Pixel, event_id, configuracao via GTM ou gateway, qualidade do match...');
        g('comp-pixel-config-dominio', 'pixel-config.dominio', 'Dominio verificado no Business Manager, eventos priorizados (8 eventos para iOS 14+), aggregated event measurement...');

        g('comp-publicos-custom', 'publicos.custom', 'Publicos personalizados criados: visitantes do site (30/60/180 dias), lista de clientes, engajamento no Instagram, viewers de video...');
        g('comp-publicos-lookalike', 'publicos.lookalike', 'Publicos semelhantes: baseados em compradores, leads, top 25% clientes. Percentuais testados (1%, 2-5%, 5-10%), pais...');
        g('comp-publicos-interesses', 'publicos.interesses', 'Segmentacao por interesses, comportamentos, dados demograficos. Categorias testadas, exclusoes, sobreposicao de publicos...');
        g('comp-publicos-exclusoes', 'publicos.exclusoes', 'Publicos excluidos: compradores recentes, funcionarios, publicos saturados. Janela de exclusao, estrategia de frequencia...');

        g('comp-estrutura-camp-objetivos', 'estrutura-camp.objetivos', 'Objetivos usados: Vendas, Leads, Trafego, Engajamento, Awareness. Quando usar cada um, otimizacao por evento de conversao...');
        g('comp-estrutura-camp-conjuntos', 'estrutura-camp.conjuntos', 'Estrutura: CBO vs ABO, conjuntos por publico, por etapa do funil (topo/meio/fundo), nomenclatura padrao, orcamento por conjunto...');
        g('comp-estrutura-camp-orcamento', 'estrutura-camp.orcamento', 'Orcamento diario vs vitalicio, CBO (Campaign Budget Optimization), bid strategy (lowest cost, bid cap, cost cap), escalonamento...');
        g('comp-estrutura-camp-nomenclatura', 'estrutura-camp.nomenclatura', 'Padrao de nomes: [Objetivo]_[Publico]_[Formato]_[Data]. Ex: VENDAS_LAL-Compradores-1%_Carrossel_Mar25. Facilita analise e filtros...');

        g('comp-criativos-formatos', 'criativos.formatos', 'Imagem unica, carrossel, video curto (15-30s), Reels ads, Stories ads, collection ads. Quando usar cada formato, especificacoes...');
        g('comp-criativos-copies', 'criativos.copies', 'Estrutura: gancho > problema > solucao > prova > CTA. Variacoes curtas e longas, emojis, perguntas no inicio, headline e descricao...');
        g('comp-criativos-visuais', 'criativos.visuais', 'Regras: pouco texto na imagem, cor chamativa, rosto humano, before/after, UGC style, mockups, thumbnail de video com gancho...');
        g('comp-criativos-testes_criativo', 'criativos.testes_criativo', 'DCT (Dynamic Creative Testing), testar 3-5 variacoes, isolar variaveis (imagem vs copy), metricas para decidir vencedor (CTR, CPA)...');

        g('comp-otimizacao-ads-kpis', 'otimizacao-ads.kpis', 'CPM, CPC, CTR, CPA (custo por aquisicao), ROAS (retorno sobre gasto), frequencia, alcance, hook rate (3s video views), hold rate...');
        g('comp-otimizacao-ads-diaria', 'otimizacao-ads.diaria', 'Rotina: verificar CPA vs meta, pausar ads com CPA alto, escalar ads vencedores, monitorar frequencia, ajustar orcamento...');
        g('comp-otimizacao-ads-escala', 'otimizacao-ads.escala', 'Como escalar: aumento gradual de orcamento (20% a cada 3 dias), duplicar conjuntos vencedores, novos publicos, horizontal scaling...');
        g('comp-otimizacao-ads-diagnostico', 'otimizacao-ads.diagnostico', 'CPM alto: publico saturado ou nicho caro. CTR baixo: criativo fraco. CPA alto: landing page ou oferta. Queda de performance: fadiga de anuncio...');

        g('comp-remarketing-funil', 'remarketing.funil', 'Topo: visitou o site. Meio: visualizou produto/adicionou ao carrinho. Fundo: iniciou checkout. Janelas de tempo por etapa...');
        g('comp-remarketing-sequencia', 'remarketing.sequencia', 'Dia 1-3: lembrete do produto. Dia 4-7: beneficios e diferenciais. Dia 8-14: depoimentos e prova social. Dia 15-30: oferta especial...');
        g('comp-remarketing-crosssell', 'remarketing.crosssell', 'Remarketing para compradores: produtos complementares, upgrades, novidades, lancamentos, programa de fidelidade...');
        g('comp-remarketing-dpa', 'remarketing.dpa', 'Catalogo de produtos configurado, feed atualizado, template de anuncio dinamico, segmentacao por comportamento de navegacao...');

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
