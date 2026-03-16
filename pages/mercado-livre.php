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
<title>Mercado Livre — Induzi</title>
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
            <h1>Mercado Livre</h1>
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

        <!-- 1. Configuracao da Conta -->
        <div class="doc-section" id="section-conta">
            <div class="doc-section-header" onclick="toggleSection('conta')">
                <span class="doc-section-badge" id="badge-conta">0/5</span>
                <h3>Configuracao da Conta</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Configure os dados essenciais da sua conta no Mercado Livre: nome da loja, identidade visual e tipo de conta.</p>
                <div class="doc-field"><label>Nome da loja</label><div id="comp-conta-nome"></div></div>
                <div class="doc-field"><label>Descricao da loja</label><div id="comp-conta-descricao"></div></div>
                <div class="doc-field">
                    <label>Logo e banner (imagens)</label>
                    <div id="comp-conta-logo"></div>
                    <div class="field-hint">Imagens de perfil e banner ajudam a transmitir profissionalismo e confianca</div>
                </div>
                <div class="doc-field"><label>Reputacao-alvo</label><div id="comp-conta-reputacao"></div></div>
                <div class="doc-field"><label>Tipo de conta</label><div id="comp-conta-tipo"></div></div>
            </div>
        </div>

        <!-- 2. Cadastro de Anuncios -->
        <div class="doc-section" id="section-anuncios">
            <div class="doc-section-header" onclick="toggleSection('anuncios')">
                <span class="doc-section-badge" id="badge-anuncios">0/4</span>
                <h3>Cadastro de Anuncios</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina os templates e padroes para criar anuncios consistentes e otimizados no Mercado Livre.</p>
                <div class="doc-field">
                    <label>Elementos do titulo</label>
                    <div id="comp-anuncios-template_titulo"></div>
                    <div class="field-hint">O titulo e o fator #1 para aparecer nas buscas. Use ate 60 caracteres com palavras-chave relevantes.</div>
                </div>
                <div class="doc-field"><label>Template da descricao</label><div id="comp-anuncios-template_descricao"></div></div>
                <div class="doc-field"><label>Variantes e SKUs</label><div id="comp-anuncios-variantes"></div></div>
                <div class="doc-field">
                    <label>Ficha tecnica</label>
                    <div id="comp-anuncios-ficha_tecnica"></div>
                    <div class="field-hint">Ficha tecnica completa melhora o posicionamento e reduz perguntas de compradores</div>
                </div>
            </div>
        </div>

        <!-- 3. Fotos e Videos -->
        <div class="doc-section" id="section-fotos">
            <div class="doc-section-header" onclick="toggleSection('fotos')">
                <span class="doc-section-badge" id="badge-fotos">0/4</span>
                <h3>Fotos e Videos</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente os padroes visuais para fotos e videos dos seus anuncios no Mercado Livre.</p>
                <div class="doc-field">
                    <label>Especificacoes de imagem</label>
                    <div id="comp-fotos-especificacoes"></div>
                    <div class="field-hint">Minimo 1200x1200px, fundo branco, sem marcas d'agua. Ate 12 imagens por anuncio.</div>
                </div>
                <div class="doc-field"><label>Checklist de fotos por produto</label><div id="comp-fotos-checklist"></div></div>
                <div class="doc-field"><label>Videos do produto</label><div id="comp-fotos-videos"></div></div>
                <div class="doc-field"><label>Ferramentas de edicao</label><div id="comp-fotos-edicao"></div></div>
            </div>
        </div>

        <!-- 4. Precificacao e Taxas -->
        <div class="doc-section" id="section-preco">
            <div class="doc-section-header" onclick="toggleSection('preco')">
                <span class="doc-section-badge" id="badge-preco">0/4</span>
                <h3>Precificacao e Taxas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina sua estrategia de precificacao considerando taxas do Mercado Livre, custos e margens.</p>
                <div class="doc-field">
                    <label>Formula de precificacao</label>
                    <div id="comp-preco-formula"></div>
                    <div class="field-hint">Inclua custo do produto, taxa ML (11-16%), frete, embalagem e margem desejada</div>
                </div>
                <div class="doc-field"><label>Margem e custos</label><div id="comp-preco-margem"></div></div>
                <div class="doc-field"><label>Estrategia de promocoes</label><div id="comp-preco-promocoes"></div></div>
                <div class="doc-field"><label>Analise de precos concorrentes</label><div id="comp-preco-concorrencia"></div></div>
            </div>
        </div>

        <!-- 5. SEO no Mercado Livre -->
        <div class="doc-section" id="section-seo">
            <div class="doc-section-header" onclick="toggleSection('seo')">
                <span class="doc-section-badge" id="badge-seo">0/4</span>
                <h3>SEO no Mercado Livre</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Otimize a visibilidade dos seus anuncios na busca do Mercado Livre com palavras-chave e ficha tecnica.</p>
                <div class="doc-field"><label>Palavras-chave principais</label><div id="comp-seo-palavras_chave"></div></div>
                <div class="doc-field">
                    <label>Titulo otimizado</label>
                    <div id="comp-seo-titulo_otimizado"></div>
                    <div class="field-hint">Formato ideal: Produto + Marca + Modelo + Caracteristica principal + Variante</div>
                </div>
                <div class="doc-field"><label>Ficha tecnica para SEO</label><div id="comp-seo-ficha_tecnica"></div></div>
                <div class="doc-field"><label>Perguntas frequentes</label><div id="comp-seo-perguntas"></div></div>
            </div>
        </div>

        <!-- 6. Tipos de Anuncio -->
        <div class="doc-section" id="section-tipos">
            <div class="doc-section-header" onclick="toggleSection('tipos')">
                <span class="doc-section-badge" id="badge-tipos">0/4</span>
                <h3>Tipos de Anuncio</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Entenda as diferencas entre Classico e Premium, catalogo e estrategias de listagem.</p>
                <div class="doc-field">
                    <label>Classico vs Premium</label>
                    <div id="comp-tipos-comparacao"></div>
                    <div class="field-hint">Premium tem mais exposicao mas taxa maior. Classico e ideal para produtos de menor margem.</div>
                </div>
                <div class="doc-field"><label>Regras por tipo de anuncio</label><div id="comp-tipos-regras"></div></div>
                <div class="doc-field"><label>Catalogo Mercado Livre</label><div id="comp-tipos-catalogo"></div></div>
                <div class="doc-field"><label>Estrategia de listagem</label><div id="comp-tipos-estrategia"></div></div>
            </div>
        </div>

        <!-- 7. Mercado Envios e Logistica -->
        <div class="doc-section" id="section-logistica">
            <div class="doc-section-header" onclick="toggleSection('logistica')">
                <span class="doc-section-badge" id="badge-logistica">0/4</span>
                <h3>Mercado Envios e Logistica</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje as modalidades de envio, embalagem e prazos para sua operacao no Mercado Livre.</p>
                <div class="doc-field">
                    <label>Modalidades de envio</label>
                    <div id="comp-logistica-modalidades"></div>
                    <div class="field-hint">Full tem maior conversao por oferecer entrega rapida e frete gratis acima de R$79</div>
                </div>
                <div class="doc-field"><label>Checklist de embalagem</label><div id="comp-logistica-embalagem"></div></div>
                <div class="doc-field"><label>Prazos por modalidade</label><div id="comp-logistica-prazos"></div></div>
                <div class="doc-field"><label>Regras de frete</label><div id="comp-logistica-frete"></div></div>
            </div>
        </div>

        <!-- 8. Atendimento e Reputacao -->
        <div class="doc-section" id="section-atendimento">
            <div class="doc-section-header" onclick="toggleSection('atendimento')">
                <span class="doc-section-badge" id="badge-atendimento">0/4</span>
                <h3>Atendimento e Reputacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente seus processos de atendimento, tempos de resposta e gestao de reclamacoes.</p>
                <div class="doc-field">
                    <label>Respostas padrao</label>
                    <div id="comp-atendimento-respostas"></div>
                    <div class="field-hint">Responder perguntas rapidamente melhora a reputacao e aumenta a taxa de conversao</div>
                </div>
                <div class="doc-field"><label>Tempos de resposta</label><div id="comp-atendimento-tempo"></div></div>
                <div class="doc-field"><label>Pos-venda</label><div id="comp-atendimento-pos_venda"></div></div>
                <div class="doc-field"><label>Gestao de reclamacoes</label><div id="comp-atendimento-reclamacoes"></div></div>
            </div>
        </div>

        <!-- 9. Mercado Ads -->
        <div class="doc-section" id="section-ads">
            <div class="doc-section-header" onclick="toggleSection('ads')">
                <span class="doc-section-badge" id="badge-ads">0/4</span>
                <h3>Mercado Ads</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje seus investimentos em Mercado Ads: Product Ads, segmentacao e otimizacao.</p>
                <div class="doc-field"><label>Orcamento por campanha</label><div id="comp-ads-orcamento"></div></div>
                <div class="doc-field">
                    <label>Product Ads</label>
                    <div id="comp-ads-product_ads"></div>
                    <div class="field-hint">Product Ads posiciona seus anuncios no topo dos resultados de busca do Mercado Livre</div>
                </div>
                <div class="doc-field"><label>Segmentacao</label><div id="comp-ads-segmentacao"></div></div>
                <div class="doc-field"><label>Otimizacao de campanhas</label><div id="comp-ads-otimizacao"></div></div>
            </div>
        </div>

        <!-- 10. Metricas e Analise -->
        <div class="doc-section" id="section-metricas">
            <div class="doc-section-header" onclick="toggleSection('metricas')">
                <span class="doc-section-badge" id="badge-metricas">0/4</span>
                <h3>Metricas e Analise</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Acompanhe os indicadores de desempenho da sua loja e defina metas e planos de acao.</p>
                <div class="doc-field"><label>KPIs principais</label><div id="comp-metricas-kpis"></div></div>
                <div class="doc-field"><label>Metas mensais</label><div id="comp-metricas-metas"></div></div>
                <div class="doc-field"><label>Relatorios</label><div id="comp-metricas-relatorios"></div></div>
                <div class="doc-field"><label>Plano de acao</label><div id="comp-metricas-acoes"></div></div>
            </div>
        </div>

        <!-- 11. Regras e Politicas -->
        <div class="doc-section" id="section-regras">
            <div class="doc-section-header" onclick="toggleSection('regras')">
                <span class="doc-section-badge" id="badge-regras">0/4</span>
                <h3>Regras e Politicas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente as politicas do Mercado Livre, regras de publicacao e boas praticas para evitar penalidades.</p>
                <div class="doc-field">
                    <label>Politicas proibidas</label>
                    <div id="comp-regras-proibidas"></div>
                    <div class="field-hint">Violacoes de politica podem resultar em suspensao temporaria ou permanente da conta</div>
                </div>
                <div class="doc-field"><label>Regras de publicacao</label><div id="comp-regras-publicacao"></div></div>
                <div class="doc-field"><label>Penalidades</label><div id="comp-regras-penalidades"></div></div>
                <div class="doc-field"><label>Boas praticas</label><div id="comp-regras-boas_praticas"></div></div>
            </div>
        </div>

        <!-- 12. Estrategias de Crescimento -->
        <div class="doc-section" id="section-crescimento">
            <div class="doc-section-header" onclick="toggleSection('crescimento')">
                <span class="doc-section-badge" id="badge-crescimento">0/4</span>
                <h3>Estrategias de Crescimento</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje estrategias para escalar vendas, kits, MercadoLider e fidelizacao de clientes.</p>
                <div class="doc-field"><label>Estrategia de escala</label><div id="comp-crescimento-escala"></div></div>
                <div class="doc-field"><label>Cross-sell e kits</label><div id="comp-crescimento-cross_sell"></div></div>
                <div class="doc-field">
                    <label>MercadoLider</label>
                    <div id="comp-crescimento-mercadolider"></div>
                    <div class="field-hint">MercadoLider oferece mais visibilidade, selo de confianca e beneficios exclusivos</div>
                </div>
                <div class="doc-field"><label>Fidelizacao</label><div id="comp-crescimento-fidelizacao"></div></div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziMercadoLivre';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['mercado-livre']) || {};

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

    function kv(id, key, kl, vl) {
        var el = document.getElementById(id);
        if (!el) return;
        _components[key] = InduziComponents.keyValue(el, { keyLabel: kl, valueLabel: vl, onChange: onChange });
    }

    function ms(id, key, opts) {
        var el = document.getElementById(id);
        if (!el) return;
        _components[key] = InduziComponents.multiSelect(el, { options: opts, onChange: onChange });
    }

    function dz(id, key, accept, max) {
        var el = document.getElementById(id);
        if (!el) return;
        _components[key] = InduziComponents.dropzone(el, { accept: accept, maxFiles: max, onChange: onChange });
    }

    window.exportarModulo = async function() {
        for (var key in _components) { var p = key.split('.'); if (!_data[p[0]]) _data[p[0]] = {}; _data[p[0]][p[1]] = _components[key].getValue(); }
        var projeto = InduziAuth.getCurrentProject();
        var exportData = { _induzi: true, modulo: 'Mercado Livre', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-mercado-livre-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        // 1. Configuracao da Conta
        g('comp-conta-nome', 'conta.nome', 'Adicionar nome da loja...');
        g('comp-conta-descricao', 'conta.descricao', 'Adicionar ponto da descricao...');
        dz('comp-conta-logo', 'conta.logo', 'image/*', 5);
        g('comp-conta-reputacao', 'conta.reputacao', 'Adicionar meta de reputacao...');
        g('comp-conta-tipo', 'conta.tipo', 'Adicionar info do tipo de conta...');

        // 2. Cadastro de Anuncios
        g('comp-anuncios-template_titulo', 'anuncios.template_titulo', 'Adicionar elemento do titulo...');
        g('comp-anuncios-template_descricao', 'anuncios.template_descricao', 'Adicionar secao da descricao...');
        g('comp-anuncios-variantes', 'anuncios.variantes', 'Adicionar variante...');
        kv('comp-anuncios-ficha_tecnica', 'anuncios.ficha_tecnica', 'Atributo', 'Valor');

        // 3. Fotos e Videos
        g('comp-fotos-especificacoes', 'fotos.especificacoes', 'Adicionar spec de imagem...');
        g('comp-fotos-checklist', 'fotos.checklist', 'Adicionar tipo de foto...');
        g('comp-fotos-videos', 'fotos.videos', 'Adicionar spec de video...');
        g('comp-fotos-edicao', 'fotos.edicao', 'Adicionar ferramenta...');

        // 4. Precificacao e Taxas
        kv('comp-preco-formula', 'preco.formula', 'Item', 'Valor/Percentual');
        kv('comp-preco-margem', 'preco.margem', 'Custo', 'Valor');
        ms('comp-preco-promocoes', 'preco.promocoes', [
            { value: 'Oferta do Dia', label: 'Oferta do Dia' },
            { value: 'Desconto ML', label: 'Desconto ML' },
            { value: 'Cupom', label: 'Cupom' },
            { value: 'Frete Gratis', label: 'Frete Gratis' },
            { value: 'Combo', label: 'Combo' }
        ]);
        kv('comp-preco-concorrencia', 'preco.concorrencia', 'Concorrente', 'Preco');

        // 5. SEO no Mercado Livre
        g('comp-seo-palavras_chave', 'seo.palavras_chave', 'Adicionar keyword...');
        g('comp-seo-titulo_otimizado', 'seo.titulo_otimizado', 'Adicionar dica de titulo...');
        g('comp-seo-ficha_tecnica', 'seo.ficha_tecnica', 'Adicionar atributo de ficha tecnica...');
        g('comp-seo-perguntas', 'seo.perguntas', 'Adicionar pergunta frequente...');

        // 6. Tipos de Anuncio
        kv('comp-tipos-comparacao', 'tipos.comparacao', 'Caracteristica', 'Classico / Premium');
        g('comp-tipos-regras', 'tipos.regras', 'Adicionar regra...');
        g('comp-tipos-catalogo', 'tipos.catalogo', 'Adicionar info do catalogo...');
        g('comp-tipos-estrategia', 'tipos.estrategia', 'Adicionar estrategia de listagem...');

        // 7. Mercado Envios e Logistica
        ms('comp-logistica-modalidades', 'logistica.modalidades', [
            { value: 'Correios', label: 'Correios' },
            { value: 'Full', label: 'Full' },
            { value: 'Flex', label: 'Flex' },
            { value: 'Agencia', label: 'Agencia' },
            { value: 'Coleta', label: 'Coleta' }
        ]);
        g('comp-logistica-embalagem', 'logistica.embalagem', 'Adicionar item de embalagem...');
        kv('comp-logistica-prazos', 'logistica.prazos', 'Modalidade', 'Prazo');
        g('comp-logistica-frete', 'logistica.frete', 'Adicionar regra de frete...');

        // 8. Atendimento e Reputacao
        kv('comp-atendimento-respostas', 'atendimento.respostas', 'Situacao', 'Resposta');
        kv('comp-atendimento-tempo', 'atendimento.tempo', 'Situacao', 'Prazo');
        g('comp-atendimento-pos_venda', 'atendimento.pos_venda', 'Adicionar acao pos-venda...');
        g('comp-atendimento-reclamacoes', 'atendimento.reclamacoes', 'Adicionar processo de reclamacao...');

        // 9. Mercado Ads
        kv('comp-ads-orcamento', 'ads.orcamento', 'Campanha', 'Valor');
        g('comp-ads-product_ads', 'ads.product_ads', 'Adicionar config de Product Ads...');
        g('comp-ads-segmentacao', 'ads.segmentacao', 'Adicionar regra de segmentacao...');
        g('comp-ads-otimizacao', 'ads.otimizacao', 'Adicionar acao de otimizacao...');

        // 10. Metricas e Analise
        g('comp-metricas-kpis', 'metricas.kpis', 'Adicionar KPI...');
        kv('comp-metricas-metas', 'metricas.metas', 'Metrica', 'Meta');
        g('comp-metricas-relatorios', 'metricas.relatorios', 'Adicionar relatorio...');
        g('comp-metricas-acoes', 'metricas.acoes', 'Adicionar acao...');

        // 11. Regras e Politicas
        g('comp-regras-proibidas', 'regras.proibidas', 'Adicionar politica proibida...');
        g('comp-regras-publicacao', 'regras.publicacao', 'Adicionar regra de publicacao...');
        g('comp-regras-penalidades', 'regras.penalidades', 'Adicionar penalidade...');
        g('comp-regras-boas_praticas', 'regras.boas_praticas', 'Adicionar boa pratica...');

        // 12. Estrategias de Crescimento
        g('comp-crescimento-escala', 'crescimento.escala', 'Adicionar estrategia de escala...');
        g('comp-crescimento-cross_sell', 'crescimento.cross_sell', 'Adicionar estrategia de cross-sell/kit...');
        g('comp-crescimento-mercadolider', 'crescimento.mercadolider', 'Adicionar meta MercadoLider...');
        g('comp-crescimento-fidelizacao', 'crescimento.fidelizacao', 'Adicionar acao de fidelizacao...');

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
