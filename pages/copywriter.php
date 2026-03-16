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
<title>Copywriter — Induzi</title>
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
            <h1>Copywriter</h1>
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

        <!-- 1. PUV -->
        <div class="doc-section" id="section-puv">
            <div class="doc-section-header" onclick="toggleSection('puv')">
                <span class="doc-section-badge" id="badge-puv">0/5</span>
                <h3>Proposta Unica de Valor (PUV)</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina o que torna seu negocio unico. A PUV e a promessa central que diferencia voce da concorrencia.</p>
                <div class="doc-field"><label>Qual e o produto/servico principal?</label><div id="comp-puv-produto"></div></div>
                <div class="doc-field"><label>Para quem e? (publico-alvo resumido)</label><div id="comp-puv-publico"></div></div>
                <div class="doc-field"><label>Qual o diferencial competitivo?</label><div id="comp-puv-diferencial"></div></div>
                <div class="doc-field"><label>Qual a transformacao/resultado prometido?</label><div id="comp-puv-transformacao"></div></div>
                <div class="doc-field"><label>PUV final (uma frase)</label><div id="comp-puv-frase"></div></div>
            </div>
        </div>

        <!-- 2. Persona -->
        <div class="doc-section" id="section-persona">
            <div class="doc-section-header" onclick="toggleSection('persona')">
                <span class="doc-section-badge" id="badge-persona">0/7</span>
                <h3>Persona e Publico-Alvo</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Construa o perfil detalhado do seu cliente ideal. Quanto mais especifico, melhor sera sua comunicacao.</p>
                <div class="doc-field"><label>Nome da persona</label><div id="comp-persona-nome"></div></div>
                <div class="doc-field"><label>Idade e dados demograficos</label><div id="comp-persona-demografico"></div></div>
                <div class="doc-field"><label>Profissao / cargo / atividade</label><div id="comp-persona-profissao"></div></div>
                <div class="doc-field"><label>Principais dores e problemas</label><div id="comp-persona-dores"></div></div>
                <div class="doc-field"><label>Desejos e objetivos</label><div id="comp-persona-desejos"></div></div>
                <div class="doc-field"><label>Objecoes mais comuns</label><div id="comp-persona-objecoes"></div></div>
                <div class="doc-field"><label>Onde busca informacao?</label><div id="comp-persona-canais"></div></div>
            </div>
        </div>

        <!-- 3. Tom de Voz -->
        <div class="doc-section" id="section-voz">
            <div class="doc-section-header" onclick="toggleSection('voz')">
                <span class="doc-section-badge" id="badge-voz">0/4</span>
                <h3>Tom de Voz da Marca</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina como sua marca fala. O tom de voz garante consistencia em toda comunicacao.</p>
                <div class="doc-field"><label>Descricao do tom de voz</label><div id="comp-voz-descricao"></div></div>
                <div class="doc-field"><label>Palavras e expressoes a USAR</label><div id="comp-voz-usar"></div></div>
                <div class="doc-field"><label>Palavras e expressoes a EVITAR</label><div id="comp-voz-evitar"></div></div>
                <div class="doc-field"><label>Exemplos de frases no tom ideal</label><div id="comp-voz-exemplo"></div></div>
            </div>
        </div>

        <!-- 4. Headlines -->
        <div class="doc-section" id="section-headlines">
            <div class="doc-section-header" onclick="toggleSection('headlines')">
                <span class="doc-section-badge" id="badge-headlines">0/4</span>
                <h3>Headlines e Titulos</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Crie titulos que capturam atencao. Headlines sao o elemento mais importante de qualquer copy.</p>
                <div class="doc-field"><label>Headlines principais</label><div id="comp-headlines-principal"></div></div>
                <div class="doc-field"><label>Sub-headlines</label><div id="comp-headlines-sub"></div></div>
                <div class="doc-field"><label>Headlines alternativas (para teste A/B)</label><div id="comp-headlines-alternativas"></div></div>
                <div class="doc-field"><label>Formulas de headline preferidas</label><div id="comp-headlines-formulas"></div></div>
            </div>
        </div>

        <!-- 5. Landing Page -->
        <div class="doc-section" id="section-landing">
            <div class="doc-section-header" onclick="toggleSection('landing')">
                <span class="doc-section-badge" id="badge-landing">0/5</span>
                <h3>Landing Page</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planeje os elementos da sua landing page ou pagina de vendas.</p>
                <div class="doc-field"><label>Elementos do hero / banner</label><div id="comp-landing-hero"></div></div>
                <div class="doc-field"><label>Lista de beneficios</label><div id="comp-landing-beneficios"></div></div>
                <div class="doc-field"><label>Prova social / depoimentos</label><div id="comp-landing-prova_social"></div></div>
                <div class="doc-field"><label>CTAs da pagina</label><div id="comp-landing-cta"></div></div>
                <div class="doc-field"><label>Elementos de urgencia / escassez</label><div id="comp-landing-urgencia"></div></div>
            </div>
        </div>

        <!-- 6. Email Marketing -->
        <div class="doc-section" id="section-email">
            <div class="doc-section-header" onclick="toggleSection('email')">
                <span class="doc-section-badge" id="badge-email">0/4</span>
                <h3>Email Marketing</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Crie os textos base para suas campanhas de email, desde boas-vindas ate nurturing.</p>
                <div class="doc-field"><label>Assuntos de email</label><div id="comp-email-assunto"></div></div>
                <div class="doc-field"><label>Topicos do email de boas-vindas</label><div id="comp-email-corpo"></div></div>
                <div class="doc-field"><label>Sequencia de nurturing</label><div id="comp-email-sequencia"></div></div>
                <div class="doc-field"><label>Templates de assuntos</label><div id="comp-email-templates"></div></div>
            </div>
        </div>

        <!-- 7. Redes Sociais -->
        <div class="doc-section" id="section-redes">
            <div class="doc-section-header" onclick="toggleSection('redes')">
                <span class="doc-section-badge" id="badge-redes">0/4</span>
                <h3>Redes Sociais</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina a estrategia de conteudo e comunicacao para suas redes sociais.</p>
                <div class="doc-field"><label>Elementos da bio</label><div id="comp-redes-bio"></div></div>
                <div class="doc-field"><label>Tipos de conteudo e formatos</label><div id="comp-redes-conteudo"></div></div>
                <div class="doc-field"><label>Hashtags principais</label><div id="comp-redes-hashtags"></div></div>
                <div class="doc-field"><label>Frequencia e calendario</label><div id="comp-redes-frequencia"></div></div>
            </div>
        </div>

        <!-- 8. Storytelling -->
        <div class="doc-section" id="section-storytelling">
            <div class="doc-section-header" onclick="toggleSection('storytelling')">
                <span class="doc-section-badge" id="badge-storytelling">0/3</span>
                <h3>Storytelling</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente as historias que conectam sua marca ao publico. Boas narrativas geram confianca e emocao.</p>
                <div class="doc-field"><label>Historia da marca / fundador</label><div id="comp-storytelling-marca"></div></div>
                <div class="doc-field"><label>Jornada do cliente (antes e depois)</label><div id="comp-storytelling-jornada"></div></div>
                <div class="doc-field"><label>Casos de sucesso</label><div id="comp-storytelling-casos"></div></div>
            </div>
        </div>

        <!-- 9. Objecoes e FAQ -->
        <div class="doc-section" id="section-objecoes">
            <div class="doc-section-header" onclick="toggleSection('objecoes')">
                <span class="doc-section-badge" id="badge-objecoes">0/2</span>
                <h3>Objecoes e FAQ</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Antecipe e responda as duvidas e resistencias do seu publico. Isso fortalece a conversao.</p>
                <div class="doc-field"><label>Objecoes comuns e respostas</label><div id="comp-objecoes-objecoes"></div></div>
                <div class="doc-field"><label>Perguntas frequentes (FAQ)</label><div id="comp-objecoes-faq"></div></div>
            </div>
        </div>

        <!-- 10. CTAs e Conversao -->
        <div class="doc-section" id="section-cta">
            <div class="doc-section-header" onclick="toggleSection('cta')">
                <span class="doc-section-badge" id="badge-cta">0/4</span>
                <h3>CTAs e Conversao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Defina os chamados para acao e elementos que impulsionam a conversao.</p>
                <div class="doc-field"><label>CTAs principais</label><div id="comp-cta-principal"></div></div>
                <div class="doc-field"><label>CTAs secundarios</label><div id="comp-cta-secundarios"></div></div>
                <div class="doc-field"><label>Gatilhos de urgencia</label><div id="comp-cta-gatilhos"></div></div>
                <div class="doc-field"><label>Garantias oferecidas</label><div id="comp-cta-garantias"></div></div>
            </div>
        </div>

    </div>
</div>
<script src="../js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script>
(function() {
    var DATA_KEY = 'induziCopywriter';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['copywriter']) || {};

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

    window.exportarModulo = async function() {
        for (var key in _components) { var p = key.split('.'); if (!_data[p[0]]) _data[p[0]] = {}; _data[p[0]][p[1]] = _components[key].getValue(); }
        var projeto = InduziAuth.getCurrentProject();
        var exportData = { _induzi: true, modulo: 'Copywriter', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-copywriter-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        _components['puv.produto'] = InduziComponents.guided(document.getElementById('comp-puv-produto'), Object.assign({ onChange: onChange, placeholder: 'Adicionar aspecto do produto...' }, presets['puv.produto'] || {}));
        _components['puv.publico'] = InduziComponents.guided(document.getElementById('comp-puv-publico'), Object.assign({ onChange: onChange, placeholder: 'Adicionar caracteristica do publico...' }, presets['puv.publico'] || {}));
        _components['puv.diferencial'] = InduziComponents.guided(document.getElementById('comp-puv-diferencial'), Object.assign({ onChange: onChange, placeholder: 'Adicionar diferencial...' }, presets['puv.diferencial'] || {}));
        _components['puv.transformacao'] = InduziComponents.guided(document.getElementById('comp-puv-transformacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar resultado prometido...' }, presets['puv.transformacao'] || {}));
        _components['puv.frase'] = InduziComponents.guided(document.getElementById('comp-puv-frase'), Object.assign({ onChange: onChange, placeholder: 'Adicionar frase da PUV... (Enter)' }, presets['puv.frase'] || {}));

        _components['persona.nome'] = InduziComponents.guided(document.getElementById('comp-persona-nome'), Object.assign({ onChange: onChange, placeholder: 'Adicionar nome... (Enter)' }, presets['persona.nome'] || {}));
        _components['persona.demografico'] = InduziComponents.guided(document.getElementById('comp-persona-demografico'), Object.assign({ onChange: onChange, placeholder: 'Adicionar dado demografico... (Enter)' }, presets['persona.demografico'] || {}));
        _components['persona.profissao'] = InduziComponents.guided(document.getElementById('comp-persona-profissao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar profissao/cargo... (Enter)' }, presets['persona.profissao'] || {}));
        _components['persona.dores'] = InduziComponents.guided(document.getElementById('comp-persona-dores'), Object.assign({ onChange: onChange, placeholder: 'Adicionar dor... (Enter)' }, presets['persona.dores'] || {}));
        _components['persona.desejos'] = InduziComponents.guided(document.getElementById('comp-persona-desejos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar desejo... (Enter)' }, presets['persona.desejos'] || {}));
        _components['persona.objecoes'] = InduziComponents.guided(document.getElementById('comp-persona-objecoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar objecao... (Enter)' }, presets['persona.objecoes'] || {}));
        _components['persona.canais'] = InduziComponents.multiSelect(document.getElementById('comp-persona-canais'), {
            options: [
                { value: 'Instagram', label: 'Instagram' }, { value: 'YouTube', label: 'YouTube' }, { value: 'TikTok', label: 'TikTok' },
                { value: 'LinkedIn', label: 'LinkedIn' }, { value: 'Blog', label: 'Blog' }, { value: 'Google', label: 'Google' },
                { value: 'WhatsApp', label: 'WhatsApp' }, { value: 'Telegram', label: 'Telegram' }, { value: 'Podcast', label: 'Podcast' }, { value: 'X/Twitter', label: 'X/Twitter' }
            ], onChange: onChange
        });

        _components['voz.descricao'] = InduziComponents.guided(document.getElementById('comp-voz-descricao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar caracteristica do tom...' }, presets['voz.descricao'] || {}));
        _components['voz.usar'] = InduziComponents.guided(document.getElementById('comp-voz-usar'), Object.assign({ onChange: onChange, placeholder: 'Adicionar palavra/expressao... (Enter)' }, presets['voz.usar'] || {}));
        _components['voz.evitar'] = InduziComponents.guided(document.getElementById('comp-voz-evitar'), Object.assign({ onChange: onChange, placeholder: 'Adicionar palavra/expressao... (Enter)' }, presets['voz.evitar'] || {}));
        _components['voz.exemplo'] = InduziComponents.guided(document.getElementById('comp-voz-exemplo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar exemplo de frase...' }, presets['voz.exemplo'] || {}));

        _components['headlines.principal'] = InduziComponents.guided(document.getElementById('comp-headlines-principal'), Object.assign({ onChange: onChange, placeholder: 'Adicionar headline... (Enter)' }, presets['headlines.principal'] || {}));
        _components['headlines.sub'] = InduziComponents.guided(document.getElementById('comp-headlines-sub'), Object.assign({ onChange: onChange, placeholder: 'Adicionar sub-headline... (Enter)' }, presets['headlines.sub'] || {}));
        _components['headlines.alternativas'] = InduziComponents.guided(document.getElementById('comp-headlines-alternativas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar headline alternativa... (Enter)' }, presets['headlines.alternativas'] || {}));
        _components['headlines.formulas'] = InduziComponents.guided(document.getElementById('comp-headlines-formulas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar formula...' }, presets['headlines.formulas'] || {}));

        _components['landing.hero'] = InduziComponents.guided(document.getElementById('comp-landing-hero'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento do hero...' }, presets['landing.hero'] || {}));
        _components['landing.beneficios'] = InduziComponents.guided(document.getElementById('comp-landing-beneficios'), Object.assign({ onChange: onChange, placeholder: 'Adicionar beneficio...' }, presets['landing.beneficios'] || {}));
        _components['landing.prova_social'] = InduziComponents.guided(document.getElementById('comp-landing-prova_social'), Object.assign({ onChange: onChange, placeholder: 'Adicionar depoimento/prova...' }, presets['landing.prova_social'] || {}));
        _components['landing.cta'] = InduziComponents.guided(document.getElementById('comp-landing-cta'), Object.assign({ onChange: onChange, placeholder: 'Adicionar CTA... (Enter)' }, presets['landing.cta'] || {}));
        _components['landing.urgencia'] = InduziComponents.guided(document.getElementById('comp-landing-urgencia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar elemento de urgencia...' }, presets['landing.urgencia'] || {}));

        _components['email.assunto'] = InduziComponents.guided(document.getElementById('comp-email-assunto'), Object.assign({ onChange: onChange, placeholder: 'Adicionar assunto... (Enter)' }, presets['email.assunto'] || {}));
        _components['email.corpo'] = InduziComponents.guided(document.getElementById('comp-email-corpo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar topico do email...' }, presets['email.corpo'] || {}));
        _components['email.sequencia'] = InduziComponents.guided(document.getElementById('comp-email-sequencia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar email da sequencia...' }, presets['email.sequencia'] || {}));
        _components['email.templates'] = InduziComponents.guided(document.getElementById('comp-email-templates'), Object.assign({ onChange: onChange, placeholder: 'Adicionar template de assunto... (Enter)' }, presets['email.templates'] || {}));

        _components['redes.bio'] = InduziComponents.guided(document.getElementById('comp-redes-bio'), Object.assign({ onChange: onChange, placeholder: 'Adicionar linha da bio...' }, presets['redes.bio'] || {}));
        _components['redes.conteudo'] = InduziComponents.multiSelect(document.getElementById('comp-redes-conteudo'), {
            options: [
                { value: 'Carrosseis', label: 'Carrosseis' }, { value: 'Reels', label: 'Reels' }, { value: 'Stories', label: 'Stories' },
                { value: 'Posts', label: 'Posts' }, { value: 'Lives', label: 'Lives' }, { value: 'Threads', label: 'Threads' }
            ], onChange: onChange
        });
        _components['redes.hashtags'] = InduziComponents.guided(document.getElementById('comp-redes-hashtags'), Object.assign({ onChange: onChange, placeholder: 'Adicionar hashtag... (Enter)' }, presets['redes.hashtags'] || {}));
        _components['redes.frequencia'] = InduziComponents.guided(document.getElementById('comp-redes-frequencia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar dia/frequencia...' }, presets['redes.frequencia'] || {}));

        _components['storytelling.marca'] = InduziComponents.guided(document.getElementById('comp-storytelling-marca'), Object.assign({ onChange: onChange, placeholder: 'Adicionar ponto da historia...' }, presets['storytelling.marca'] || {}));
        _components['storytelling.jornada'] = InduziComponents.guided(document.getElementById('comp-storytelling-jornada'), Object.assign({ onChange: onChange, placeholder: 'Adicionar etapa da jornada...' }, presets['storytelling.jornada'] || {}));
        _components['storytelling.casos'] = InduziComponents.guided(document.getElementById('comp-storytelling-casos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar caso de sucesso...' }, presets['storytelling.casos'] || {}));

        _components['objecoes.objecoes'] = InduziComponents.keyValue(document.getElementById('comp-objecoes-objecoes'), { keyLabel: 'Objecao', valueLabel: 'Resposta', onChange: onChange });
        _components['objecoes.faq'] = InduziComponents.keyValue(document.getElementById('comp-objecoes-faq'), { keyLabel: 'Pergunta', valueLabel: 'Resposta', onChange: onChange });

        _components['cta.principal'] = InduziComponents.guided(document.getElementById('comp-cta-principal'), Object.assign({ onChange: onChange, placeholder: 'Adicionar CTA principal... (Enter)' }, presets['cta.principal'] || {}));
        _components['cta.secundarios'] = InduziComponents.guided(document.getElementById('comp-cta-secundarios'), Object.assign({ onChange: onChange, placeholder: 'Adicionar CTA secundario... (Enter)' }, presets['cta.secundarios'] || {}));
        _components['cta.gatilhos'] = InduziComponents.guided(document.getElementById('comp-cta-gatilhos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar gatilho... (Enter)' }, presets['cta.gatilhos'] || {}));
        _components['cta.garantias'] = InduziComponents.guided(document.getElementById('comp-cta-garantias'), Object.assign({ onChange: onChange, placeholder: 'Adicionar garantia...' }, presets['cta.garantias'] || {}));

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
