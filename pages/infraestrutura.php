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
<title>Infraestrutura — Induzi</title>
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
            <h1>Infraestrutura</h1>
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

        <!-- 1. Hospedagem -->
        <div class="doc-section" id="section-hospedagem">
            <div class="doc-section-header" onclick="toggleSection('hospedagem')">
                <span class="doc-section-badge" id="badge-hospedagem">0/4</span>
                <h3>Hospedagem</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">A escolha da hospedagem impacta diretamente performance, seguranca e disponibilidade do site. E o alicerce de tudo.</p>
                <div class="doc-field">
                    <label>Tipo de hospedagem</label>
                    <div id="comp-hospedagem-tipo"></div>
                </div>
                <div class="doc-field">
                    <label>Provedor e plano</label>
                    <div id="comp-hospedagem-provedor"></div>
                </div>
                <div class="doc-field">
                    <label>Escalabilidade</label>
                    <div id="comp-hospedagem-escalabilidade"></div>
                </div>
                <div class="doc-field">
                    <label>Painel de controle</label>
                    <div id="comp-hospedagem-painel"></div>
                </div>
            </div>
        </div>

        <!-- 2. Dominio e DNS -->
        <div class="doc-section" id="section-dominio">
            <div class="doc-section-header" onclick="toggleSection('dominio')">
                <span class="doc-section-badge" id="badge-dominio">0/4</span>
                <h3>Dominio e DNS</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">O dominio e o endereco do seu negocio na internet. DNS bem configurado garante que tudo funcione corretamente.</p>
                <div class="doc-field">
                    <label>Registro de dominio</label>
                    <div id="comp-dominio-registro"></div>
                </div>
                <div class="doc-field">
                    <label>Configuracao DNS</label>
                    <div id="comp-dominio-dns"></div>
                </div>
                <div class="doc-field">
                    <label>Subdominios</label>
                    <div id="comp-dominio-subdominios"></div>
                </div>
                <div class="doc-field">
                    <label>Redirecionamentos</label>
                    <div id="comp-dominio-redirecionamentos"></div>
                </div>
            </div>
        </div>

        <!-- 3. SSL e Seguranca do Servidor -->
        <div class="doc-section" id="section-ssl-seguranca">
            <div class="doc-section-header" onclick="toggleSection('ssl-seguranca')">
                <span class="doc-section-badge" id="badge-ssl-seguranca">0/4</span>
                <h3>SSL e Seguranca do Servidor</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">HTTPS e obrigatorio. Alem do SSL, configuracoes de seguranca no servidor protegem contra ataques comuns.</p>
                <div class="doc-field">
                    <label>Certificado SSL</label>
                    <div id="comp-ssl-seguranca-ssl"></div>
                </div>
                <div class="doc-field">
                    <label>Headers de seguranca</label>
                    <div id="comp-ssl-seguranca-headers"></div>
                </div>
                <div class="doc-field">
                    <label>Firewall e WAF</label>
                    <div id="comp-ssl-seguranca-firewall"></div>
                </div>
                <div class="doc-field">
                    <label>Atualizacoes</label>
                    <div id="comp-ssl-seguranca-atualizacoes"></div>
                </div>
            </div>
        </div>

        <!-- 4. Email Profissional -->
        <div class="doc-section" id="section-email-prof">
            <div class="doc-section-header" onclick="toggleSection('email-prof')">
                <span class="doc-section-badge" id="badge-email-prof">0/4</span>
                <h3>Email Profissional</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Email com dominio proprio (@suaempresa.com.br) transmite profissionalismo e melhora a entregabilidade.</p>
                <div class="doc-field">
                    <label>Provedor de email</label>
                    <div id="comp-email-prof-provedor_email"></div>
                </div>
                <div class="doc-field">
                    <label>Contas e aliases</label>
                    <div id="comp-email-prof-contas"></div>
                </div>
                <div class="doc-field">
                    <label>Autenticacao (SPF/DKIM/DMARC)</label>
                    <div id="comp-email-prof-autenticacao_email"></div>
                </div>
                <div class="doc-field">
                    <label>Assinatura de email</label>
                    <div id="comp-email-prof-assinatura"></div>
                </div>
            </div>
        </div>

        <!-- 5. Backups e Recuperacao -->
        <div class="doc-section" id="section-backup">
            <div class="doc-section-header" onclick="toggleSection('backup')">
                <span class="doc-section-badge" id="badge-backup">0/4</span>
                <h3>Backups e Recuperacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Backup nao e opcional. Sem backup testado, qualquer incidente pode significar perda total do site e dos dados.</p>
                <div class="doc-field">
                    <label>Estrategia de backup</label>
                    <div id="comp-backup-estrategia"></div>
                </div>
                <div class="doc-field">
                    <label>Frequencia e retencao</label>
                    <div id="comp-backup-frequencia"></div>
                </div>
                <div class="doc-field">
                    <label>Armazenamento</label>
                    <div id="comp-backup-armazenamento"></div>
                </div>
                <div class="doc-field">
                    <label>Teste de restauracao</label>
                    <div id="comp-backup-restauracao"></div>
                </div>
            </div>
        </div>

        <!-- 6. Deploy e Versionamento -->
        <div class="doc-section" id="section-deploy">
            <div class="doc-section-header" onclick="toggleSection('deploy')">
                <span class="doc-section-badge" id="badge-deploy">0/4</span>
                <h3>Deploy e Versionamento</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Um processo de deploy organizado evita erros em producao e permite reverter mudancas rapidamente se algo der errado.</p>
                <div class="doc-field">
                    <label>Ambientes</label>
                    <div id="comp-deploy-ambientes"></div>
                </div>
                <div class="doc-field">
                    <label>Versionamento (Git)</label>
                    <div id="comp-deploy-git"></div>
                </div>
                <div class="doc-field">
                    <label>CI/CD</label>
                    <div id="comp-deploy-cicd"></div>
                </div>
                <div class="doc-field">
                    <label>Monitoramento pos-deploy</label>
                    <div id="comp-deploy-monitoramento"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
(function() {
    var DATA_KEY = 'induziInfraestrutura';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['infraestrutura']) || {};

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
        var exportData = { _induzi: true, modulo: 'Infraestrutura', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-infraestrutura-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
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
        g('comp-hospedagem-tipo', 'hospedagem.tipo', 'Compartilhada, VPS, Cloud (AWS, GCP, DigitalOcean), Dedicado, Managed WordPress (Kinsta, WP Engine). Qual foi escolhida e por que...');
        g('comp-hospedagem-provedor', 'hospedagem.provedor', 'Provedor contratado, plano, recursos (CPU, RAM, armazenamento), localizacao do servidor (datacenter), suporte, SLA...');
        g('comp-hospedagem-escalabilidade', 'hospedagem.escalabilidade', 'Como escalar em picos de trafego: auto-scaling, load balancer, CDN, plano de contingencia, limites do plano atual...');
        g('comp-hospedagem-painel', 'hospedagem.painel', 'cPanel, Plesk, painel customizado, acesso SSH, FTP/SFTP, gerenciador de arquivos, phpMyAdmin, credenciais e acessos...');

        g('comp-dominio-registro', 'dominio.registro', 'Dominio principal, dominios secundarios, registrador (Registro.br, GoDaddy, Cloudflare), data de expiracao, auto-renovacao...');
        g('comp-dominio-dns', 'dominio.dns', 'Nameservers, registros A, CNAME, MX, TXT, AAAA. Provedor de DNS (Cloudflare, Route53), TTL, propagacao...');
        g('comp-dominio-subdominios', 'dominio.subdominios', 'Subdominios em uso: www, blog, app, api, staging, mail. Apontamento de cada um, certificado SSL por subdominio...');
        g('comp-dominio-redirecionamentos', 'dominio.redirecionamentos', 'www vs non-www, HTTP para HTTPS, dominios antigos, redirecionamentos 301 permanentes, regras no .htaccess ou Nginx...');

        g('comp-ssl-seguranca-ssl', 'ssl-seguranca.ssl', 'Tipo: Let\'s Encrypt (gratuito), DV, OV, EV, Wildcard. Renovacao automatica, instalacao, verificacao (cadeado verde)...');
        g('comp-ssl-seguranca-headers', 'ssl-seguranca.headers', 'HSTS, X-Content-Type-Options, X-Frame-Options, Content-Security-Policy, Referrer-Policy, Permissions-Policy. Configuracao...');
        g('comp-ssl-seguranca-firewall', 'ssl-seguranca.firewall', 'Web Application Firewall (Cloudflare, Sucuri, ModSecurity), regras configuradas, protecao contra DDoS, rate limiting...');
        g('comp-ssl-seguranca-atualizacoes', 'ssl-seguranca.atualizacoes', 'PHP, MySQL, CMS (WordPress), plugins, sistema operacional do servidor. Politica de atualizacao, testes antes de atualizar...');

        g('comp-email-prof-provedor_email', 'email-prof.provedor_email', 'Google Workspace, Microsoft 365, Zoho Mail, email no servidor. Plano, numero de contas, armazenamento, custo...');
        g('comp-email-prof-contas', 'email-prof.contas', 'Contas criadas: contato@, suporte@, vendas@, financeiro@. Aliases, grupos de distribuicao, redirecionamentos...');
        g('comp-email-prof-autenticacao_email', 'email-prof.autenticacao_email', 'Registros SPF, DKIM e DMARC no DNS. Verificacao com mail-tester.com ou MXToolbox. Politica DMARC (none, quarantine, reject)...');
        g('comp-email-prof-assinatura', 'email-prof.assinatura', 'Template padrao de assinatura: nome, cargo, telefone, logo, links sociais, banner promocional (opcional). Ferramenta de gestao...');

        g('comp-backup-estrategia', 'backup.estrategia', 'Regra 3-2-1: 3 copias, 2 midias diferentes, 1 offsite. O que e incluso: arquivos, banco de dados, emails, configuracoes...');
        g('comp-backup-frequencia', 'backup.frequencia', 'Backup diario automatico, retencao (30 dias, 90 dias), backup antes de atualizacoes, backup manual sob demanda...');
        g('comp-backup-armazenamento', 'backup.armazenamento', 'Onde os backups ficam: servidor, cloud storage (S3, Google Cloud), local. Criptografia, acesso restrito, custo...');
        g('comp-backup-restauracao', 'backup.restauracao', 'Frequencia de testes de restore, ambiente de staging para teste, tempo de recuperacao (RTO), ponto de recuperacao (RPO), documentacao do processo...');

        g('comp-deploy-ambientes', 'deploy.ambientes', 'Desenvolvimento (local), Staging (homologacao), Producao. URLs de cada ambiente, como promover de staging para producao...');
        g('comp-deploy-git', 'deploy.git', 'Repositorio Git (GitHub, GitLab, Bitbucket), branching strategy (GitFlow, trunk-based), pull requests, code review...');
        g('comp-deploy-cicd', 'deploy.cicd', 'Pipeline automatizado: build > testes > deploy. Ferramenta (GitHub Actions, GitLab CI, Jenkins), triggers, rollback automatico...');
        g('comp-deploy-monitoramento', 'deploy.monitoramento', 'Uptime monitoring (UptimeRobot, Pingdom), alertas por email/SMS/Slack, logs de erro, APM (New Relic, Datadog), status page...');

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
