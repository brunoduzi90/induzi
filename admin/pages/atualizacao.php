<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
spaFragmentStart();
$session = requireAdmin();
session_write_close();
$_currentVersion = defined('INDUZI_VERSION') ? INDUZI_VERSION : '0.0.0';
$_versionDate = defined('INDUZI_VERSION_DATE') ? INDUZI_VERSION_DATE : '';
?>
<style>
    .update-tabs { display:flex; border-bottom:1px solid var(--color-border); margin-bottom:24px; gap:0; }
    .update-tab-btn { background:none; border:none; border-bottom:2px solid transparent; padding:10px 20px; font-size:0.9rem; font-weight:500; color:var(--text-muted); cursor:pointer; transition:color .2s, border-color .2s; font-family:inherit; }
    .update-tab-btn:hover { color:var(--text-primary); }
    .update-tab-btn.active { color:var(--text-primary); border-bottom-color:var(--color-accent); }

    .version-display { text-align:center; margin-bottom:24px; }
    .version-display .ver-num { font-size:2.2rem; font-weight:700; color:var(--text-primary); font-family:'Space Grotesk',sans-serif; }
    .version-display .ver-label { font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:var(--text-muted); margin-bottom:6px; }
    .version-display .ver-date { font-size:0.85rem; color:var(--text-muted); margin-top:4px; }
    .version-display .ver-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:0.75rem; font-weight:600; margin-top:8px; }
    .ver-badge.uptodate { background:rgba(var(--accent-rgb,184,224,200),0.15); color:var(--color-accent); }
    .ver-badge.available { background:rgba(59,130,246,0.1); color:#3b82f6; }

    .upload-zone { border:2px dashed var(--color-border); border-radius:8px; padding:24px; text-align:center; cursor:pointer; transition:border-color .2s, background .2s; margin-bottom:12px; }
    .upload-zone:hover, .upload-zone.dragover { border-color:var(--color-accent); background:rgba(var(--accent-rgb,184,224,200),0.05); }
    .upload-zone svg { width:32px; height:32px; stroke:var(--text-muted); margin-bottom:8px; }
    .upload-zone .upload-text { font-size:0.85rem; color:var(--text-muted); }
    .upload-zone .upload-text strong { color:var(--text-primary); }
    .upload-zone .upload-hint { font-size:0.75rem; color:var(--text-muted); margin-top:4px; }
    .upload-zone.has-file { border-style:solid; border-color:var(--color-accent); background:rgba(var(--accent-rgb,184,224,200),0.05); }
    .upload-zone.has-file .upload-text { color:var(--text-primary); font-weight:500; }

    .hist-timeline { position:relative; padding-left:28px; }
    .hist-timeline::before { content:''; position:absolute; left:7px; top:8px; bottom:8px; width:2px; background:var(--color-border); }
    .hist-entry { position:relative; background:var(--card-bg); border:1px solid var(--color-border); border-radius:10px; padding:16px 20px; margin-bottom:12px; }
    .hist-entry::before { content:''; position:absolute; left:-25px; top:20px; width:12px; height:12px; border-radius:50%; border:2px solid var(--color-border); background:var(--card-bg); }
    .hist-entry.current { border-color:var(--color-accent); }
    .hist-entry.current::before { background:var(--color-accent); border-color:var(--color-accent); }
    .hist-entry-header { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:8px; }
    .hist-version-num { font-size:1.05rem; font-weight:700; color:var(--text-primary); font-family:'Space Grotesk',sans-serif; }
    .hist-date { font-size:0.8rem; color:var(--text-muted); }
    .hist-current-badge { display:inline-block; padding:2px 10px; border-radius:12px; font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; background:var(--color-accent); color:var(--bg-primary,#0f0f1a); }
    .hist-changes { margin:0; padding-left:18px; }
    .hist-changes li { font-size:0.82rem; color:var(--text-secondary); line-height:1.7; }
    .hist-empty, .hist-loading { text-align:center; padding:40px 20px; color:var(--text-muted); font-size:0.9rem; }

    .maint-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    @media (max-width:768px) { .maint-grid { grid-template-columns:1fr; } }
    .maint-card { background:var(--card-bg); border:1px solid var(--color-border); border-radius:10px; padding:20px; display:flex; flex-direction:column; gap:8px; }
    .maint-card-header { display:flex; align-items:center; gap:12px; }
    .maint-card-icon { width:36px; height:36px; background:var(--bg-secondary,rgba(255,255,255,0.05)); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .maint-card-icon svg { width:18px; height:18px; stroke:var(--text-secondary); }
    .maint-card-title { font-size:0.9rem; font-weight:600; color:var(--text-primary); }
    .maint-card-desc { font-size:0.8rem; color:var(--text-muted); line-height:1.5; }

    .status-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:24px; }
    @media (max-width:768px) { .status-grid { grid-template-columns:1fr; } }
    .status-card { background:var(--card-bg); border:1px solid var(--color-border); border-radius:10px; padding:20px; }
    .status-card-title { font-size:0.9rem; font-weight:600; color:var(--text-primary); margin-bottom:14px; }
    .status-item { display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid var(--color-border); font-size:0.82rem; }
    .status-item:last-child { border-bottom:none; }
    .status-item-label { color:var(--text-muted); }
    .status-item-value { color:var(--text-primary); font-weight:500; }

    .files-list { max-height:250px; overflow-y:auto; border:1px solid var(--color-border); border-radius:8px; }
    .files-list-item { display:flex; align-items:center; gap:8px; padding:6px 12px; font-size:0.78rem; color:var(--text-secondary); border-bottom:1px solid var(--color-border); font-family:monospace; }
    .files-list-item:last-child { border-bottom:none; }
    .file-badge { font-size:0.65rem; font-weight:600; text-transform:uppercase; padding:2px 6px; border-radius:4px; flex-shrink:0; }
    .file-badge.atualizado { background:rgba(59,130,246,0.15); color:#3b82f6; }
    .file-badge.criado { background:rgba(var(--accent-rgb,184,224,200),0.2); color:var(--color-accent); }

    @media (max-width:480px) {
        .update-tab-btn { padding:8px 14px; font-size:0.85rem; }
        .version-display .ver-num { font-size:1.8rem; }
        .hist-timeline { padding-left:24px; }
        .hist-entry { padding:12px 14px; }
        .hist-entry::before { left:-21px; width:10px; height:10px; }
    }
</style>

<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Atualizacao do Sistema</h1>
    </div>

    <div class="update-tabs">
        <button class="update-tab-btn active" onclick="switchTab('atualizacao')" id="tabBtnAtualizacao">Atualizacao</button>
        <button class="update-tab-btn" onclick="switchTab('historico')" id="tabBtnHistorico">Historico</button>
        <button class="update-tab-btn" onclick="switchTab('manutencao')" id="tabBtnManutencao">Manutencao</button>
    </div>

    <!-- ========== TAB: ATUALIZACAO ========== -->
    <div id="tabAtualizacao">
        <!-- Versao Atual -->
        <div class="card" style="margin-bottom:24px;">
            <div class="card-body version-display">
                <div class="ver-label">Versao Atual</div>
                <div class="ver-num" id="updVerNum"><?= e($_currentVersion) ?></div>
                <div class="ver-date" id="updVerDate"><?= e($_versionDate) ?></div>
                <div id="updVerBadge"></div>
            </div>
        </div>

        <!-- Atualizacao Remota -->
        <div class="card" style="margin-bottom:24px;">
            <div class="card-body">
                <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:16px;">
                    <div class="maint-card-icon" style="flex-shrink:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:4px;">Atualizacao Remota</h3>
                        <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">Verifique se ha novas versoes disponiveis no servidor de atualizacoes.</p>
                    </div>
                </div>
                <div id="updRemoteStatus">
                    <button class="btn btn-sm" onclick="updCheckRemote()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;vertical-align:-2px;margin-right:4px;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Verificar Atualizacoes
                    </button>
                </div>
            </div>
        </div>

        <!-- Upload Manual (collapsible) -->
        <div style="margin-bottom:24px;">
            <button class="btn btn-sm btn-outline" onclick="var el=document.getElementById('manualSection');el.style.display=el.style.display==='none'?'block':'none';" style="font-size:0.8rem;color:var(--text-muted);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;vertical-align:-2px;margin-right:4px;"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                Atualizar Manualmente
            </button>
        </div>
        <div id="manualSection" style="display:none;">
            <div class="card" style="margin-bottom:24px;">
                <div class="card-body">
                    <h3 style="font-size:1rem;font-weight:600;color:var(--text-primary);margin-bottom:12px;">Upload de Pacote ZIP</h3>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:16px;">Envie um pacote ZIP gerado pelo sistema. Os arquivos serao extraidos e aplicados automaticamente.</p>

                    <div class="upload-zone" id="uploadZone" onclick="document.getElementById('updZipFile').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <div class="upload-text" id="uploadText">Clique ou arraste o arquivo ZIP aqui</div>
                        <div class="upload-hint">Maximo 50MB</div>
                    </div>
                    <input type="file" id="updZipFile" accept=".zip" style="display:none" onchange="updFileSelected(this)">

                    <button class="btn btn-primary btn-sm" onclick="updUploadZip()" id="updBtnUpload" disabled>Enviar e Aplicar</button>
                    <div id="updUploadStatus" style="margin-top:12px;"></div>
                </div>
            </div>
        </div>

        <!-- Link para atualizador completo (migracoes) -->
        <div class="card">
            <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div>
                    <h3 style="font-size:0.95rem;font-weight:600;color:var(--text-primary);margin-bottom:4px;">Migracoes de Banco</h3>
                    <p style="font-size:0.83rem;color:var(--text-muted);margin:0;">Verificar e executar migracoes de banco pendentes.</p>
                </div>
                <a href="../update.php" target="_blank" class="btn btn-sm btn-outline">Atualizador Completo</a>
            </div>
        </div>
    </div>

    <!-- ========== TAB: HISTORICO ========== -->
    <div id="tabHistorico" style="display:none;">
        <div id="historicoContent">
            <div class="hist-loading">Carregando historico...</div>
        </div>
    </div>

    <!-- ========== TAB: MANUTENCAO ========== -->
    <div id="tabManutencao" style="display:none;">
        <div style="margin-bottom:24px;">
            <h3 style="font-size:0.85rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:16px;">Limpeza</h3>
            <div class="maint-grid">
                <div class="maint-card">
                    <div class="maint-card-header">
                        <div class="maint-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </div>
                        <div class="maint-card-title">Cache do SPA</div>
                    </div>
                    <div class="maint-card-desc">Limpa os fragmentos de pagina em memoria, forcando recarregamento na proxima navegacao.</div>
                    <button class="btn btn-sm" style="align-self:flex-start;margin-top:4px;" onclick="limparCacheSPA(this)">Limpar</button>
                </div>

                <div class="maint-card">
                    <div class="maint-card-header">
                        <div class="maint-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        </div>
                        <div class="maint-card-title">Dados Locais (localStorage)</div>
                    </div>
                    <div class="maint-card-desc">Remove preferencias locais do INDUZI (tema, customizacoes).</div>
                    <button class="btn btn-sm" style="align-self:flex-start;margin-top:4px;" onclick="limparLocalStorage(this)">Limpar</button>
                </div>
            </div>
        </div>

        <div>
            <h3 style="font-size:0.85rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:16px;">Status do Sistema</h3>
            <div class="status-grid" id="statusGrid">
                <div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--text-muted);font-size:0.85rem;">Carregando...</div>
            </div>
        </div>
    </div>

</div>
</div>

<script>
(function(){
    var _historicoLoaded = false;
    var _statusLoaded = false;

    // ===== TABS =====
    window.switchTab = function(name) {
        ['atualizacao','historico','manutencao'].forEach(function(t) {
            var tab = document.getElementById('tab' + t.charAt(0).toUpperCase() + t.slice(1));
            var btn = document.getElementById('tabBtn' + t.charAt(0).toUpperCase() + t.slice(1));
            if (tab) tab.style.display = (t === name) ? 'block' : 'none';
            if (btn) btn.classList.toggle('active', t === name);
        });
        if (name === 'historico' && !_historicoLoaded) carregarHistorico();
        if (name === 'manutencao' && !_statusLoaded) carregarStatus();
    };

    // ===== VERIFICAR REMOTO =====
    window.updCheckRemote = async function() {
        var el = document.getElementById('updRemoteStatus');
        var badge = document.getElementById('updVerBadge');
        el.innerHTML = '<p style="color:var(--text-muted)">Verificando...</p>';

        try {
            var res = await IgrisDB.fetch('api/atualizacao/verificar.php');
            var data = await res.json();

            if (!data.ok) {
                el.innerHTML = '<div class="alert alert-error">' + (data.msg || 'Erro ao verificar.') + '</div>';
                return;
            }

            var d = data.data;

            if (!d.configured) {
                badge.innerHTML = '<span class="ver-badge" style="background:rgba(251,191,36,0.15);color:#fbbf24;">Nao configurado</span>';
                el.innerHTML = '<div class="alert alert-warning">' + (d.msg || 'URL nao configurada.') +
                    '<br><small>Defina <code>update_url</code> e <code>update_token</code> em <a href="' + (window._adminBase || '') + 'configuracoes" data-route="configuracoes" style="color:var(--color-accent);">Configuracoes</a>.</small></div>' +
                    '<button class="btn btn-sm" onclick="updCheckRemote()" style="margin-top:12px;">Verificar Novamente</button>';
                return;
            }

            if (!d.hasUpdate) {
                badge.innerHTML = '<span class="ver-badge uptodate">Sistema atualizado</span>';
                el.innerHTML = '<div class="alert alert-success">Nenhuma atualizacao disponivel. Voce esta na versao mais recente.</div>' +
                    '<button class="btn btn-sm" onclick="updCheckRemote()" style="margin-top:12px;">Verificar Novamente</button>';
                return;
            }

            // Tem update disponivel
            badge.innerHTML = '<span class="ver-badge available">v' + _esc(d.remoteVersion) + ' disponivel</span>';

            var html = '<div style="display:flex;align-items:center;gap:16px;margin-bottom:16px;flex-wrap:wrap;">' +
                '<div><span style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);display:block;">Instalada</span><span style="font-size:1.1rem;font-weight:700;color:var(--text-primary);">' + _esc(d.currentVersion) + '</span></div>' +
                '<span style="color:var(--text-muted);font-size:1.2rem;margin-top:12px;">&rarr;</span>' +
                '<div><span style="font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);display:block;">Disponivel</span><span style="font-size:1.1rem;font-weight:700;color:var(--color-accent);">' + _esc(d.remoteVersion) + '</span></div>' +
                '</div>';

            if (!d.phpCompatible) {
                html += '<div class="alert alert-error" style="margin-bottom:12px;">' + _esc(d.phpMsg) + '</div>';
            }

            if (d.changelog && d.changelog.length > 0) {
                html += '<div style="margin-bottom:16px;"><h4 style="font-size:0.8rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:10px;">Novidades</h4>';
                d.changelog.forEach(function(entry) {
                    html += '<div style="background:var(--bg-secondary,rgba(255,255,255,0.03));border-radius:8px;padding:12px 16px;margin-bottom:8px;">' +
                        '<div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);margin-bottom:6px;">v' + _esc(entry.version) + (entry.date ? ' <span style="font-weight:400;color:var(--text-muted);">' + _esc(entry.date) + '</span>' : '') + '</div>';
                    if (entry.changes && entry.changes.length) {
                        html += '<ul style="margin:0;padding-left:18px;">';
                        entry.changes.forEach(function(c) { html += '<li style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;">' + _esc(c) + '</li>'; });
                        html += '</ul>';
                    }
                    html += '</div>';
                });
                html += '</div>';
            }

            if (d.phpCompatible) {
                html += '<div style="display:flex;gap:12px;flex-wrap:wrap;">' +
                    '<button class="btn btn-primary btn-sm" onclick="updDownloadRemote(\'' + _esc(d.downloadUrl).replace(/'/g,"\\'") + '\',\'' + _esc(d.sha256) + '\',\'' + _esc(d.remoteVersion) + '\')" id="updBtnDownload">Baixar e Aplicar v' + _esc(d.remoteVersion) + '</button>' +
                    '<button class="btn btn-sm" onclick="updCheckRemote()">Verificar Novamente</button>' +
                    '</div>';
            }

            html += '<div id="updDownloadStatus" style="margin-top:12px;"></div>';
            el.innerHTML = html;

        } catch (err) {
            el.innerHTML = '<div class="alert alert-error">Erro de comunicacao: ' + _esc(err.message) + '</div>';
        }
    };

    // ===== BAIXAR REMOTO =====
    window.updDownloadRemote = async function(downloadUrl, sha256, remoteVersion) {
        var btn = document.getElementById('updBtnDownload');
        var status = document.getElementById('updDownloadStatus');
        if (btn) { btn.disabled = true; btn.textContent = 'Baixando...'; }

        try {
            var res = await IgrisDB.fetch('api/atualizacao/baixar-remoto.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ download_url: downloadUrl, sha256: sha256, remote_version: remoteVersion })
            });
            var data = await res.json();

            if (data.ok) {
                var d = data.data || {};
                var html = '<div class="alert alert-success">' + _esc(data.msg) + '</div>';
                if (d.filesUpdated) {
                    html += '<p style="font-size:0.83rem;color:var(--text-muted);margin:8px 0;">Arquivos atualizados: ' + d.filesUpdated + '</p>';
                }
                if (d.files && d.files.length > 0 && d.files.length <= 50) {
                    html += '<div class="files-list">';
                    d.files.forEach(function(f) {
                        html += '<div class="files-list-item"><span class="file-badge ' + f.action + '">' + f.action + '</span>' + _esc(f.path) + '</div>';
                    });
                    html += '</div>';
                }
                status.innerHTML = html;
                if (btn) btn.textContent = 'Concluido!';
                Igris.toast('Atualizacao aplicada!', 'success');
                document.getElementById('updVerNum').textContent = d.newVersion || remoteVersion;
                document.getElementById('updVerBadge').innerHTML = '<span class="ver-badge uptodate">Sistema atualizado</span>';
            } else {
                status.innerHTML = '<div class="alert alert-error">' + _esc(data.msg) + '</div>';
                if (btn) { btn.disabled = false; btn.textContent = 'Tentar novamente'; }
            }
        } catch (err) {
            status.innerHTML = '<div class="alert alert-error">Erro: ' + _esc(err.message) + '</div>';
            if (btn) { btn.disabled = false; btn.textContent = 'Tentar novamente'; }
        }
    };

    // ===== UPLOAD MANUAL =====
    window.updFileSelected = function(input) {
        var zone = document.getElementById('uploadZone');
        var text = document.getElementById('uploadText');
        var btn = document.getElementById('updBtnUpload');
        if (input.files && input.files[0]) {
            zone.classList.add('has-file');
            text.innerHTML = '<strong>' + _esc(input.files[0].name) + '</strong>';
            btn.disabled = false;
        } else {
            zone.classList.remove('has-file');
            text.textContent = 'Clique ou arraste o arquivo ZIP aqui';
            btn.disabled = true;
        }
    };

    window.updUploadZip = async function() {
        var fileInput = document.getElementById('updZipFile');
        var btn = document.getElementById('updBtnUpload');
        var status = document.getElementById('updUploadStatus');

        if (!fileInput.files || !fileInput.files[0]) { Igris.toast('Selecione um arquivo ZIP.', 'warning'); return; }
        var file = fileInput.files[0];
        if (!file.name.endsWith('.zip')) { Igris.toast('Apenas .zip aceito.', 'warning'); return; }

        btn.disabled = true; btn.textContent = 'Enviando...';
        status.innerHTML = '<p style="color:var(--text-muted)">Enviando e aplicando...</p>';

        var formData = new FormData();
        formData.append('zipfile', file);

        try {
            var res = await IgrisDB.fetch('api/atualizacao/aplicar.php', { method: 'POST', body: formData });
            var data = await res.json();

            if (data.ok) {
                var d = data.data || {};
                var html = '<div class="alert alert-success">' + _esc(data.msg) + '<br><small>v' + _esc(d.oldVersion||'?') + ' &rarr; v' + _esc(d.newVersion||'?') + ' | Arquivos: ' + (d.filesUpdated||0) + '</small></div>';
                if (d.files && d.files.length > 0 && d.files.length <= 50) {
                    html += '<div class="files-list" style="margin-top:8px;">';
                    d.files.forEach(function(f) { html += '<div class="files-list-item"><span class="file-badge ' + f.action + '">' + f.action + '</span>' + _esc(f.path) + '</div>'; });
                    html += '</div>';
                }
                status.innerHTML = html;
                Igris.toast('Atualizacao aplicada!', 'success');
                btn.textContent = 'Concluido!';
                if (d.newVersion) document.getElementById('updVerNum').textContent = d.newVersion;
            } else {
                status.innerHTML = '<div class="alert alert-error">' + _esc(data.msg) + '</div>';
                btn.disabled = false; btn.textContent = 'Enviar e Aplicar';
            }
        } catch (err) {
            status.innerHTML = '<div class="alert alert-error">Erro: ' + _esc(err.message) + '</div>';
            btn.disabled = false; btn.textContent = 'Enviar e Aplicar';
        }
    };

    // Drag & drop support
    var zone = document.getElementById('uploadZone');
    if (zone) {
        zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.classList.add('dragover'); });
        zone.addEventListener('dragleave', function() { zone.classList.remove('dragover'); });
        zone.addEventListener('drop', function(e) {
            e.preventDefault(); zone.classList.remove('dragover');
            var input = document.getElementById('updZipFile');
            if (e.dataTransfer.files.length) { input.files = e.dataTransfer.files; updFileSelected(input); }
        });
    }

    // ===== HISTORICO =====
    async function carregarHistorico() {
        var container = document.getElementById('historicoContent');
        container.innerHTML = '<div class="hist-loading">Carregando historico...</div>';

        try {
            var res = await IgrisDB.fetch('api/atualizacao/verificar.php?full_changelog=1');
            var data = await res.json();

            if (!data.ok || !data.data || !data.data.changelog || data.data.changelog.length === 0) {
                container.innerHTML = '<div class="hist-empty">Nenhum historico de versoes disponivel.<br><small style="color:var(--text-muted);">Configure a URL de atualizacao em Configuracoes para ver o changelog.</small></div>';
                _historicoLoaded = true;
                return;
            }

            var currentVersion = data.data.currentVersion || '';
            var entries = data.data.changelog;
            var html = '<div class="hist-timeline">';

            entries.forEach(function(entry) {
                var isCurrent = entry.version === currentVersion;
                html += '<div class="hist-entry' + (isCurrent ? ' current' : '') + '">';
                html += '<div class="hist-entry-header">';
                html += '<span class="hist-version-num">v' + _esc(entry.version) + '</span>';
                if (entry.date) html += '<span class="hist-date">' + _esc(entry.date) + '</span>';
                if (isCurrent) html += '<span class="hist-current-badge">Versao Atual</span>';
                html += '</div>';

                if (entry.changes && entry.changes.length > 0) {
                    html += '<ul class="hist-changes">';
                    entry.changes.forEach(function(c) { html += '<li>' + _esc(c) + '</li>'; });
                    html += '</ul>';
                }
                html += '</div>';
            });

            html += '</div>';
            container.innerHTML = html;
            _historicoLoaded = true;
        } catch (e) {
            container.innerHTML = '<div class="hist-empty">Nao foi possivel carregar o historico.</div>';
            _historicoLoaded = true;
        }
    }

    // ===== MANUTENCAO =====
    window.limparCacheSPA = function(btn) {
        if (typeof SpaRouter !== 'undefined' && SpaRouter.clearCache) SpaRouter.clearCache();
        btn.textContent = 'Limpo!';
        btn.disabled = true;
        Igris.toast('Cache do SPA limpo.', 'success');
    };

    window.limparLocalStorage = function(btn) {
        var keys = [];
        for (var i = 0; i < localStorage.length; i++) {
            var k = localStorage.key(i);
            if (k && (k.indexOf('igris') === 0 || k.indexOf('induzi') === 0)) keys.push(k);
        }
        keys.forEach(function(k) { localStorage.removeItem(k); });
        btn.textContent = 'Limpo! (' + keys.length + ')';
        btn.disabled = true;
        Igris.toast('Dados locais removidos.', 'success');
    };

    async function carregarStatus() {
        var grid = document.getElementById('statusGrid');
        try {
            // Usar o update.php?action=status para obter checks
            var res = await fetch('../update.php?action=status');
            var data = await res.json();

            if (!data.ok) {
                grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--text-muted);">Erro ao carregar status.</div>';
                _statusLoaded = true;
                return;
            }

            var html = '';

            // Card: Versao
            html += '<div class="status-card">';
            html += '<div class="status-card-title">Versao</div>';
            html += '<div class="status-item"><span class="status-item-label">Codigo</span><span class="status-item-value">' + _esc(data.codeVersion) + '</span></div>';
            html += '<div class="status-item"><span class="status-item-label">Schema DB</span><span class="status-item-value">' + _esc(data.dbVersion) + '</span></div>';
            html += '<div class="status-item"><span class="status-item-label">Migracoes pendentes</span><span class="status-item-value">' + data.pendingCount + '</span></div>';
            html += '</div>';

            // Card: Checks
            html += '<div class="status-card">';
            html += '<div class="status-card-title">Verificacoes</div>';
            if (data.checks) {
                data.checks.forEach(function(c) {
                    var icon = c.ok ? '<span style="color:var(--color-accent);">&#10003;</span>' : '<span style="color:#f87171;">&#10007;</span>';
                    html += '<div class="status-item"><span class="status-item-label">' + _esc(c.label) + '</span><span class="status-item-value">' + icon + '</span></div>';
                });
            }
            html += '</div>';

            grid.innerHTML = html;
            _statusLoaded = true;
        } catch (e) {
            grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--text-muted);">Erro ao carregar: ' + _esc(e.message) + '</div>';
            _statusLoaded = true;
        }
    }

    // Auto-check on load
    updCheckRemote();
})();
</script>
<?php spaFragmentEnd(); ?>
