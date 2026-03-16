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
<title>Painel — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<style>
.page-header-compact { margin-bottom: 28px; }
.page-header-compact h1 { font-size: 1.4rem; font-weight: 700; color: var(--color-black); }
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}
.dash-card {
    background: var(--color-white);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    padding: 28px 24px;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}
.dash-card:hover {
    border-color: var(--color-accent, #7c3aed);
    box-shadow: 0 4px 12px rgba(124,58,237,0.1);
    transform: translateY(-2px);
}
.dash-card-icon {
    width: 40px;
    height: 40px;
    color: var(--color-gray);
    margin-bottom: 16px;
}
.dash-card-icon svg { width: 100%; height: 100%; }
.dash-card h3 { font-size: 1rem; font-weight: 600; color: var(--color-black); margin-bottom: 6px; }
.dash-card p { font-size: 0.82rem; color: var(--color-gray); line-height: 1.5; }
.dash-card-progress { position: absolute; top: 16px; right: 42px; font-size: 0.75rem; font-weight: 600; color: var(--color-gray-light); }
.dash-section-title { font-size: 1.05rem; font-weight: 600; color: var(--color-gray); margin-bottom: 16px; }
.project-config-card {
    background: var(--color-white);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    padding: 28px;
}
.project-config-card h3 { font-size: 1.05rem; font-weight: 600; color: var(--color-black); margin-bottom: 20px; }
.config-form-group { margin-bottom: 16px; }
.config-form-group label { display: block; font-size: 0.78rem; font-weight: 500; color: var(--color-gray); margin-bottom: 5px; }
.config-form-group input,
.config-form-group textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    font-size: 0.9rem;
    font-family: inherit;
    background: var(--color-bg-card);
    color: var(--color-gray-dark);
    transition: border-color 0.15s;
    box-sizing: border-box;
}
.config-form-group input:focus,
.config-form-group textarea:focus { outline: none; border-color: var(--color-gray-dark); }
.config-form-group textarea { min-height: 80px; resize: vertical; }
.config-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
@media (max-width: 600px) { .config-form-row { grid-template-columns: 1fr; } }
</style>
</head>
<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="container">

        <div class="page-header-compact">
            <h1 id="dashProjectName">Painel</h1>
        </div>

        <div class="dashboard-grid">

            <div class="dash-card" data-route="branding" data-url="branding.php" data-tooltip="Defina a essencia, personalidade e identidade visual da marca">
                <span class="dash-card-progress" id="progress-branding"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </div>
                <h3>Branding</h3>
                <p>Identidade visual e marca</p>
            </div>

            <div class="dash-card" data-route="copywriter" data-url="copywriter.php" data-tooltip="Planeje PUV, persona, tom de voz, CTAs e conteudo persuasivo">
                <span class="dash-card-progress" id="progress-copywriter"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                </div>
                <h3>Copywriter</h3>
                <p>Guia de copy e conteudo</p>
            </div>

            <div class="dash-card" data-route="estrutura" data-url="estrutura.php" data-tooltip="Arquitetura, layout, tipografia e componentes do site">
                <span class="dash-card-progress" id="progress-estrutura"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="3" y1="9" x2="21" y2="9"></line>
                        <line x1="9" y1="21" x2="9" y2="9"></line>
                    </svg>
                </div>
                <h3>Estrutura</h3>
                <p>Estrutura e arquitetura do site</p>
            </div>

            <div class="dash-card" data-route="seguranca" data-url="seguranca.php" data-tooltip="HTTPS, LGPD, protecao DDoS, backups e boas praticas">
                <span class="dash-card-progress" id="progress-seguranca"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3>Seguranca</h3>
                <p>Seguranca e boas praticas</p>
            </div>

            <div class="dash-card" data-route="seo" data-url="seo.php" data-tooltip="Palavras-chave, SEO on-page, tecnico, local e link building">
                <span class="dash-card-progress" id="progress-seo"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <h3>SEO</h3>
                <p>Otimizacao para buscadores</p>
            </div>

            <div class="dash-card" data-route="conteudo" data-url="conteudo.php" data-tooltip="Estrategia de conteudo, calendario editorial, blog e formatos">
                <span class="dash-card-progress" id="progress-conteudo"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <h3>Conteudo</h3>
                <p>Estrategia de conteudo e blog</p>
            </div>

            <div class="dash-card" data-route="ux-design" data-url="ux-design.php" data-tooltip="Usabilidade, jornada do usuario, responsividade e testes">
                <span class="dash-card-progress" id="progress-ux-design"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                </div>
                <h3>UX Design</h3>
                <p>Experiencia do usuario e design</p>
            </div>

            <div class="dash-card" data-route="performance" data-url="performance.php" data-tooltip="Core Web Vitals, cache, CDN, otimizacao de imagens e codigo">
                <span class="dash-card-progress" id="progress-performance"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
                <h3>Performance</h3>
                <p>Velocidade e otimizacao</p>
            </div>

            <div class="dash-card" data-route="acessibilidade" data-url="acessibilidade.php" data-tooltip="WCAG, ARIA, navegacao por teclado, contraste e conformidade">
                <span class="dash-card-progress" id="progress-acessibilidade"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="8" r="1"></circle>
                        <path d="M12 12v4"></path>
                        <path d="M8 14h8"></path>
                    </svg>
                </div>
                <h3>Acessibilidade</h3>
                <p>Inclusao e conformidade WCAG</p>
            </div>

            <div class="dash-card" data-route="infraestrutura" data-url="infraestrutura.php" data-tooltip="Hospedagem, DNS, SSL, backups, deploy e monitoramento">
                <span class="dash-card-progress" id="progress-infraestrutura"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                    </svg>
                </div>
                <h3>Infraestrutura</h3>
                <p>Hospedagem, DNS e deploy</p>
            </div>

            <div class="dash-card" data-route="analytics" data-url="analytics.php" data-tooltip="GA4, GTM, Search Console, eventos, funis e KPIs">
                <span class="dash-card-progress" id="progress-analytics"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                </div>
                <h3>Analytics</h3>
                <p>Metricas e dados do site</p>
            </div>

            <div class="dash-card" data-route="cro" data-url="cro.php" data-tooltip="Taxa de conversao, landing pages, testes A/B e gatilhos mentais">
                <span class="dash-card-progress" id="progress-cro"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h3>CRO</h3>
                <p>Otimizacao de conversao</p>
            </div>

        </div>

        <h2 class="dash-section-title">Trafego e Marketing</h2>
        <div class="dashboard-grid">

            <div class="dash-card" data-route="google-ads" data-url="google-ads.php" data-tooltip="Campanhas Search, Shopping, Display, YouTube e Performance Max">
                <span class="dash-card-progress" id="progress-google-ads"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                </div>
                <h3>Google Ads</h3>
                <p>Campanhas e anuncios no Google</p>
            </div>

            <div class="dash-card" data-route="meta-ads" data-url="meta-ads.php" data-tooltip="Facebook e Instagram Ads, Pixel, publicos e remarketing">
                <span class="dash-card-progress" id="progress-meta-ads"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                </div>
                <h3>Meta Ads</h3>
                <p>Facebook e Instagram Ads</p>
            </div>

            <div class="dash-card" data-route="email-marketing" data-url="email-marketing.php" data-tooltip="Captacao de leads, automacao, newsletters e metricas">
                <span class="dash-card-progress" id="progress-email-marketing"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h3>Email Marketing</h3>
                <p>Leads, automacao e newsletters</p>
            </div>

            <div class="dash-card" data-route="redes-sociais" data-url="redes-sociais.php" data-tooltip="Instagram, TikTok, YouTube, LinkedIn e calendario de posts">
                <span class="dash-card-progress" id="progress-redes-sociais"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                </div>
                <h3>Redes Sociais</h3>
                <p>Estrategia e gestao social</p>
            </div>

        </div>

        <h2 class="dash-section-title">Marketplaces</h2>
        <div class="dashboard-grid">

            <div class="dash-card" data-route="shopee" data-url="shopee.php" data-tooltip="Cadastro de produtos, fotos, precificacao e estrategias de venda">
                <span class="dash-card-progress" id="progress-shopee"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h3>Shopee</h3>
                <p>Guia para vender na Shopee</p>
            </div>

            <div class="dash-card" data-route="mercado-livre" data-url="mercado-livre.php" data-tooltip="Conta, anuncios, precificacao, Mercado Envios e estrategias de venda">
                <span class="dash-card-progress" id="progress-mercado-livre"></span>
                <div class="dash-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>
                <h3>Mercado Livre</h3>
                <p>Guia para vender no Mercado Livre</p>
            </div>

        </div>

        <div class="project-config-card" style="margin-bottom:20px;">
            <h3>Progresso ao Longo do Tempo</h3>
            <div id="progressChartContainer" style="width:100%;overflow-x:auto;">
                <svg id="progressChart" width="100%" height="200" style="min-width:400px;"></svg>
            </div>
            <div id="progressChartLegend" style="display:flex;gap:16px;flex-wrap:wrap;margin-top:12px;font-size:0.78rem;color:var(--color-gray);"></div>
        </div>

        <div class="project-config-card" style="margin-bottom:20px;">
            <h3>Dados do Projeto</h3>
            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                <button class="btn-action" onclick="exportFullProject()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Exportar Projeto Completo</button>
                <label class="btn-action" style="cursor:pointer;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg> Importar Projeto<input type="file" accept=".json" style="display:none;" onchange="importFullProject(this)"></label>
                <button class="btn-action" onclick="InduziExportDoc.exportarProjeto()" data-tooltip="Exporta todos os modulos preenchidos como Markdown para uso com IA"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Exportar Documentacao</button>
            </div>
        </div>

        <div class="project-config-card">
            <h3>Configuracoes do Projeto</h3>
            <div class="config-form-row">
                <div class="config-form-group">
                    <label for="cfgUrl" data-tooltip="URL principal do projeto para referencia">URL do site</label>
                    <input type="text" id="cfgUrl" placeholder="https://exemplo.com.br">
                </div>
                <div class="config-form-group">
                    <label for="cfgNicho" data-tooltip="Area de atuacao do projeto (ex: e-commerce, saude, educacao)">Nicho / Segmento</label>
                    <input type="text" id="cfgNicho" placeholder="Ex: E-commerce de roupas">
                </div>
            </div>
            <div class="config-form-group">
                <label for="cfgNotas">Notas rapidas</label>
                <textarea id="cfgNotas" placeholder="Anotacoes sobre o projeto..."></textarea>
            </div>
            <button class="btn btn-primary" onclick="saveProjectConfig()" style="margin-top: 4px;">Salvar configuracoes</button>
        </div>

    </div>
</div>
<script>
(function() {
    // Load project name
    var project = InduziAuth.getCurrentProject();
    if (project) {
        document.getElementById('dashProjectName').textContent = project.nome;
    }

    // Module cards click -> SPA navigate
    document.querySelectorAll('.dash-card[data-route]').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.pin-btn')) return;
            if (window.SpaRouter) SpaRouter.go(this.dataset.route);
            else window.location.href = this.dataset.url;
        });
        // Add pin button
        var route = card.dataset.route;
        var pinBtn = document.createElement('button');
        pinBtn.className = 'pin-btn';
        pinBtn.title = 'Favoritar';
        pinBtn.style.cssText = 'position:absolute;top:12px;right:12px;background:none;border:none;cursor:pointer;color:var(--color-gray-light);padding:4px;transition:color 0.15s;';
        pinBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';
        pinBtn.dataset.route = route;
        pinBtn.addEventListener('click', async function(e) {
            e.stopPropagation();
            var favs = await InduziAuth.toggleFavorito(this.dataset.route);
            updatePinStates();
        });
        card.appendChild(pinBtn);
    });

    function updatePinStates() {
        var favs = InduziAuth.getFavoritos();
        document.querySelectorAll('.pin-btn').forEach(function(btn) {
            var isFav = favs.indexOf(btn.dataset.route) >= 0;
            btn.style.color = isFav ? 'var(--color-accent)' : 'var(--color-gray-light)';
            btn.querySelector('svg').setAttribute('fill', isFav ? 'var(--color-accent)' : 'none');
        });
        InduziAuth._renderFavoritos();
    }
    updatePinStates();

    // Load/save project config
    async function loadConfig() {
        var data = await InduziDB.load('induziConfig');
        if (data) {
            document.getElementById('cfgUrl').value = data.url || '';
            document.getElementById('cfgNicho').value = data.nicho || '';
            document.getElementById('cfgNotas').value = data.notas || '';
        }
    }

    async function saveConfig() {
        var config = {
            url: document.getElementById('cfgUrl').value.trim(),
            nicho: document.getElementById('cfgNicho').value.trim(),
            notas: document.getElementById('cfgNotas').value.trim()
        };
        var result = await InduziDB.save('induziConfig', config);
        if (result && result.ok) Igris.toast('Configuracoes salvas!', 'success');
        else Igris.toast('Erro ao salvar', 'error');
    }

    window.saveProjectConfig = saveConfig;

    window.exportFullProject = async function() {
        try {
            var base = InduziDB._getApiBase();
            var resp = await fetch(base + 'data/export-all.php?_t=' + Date.now(), { cache: 'no-store', credentials: 'same-origin' });
            var data = await resp.json();
            if (!data.ok) { Igris.toast('Erro ao exportar', 'error'); return; }
            var blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = (data.project.nome || 'projeto') + '_export.json';
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
            URL.revokeObjectURL(url);
            Igris.toast('Projeto exportado!', 'success');
        } catch (e) { Igris.toast('Erro ao exportar', 'error'); }
    };

    window.importFullProject = async function(input) {
        var file = input.files[0];
        if (!file) return;
        try {
            var text = await file.text();
            var importData = JSON.parse(text);
            if (!importData.data) { Igris.toast('Arquivo invalido', 'error'); return; }
            if (!await Igris.confirm('Importar dados? Os dados atuais dos modulos importados serao substituidos.')) { input.value = ''; return; }
            var count = 0;
            for (var key in importData.data) {
                var val = importData.data[key].value !== undefined ? importData.data[key].value : importData.data[key];
                var result = await InduziDB.save(key, val);
                if (result) count++;
            }
            Igris.toast(count + ' modulo(s) importado(s)!', 'success');
            input.value = '';
        } catch (e) { Igris.toast('Erro ao importar: arquivo invalido', 'error'); input.value = ''; }
    };

    loadConfig();

    // Load progress for each module (counts filled fields)
    async function loadProgress() {
        var modules = ['induziCopywriter', 'induziEstrutura', 'induziSeguranca', 'induziSeo', 'induziBranding', 'induziGoogleAds', 'induziShopee', 'induziMercadoLivre', 'induziPerformance', 'induziAnalytics', 'induziUxDesign', 'induziAcessibilidade', 'induziConteudo', 'induziCro', 'induziEmailMarketing', 'induziRedesSociais', 'induziMetaAds', 'induziInfraestrutura'];
        var routes = ['copywriter', 'estrutura', 'seguranca', 'seo', 'branding', 'google-ads', 'shopee', 'mercado-livre', 'performance', 'analytics', 'ux-design', 'acessibilidade', 'conteudo', 'cro', 'email-marketing', 'redes-sociais', 'meta-ads', 'infraestrutura'];
        for (var i = 0; i < modules.length; i++) {
            var data = await InduziDB.load(modules[i]);
            var el = document.getElementById('progress-' + routes[i]);
            if (el && data) {
                var total = 0, done = 0;
                for (var section in data) {
                    if (typeof data[section] === 'object' && data[section] !== null) {
                        for (var field in data[section]) {
                            total++;
                            if (data[section][field] && String(data[section][field]).trim()) done++;
                        }
                    }
                }
                var pct = total > 0 ? Math.round(done / total * 100) : 0;
                el.textContent = pct + '%';
                el.style.color = pct === 100 ? 'var(--color-success)' : 'var(--color-gray-light)';
            }
        }
    }
    loadProgress();

    // Save progress snapshot (1 per day, max 365)
    async function saveProgressSnapshot() {
        var modules = ['induziCopywriter', 'induziEstrutura', 'induziSeguranca', 'induziSeo', 'induziBranding', 'induziGoogleAds', 'induziShopee', 'induziMercadoLivre', 'induziPerformance', 'induziAnalytics', 'induziUxDesign', 'induziAcessibilidade', 'induziConteudo', 'induziCro', 'induziEmailMarketing', 'induziRedesSociais', 'induziMetaAds', 'induziInfraestrutura'];
        var labels = ['Copywriter', 'Estrutura', 'Seguranca', 'SEO', 'Branding', 'Google Ads', 'Shopee', 'Mercado Livre', 'Performance', 'Analytics', 'UX Design', 'Acessibilidade', 'Conteudo', 'CRO', 'Email Marketing', 'Redes Sociais', 'Meta Ads', 'Infraestrutura'];
        var moduleProgress = {};
        var totalPct = 0, totalCount = 0;
        for (var i = 0; i < modules.length; i++) {
            var data = await InduziDB.load(modules[i]);
            var total = 0, done = 0;
            if (data) {
                for (var section in data) {
                    if (typeof data[section] === 'object' && data[section] !== null) {
                        for (var field in data[section]) { total++; if (data[section][field] && String(data[section][field]).trim()) done++; }
                    }
                }
            }
            var pct = total > 0 ? Math.round(done / total * 100) : 0;
            moduleProgress[labels[i].toLowerCase().replace(/ /g, '')] = pct;
            totalPct += pct;
            totalCount++;
        }
        var overall = totalCount > 0 ? Math.round(totalPct / totalCount) : 0;
        var today = new Date().toISOString().slice(0, 10);

        var history = await InduziDB.load('induziProgressHistory', []);
        if (!Array.isArray(history)) history = [];
        var lastEntry = history.length > 0 ? history[history.length - 1] : null;
        if (lastEntry && lastEntry.date === today) {
            lastEntry.modules = moduleProgress;
            lastEntry.overall = overall;
        } else {
            history.push({ date: today, modules: moduleProgress, overall: overall });
        }
        if (history.length > 365) history = history.slice(-365);
        await InduziDB.save('induziProgressHistory', history);
        renderChart(history);
    }

    function renderChart(history) {
        var svg = document.getElementById('progressChart');
        var legend = document.getElementById('progressChartLegend');
        if (!svg || !history || history.length < 1) {
            if (svg) svg.innerHTML = '<text x="50%" y="50%" text-anchor="middle" fill="var(--color-gray-light)" font-size="14">Dados insuficientes</text>';
            return;
        }
        var w = Math.max(400, history.length * 40);
        svg.setAttribute('width', w);
        var h = 180, pad = 30, gw = w - pad * 2, gh = h - pad * 2;
        var html = '';

        // Grid lines
        for (var g = 0; g <= 4; g++) {
            var gy = pad + gh - (g / 4) * gh;
            html += '<line x1="' + pad + '" y1="' + gy + '" x2="' + (pad + gw) + '" y2="' + gy + '" stroke="var(--color-border)" stroke-width="0.5"/>';
            html += '<text x="' + (pad - 4) + '" y="' + (gy + 4) + '" text-anchor="end" fill="var(--color-gray-light)" font-size="10">' + (g * 25) + '%</text>';
        }

        // Overall line
        var points = [];
        for (var i = 0; i < history.length; i++) {
            var x = pad + (i / Math.max(1, history.length - 1)) * gw;
            var y = pad + gh - (history[i].overall / 100) * gh;
            points.push(x + ',' + y);
        }
        html += '<polyline points="' + points.join(' ') + '" fill="none" stroke="var(--color-accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>';

        // Dots
        for (var j = 0; j < history.length; j++) {
            var dx = pad + (j / Math.max(1, history.length - 1)) * gw;
            var dy = pad + gh - (history[j].overall / 100) * gh;
            html += '<circle cx="' + dx + '" cy="' + dy + '" r="3.5" fill="var(--color-accent)"/>';
            if (history.length <= 15) {
                html += '<text x="' + dx + '" y="' + (h - 4) + '" text-anchor="middle" fill="var(--color-gray-light)" font-size="9">' + history[j].date.slice(5) + '</text>';
            }
        }

        svg.innerHTML = html;
        if (legend) legend.innerHTML = '<span style="display:flex;align-items:center;gap:4px;"><span style="width:12px;height:3px;background:var(--color-accent);border-radius:2px;"></span> Progresso geral</span>';
    }

    saveProgressSnapshot();

    window._spaCleanup = function() {};
})();
</script>
<?php if (!isset($_GET['fragment'])): ?>
</div></body></html>
<?php endif; ?>
<?php spaFragmentEnd(); ?>
