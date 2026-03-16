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
<title>Seguranca — Induzi</title>
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
.doc-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.doc-toolbar { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
.doc-toolbar .btn-tool { display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px; border: 1px solid var(--color-border); border-radius: 6px; background: var(--color-white); color: var(--color-gray-dark, #444); font-size: 0.82rem; font-weight: 500; font-family: inherit; cursor: pointer; transition: all 0.15s; }
.doc-toolbar .btn-tool:hover { border-color: var(--color-accent, #7c3aed); color: var(--color-accent, #7c3aed); }
.doc-toolbar .btn-tool svg { width: 15px; height: 15px; flex-shrink: 0; }
.doc-import-file { display: none; }
@media (max-width: 600px) { .doc-field-row { grid-template-columns: 1fr; } }
</style>
</head>
<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">
    <div class="container">

        <div class="page-header-compact">
            <h1>Seguranca</h1>
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

        <!-- 1. HTTPS e Certificado SSL -->
        <div class="doc-section" id="section-https">
            <div class="doc-section-header" onclick="toggleSection('https')">
                <span class="doc-section-badge" id="badge-https">0/3</span>
                <h3>HTTPS e Certificado SSL</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente a configuracao de HTTPS e certificados SSL do seu projeto. Conexoes seguras sao a base da seguranca web.</p>
                <div class="doc-field">
                    <label>Tipo de certificado</label>
                    <div id="comp-https-certificado"></div>
                </div>
                <div class="doc-field">
                    <label>Checklist de configuracao SSL</label>
                    <div id="comp-https-configuracao"></div>
                </div>
                <div class="doc-field">
                    <label>Processo de renovacao</label>
                    <div id="comp-https-renovacao"></div>
                </div>
            </div>
        </div>

        <!-- 2. Headers de Seguranca -->
        <div class="doc-section" id="section-headers">
            <div class="doc-section-header" onclick="toggleSection('headers')">
                <span class="doc-section-badge" id="badge-headers">0/4</span>
                <h3>Headers de Seguranca</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Registre os headers HTTP de seguranca configurados no seu servidor.</p>
                <div class="doc-field">
                    <label>Content-Security-Policy</label>
                    <div id="comp-headers-csp"></div>
                </div>
                <div class="doc-field">
                    <label>Strict-Transport-Security</label>
                    <div id="comp-headers-hsts"></div>
                    <div class="field-hint">Header HSTS que forca o uso de HTTPS em todas as conexoes futuras</div>
                </div>
                <div class="doc-field">
                    <label>Headers implementados</label>
                    <div id="comp-headers-outros"></div>
                </div>
                <div class="doc-field">
                    <label>CORS</label>
                    <div id="comp-headers-cors"></div>
                </div>
            </div>
        </div>

        <!-- 3. Autenticacao e Senhas -->
        <div class="doc-section" id="section-auth">
            <div class="doc-section-header" onclick="toggleSection('auth')">
                <span class="doc-section-badge" id="badge-auth">0/4</span>
                <h3>Autenticacao e Senhas</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente o sistema de autenticacao, politica de senhas e gerenciamento de sessoes do seu projeto.</p>
                <div class="doc-field">
                    <label>Metodo de autenticacao</label>
                    <div id="comp-auth-metodo"></div>
                </div>
                <div class="doc-field">
                    <label>Politica de senhas</label>
                    <div id="comp-auth-senhas"></div>
                </div>
                <div class="doc-field">
                    <label>Autenticacao multi-fator (MFA)</label>
                    <div id="comp-auth-mfa"></div>
                </div>
                <div class="doc-field">
                    <label>Gerenciamento de sessoes</label>
                    <div id="comp-auth-sessoes"></div>
                </div>
            </div>
        </div>

        <!-- 4. Protecao contra Injecao -->
        <div class="doc-section" id="section-injecao">
            <div class="doc-section-header" onclick="toggleSection('injecao')">
                <span class="doc-section-badge" id="badge-injecao">0/4</span>
                <h3>Protecao contra Injecao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Registre as medidas de protecao contra ataques de injecao (OWASP Top 10).</p>
                <div class="doc-field">
                    <label>SQL Injection</label>
                    <div id="comp-injecao-sql"></div>
                </div>
                <div class="doc-field">
                    <label>XSS (Cross-Site Scripting)</label>
                    <div id="comp-injecao-xss"></div>
                </div>
                <div class="doc-field">
                    <label>CSRF</label>
                    <div id="comp-injecao-csrf"></div>
                </div>
                <div class="doc-field">
                    <label>Outros vetores</label>
                    <div id="comp-injecao-outros_ataques"></div>
                </div>
            </div>
        </div>

        <!-- 5. LGPD e Privacidade -->
        <div class="doc-section" id="section-lgpd">
            <div class="doc-section-header" onclick="toggleSection('lgpd')">
                <span class="doc-section-badge" id="badge-lgpd">0/4</span>
                <h3>LGPD e Privacidade</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente a conformidade com a LGPD e suas politicas de privacidade.</p>
                <div class="doc-field">
                    <label>Consentimento e cookies</label>
                    <div id="comp-lgpd-consentimento"></div>
                </div>
                <div class="doc-field">
                    <label>Politica de privacidade</label>
                    <div id="comp-lgpd-politica"></div>
                </div>
                <div class="doc-field">
                    <label>Direitos do titular</label>
                    <div id="comp-lgpd-direitos"></div>
                </div>
                <div class="doc-field">
                    <label>DPO e processos</label>
                    <div id="comp-lgpd-dpo"></div>
                </div>
            </div>
        </div>

        <!-- 6. Backup e Recuperacao -->
        <div class="doc-section" id="section-backup">
            <div class="doc-section-header" onclick="toggleSection('backup')">
                <span class="doc-section-badge" id="badge-backup">0/4</span>
                <h3>Backup e Recuperacao</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Registre sua estrategia de backup e planos de recuperacao de desastres.</p>
                <div class="doc-field">
                    <label>Estrategia de backup</label>
                    <div id="comp-backup-estrategia"></div>
                </div>
                <div class="doc-field">
                    <label>Locais de armazenamento</label>
                    <div id="comp-backup-locais"></div>
                </div>
                <div class="doc-field">
                    <label>Processo de restauracao</label>
                    <div id="comp-backup-restauracao"></div>
                </div>
                <div class="doc-field">
                    <label>Testes de backup</label>
                    <div id="comp-backup-testes"></div>
                </div>
            </div>
        </div>

        <!-- 7. Monitoramento e Logs -->
        <div class="doc-section" id="section-monitoramento">
            <div class="doc-section-header" onclick="toggleSection('monitoramento')">
                <span class="doc-section-badge" id="badge-monitoramento">0/3</span>
                <h3>Monitoramento e Logs</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente suas ferramentas de monitoramento, politica de logs e sistema de alertas.</p>
                <div class="doc-field">
                    <label>Ferramentas de monitoramento</label>
                    <div id="comp-monitoramento-ferramentas"></div>
                </div>
                <div class="doc-field">
                    <label>Politica de logs</label>
                    <div id="comp-monitoramento-logs"></div>
                </div>
                <div class="doc-field">
                    <label>Canais de alerta</label>
                    <div id="comp-monitoramento-alertas"></div>
                </div>
            </div>
        </div>

        <!-- 8. Atualizacoes e Patches -->
        <div class="doc-section" id="section-atualizacoes">
            <div class="doc-section-header" onclick="toggleSection('atualizacoes')">
                <span class="doc-section-badge" id="badge-atualizacoes">0/3</span>
                <h3>Atualizacoes e Patches</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Registre as versoes em uso e sua politica de atualizacoes.</p>
                <div class="doc-field">
                    <label>CMS e framework</label>
                    <div id="comp-atualizacoes-cms"></div>
                </div>
                <div class="doc-field">
                    <label>Dependencias e plugins</label>
                    <div id="comp-atualizacoes-dependencias"></div>
                </div>
                <div class="doc-field">
                    <label>Sistema operacional e servidor</label>
                    <div id="comp-atualizacoes-servidor"></div>
                </div>
            </div>
        </div>

        <!-- 9. Protecao DDoS e Rate Limiting -->
        <div class="doc-section" id="section-ddos">
            <div class="doc-section-header" onclick="toggleSection('ddos')">
                <span class="doc-section-badge" id="badge-ddos">0/3</span>
                <h3>Protecao DDoS e Rate Limiting</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Documente as protecoes contra ataques de negacao de servico e limitacao de requisicoes.</p>
                <div class="doc-field">
                    <label>CDN e protecao DDoS</label>
                    <div id="comp-ddos-cdn"></div>
                </div>
                <div class="doc-field">
                    <label>Rate limiting</label>
                    <div id="comp-ddos-rate_limiting"></div>
                </div>
                <div class="doc-field">
                    <label>WAF (Web Application Firewall)</label>
                    <div id="comp-ddos-waf"></div>
                </div>
            </div>
        </div>

        <!-- 10. Seguranca do Servidor -->
        <div class="doc-section" id="section-servidor">
            <div class="doc-section-header" onclick="toggleSection('servidor')">
                <span class="doc-section-badge" id="badge-servidor">0/4</span>
                <h3>Seguranca do Servidor</h3>
                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="doc-section-body">
                <p class="doc-section-desc">Registre as configuracoes de seguranca do servidor, controle de acesso e hardening.</p>
                <div class="doc-field">
                    <label>Firewall</label>
                    <div id="comp-servidor-firewall"></div>
                </div>
                <div class="doc-field">
                    <label>Controle de acesso</label>
                    <div id="comp-servidor-acesso"></div>
                </div>
                <div class="doc-field">
                    <label>Permissoes de arquivos</label>
                    <div id="comp-servidor-permissoes"></div>
                </div>
                <div class="doc-field">
                    <label>Hardening</label>
                    <div id="comp-servidor-hardening"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="../js/components.js?v=<?= INDUZI_VERSION ?>"></script>
<script>
(function() {
    var DATA_KEY = 'induziSeguranca';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['seguranca']) || {};

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

    window.toggleSection = function(id) {
        var el = document.getElementById('section-' + id);
        if (el) el.classList.toggle('open');
    };

    function populateAll() {
        for (var key in _components) {
            var p = key.split('.');
            if (_data[p[0]] && _data[p[0]][p[1]] != null) _components[key].setValue(_data[p[0]][p[1]]);
        }
    }

    window.exportarModulo = async function() {
        for (var key in _components) { var p = key.split('.'); if (!_data[p[0]]) _data[p[0]] = {}; _data[p[0]][p[1]] = _components[key].getValue(); }
        var projeto = InduziAuth.getCurrentProject();
        var exportData = { _induzi: true, modulo: 'Seguranca', dataKey: DATA_KEY, projeto: projeto ? projeto.nome : '', exportado_em: new Date().toISOString(), dados: _data };
        var json = JSON.stringify(exportData, null, 2);
        var blob = new Blob([json], { type: 'application/json' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url;
        a.download = 'induzi-seguranca-' + (projeto ? projeto.nome : 'projeto').toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.json';
        a.click(); URL.revokeObjectURL(url);
        Igris.toast('Dados exportados!', 'success');
    };

    window.importarModulo = async function(input) {
        var file = input.files[0]; if (!file) return;
        try {
            var text = await file.text(); var importData = JSON.parse(text);
            var dados = importData.dados || importData;
            if (typeof dados !== 'object') { Igris.toast('JSON invalido', 'error'); input.value = ''; return; }
            var ok = await Igris.confirm('Importar dados de "' + file.name + '"? Os dados atuais serao substituidos.');
            if (!ok) { input.value = ''; return; }
            _data = dados; await InduziDB.save(DATA_KEY, _data);
            populateAll(); updateProgress();
            Igris.toast('Dados importados!', 'success');
        } catch (e) { Igris.toast('Erro ao ler arquivo: ' + e.message, 'error'); }
        input.value = '';
    };

    async function init() {
        // 1. HTTPS
        _components['https.certificado'] = InduziComponents.multiSelect(document.getElementById('comp-https-certificado'), {
            options: [
                { value: "Let's Encrypt", label: "Let's Encrypt" }, { value: 'SSL Pago', label: 'SSL Pago' },
                { value: 'Wildcard', label: 'Wildcard' }, { value: 'EV', label: 'EV' }
            ], onChange: onChange
        });
        _components['https.configuracao'] = InduziComponents.guided(document.getElementById('comp-https-configuracao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['https.configuracao'] || {}));
        _components['https.renovacao'] = InduziComponents.guided(document.getElementById('comp-https-renovacao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['https.renovacao'] || {}));

        // 2. Headers
        _components['headers.csp'] = InduziComponents.guided(document.getElementById('comp-headers-csp'), Object.assign({ onChange: onChange, placeholder: 'Adicionar diretiva...' }, presets['headers.csp'] || {}));
        _components['headers.hsts'] = InduziComponents.guided(document.getElementById('comp-headers-hsts'), Object.assign({ onChange: onChange, placeholder: 'Adicionar parametro... (Enter)' }, presets['headers.hsts'] || {}));
        _components['headers.outros'] = InduziComponents.guided(document.getElementById('comp-headers-outros'), Object.assign({ onChange: onChange, placeholder: 'Adicionar header...' }, presets['headers.outros'] || {}));
        _components['headers.cors'] = InduziComponents.guided(document.getElementById('comp-headers-cors'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra...' }, presets['headers.cors'] || {}));

        // 3. Auth
        _components['auth.metodo'] = InduziComponents.multiSelect(document.getElementById('comp-auth-metodo'), {
            options: [
                { value: 'Session-based', label: 'Session-based' }, { value: 'JWT', label: 'JWT' },
                { value: 'OAuth', label: 'OAuth' }, { value: 'SSO', label: 'SSO' }
            ], onChange: onChange
        });
        _components['auth.senhas'] = InduziComponents.guided(document.getElementById('comp-auth-senhas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar requisito...' }, presets['auth.senhas'] || {}));
        _components['auth.mfa'] = InduziComponents.multiSelect(document.getElementById('comp-auth-mfa'), {
            options: [
                { value: 'TOTP', label: 'TOTP' }, { value: 'SMS', label: 'SMS' },
                { value: 'Email', label: 'Email' }, { value: 'Chave Fisica', label: 'Chave Fisica' }
            ], onChange: onChange
        });
        _components['auth.sessoes'] = InduziComponents.guided(document.getElementById('comp-auth-sessoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar medida...' }, presets['auth.sessoes'] || {}));

        // 4. Injecao
        _components['injecao.sql'] = InduziComponents.guided(document.getElementById('comp-injecao-sql'), Object.assign({ onChange: onChange, placeholder: 'Adicionar medida...' }, presets['injecao.sql'] || {}));
        _components['injecao.xss'] = InduziComponents.guided(document.getElementById('comp-injecao-xss'), Object.assign({ onChange: onChange, placeholder: 'Adicionar medida...' }, presets['injecao.xss'] || {}));
        _components['injecao.csrf'] = InduziComponents.guided(document.getElementById('comp-injecao-csrf'), Object.assign({ onChange: onChange, placeholder: 'Adicionar medida...' }, presets['injecao.csrf'] || {}));
        _components['injecao.outros_ataques'] = InduziComponents.guided(document.getElementById('comp-injecao-outros_ataques'), Object.assign({ onChange: onChange, placeholder: 'Adicionar vetor protegido... (Enter)' }, presets['injecao.outros_ataques'] || {}));

        // 5. LGPD
        _components['lgpd.consentimento'] = InduziComponents.guided(document.getElementById('comp-lgpd-consentimento'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['lgpd.consentimento'] || {}));
        _components['lgpd.politica'] = InduziComponents.guided(document.getElementById('comp-lgpd-politica'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['lgpd.politica'] || {}));
        _components['lgpd.direitos'] = InduziComponents.guided(document.getElementById('comp-lgpd-direitos'), Object.assign({ onChange: onChange, placeholder: 'Adicionar direito...' }, presets['lgpd.direitos'] || {}));
        _components['lgpd.dpo'] = InduziComponents.guided(document.getElementById('comp-lgpd-dpo'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['lgpd.dpo'] || {}));

        // 6. Backup
        _components['backup.estrategia'] = InduziComponents.guided(document.getElementById('comp-backup-estrategia'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['backup.estrategia'] || {}));
        _components['backup.locais'] = InduziComponents.guided(document.getElementById('comp-backup-locais'), Object.assign({ onChange: onChange, placeholder: 'Adicionar local... (Enter)' }, presets['backup.locais'] || {}));
        _components['backup.restauracao'] = InduziComponents.guided(document.getElementById('comp-backup-restauracao'), Object.assign({ onChange: onChange, placeholder: 'Adicionar passo...' }, presets['backup.restauracao'] || {}));
        _components['backup.testes'] = InduziComponents.guided(document.getElementById('comp-backup-testes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['backup.testes'] || {}));

        // 7. Monitoramento
        _components['monitoramento.ferramentas'] = InduziComponents.guided(document.getElementById('comp-monitoramento-ferramentas'), Object.assign({ onChange: onChange, placeholder: 'Adicionar ferramenta... (Enter)' }, presets['monitoramento.ferramentas'] || {}));
        _components['monitoramento.logs'] = InduziComponents.guided(document.getElementById('comp-monitoramento-logs'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['monitoramento.logs'] || {}));
        _components['monitoramento.alertas'] = InduziComponents.multiSelect(document.getElementById('comp-monitoramento-alertas'), {
            options: [
                { value: 'Email', label: 'Email' }, { value: 'Slack', label: 'Slack' },
                { value: 'SMS', label: 'SMS' }, { value: 'PagerDuty', label: 'PagerDuty' }
            ], onChange: onChange
        });

        // 8. Atualizacoes
        _components['atualizacoes.cms'] = InduziComponents.guided(document.getElementById('comp-atualizacoes-cms'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['atualizacoes.cms'] || {}));
        _components['atualizacoes.dependencias'] = InduziComponents.guided(document.getElementById('comp-atualizacoes-dependencias'), Object.assign({ onChange: onChange, placeholder: 'Adicionar dependencia...' }, presets['atualizacoes.dependencias'] || {}));
        _components['atualizacoes.servidor'] = InduziComponents.guided(document.getElementById('comp-atualizacoes-servidor'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['atualizacoes.servidor'] || {}));

        // 9. DDoS
        _components['ddos.cdn'] = InduziComponents.multiSelect(document.getElementById('comp-ddos-cdn'), {
            options: [
                { value: 'Cloudflare', label: 'Cloudflare' }, { value: 'AWS Shield', label: 'AWS Shield' },
                { value: 'Akamai', label: 'Akamai' }, { value: 'Sucuri', label: 'Sucuri' }
            ], onChange: onChange
        });
        _components['ddos.rate_limiting'] = InduziComponents.guided(document.getElementById('comp-ddos-rate_limiting'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra...' }, presets['ddos.rate_limiting'] || {}));
        _components['ddos.waf'] = InduziComponents.guided(document.getElementById('comp-ddos-waf'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['ddos.waf'] || {}));

        // 10. Servidor
        _components['servidor.firewall'] = InduziComponents.guided(document.getElementById('comp-servidor-firewall'), Object.assign({ onChange: onChange, placeholder: 'Adicionar regra...' }, presets['servidor.firewall'] || {}));
        _components['servidor.acesso'] = InduziComponents.guided(document.getElementById('comp-servidor-acesso'), Object.assign({ onChange: onChange, placeholder: 'Adicionar medida...' }, presets['servidor.acesso'] || {}));
        _components['servidor.permissoes'] = InduziComponents.guided(document.getElementById('comp-servidor-permissoes'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['servidor.permissoes'] || {}));
        _components['servidor.hardening'] = InduziComponents.guided(document.getElementById('comp-servidor-hardening'), Object.assign({ onChange: onChange, placeholder: 'Adicionar item...' }, presets['servidor.hardening'] || {}));

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
