<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/fragment.php';
spaFragmentStart();
requireAuth();
session_write_close();
$db = getDB();
$_cfg = [];
$stmt = $db->query('SELECT chave, valor FROM configuracoes');
while ($row = $stmt->fetch()) $_cfg[$row['chave']] = $row['valor'];
spaPreload(['ok' => true, 'config' => $_cfg]);
?>
<div class="main-content">
<div class="container">
    <div class="page-header-compact">
        <h1>Configuracoes</h1>
        <button class="btn btn-primary btn-sm" onclick="configSave()">Salvar</button>
    </div>

    <div id="configForm"><p style="color:var(--text-muted)">Carregando...</p></div>
</div>
</div>

<script>
(function(){
    var _d = window._preloaded; window._preloaded = undefined;
    var config = (_d && _d.config) ? _d.config : {};

    async function load() {
        var res = await IgrisDB.fetch('api/configuracoes/load.php');
        var data = await res.json();
        config = data.ok ? data.config : {};
        render();
    }

    function field(key, label, type) {
        type = type || 'text';
        var val = config[key] || '';
        if (type === 'textarea') {
            return '<div class="form-group"><label>' + label + '</label><textarea class="form-textarea" data-key="' + key + '" rows="3">' + _esc(val) + '</textarea></div>';
        }
        return '<div class="form-group"><label>' + label + '</label><input class="form-input" type="' + type + '" data-key="' + key + '" value="' + _esc(val) + '"></div>';
    }

    function render() {
        var el = document.getElementById('configForm');
        el.innerHTML =
            '<h3 style="font-size:0.95rem;margin-bottom:12px;color:var(--text-secondary)">Geral</h3>' +
            field('site_titulo', 'Titulo do Site') +
            field('site_descricao', 'Descricao', 'textarea') +
            field('site_email', 'Email de Contato', 'email') +
            field('site_telefone', 'Telefone') +
            field('endereco', 'Endereco', 'textarea') +
            field('horario_funcionamento', 'Horario de Funcionamento') +
            '<h3 style="font-size:0.95rem;margin:24px 0 12px;color:var(--text-secondary)">Redes Sociais</h3>' +
            field('site_instagram', 'Instagram (URL)') +
            field('site_whatsapp', 'WhatsApp (numero)') +
            field('site_facebook', 'Facebook (URL)') +
            field('site_linkedin', 'LinkedIn (URL)') +
            '<h3 style="font-size:0.95rem;margin:24px 0 12px;color:var(--text-secondary)">SEO</h3>' +
            field('seo_keywords', 'Palavras-chave', 'textarea') +
            field('seo_og_image', 'OG Image (URL)') +
            field('google_analytics', 'Google Analytics ID') +
            '<h3 style="font-size:0.95rem;margin:24px 0 12px;color:var(--text-secondary)">Atualizacao</h3>' +
            field('update_url', 'URL do Manifest (update-manifest.json)') +
            field('update_token', 'Token GitHub (para repos privados)') +
            '<p style="font-size:0.78rem;color:var(--text-muted);margin-top:-8px;">Ex: URL raw do GitHub ou API. Token opcional para repositorios privados.</p>' +
            '<div style="margin-top:24px"><button class="btn btn-primary" onclick="configSave()">Salvar Configuracoes</button></div>';
    }

    window.configSave = async function() {
        var newConfig = {};
        document.querySelectorAll('#configForm [data-key]').forEach(function(el) {
            newConfig[el.dataset.key] = el.value;
        });
        var res = await IgrisDB.fetch('api/configuracoes/save.php', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ config: newConfig })
        });
        var data = await res.json();
        if (data.ok) Igris.toast('Configuracoes salvas!', 'success');
        else Igris.toast(data.msg, 'error');
    };

    if (_d && _d.ok) { render(); } else { load(); }
})();
</script>
<?php spaFragmentEnd(); ?>
