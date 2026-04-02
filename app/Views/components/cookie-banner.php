<!-- Cookie Consent Banner — LGPD -->
<div class="ps-consent" id="cookieBanner">
    <div class="ps-consent__title">Cookies</div>
    <p class="ps-consent__text">Este site utiliza cookies para melhorar sua experiencia. Voce pode escolher quais tipos aceitar.</p>
    <div style="display:flex;gap:var(--ps-space-4);flex-wrap:wrap;font-size:var(--ps-font-xs);color:var(--ps-text-muted);margin-bottom:var(--ps-space-4);">
        <label class="ps-checkbox">
            <input type="checkbox" class="ps-checkbox__input" checked disabled>
            <span style="color:var(--ps-success);">Necessarios</span> (sempre ativos)
        </label>
        <label class="ps-checkbox">
            <input type="checkbox" class="ps-checkbox__input" id="cookieAnalytics">
            Analiticos
        </label>
        <label class="ps-checkbox">
            <input type="checkbox" class="ps-checkbox__input" id="cookieMarketing">
            Marketing
        </label>
    </div>
    <div class="ps-consent__actions">
        <button class="ps-btn ps-btn--secondary ps-btn--sm" data-consent-close onclick="acceptCookies('selected')">Aceitar selecionados</button>
        <button class="ps-btn ps-btn--primary ps-btn--sm" data-consent-close onclick="acceptCookies('all')">Aceitar todos</button>
    </div>
</div>
