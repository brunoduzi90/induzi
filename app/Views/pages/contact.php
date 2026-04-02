<!-- ═══ CONTATO ═══ -->
<section class="ps-section" style="padding-top:var(--ps-space-20);">
    <div class="ps-container">
        <h1 class="ps-animate-on-scroll" style="font-size:var(--ps-font-4xl);font-family:var(--ps-font-heading);font-weight:var(--ps-fw-bold);letter-spacing:var(--ps-ls-tighter);margin-bottom:var(--ps-space-4);">Contato</h1>
        <p class="ps-animate-on-scroll" style="font-size:var(--ps-font-md);color:var(--ps-text-secondary);max-width:600px;line-height:var(--ps-lh-relaxed);">Cada projeto nasce de uma conversa. Conte sua ideia.</p>
    </div>
</section>

<section class="ps-section">
    <div class="ps-container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--ps-space-12);" class="ps-grid-responsive">

            <!-- Info -->
            <div class="ps-animate-on-scroll">
                <div style="margin-bottom:var(--ps-space-8);">
                    <h3 style="font-size:var(--ps-font-sm);text-transform:uppercase;letter-spacing:var(--ps-ls-wider);color:var(--ps-text-muted);margin-bottom:var(--ps-space-4);">Localiza&ccedil;&atilde;o</h3>
                    <p style="color:var(--ps-text-secondary);line-height:var(--ps-lh-relaxed);">
                        S&atilde;o Paulo, SP<br>
                        Brasil
                    </p>
                </div>

                <div style="margin-bottom:var(--ps-space-8);">
                    <h3 style="font-size:var(--ps-font-sm);text-transform:uppercase;letter-spacing:var(--ps-ls-wider);color:var(--ps-text-muted);margin-bottom:var(--ps-space-4);">Email</h3>
                    <a href="mailto:contato@induzi.com.br" style="color:var(--ps-accent);">contato@induzi.com.br</a>
                </div>

                <div style="margin-bottom:var(--ps-space-8);">
                    <h3 style="font-size:var(--ps-font-sm);text-transform:uppercase;letter-spacing:var(--ps-ls-wider);color:var(--ps-text-muted);margin-bottom:var(--ps-space-4);">Redes</h3>
                    <div class="ps-social">
                        <a href="https://instagram.com/induzi" class="ps-social__link" aria-label="Instagram" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <a href="https://pinterest.com/induzi" class="ps-social__link" aria-label="Pinterest" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 12a4 4 0 1 1 8 0c0 4-3 6-3 6"/><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/><line x1="10" y1="16" x2="8" y2="22"/></svg>
                        </a>
                        <a href="https://wa.me/5511970000000" class="ps-social__link" aria-label="WhatsApp" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 style="font-size:var(--ps-font-sm);text-transform:uppercase;letter-spacing:var(--ps-ls-wider);color:var(--ps-text-muted);margin-bottom:var(--ps-space-4);">Visitas ao ateli&ecirc;</h3>
                    <p style="color:var(--ps-text-secondary);line-height:var(--ps-lh-relaxed);">
                        Agende pelo formul&aacute;rio ou WhatsApp.<br>
                        Incentivamos visitas &mdash; ver o processo &eacute; parte da experi&ecirc;ncia.
                    </p>
                </div>
            </div>

            <!-- Formulario -->
            <div class="ps-animate-on-scroll">
                <?php if ($flash = flash('success')): ?>
                    <div class="ps-alert ps-alert--success"><?= e($flash) ?></div>
                <?php endif; ?>
                <?php if ($flash = flash('error')): ?>
                    <div class="ps-alert ps-alert--error"><?= e($flash) ?></div>
                <?php endif; ?>

                <?php $old = flash('old') ?? []; $errors = flash('errors') ?? []; ?>

                <form method="POST" action="<?= url('contato') ?>" data-validate>
                    <?= csrf_field() ?>

                    <div class="ps-form-group">
                        <label for="name" class="ps-form-label">Nome</label>
                        <input type="text" id="name" name="name" class="ps-input" required minlength="2" value="<?= e($old['name'] ?? '') ?>" placeholder="Seu nome">
                        <?php if (!empty($errors['name'])): ?><small class="ps-form-error"><?= e($errors['name'][0]) ?></small><?php endif; ?>
                    </div>

                    <div class="ps-form-group">
                        <label for="email" class="ps-form-label">Email</label>
                        <input type="email" id="email" name="email" class="ps-input" required value="<?= e($old['email'] ?? '') ?>" placeholder="seu@email.com">
                        <?php if (!empty($errors['email'])): ?><small class="ps-form-error"><?= e($errors['email'][0]) ?></small><?php endif; ?>
                    </div>

                    <div class="ps-form-group">
                        <label for="subject" class="ps-form-label">Tipo de projeto</label>
                        <select id="subject" name="subject" class="ps-input ps-select" required>
                            <option value="" disabled <?= empty($old['subject']) ? 'selected' : '' ?>>Selecione o tipo de projeto</option>
                            <option value="Mobiliario sob medida" <?= ($old['subject'] ?? '') === 'Mobiliario sob medida' ? 'selected' : '' ?>>Mobili&aacute;rio sob medida</option>
                            <option value="Arquitetura de interiores" <?= ($old['subject'] ?? '') === 'Arquitetura de interiores' ? 'selected' : '' ?>>Arquitetura de interiores</option>
                            <option value="Estrutura metalica" <?= ($old['subject'] ?? '') === 'Estrutura metalica' ? 'selected' : '' ?>>Estrutura met&aacute;lica</option>
                            <option value="Impressao 3D" <?= ($old['subject'] ?? '') === 'Impressao 3D' ? 'selected' : '' ?>>Impress&atilde;o 3D</option>
                            <option value="Peca de concreto" <?= ($old['subject'] ?? '') === 'Peca de concreto' ? 'selected' : '' ?>>Pe&ccedil;a de concreto</option>
                            <option value="Visita ao atelie" <?= ($old['subject'] ?? '') === 'Visita ao atelie' ? 'selected' : '' ?>>Visita ao ateli&ecirc;</option>
                            <option value="Outro" <?= ($old['subject'] ?? '') === 'Outro' ? 'selected' : '' ?>>Outro</option>
                        </select>
                        <?php if (!empty($errors['subject'])): ?><small class="ps-form-error"><?= e($errors['subject'][0]) ?></small><?php endif; ?>
                    </div>

                    <div class="ps-form-group">
                        <label for="message" class="ps-form-label">Conte sobre seu projeto</label>
                        <textarea id="message" name="message" class="ps-input" required minlength="10" rows="6" placeholder="Descreva sua ideia, o espaco, materiais de interesse..."><?= e($old['message'] ?? '') ?></textarea>
                        <?php if (!empty($errors['message'])): ?><small class="ps-form-error"><?= e($errors['message'][0]) ?></small><?php endif; ?>
                    </div>

                    <button type="submit" class="ps-btn ps-btn--primary ps-btn--ripple" style="width:100%;">Enviar Mensagem</button>
                </form>
            </div>

        </div>
    </div>
</section>
