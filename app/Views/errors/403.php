<div style="min-height:60vh;display:flex;align-items:center;justify-content:center;padding:24px;text-align:center;">
    <div>
        <h1 style="font-size:6rem;font-weight:800;color:#eab308;margin-bottom:8px;">403</h1>
        <h2 style="margin-bottom:12px;">Acesso Negado</h2>
        <p style="color:var(--ps-text-muted);margin-bottom:32px;max-width:400px;">Voce nao tem permissao para acessar esta pagina. Faca login ou entre em contato com o administrador.</p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <a href="<?= url('/') ?>" class="ps-btn ps-btn--primary ps-btn--md">Ir para Home</a>
            <a href="<?= url('admin/') ?>" class="ps-btn ps-btn--secondary ps-btn--md">Login Admin</a>
        </div>
    </div>
</div>
