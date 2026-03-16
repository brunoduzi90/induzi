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
<title>Email Marketing — Induzi</title>
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
            <h1>Email Marketing</h1>
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

        <!-- 1. Captacao de Leads -->
        <div class="doc-section" id="section-captacao">
            <div class="doc-section-header" onclick="toggleSection('captacao')">
                <span class="doc-section-badge" id="badge-captacao">0/4</span>
                <h3>Captacao de Leads</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Construir uma lista de emails qualificada e o ativo mais valioso do marketing digital. Lista propria nao depende de algoritmo.</p>
                <div class="doc-field">
                    <label>Lead magnets</label>
                    <div id="comp-captacao-magnets"></div>
                </div>
                <div class="doc-field">
                    <label>Formularios de captacao</label>
                    <div id="comp-captacao-formularios"></div>
                </div>
                <div class="doc-field">
                    <label>Pop-ups e overlays</label>
                    <div id="comp-captacao-popups"></div>
                </div>
                <div class="doc-field">
                    <label>Landing pages de captacao</label>
                    <div id="comp-captacao-landing"></div>
                </div>
            </div>
        </div>

        <!-- 2. Gestao de Listas -->
        <div class="doc-section" id="section-listas">
            <div class="doc-section-header" onclick="toggleSection('listas')">
                <span class="doc-section-badge" id="badge-listas">0/4</span>
                <h3>Gestao de Listas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Uma lista limpa e bem segmentada vale mais que uma lista grande e desengajada. Qualidade supera quantidade.</p>
                <div class="doc-field">
                    <label>Segmentacao</label>
                    <div id="comp-listas-segmentacao"></div>
                </div>
                <div class="doc-field">
                    <label>Tags e categorias</label>
                    <div id="comp-listas-tags"></div>
                </div>
                <div class="doc-field">
                    <label>Higiene da lista</label>
                    <div id="comp-listas-higiene"></div>
                </div>
                <div class="doc-field">
                    <label>LGPD e conformidade</label>
                    <div id="comp-listas-lgpd"></div>
                </div>
            </div>
        </div>

        <!-- 3. Automacoes e Fluxos -->
        <div class="doc-section" id="section-automacao">
            <div class="doc-section-header" onclick="toggleSection('automacao')">
                <span class="doc-section-badge" id="badge-automacao">0/4</span>
                <h3>Automacoes e Fluxos</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Automacoes trabalham 24/7 nutrindo leads e conduzindo-os pelo funil ate a conversao.</p>
                <div class="doc-field">
                    <label>Welcome sequence</label>
                    <div id="comp-automacao-welcome"></div>
                </div>
                <div class="doc-field">
                    <label>Nurturing</label>
                    <div id="comp-automacao-nurturing"></div>
                </div>
                <div class="doc-field">
                    <label>Carrinho abandonado</label>
                    <div id="comp-automacao-carrinho"></div>
                </div>
                <div class="doc-field">
                    <label>Pos-venda</label>
                    <div id="comp-automacao-pos_venda"></div>
                </div>
            </div>
        </div>

        <!-- 4. Campanhas e Newsletters -->
        <div class="doc-section" id="section-campanhas">
            <div class="doc-section-header" onclick="toggleSection('campanhas')">
                <span class="doc-section-badge" id="badge-campanhas">0/4</span>
                <h3>Campanhas e Newsletters</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Campanhas pontuais e newsletters mantem sua marca na mente do assinante e geram vendas recorrentes.</p>
                <div class="doc-field">
                    <label>Newsletter</label>
                    <div id="comp-campanhas-newsletter"></div>
                </div>
                <div class="doc-field">
                    <label>Campanhas promocionais</label>
                    <div id="comp-campanhas-promocionais"></div>
                </div>
                <div class="doc-field">
                    <label>Emails transacionais</label>
                    <div id="comp-campanhas-transacionais"></div>
                </div>
                <div class="doc-field">
                    <label>Templates e design</label>
                    <div id="comp-campanhas-templates"></div>
                </div>
            </div>
        </div>

        <!-- 5. Metricas e Otimizacao -->
        <div class="doc-section" id="section-metricas-email">
            <div class="doc-section-header" onclick="toggleSection('metricas-email')">
                <span class="doc-section-badge" id="badge-metricas-email">0/4</span>
                <h3>Metricas e Otimizacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Acompanhar metricas permite identificar o que funciona e otimizar continuamente cada aspecto dos emails.</p>
                <div class="doc-field">
                    <label>Taxa de abertura</label>
                    <div id="comp-metricas-email-abertura"></div>
                </div>
                <div class="doc-field">
                    <label>Taxa de clique (CTR)</label>
                    <div id="comp-metricas-email-ctr"></div>
                </div>
                <div class="doc-field">
                    <label>Conversao e receita</label>
                    <div id="comp-metricas-email-conversao"></div>
                </div>
                <div class="doc-field">
                    <label>Deliverability</label>
                    <div id="comp-metricas-email-deliverability"></div>
                </div>
            </div>
        </div>

        <!-- 6. Ferramentas e Infraestrutura -->
        <div class="doc-section" id="section-ferramentas-email">
            <div class="doc-section-header" onclick="toggleSection('ferramentas-email')">
                <span class="doc-section-badge" id="badge-ferramentas-email">0/4</span>
                <h3>Ferramentas e Infraestrutura</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Escolher a ferramenta certa e configurar a infraestrutura de envio corretamente garante que seus emails cheguem na caixa de entrada.</p>
                <div class="doc-field">
                    <label>Plataforma de envio</label>
                    <div id="comp-ferramentas-email-plataforma"></div>
                </div>
                <div class="doc-field">
                    <label>Autenticacao de dominio</label>
                    <div id="comp-ferramentas-email-autenticacao"></div>
                </div>
                <div class="doc-field">
                    <label>Integracoes</label>
                    <div id="comp-ferramentas-email-integracoes"></div>
                </div>
                <div class="doc-field">
                    <label>Testes de email</label>
                    <div id="comp-ferramentas-email-testes"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziEmailMarketing';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['email-marketing']) || {};

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
        var exportData = { _induzi: true, modulo: 'Email Marketing', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-email-marketing-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-captacao-magnets', 'captacao.magnets', 'Materiais oferecidos em troca do email: e-book, checklist, template, planilha, mini-curso, desconto, trial gratuito...');
        g('comp-captacao-formularios', 'captacao.formularios', 'Posicao dos formularios: header, sidebar, inline no conteudo, footer, pop-up. Campos solicitados, design, copy do botao...');
        g('comp-captacao-popups', 'captacao.popups', 'Exit intent, scroll-triggered, time-delayed. Regras de exibicao, frequencia, mobile vs desktop, testes de variacao...');
        g('comp-captacao-landing', 'captacao.landing', 'Paginas dedicadas a captacao: headline, beneficios do material, preview, formulario simples, prova social...');

        g('comp-listas-segmentacao', 'listas.segmentacao', 'Criterios de segmentacao: interesse, comportamento, estagio do funil, frequencia de compra, localizacao, engajamento...');
        g('comp-listas-tags', 'listas.tags', 'Sistema de tags: por lead magnet baixado, paginas visitadas, produtos comprados, acoes realizadas, nivel de engajamento...');
        g('comp-listas-higiene', 'listas.higiene', 'Limpeza periodica: remover bounces, reengajar inativos (campanha win-back), remover nao-engajados apos X dias, verificacao de emails...');
        g('comp-listas-lgpd', 'listas.lgpd', 'Double opt-in, link de descadastro em todo email, politica de privacidade, base legal (consentimento), registro de consentimento...');

        g('comp-automacao-welcome', 'automacao.welcome', 'Sequencia de boas-vindas: email 1 (entrega + apresentacao), email 2 (valor + historia), email 3 (conteudo educativo), email 4 (oferta)...');
        g('comp-automacao-nurturing', 'automacao.nurturing', 'Fluxos de nutricao por segmento: conteudo educativo, cases, demonstracao de valor, quebra de objecoes, convite para acao...');
        g('comp-automacao-carrinho', 'automacao.carrinho', 'Sequencia de recuperacao: email 1 (1h - lembrete), email 2 (24h - beneficios), email 3 (48h - urgencia/desconto). Timing e copy...');
        g('comp-automacao-pos_venda', 'automacao.pos_venda', 'Confirmacao de compra, instrucoes de uso, pesquisa de satisfacao (NPS), pedido de avaliacao, cross-sell, programa de indicacao...');

        g('comp-campanhas-newsletter', 'campanhas.newsletter', 'Frequencia (semanal, quinzenal, mensal), formato, secoes fixas, conteudo curado vs original, dia e horario de envio...');
        g('comp-campanhas-promocionais', 'campanhas.promocionais', 'Black Friday, lancamentos, liquidacoes, datas comemorativas. Estrutura: teaser > lancamento > lembrete > ultima chance...');
        g('comp-campanhas-transacionais', 'campanhas.transacionais', 'Confirmacao de pedido, nota fiscal, rastreamento, atualizacao de senha. Oportunidade de branding e cross-sell...');
        g('comp-campanhas-templates', 'campanhas.templates', 'Template padrao da marca, header com logo, cores da marca, layout responsivo, largura maxima 600px, botoes grandes, alt em imagens...');

        g('comp-metricas-email-abertura', 'metricas-email.abertura', 'Open rate medio por tipo de campanha, impacto do iOS Mail Privacy, assunto do email (subject line), nome do remetente, pre-header...');
        g('comp-metricas-email-ctr', 'metricas-email.ctr', 'Click-through rate, CTOR (click-to-open rate), posicao dos links, CTA principal, heatmap de cliques no email...');
        g('comp-metricas-email-conversao', 'metricas-email.conversao', 'Taxa de conversao por email, receita por email enviado, receita de automacoes vs campanhas, ROI do email marketing...');
        g('comp-metricas-email-deliverability', 'metricas-email.deliverability', 'Taxa de entrega, bounce rate, spam complaints, reputacao do dominio, aquecimento de IP, blacklists, inbox placement...');

        g('comp-ferramentas-email-plataforma', 'ferramentas-email.plataforma', 'Ferramenta escolhida (Mailchimp, RD Station, ActiveCampaign, Brevo, ConvertKit), plano, limites, funcionalidades usadas...');
        g('comp-ferramentas-email-autenticacao', 'ferramentas-email.autenticacao', 'SPF, DKIM, DMARC configurados no DNS, dominio de envio dedicado, verificacao de configuracao, ferramentas de teste...');
        g('comp-ferramentas-email-integracoes', 'ferramentas-email.integracoes', 'Integracao com site (formularios), CRM, e-commerce, analytics (UTMs), Zapier/Make, APIs, webhooks...');
        g('comp-ferramentas-email-testes', 'ferramentas-email.testes', 'Teste de renderizacao (Litmus, Email on Acid), A/B test de subject line, preview em clientes de email, spam score check...');

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
