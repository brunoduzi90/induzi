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
<title>CRO — Induzi</title>
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
            <h1>CRO</h1>
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

        <!-- 1. Fundamentos de CRO -->
        <div class="doc-section" id="section-fundamentos">
            <div class="doc-section-header" onclick="toggleSection('fundamentos')">
                <span class="doc-section-badge" id="badge-fundamentos">0/4</span>
                <h3>Fundamentos de CRO</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Entender os conceitos basicos de otimizacao de conversao e definir metas claras e o primeiro passo.</p>
                <div class="doc-field">
                    <label>Taxa de conversao atual</label>
                    <div id="comp-fundamentos-taxa_atual"></div>
                </div>
                <div class="doc-field">
                    <label>Metas de conversao</label>
                    <div id="comp-fundamentos-metas"></div>
                </div>
                <div class="doc-field">
                    <label>Micro e macro conversoes</label>
                    <div id="comp-fundamentos-micro_macro"></div>
                </div>
                <div class="doc-field">
                    <label>Framework de otimizacao</label>
                    <div id="comp-fundamentos-framework"></div>
                </div>
            </div>
        </div>

        <!-- 2. Landing Pages -->
        <div class="doc-section" id="section-landing">
            <div class="doc-section-header" onclick="toggleSection('landing')">
                <span class="doc-section-badge" id="badge-landing">0/4</span>
                <h3>Landing Pages</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Landing pages sao a porta de entrada para conversao. Cada elemento deve trabalhar para convencer o visitante a agir.</p>
                <div class="doc-field">
                    <label>Headline e proposta de valor</label>
                    <div id="comp-landing-headline"></div>
                </div>
                <div class="doc-field">
                    <label>Estrutura da pagina</label>
                    <div id="comp-landing-estrutura"></div>
                </div>
                <div class="doc-field">
                    <label>CTA (Call to Action)</label>
                    <div id="comp-landing-cta"></div>
                </div>
                <div class="doc-field">
                    <label>Elementos de confianca</label>
                    <div id="comp-landing-confianca"></div>
                </div>
            </div>
        </div>

        <!-- 3. Formularios Otimizados -->
        <div class="doc-section" id="section-formularios-cro">
            <div class="doc-section-header" onclick="toggleSection('formularios-cro')">
                <span class="doc-section-badge" id="badge-formularios-cro">0/4</span>
                <h3>Formularios Otimizados</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Cada campo adicional no formulario reduz a conversao. Simplifique ao maximo e remova toda friccao possivel.</p>
                <div class="doc-field">
                    <label>Campos essenciais</label>
                    <div id="comp-formularios-cro-campos"></div>
                </div>
                <div class="doc-field">
                    <label>UX do formulario</label>
                    <div id="comp-formularios-cro-ux"></div>
                </div>
                <div class="doc-field">
                    <label>Multi-step forms</label>
                    <div id="comp-formularios-cro-multistep"></div>
                </div>
                <div class="doc-field">
                    <label>Pagina de sucesso</label>
                    <div id="comp-formularios-cro-sucesso"></div>
                </div>
            </div>
        </div>

        <!-- 4. Gatilhos Mentais e Persuasao -->
        <div class="doc-section" id="section-gatilhos">
            <div class="doc-section-header" onclick="toggleSection('gatilhos')">
                <span class="doc-section-badge" id="badge-gatilhos">0/4</span>
                <h3>Gatilhos Mentais e Persuasao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Principios psicologicos que influenciam a decisao de compra. Use com etica para facilitar a tomada de decisao.</p>
                <div class="doc-field">
                    <label>Prova social</label>
                    <div id="comp-gatilhos-prova_social"></div>
                </div>
                <div class="doc-field">
                    <label>Urgencia e escassez</label>
                    <div id="comp-gatilhos-urgencia"></div>
                </div>
                <div class="doc-field">
                    <label>Autoridade</label>
                    <div id="comp-gatilhos-autoridade"></div>
                </div>
                <div class="doc-field">
                    <label>Reciprocidade e garantia</label>
                    <div id="comp-gatilhos-reciprocidade"></div>
                </div>
            </div>
        </div>

        <!-- 5. Testes A/B e Experimentacao -->
        <div class="doc-section" id="section-testes-cro">
            <div class="doc-section-header" onclick="toggleSection('testes-cro')">
                <span class="doc-section-badge" id="badge-testes-cro">0/4</span>
                <h3>Testes A/B e Experimentacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Testar hipoteses com dados reais e a unica forma confiavel de melhorar conversao. Opinioes nao vencem dados.</p>
                <div class="doc-field">
                    <label>Hipoteses</label>
                    <div id="comp-testes-cro-hipoteses"></div>
                </div>
                <div class="doc-field">
                    <label>Ferramenta de testes</label>
                    <div id="comp-testes-cro-ferramenta"></div>
                </div>
                <div class="doc-field">
                    <label>Processo de teste</label>
                    <div id="comp-testes-cro-processo"></div>
                </div>
                <div class="doc-field">
                    <label>Historico de testes</label>
                    <div id="comp-testes-cro-historico"></div>
                </div>
            </div>
        </div>

        <!-- 6. Analise e Diagnostico -->
        <div class="doc-section" id="section-analise-cro">
            <div class="doc-section-header" onclick="toggleSection('analise-cro')">
                <span class="doc-section-badge" id="badge-analise-cro">0/4</span>
                <h3>Analise e Diagnostico</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Antes de otimizar, e preciso diagnosticar. Ferramentas de analise comportamental revelam onde estao os problemas.</p>
                <div class="doc-field">
                    <label>Heatmaps</label>
                    <div id="comp-analise-cro-heatmaps"></div>
                </div>
                <div class="doc-field">
                    <label>Gravacoes de sessao</label>
                    <div id="comp-analise-cro-gravacoes"></div>
                </div>
                <div class="doc-field">
                    <label>Pesquisas on-site</label>
                    <div id="comp-analise-cro-pesquisas"></div>
                </div>
                <div class="doc-field">
                    <label>Auditoria de conversao</label>
                    <div id="comp-analise-cro-auditoria"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziCro';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['cro']) || {};

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
        var exportData = { _induzi: true, modulo: 'CRO', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-cro-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-fundamentos-taxa_atual', 'fundamentos.taxa_atual', 'Qual a taxa de conversao atual do site? Como e calculada? Baseline por pagina, por canal, por dispositivo...');
        g('comp-fundamentos-metas', 'fundamentos.metas', 'Quais as metas? Ex: aumentar conversao de 2% para 3.5%. Metas por funil, por pagina, timeline...');
        g('comp-fundamentos-micro_macro', 'fundamentos.micro_macro', 'Macro: compra, cadastro, contato. Micro: adicionar ao carrinho, clicar no CTA, assistir video, scroll ate o fim...');
        g('comp-fundamentos-framework', 'fundamentos.framework', 'Metodologia usada: PIE (Potential, Importance, Ease), ICE (Impact, Confidence, Ease), processo de priorizacao de testes...');

        g('comp-landing-headline', 'landing.headline', 'Headline clara e orientada a beneficio, subheadline de suporte, proposta de valor unica (UVP), acima da dobra...');
        g('comp-landing-estrutura', 'landing.estrutura', 'Secoes: hero > beneficios > como funciona > prova social > FAQ > CTA final. Fluxo logico de persuasao, hierarquia visual...');
        g('comp-landing-cta', 'landing.cta', 'Texto do botao orientado a acao, cor contrastante, tamanho adequado, posicao estrategica (acima da dobra + repeticao), urgencia...');
        g('comp-landing-confianca', 'landing.confianca', 'Depoimentos, logos de clientes, selos de seguranca, garantias, numeros/estatisticas, cases de sucesso, certificacoes...');

        g('comp-formularios-cro-campos', 'formularios-cro.campos', 'Quais campos sao realmente necessarios? Reduzir ao minimo. Nome + email vs formulario completo. Testes com menos campos...');
        g('comp-formularios-cro-ux', 'formularios-cro.ux', 'Labels claros, placeholders uteis, validacao inline, auto-focus no primeiro campo, teclado numerico para telefone, autocomplete...');
        g('comp-formularios-cro-multistep', 'formularios-cro.multistep', 'Dividir formularios longos em etapas, barra de progresso, salvar rascunho, logica condicional, campos dinamicos...');
        g('comp-formularios-cro-sucesso', 'formularios-cro.sucesso', 'Thank you page otimizada: confirmacao clara, proximos passos, upsell/cross-sell, compartilhamento social, tracking de conversao...');

        g('comp-gatilhos-prova_social', 'gatilhos.prova_social', 'Depoimentos reais com foto e nome, numero de clientes/vendas, avaliacoes e estrelas, logos de empresas, contadores em tempo real...');
        g('comp-gatilhos-urgencia', 'gatilhos.urgencia', 'Contadores regressivos, estoque limitado, vagas limitadas, preco por tempo limitado. IMPORTANTE: sempre usar com honestidade...');
        g('comp-gatilhos-autoridade', 'gatilhos.autoridade', 'Certificacoes, premios, mencoes na midia, parcerias, especialistas, anos de experiencia, numeros relevantes...');
        g('comp-gatilhos-reciprocidade', 'gatilhos.reciprocidade', 'Conteudo gratuito de valor, amostras, trial, garantia de devolucao, risco zero, politica de troca generosa...');

        g('comp-testes-cro-hipoteses', 'testes-cro.hipoteses', 'Lista de hipoteses para testar: "Se mudarmos X, esperamos Y porque Z". Priorizacao por impacto potencial e facilidade...');
        g('comp-testes-cro-ferramenta', 'testes-cro.ferramenta', 'Ferramenta usada: Google Optimize, VWO, Optimizely, AB Tasty. Configuracao, integracao com analytics, segmentacao...');
        g('comp-testes-cro-processo', 'testes-cro.processo', 'Duracao minima do teste, tamanho da amostra, significancia estatistica (95%), quando parar, como documentar resultados...');
        g('comp-testes-cro-historico', 'testes-cro.historico', 'Registro de testes realizados: hipotese, variantes, resultado, lift obtido, aprendizados. Repositorio de conhecimento...');

        g('comp-analise-cro-heatmaps', 'analise-cro.heatmaps', 'Mapas de calor de cliques, scroll e movimento. Ferramentas (Hotjar, Clarity, Crazy Egg). Paginas prioritarias para analisar...');
        g('comp-analise-cro-gravacoes', 'analise-cro.gravacoes', 'Gravacoes de sessao de usuarios reais, padroes de comportamento, pontos de confusao, rage clicks, hesitacoes...');
        g('comp-analise-cro-pesquisas', 'analise-cro.pesquisas', 'Pesquisas no site: "O que te impediu de comprar?", NPS, exit intent surveys, feedback pos-compra, enquetes rapidas...');
        g('comp-analise-cro-auditoria', 'analise-cro.auditoria', 'Checklist de auditoria: velocidade, mobile, copy, CTA, formularios, checkout, confianca, objecoes respondidas...');

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
