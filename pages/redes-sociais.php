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
<title>Redes Sociais — Induzi</title>
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
            <h1>Redes Sociais</h1>
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

        <!-- 1. Estrategia de Redes Sociais -->
        <div class="doc-section" id="section-estrategia-social">
            <div class="doc-section-header" onclick="toggleSection('estrategia-social')">
                <span class="doc-section-badge" id="badge-estrategia-social">0/4</span>
                <h3>Estrategia de Redes Sociais</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Estar nas redes sociais sem estrategia e desperdicar tempo e dinheiro. Defina objetivos claros antes de criar conteudo.</p>
                <div class="doc-field">
                    <label>Objetivos</label>
                    <div id="comp-estrategia-social-objetivos"></div>
                </div>
                <div class="doc-field">
                    <label>Plataformas escolhidas</label>
                    <div id="comp-estrategia-social-plataformas"></div>
                </div>
                <div class="doc-field">
                    <label>Publico-alvo</label>
                    <div id="comp-estrategia-social-publico"></div>
                </div>
                <div class="doc-field">
                    <label>Tom e personalidade</label>
                    <div id="comp-estrategia-social-tom"></div>
                </div>
            </div>
        </div>

        <!-- 2. Instagram -->
        <div class="doc-section" id="section-instagram">
            <div class="doc-section-header" onclick="toggleSection('instagram')">
                <span class="doc-section-badge" id="badge-instagram">0/4</span>
                <h3>Instagram</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Principal rede social para marcas no Brasil. Domine os formatos e o algoritmo para maximizar alcance e engajamento.</p>
                <div class="doc-field">
                    <label>Perfil e bio</label>
                    <div id="comp-instagram-perfil"></div>
                </div>
                <div class="doc-field">
                    <label>Feed e estetica</label>
                    <div id="comp-instagram-feed"></div>
                </div>
                <div class="doc-field">
                    <label>Stories e Reels</label>
                    <div id="comp-instagram-stories_reels"></div>
                </div>
                <div class="doc-field">
                    <label>Hashtags e legenda</label>
                    <div id="comp-instagram-hashtags"></div>
                </div>
            </div>
        </div>

        <!-- 3. TikTok e YouTube -->
        <div class="doc-section" id="section-tiktok-youtube">
            <div class="doc-section-header" onclick="toggleSection('tiktok-youtube')">
                <span class="doc-section-badge" id="badge-tiktok-youtube">0/4</span>
                <h3>TikTok e YouTube</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Video e o formato de maior crescimento. TikTok para descoberta rapida, YouTube para conteudo longo e busca.</p>
                <div class="doc-field">
                    <label>TikTok</label>
                    <div id="comp-tiktok-youtube-tiktok"></div>
                </div>
                <div class="doc-field">
                    <label>YouTube longo</label>
                    <div id="comp-tiktok-youtube-youtube_longo"></div>
                </div>
                <div class="doc-field">
                    <label>YouTube Shorts</label>
                    <div id="comp-tiktok-youtube-shorts"></div>
                </div>
                <div class="doc-field">
                    <label>Metricas de video</label>
                    <div id="comp-tiktok-youtube-metricas_video"></div>
                </div>
            </div>
        </div>

        <!-- 4. LinkedIn -->
        <div class="doc-section" id="section-linkedin">
            <div class="doc-section-header" onclick="toggleSection('linkedin')">
                <span class="doc-section-badge" id="badge-linkedin">0/4</span>
                <h3>LinkedIn</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">A rede profissional por excelencia. Ideal para B2B, autoridade e networking estrategico.</p>
                <div class="doc-field">
                    <label>Company page</label>
                    <div id="comp-linkedin-company"></div>
                </div>
                <div class="doc-field">
                    <label>Conteudo e formatos</label>
                    <div id="comp-linkedin-conteudo_li"></div>
                </div>
                <div class="doc-field">
                    <label>Perfil dos lideres</label>
                    <div id="comp-linkedin-lideres"></div>
                </div>
                <div class="doc-field">
                    <label>Networking e engajamento</label>
                    <div id="comp-linkedin-networking"></div>
                </div>
            </div>
        </div>

        <!-- 5. Calendario e Producao -->
        <div class="doc-section" id="section-calendario-social">
            <div class="doc-section-header" onclick="toggleSection('calendario-social')">
                <span class="doc-section-badge" id="badge-calendario-social">0/4</span>
                <h3>Calendario e Producao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Planejar com antecedencia evita a 'paralisia do post' e garante consistencia na presenca digital.</p>
                <div class="doc-field">
                    <label>Calendario de publicacao</label>
                    <div id="comp-calendario-social-calendario"></div>
                </div>
                <div class="doc-field">
                    <label>Pilares de conteudo</label>
                    <div id="comp-calendario-social-pilares"></div>
                </div>
                <div class="doc-field">
                    <label>Ferramentas de gestao</label>
                    <div id="comp-calendario-social-ferramentas"></div>
                </div>
                <div class="doc-field">
                    <label>Processo de criacao</label>
                    <div id="comp-calendario-social-processo"></div>
                </div>
            </div>
        </div>

        <!-- 6. Integracao com o Site -->
        <div class="doc-section" id="section-integracao-site">
            <div class="doc-section-header" onclick="toggleSection('integracao-site')">
                <span class="doc-section-badge" id="badge-integracao-site">0/4</span>
                <h3>Integracao com o Site</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">As redes sociais devem trabalhar em conjunto com o site, direcionando trafego e fortalecendo a presenca online.</p>
                <div class="doc-field">
                    <label>Open Graph e meta tags</label>
                    <div id="comp-integracao-site-opengraph"></div>
                </div>
                <div class="doc-field">
                    <label>Botoes de compartilhamento</label>
                    <div id="comp-integracao-site-share"></div>
                </div>
                <div class="doc-field">
                    <label>Feed social no site</label>
                    <div id="comp-integracao-site-feed_site"></div>
                </div>
                <div class="doc-field">
                    <label>Pixel e tracking</label>
                    <div id="comp-integracao-site-pixel"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziRedesSociais';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['redes-sociais']) || {};

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
        var exportData = { _induzi: true, modulo: 'Redes Sociais', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-redes-sociais-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-estrategia-social-objetivos', 'estrategia-social.objetivos', 'Objetivos nas redes: awareness, trafego para o site, geracao de leads, vendas diretas, relacionamento, suporte ao cliente...');
        g('comp-estrategia-social-plataformas', 'estrategia-social.plataformas', 'Quais redes usar e por que: Instagram, TikTok, YouTube, LinkedIn, Facebook, Pinterest, Twitter/X. Onde o publico esta...');
        g('comp-estrategia-social-publico', 'estrategia-social.publico', 'Quem seguir/atrair em cada rede: dados demograficos, interesses, comportamento, horarios online, tipo de conteudo que consome...');
        g('comp-estrategia-social-tom', 'estrategia-social.tom', 'Como a marca se comunica nas redes: informal, educativa, divertida, inspiradora. Diferenca de tom por plataforma, do\'s e don\'ts...');

        g('comp-instagram-perfil', 'instagram.perfil', 'Foto de perfil (logo), bio otimizada com proposta de valor, link na bio (Linktree ou similar), destaques organizados por tema...');
        g('comp-instagram-feed', 'instagram.feed', 'Identidade visual do feed, paleta de cores, templates Canva/Figma, tipos de post (carrossel, imagem unica, video), proporcao de conteudo...');
        g('comp-instagram-stories_reels', 'instagram.stories_reels', 'Frequencia de stories, stickers interativos (enquete, quiz, perguntas), Reels com trends e audio viral, bastidores, tutoriais rapidos...');
        g('comp-instagram-hashtags', 'instagram.hashtags', 'Estrategia de hashtags: mix de volume (grande, medio, nicho), numero ideal (5-15), pesquisa de hashtags, legendas com CTA, emojis...');

        g('comp-tiktok-youtube-tiktok', 'tiktok-youtube.tiktok', 'Tipo de conteudo: trends, educativo, bastidores, humor. Duracao ideal, frequencia, sons em alta, hashtags, hook nos primeiros 3s...');
        g('comp-tiktok-youtube-youtube_longo', 'tiktok-youtube.youtube_longo', 'Canal: branding, banner, secoes, playlists. Videos longos: roteiro, thumbnail, titulo com keyword, descricao otimizada, end screens...');
        g('comp-tiktok-youtube-shorts', 'tiktok-youtube.shorts', 'Conteudo curto vertical, reaproveitamento de Reels/TikTok, frequencia, ideias recorrentes, como direcionar para videos longos...');
        g('comp-tiktok-youtube-metricas_video', 'tiktok-youtube.metricas_video', 'Views, tempo de retencao, taxa de clique (CTR da thumbnail), engajamento, inscritos, watch time, fontes de trafego...');

        g('comp-linkedin-company', 'linkedin.company', 'Pagina da empresa: logo, capa, descricao com keywords, especializacoes, showcase pages, convite para funcionarios seguirem...');
        g('comp-linkedin-conteudo_li', 'linkedin.conteudo_li', 'Posts de texto (storytelling), carrosseis PDF, artigos longos (newsletter), enquetes, videos nativos, lives. Frequencia ideal...');
        g('comp-linkedin-lideres', 'linkedin.lideres', 'LinkedIn pessoal dos fundadores/lideres como canal de marca, social selling, thought leadership, posts pessoais que reforcam a marca...');
        g('comp-linkedin-networking', 'linkedin.networking', 'Estrategia de conexoes, grupos relevantes, comentarios em posts estrategicos, mensagens diretas, InMail, eventos LinkedIn...');

        g('comp-calendario-social-calendario', 'calendario-social.calendario', 'Frequencia por rede, dias e horarios ideais, temas por dia da semana, sazonalidade, datas comemorativas relevantes...');
        g('comp-calendario-social-pilares', 'calendario-social.pilares', '3-5 categorias de conteudo que se repetem: educativo, bastidores, produto, depoimentos, entretenimento. Proporcao de cada um...');
        g('comp-calendario-social-ferramentas', 'calendario-social.ferramentas', 'Agendamento (mLabs, Hootsuite, Buffer, Meta Business Suite), criacao (Canva, CapCut), organizacao (Notion, Trello), banco de conteudo...');
        g('comp-calendario-social-processo', 'calendario-social.processo', 'Fluxo: brainstorm > briefing > criacao > aprovacao > agendamento > publicacao > engajamento. Responsaveis, prazos, batch content...');

        g('comp-integracao-site-opengraph', 'integracao-site.opengraph', 'og:title, og:description, og:image, og:type para cada pagina. Twitter Cards. Preview otimizado ao compartilhar links...');
        g('comp-integracao-site-share', 'integracao-site.share', 'Botoes de share em artigos/produtos, posicao (flutuante, inline, no final), redes incluidas, contador de shares...');
        g('comp-integracao-site-feed_site', 'integracao-site.feed_site', 'Widget de Instagram no site, depoimentos do Google, feed de tweets, galeria de UGC (conteudo gerado pelo usuario)...');
        g('comp-integracao-site-pixel', 'integracao-site.pixel', 'Meta Pixel, TikTok Pixel, LinkedIn Insight Tag instalados. Eventos rastreados, publicos de remarketing criados, UTMs nos links da bio...');

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
