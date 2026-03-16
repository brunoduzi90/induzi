/**
 * InduziSearch — Busca Global (Ctrl+K)
 */
var InduziSearch = (function() {
    var overlay = null;
    var input = null;
    var resultsEl = null;
    var selectedIdx = -1;
    var filteredResults = [];

    var INDEX = [
        // Pages
        { label: 'Painel', route: 'painel', module: 'Painel', type: 'page' },
        { label: 'Projetos', route: 'projetos', module: 'Projetos', type: 'page' },
        { label: 'Icones SVG', route: 'icones', module: 'Icones', type: 'page' },
        { label: 'Configuracoes', route: 'configuracoes', module: 'Configuracoes', type: 'page' },
        { label: 'Atividades', route: 'atividades', module: 'Atividades', type: 'page' },
        // Branding
        { label: 'Essencia da Marca', route: 'branding', section: 'section-essencia-da-marca', module: 'Branding' },
        { label: 'Personalidade da Marca', route: 'branding', section: 'section-personalidade-da-marca', module: 'Branding' },
        { label: 'Naming e Tagline', route: 'branding', section: 'section-naming-e-tagline', module: 'Branding' },
        { label: 'Logo', route: 'branding', section: 'section-logo', module: 'Branding' },
        { label: 'Paleta de Cores (Branding)', route: 'branding', section: 'section-paleta-de-cores', module: 'Branding' },
        { label: 'Tipografia (Branding)', route: 'branding', section: 'section-tipografia', module: 'Branding' },
        { label: 'Elementos Visuais', route: 'branding', section: 'section-elementos-visuais', module: 'Branding' },
        { label: 'Aplicacoes da Marca', route: 'branding', section: 'section-aplicacoes-da-marca', module: 'Branding' },
        { label: 'Presenca Digital', route: 'branding', section: 'section-presenca-digital', module: 'Branding' },
        { label: 'Manual e Governanca', route: 'branding', section: 'section-manual-e-governanca', module: 'Branding' },
        // Copywriter
        { label: 'Proposta Unica de Valor (PUV)', route: 'copywriter', section: 'section-proposta-unica-de-valor-puv', module: 'Copywriter' },
        { label: 'Persona e Publico-Alvo', route: 'copywriter', section: 'section-persona-e-publico-alvo', module: 'Copywriter' },
        { label: 'Tom de Voz da Marca', route: 'copywriter', section: 'section-tom-de-voz-da-marca', module: 'Copywriter' },
        { label: 'Headlines e Titulos', route: 'copywriter', section: 'section-headlines-e-titulos', module: 'Copywriter' },
        { label: 'Landing Page', route: 'copywriter', section: 'section-landing-page', module: 'Copywriter' },
        { label: 'Email Marketing', route: 'copywriter', section: 'section-email-marketing', module: 'Copywriter' },
        { label: 'Redes Sociais', route: 'copywriter', section: 'section-redes-sociais', module: 'Copywriter' },
        { label: 'Storytelling', route: 'copywriter', section: 'section-storytelling', module: 'Copywriter' },
        { label: 'Objecoes e FAQ', route: 'copywriter', section: 'section-objecoes-e-faq', module: 'Copywriter' },
        { label: 'CTAs e Conversao', route: 'copywriter', section: 'section-ctas-e-conversao', module: 'Copywriter' },
        // Estrutura
        { label: 'Arquitetura do Site', route: 'estrutura', section: 'section-arquitetura-do-site', module: 'Estrutura' },
        { label: 'Header e Navegacao', route: 'estrutura', section: 'section-header-e-navegacao', module: 'Estrutura' },
        { label: 'Hero e Banners', route: 'estrutura', section: 'section-hero-e-banners', module: 'Estrutura' },
        { label: 'Paginas Essenciais', route: 'estrutura', section: 'section-paginas-essenciais', module: 'Estrutura' },
        { label: 'Paleta de Cores (Estrutura)', route: 'estrutura', section: 'section-paleta-de-cores', module: 'Estrutura' },
        { label: 'Tipografia (Estrutura)', route: 'estrutura', section: 'section-tipografia', module: 'Estrutura' },
        { label: 'Componentes UI', route: 'estrutura', section: 'section-componentes-ui', module: 'Estrutura' },
        { label: 'Layout e Grid', route: 'estrutura', section: 'section-layout-e-grid', module: 'Estrutura' },
        { label: 'Performance', route: 'estrutura', section: 'section-performance', module: 'Estrutura' },
        { label: 'Acessibilidade', route: 'estrutura', section: 'section-acessibilidade', module: 'Estrutura' },
        // Seguranca
        { label: 'HTTPS e Certificado SSL', route: 'seguranca', section: 'section-https-e-certificado-ssl', module: 'Seguranca' },
        { label: 'Headers de Seguranca', route: 'seguranca', section: 'section-headers-de-seguranca', module: 'Seguranca' },
        { label: 'Autenticacao e Senhas', route: 'seguranca', section: 'section-autenticacao-e-senhas', module: 'Seguranca' },
        { label: 'Protecao contra Injecao', route: 'seguranca', section: 'section-protecao-contra-injecao', module: 'Seguranca' },
        { label: 'LGPD e Privacidade', route: 'seguranca', section: 'section-lgpd-e-privacidade', module: 'Seguranca' },
        { label: 'Backup e Recuperacao', route: 'seguranca', section: 'section-backup-e-recuperacao', module: 'Seguranca' },
        { label: 'Monitoramento e Logs', route: 'seguranca', section: 'section-monitoramento-e-logs', module: 'Seguranca' },
        { label: 'Atualizacoes e Patches', route: 'seguranca', section: 'section-atualizacoes-e-patches', module: 'Seguranca' },
        { label: 'Protecao DDoS e Rate Limiting', route: 'seguranca', section: 'section-protecao-ddos-e-rate-limiting', module: 'Seguranca' },
        { label: 'Seguranca do Servidor', route: 'seguranca', section: 'section-seguranca-do-servidor', module: 'Seguranca' },
        // SEO
        { label: 'Pesquisa de Palavras-Chave', route: 'seo', section: 'section-pesquisa-de-palavras-chave', module: 'SEO' },
        { label: 'SEO On-Page', route: 'seo', section: 'section-seo-on-page', module: 'SEO' },
        { label: 'Estrategia de Conteudo', route: 'seo', section: 'section-estrategia-de-conteudo', module: 'SEO' },
        { label: 'SEO Tecnico', route: 'seo', section: 'section-seo-tecnico', module: 'SEO' },
        { label: 'Link Building', route: 'seo', section: 'section-link-building', module: 'SEO' },
        { label: 'SEO Local', route: 'seo', section: 'section-seo-local', module: 'SEO' },
        { label: 'Core Web Vitals e Performance', route: 'seo', section: 'section-core-web-vitals-e-performance', module: 'SEO' },
        { label: 'Mobile SEO', route: 'seo', section: 'section-mobile-seo', module: 'SEO' },
        { label: 'Imagens e Midia', route: 'seo', section: 'section-imagens-e-midia', module: 'SEO' },
        { label: 'Analytics e Monitoramento', route: 'seo', section: 'section-analytics-e-monitoramento', module: 'SEO' },
        // Google Ads
        { label: 'Estrategia e Objetivos', route: 'google-ads', section: 'section-estrategia-e-objetivos', module: 'Google Ads' },
        { label: 'Conta e Estrutura de Campanhas', route: 'google-ads', section: 'section-conta-e-estrutura-de-campanhas', module: 'Google Ads' },
        { label: 'Pesquisa de Palavras-Chave (Ads)', route: 'google-ads', section: 'section-pesquisa-de-palavras-chave', module: 'Google Ads' },
        { label: 'Anuncios de Pesquisa (Search)', route: 'google-ads', section: 'section-anuncios-de-pesquisa-search', module: 'Google Ads' },
        { label: 'Google Shopping', route: 'google-ads', section: 'section-google-shopping', module: 'Google Ads' },
        { label: 'Display e Remarketing', route: 'google-ads', section: 'section-display-e-remarketing', module: 'Google Ads' },
        { label: 'YouTube Ads', route: 'google-ads', section: 'section-youtube-ads', module: 'Google Ads' },
        { label: 'Performance Max', route: 'google-ads', section: 'section-performance-max', module: 'Google Ads' },
        { label: 'Landing Pages e Conversao', route: 'google-ads', section: 'section-landing-pages-e-conversao', module: 'Google Ads' },
        { label: 'Otimizacao e Escala', route: 'google-ads', section: 'section-otimizacao-e-escala', module: 'Google Ads' },
        // Shopee
        { label: 'Configuracao da Loja', route: 'shopee', section: 'section-configuracao-da-loja', module: 'Shopee' },
        { label: 'Cadastro de Produtos', route: 'shopee', section: 'section-cadastro-de-produtos', module: 'Shopee' },
        { label: 'Fotos e Videos', route: 'shopee', section: 'section-fotos-e-videos', module: 'Shopee' },
        { label: 'Precificacao', route: 'shopee', section: 'section-precificacao', module: 'Shopee' },
        { label: 'SEO na Shopee', route: 'shopee', section: 'section-seo-na-shopee', module: 'Shopee' },
        { label: 'Logistica e Envio', route: 'shopee', section: 'section-logistica-e-envio', module: 'Shopee' },
        { label: 'Atendimento ao Cliente', route: 'shopee', section: 'section-atendimento-ao-cliente', module: 'Shopee' },
        { label: 'Anuncios e Ads', route: 'shopee', section: 'section-anuncios-e-ads', module: 'Shopee' },
        { label: 'Metricas e Analise', route: 'shopee', section: 'section-metricas-e-analise', module: 'Shopee' },
        { label: 'Estrategias de Crescimento', route: 'shopee', section: 'section-estrategias-de-crescimento', module: 'Shopee' },
        // Performance
        { label: 'Core Web Vitals', route: 'performance', section: 'section-core-vitals', module: 'Performance' },
        { label: 'Otimizacao de Imagens', route: 'performance', section: 'section-imagens', module: 'Performance' },
        { label: 'Cache e CDN', route: 'performance', section: 'section-cache', module: 'Performance' },
        { label: 'Otimizacao de Codigo', route: 'performance', section: 'section-codigo', module: 'Performance' },
        { label: 'Otimizacao de Servidor', route: 'performance', section: 'section-servidor', module: 'Performance' },
        { label: 'Monitoramento de Performance', route: 'performance', section: 'section-monitoramento', module: 'Performance' },
        // Analytics
        { label: 'Configuracao GA4/GTM', route: 'analytics', section: 'section-configuracao', module: 'Analytics' },
        { label: 'Eventos e Conversoes', route: 'analytics', section: 'section-eventos', module: 'Analytics' },
        { label: 'UTMs e Campanhas', route: 'analytics', section: 'section-campanhas', module: 'Analytics' },
        { label: 'Relatorios e KPIs', route: 'analytics', section: 'section-relatorios', module: 'Analytics' },
        { label: 'Funis de Conversao', route: 'analytics', section: 'section-funis', module: 'Analytics' },
        { label: 'Integracoes e Dados', route: 'analytics', section: 'section-integracao', module: 'Analytics' },
        // UX Design
        { label: 'Pesquisa de Usuario', route: 'ux-design', section: 'section-pesquisa', module: 'UX Design' },
        { label: 'Navegacao e Arquitetura', route: 'ux-design', section: 'section-navegacao', module: 'UX Design' },
        { label: 'Layout e Hierarquia Visual', route: 'ux-design', section: 'section-layout', module: 'UX Design' },
        { label: 'Componentes e Padroes', route: 'ux-design', section: 'section-componentes', module: 'UX Design' },
        { label: 'Experiencia Mobile', route: 'ux-design', section: 'section-mobile', module: 'UX Design' },
        { label: 'Testes e Validacao UX', route: 'ux-design', section: 'section-testes', module: 'UX Design' },
        // Acessibilidade
        { label: 'HTML Semantico e ARIA', route: 'acessibilidade', section: 'section-semantica', module: 'Acessibilidade' },
        { label: 'Navegacao por Teclado', route: 'acessibilidade', section: 'section-navegacao-a11y', module: 'Acessibilidade' },
        { label: 'Design Visual Acessivel', route: 'acessibilidade', section: 'section-visual', module: 'Acessibilidade' },
        { label: 'Imagens e Midia Acessivel', route: 'acessibilidade', section: 'section-midia', module: 'Acessibilidade' },
        { label: 'Formularios Acessiveis', route: 'acessibilidade', section: 'section-formularios-a11y', module: 'Acessibilidade' },
        { label: 'Conformidade WCAG', route: 'acessibilidade', section: 'section-conformidade', module: 'Acessibilidade' },
        // Conteudo
        { label: 'Estrategia de Conteudo', route: 'conteudo', section: 'section-estrategia', module: 'Conteudo' },
        { label: 'Calendario Editorial', route: 'conteudo', section: 'section-calendario', module: 'Conteudo' },
        { label: 'Diretrizes de Redacao', route: 'conteudo', section: 'section-redacao', module: 'Conteudo' },
        { label: 'Formatos de Conteudo', route: 'conteudo', section: 'section-formatos', module: 'Conteudo' },
        { label: 'Distribuicao e Promocao', route: 'conteudo', section: 'section-distribuicao', module: 'Conteudo' },
        { label: 'Metricas de Conteudo', route: 'conteudo', section: 'section-metricas-conteudo', module: 'Conteudo' },
        // CRO
        { label: 'Fundamentos de CRO', route: 'cro', section: 'section-fundamentos', module: 'CRO' },
        { label: 'Landing Pages (CRO)', route: 'cro', section: 'section-landing', module: 'CRO' },
        { label: 'Formularios Otimizados', route: 'cro', section: 'section-formularios-cro', module: 'CRO' },
        { label: 'Gatilhos Mentais e Persuasao', route: 'cro', section: 'section-gatilhos', module: 'CRO' },
        { label: 'Testes A/B e Experimentacao', route: 'cro', section: 'section-testes-cro', module: 'CRO' },
        { label: 'Analise e Diagnostico CRO', route: 'cro', section: 'section-analise-cro', module: 'CRO' },
        // Email Marketing
        { label: 'Captacao de Leads', route: 'email-marketing', section: 'section-captacao', module: 'Email Marketing' },
        { label: 'Gestao de Listas', route: 'email-marketing', section: 'section-listas', module: 'Email Marketing' },
        { label: 'Automacoes e Fluxos', route: 'email-marketing', section: 'section-automacao', module: 'Email Marketing' },
        { label: 'Campanhas e Newsletters', route: 'email-marketing', section: 'section-campanhas', module: 'Email Marketing' },
        { label: 'Metricas de Email', route: 'email-marketing', section: 'section-metricas-email', module: 'Email Marketing' },
        { label: 'Ferramentas de Email', route: 'email-marketing', section: 'section-ferramentas-email', module: 'Email Marketing' },
        // Redes Sociais
        { label: 'Estrategia de Redes Sociais', route: 'redes-sociais', section: 'section-estrategia-social', module: 'Redes Sociais' },
        { label: 'Instagram', route: 'redes-sociais', section: 'section-instagram', module: 'Redes Sociais' },
        { label: 'TikTok e YouTube', route: 'redes-sociais', section: 'section-tiktok-youtube', module: 'Redes Sociais' },
        { label: 'LinkedIn', route: 'redes-sociais', section: 'section-linkedin', module: 'Redes Sociais' },
        { label: 'Calendario e Producao Social', route: 'redes-sociais', section: 'section-calendario-social', module: 'Redes Sociais' },
        { label: 'Integracao Social com Site', route: 'redes-sociais', section: 'section-integracao-site', module: 'Redes Sociais' },
        // Meta Ads
        { label: 'Pixel e Configuracao Meta', route: 'meta-ads', section: 'section-pixel-config', module: 'Meta Ads' },
        { label: 'Publicos e Segmentacao', route: 'meta-ads', section: 'section-publicos', module: 'Meta Ads' },
        { label: 'Estrutura de Campanhas Meta', route: 'meta-ads', section: 'section-estrutura-camp', module: 'Meta Ads' },
        { label: 'Criativos e Copies (Meta)', route: 'meta-ads', section: 'section-criativos', module: 'Meta Ads' },
        { label: 'Otimizacao e Metricas Meta', route: 'meta-ads', section: 'section-otimizacao-ads', module: 'Meta Ads' },
        { label: 'Remarketing e Retargeting', route: 'meta-ads', section: 'section-remarketing', module: 'Meta Ads' },
        // Infraestrutura
        { label: 'Hospedagem', route: 'infraestrutura', section: 'section-hospedagem', module: 'Infraestrutura' },
        { label: 'Dominio e DNS', route: 'infraestrutura', section: 'section-dominio', module: 'Infraestrutura' },
        { label: 'SSL e Seguranca do Servidor', route: 'infraestrutura', section: 'section-ssl-seguranca', module: 'Infraestrutura' },
        { label: 'Email Profissional', route: 'infraestrutura', section: 'section-email-prof', module: 'Infraestrutura' },
        { label: 'Backups e Recuperacao', route: 'infraestrutura', section: 'section-backup', module: 'Infraestrutura' },
        { label: 'Deploy e Versionamento', route: 'infraestrutura', section: 'section-deploy', module: 'Infraestrutura' },
    ];

    function normalize(str) {
        return str.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function ensureDOM() {
        if (overlay) return;
        overlay = document.createElement('div');
        overlay.className = 'search-overlay';
        overlay.innerHTML = '<div class="search-modal">' +
            '<div class="search-input-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>' +
            '<input type="text" class="search-input" id="globalSearchInput" placeholder="Buscar modulos e secoes..." autocomplete="off">' +
            '<kbd class="search-kbd">Esc</kbd></div>' +
            '<div class="search-results" id="globalSearchResults"></div>' +
            '</div>';
        document.body.appendChild(overlay);
        input = document.getElementById('globalSearchInput');
        resultsEl = document.getElementById('globalSearchResults');

        input.addEventListener('input', function() { doSearch(this.value); });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); selectResult(selectedIdx + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); selectResult(selectedIdx - 1); }
            else if (e.key === 'Enter' && filteredResults[selectedIdx]) { e.preventDefault(); goToResult(filteredResults[selectedIdx]); }
        });
        overlay.addEventListener('click', function(e) { if (e.target === overlay) close(); });
    }

    function doSearch(query) {
        var q = normalize(query.trim());
        if (!q) { resultsEl.innerHTML = '<div class="search-empty">Digite para buscar...</div>'; filteredResults = []; selectedIdx = -1; return; }
        filteredResults = INDEX.filter(function(item) {
            return normalize(item.label).indexOf(q) >= 0 || normalize(item.module).indexOf(q) >= 0;
        }).slice(0, 15);
        if (!filteredResults.length) { resultsEl.innerHTML = '<div class="search-empty">Nenhum resultado encontrado.</div>'; selectedIdx = -1; return; }
        var html = '';
        for (var i = 0; i < filteredResults.length; i++) {
            var r = filteredResults[i];
            html += '<div class="search-result-item' + (i === 0 ? ' selected' : '') + '" data-idx="' + i + '">';
            html += '<span class="search-result-label">' + escapeHtml(r.label) + '</span>';
            html += '<span class="search-result-module">' + escapeHtml(r.module) + '</span>';
            html += '</div>';
        }
        resultsEl.innerHTML = html;
        selectedIdx = 0;

        resultsEl.querySelectorAll('.search-result-item').forEach(function(el) {
            el.addEventListener('click', function() { goToResult(filteredResults[parseInt(this.dataset.idx)]); });
            el.addEventListener('mouseenter', function() { selectResult(parseInt(this.dataset.idx)); });
        });
    }

    function selectResult(idx) {
        if (idx < 0) idx = filteredResults.length - 1;
        if (idx >= filteredResults.length) idx = 0;
        resultsEl.querySelectorAll('.search-result-item').forEach(function(el, i) {
            el.classList.toggle('selected', i === idx);
        });
        selectedIdx = idx;
        var selected = resultsEl.querySelector('.selected');
        if (selected) selected.scrollIntoView({ block: 'nearest' });
    }

    function goToResult(r) {
        close();
        if (window.SpaRouter && SpaRouter.ROUTES[r.route]) {
            SpaRouter.go(r.route);
            if (r.section) {
                setTimeout(function() {
                    var el = document.getElementById(r.section);
                    if (el) {
                        if (!el.classList.contains('open')) {
                            var header = el.querySelector('.doc-section-header');
                            if (header) header.click();
                        }
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 400);
            }
        }
    }

    function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

    function open() {
        ensureDOM();
        overlay.classList.add('active');
        input.value = '';
        resultsEl.innerHTML = '<div class="search-empty">Digite para buscar...</div>';
        filteredResults = [];
        selectedIdx = -1;
        setTimeout(function() { input.focus(); }, 50);
    }

    function close() {
        if (overlay) overlay.classList.remove('active');
    }

    function isOpen() {
        return overlay && overlay.classList.contains('active');
    }

    return {
        open: open,
        close: close,
        isOpen: isOpen,
        toggle: function() { if (isOpen()) close(); else open(); }
    };
})();
