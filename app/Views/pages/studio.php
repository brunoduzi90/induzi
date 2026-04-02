<style>
/* Studio — use custom wipe instead of default */
.ps-snap-wipe { display: none !important; }

.ps-wipe-reveal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    pointer-events: none;
    background: var(--ps-accent);
    transform-origin: top;
    animation: ps-wipe-exit 0.4s cubic-bezier(.77, 0, .18, 1) forwards;
}

@keyframes ps-wipe-exit {
    from { transform: scaleY(1); }
    to   { transform: scaleY(0); }
}
</style>
<div class="ps-wipe-reveal"></div>

<!-- ═══ HERO ═══ -->
<section class="ps-hero ps-hero--visionary" style="position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">01 — HERO</span>
    <!-- Background Video -->
    <div class="ps-hero__bg">
        <video autoplay muted playsinline preload="auto" aria-hidden="true" id="hero-video">
            <source src="<?= asset('video/video-hero.mp4') ?>" type="video/mp4"/>
        </video>
        <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 01 — video-hero.mp4</span>
        <div class="ps-hero__gradient"></div>
    </div>

    <!-- Content -->
    <div class="ps-hero__content">
        <div style="max-width:72rem;">
            <span class="ps-hero__kicker ps-text-reveal" style="animation-delay:0.2s">Exclusividade &amp; T&eacute;cnica</span>
            <h1 class="ps-hero__title ps-text-reveal" style="animation-delay:0.4s">
                Profundidade que Induz.<br/>
                <span class="ps-accent-text">Resultados que Elevam.</span>
            </h1>
            <div class="ps-hero__row ps-text-reveal" style="animation-delay:0.6s">
                <p class="ps-hero__desc">
                    Onde a engenharia encontra a alma do artes&atilde;o. Criamos pe&ccedil;as que transcendem a forma, unindo precis&atilde;o industrial &agrave; sensibilidade est&eacute;tica.
                </p>
                <div class="ps-hero__ctas">
                    <a href="<?= url('portfolio') ?>" class="ps-hero__cta-btn ps-hero__cta-btn--primary">Explorar Cole&ccedil;&otilde;es</a>
                    <a href="<?= url('sobre') ?>" class="ps-hero__cta-btn ps-hero__cta-btn--ghost">O Ateli&ecirc;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="ps-hero__scroll-hint ps-text-reveal" style="animation-delay:1s" aria-hidden="true">
        <div class="ps-hero__scroll-inner">
            <span class="ps-hero__scroll-line"></span>
            Scroll para descobrir
        </div>
    </div>
    <div class="ps-hero__bottom-line"></div>
</section>

<!-- ═══ O ARTESÃO ═══ -->
<section class="ps-about-hero" id="artesao" style="content-visibility:auto;contain-intrinsic-size:auto 900px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">02 — O ARTES&Atilde;O</span>
    <div class="ps-about-hero__grid">
        <!-- Left: Narrative & Biography -->
        <div class="ps-animate-on-scroll">
            <header style="margin-bottom:var(--ps-space-16);">
                <span class="ps-about-hero__kicker">Manifesto de Origem</span>
                <h2 class="ps-about-hero__title ps-text-reveal">
                    A Mat&eacute;ria <br>&eacute; <em>Mem&oacute;ria.</em>
                </h2>
                <div class="ps-about-hero__divider"></div>
            </header>
            <div>
                <p class="ps-about-hero__lead">
                    Desde os 4 anos, o cheiro de serragem e o toque frio do cinzel definiram meu mundo. No ateli&ecirc; do meu av&ocirc;, aprendi que a madeira n&atilde;o &eacute; um recurso, mas um di&aacute;logo silencioso entre o tempo e a m&atilde;o humana.
                </p>
                <p class="ps-about-hero__text">
                    Minha pr&aacute;tica evoluiu de marcenaria tradicional para uma busca espiritual pela forma. Cada pe&ccedil;a que emerge do est&uacute;dio &eacute; um experimento em Alquimia do detalhe &mdash; onde metais l&iacute;quidos encontram madeiras centen&aacute;rias e a imperfei&ccedil;&atilde;o &eacute; celebrada como a assinatura da alma.
                </p>
            </div>
            <!-- Key Milestones -->
            <div class="ps-about-hero__milestones ps-stagger">
                <div class="ps-glass-card">
                    <span class="ps-glass-card__number">01 / RA&Iacute;ZES</span>
                    <h3 class="ps-glass-card__title">Aprendizado Arcaico</h3>
                    <p class="ps-glass-card__desc">Imers&atilde;o nas t&eacute;cnicas de encaixe manual em Floren&ccedil;a, resgatando processos do s&eacute;culo XVII.</p>
                </div>
                <div class="ps-glass-card">
                    <span class="ps-glass-card__number">02 / RUPTURA</span>
                    <h3 class="ps-glass-card__title">Fus&atilde;o de Elementos</h3>
                    <p class="ps-glass-card__desc">Primeira exposi&ccedil;&atilde;o individual explorando a intera&ccedil;&atilde;o entre bronze oxidado e nogueira preta.</p>
                </div>
                <div class="ps-glass-card">
                    <span class="ps-glass-card__number">03 / LEGADO</span>
                    <h3 class="ps-glass-card__title">Sustentabilidade &Eacute;tica</h3>
                    <p class="ps-glass-card__desc">Certifica&ccedil;&atilde;o global pelo uso exclusivo de madeiras de reuso e resgate urbano.</p>
                </div>
                <div class="ps-glass-card">
                    <span class="ps-glass-card__number">04 / FUTURO</span>
                    <h3 class="ps-glass-card__title">Laborat&oacute;rio Duzi</h3>
                    <p class="ps-glass-card__desc">Inaugura&ccedil;&atilde;o do espa&ccedil;o de pesquisa em design sensorial e mobili&aacute;rio escultural.</p>
                </div>
            </div>
        </div>
        <!-- Right: Portrait & Vertical Quote -->
        <div class="ps-about-hero__portrait-col">
            <div class="ps-about-hero__vertical-quote">
                <div class="ps-about-hero__vline"></div>
                <p class="ps-about-hero__vtext">A ALQUIMIA DO DETALHE &Eacute; O SIL&Ecirc;NCIO DA PERFEI&Ccedil;&Atilde;O</p>
                <div class="ps-about-hero__vline"></div>
            </div>
            <div class="ps-about-hero__portrait ps-reveal">
                <img alt="Bruno Duzi - Mestre Artes&atilde;o" src="<?= asset('images/hero-profile.jpeg') ?>" loading="lazy">
                <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 02 — hero-profile.jpeg</span>
                <div class="ps-about-hero__portrait-frame"></div>
                <div class="ps-about-hero__portrait-badge">
                    <span>Mestre Artes&atilde;o</span>
                    <h4>Bruno Duzi</h4>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- ═══ MESA MONÓLITO — HERO ═══ -->
<section class="ps-mesa-hero ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 921px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">05 — MESA HERO</span>
    <img alt="Mesa Mon&oacute;lito &mdash; Acr&iacute;lico Cristal" class="ps-mesa-hero__img" src="<?= asset('images/portfolio/mesahero.jpg') ?>" loading="lazy"/>
    <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 03 — mesahero.jpg</span>
    <div class="ps-mesa-hero__gradient"></div>
    <div class="ps-mesa-hero__content">
        <h2 class="ps-mesa-hero__title">
            Mesa Mon&oacute;lito: <br/><span>A Alquimia da Transpar&ecirc;ncia</span>
        </h2>
        <p class="ps-mesa-hero__subtitle">
            Uma fus&atilde;o de engenharia de precis&atilde;o e minimalismo radical. 50mm de acr&iacute;lico s&oacute;lido lapidado &agrave; m&atilde;o.
        </p>
    </div>
</section>

<!-- ═══ MESA MONÓLITO — EDITORIAL GRID ═══ -->
<section class="ps-mesa-editorial ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 900px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">06 — MESA EDITORIAL</span>
    <div class="ps-mesa-editorial__grid">
        <!-- Left Column: Narrative & Side View -->
        <div class="ps-mesa-editorial__left">
            <div class="ps-reveal">
                <span class="ps-mesa-editorial__kicker">Manifesto Visual</span>
                <p class="ps-mesa-editorial__narrative">
                    Cada &acirc;ngulo revela uma nova refra&ccedil;&atilde;o. <em>A luz n&atilde;o apenas atravessa a pe&ccedil;a; ela &eacute; esculpida por ela.</em>
                </p>
            </div>
            <div class="ps-mesa-glass">
                <img alt="Mesa Mon&oacute;lito &mdash; Perfil Linear" style="aspect-ratio:4/5;" src="<?= asset('images/portfolio/mesa-acrilico-02.jpg') ?>" loading="lazy"/>
                <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 04 — mesa-acrilico-02.jpg</span>
                <div class="ps-mesa-glass__caption">
                    <h3>Perfil Linear</h3>
                    <p>Minimalismo Estrutural</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Details & Asymmetric Layout -->
        <div class="ps-mesa-editorial__right">
            <!-- Top Corner Detail -->
            <div class="ps-mesa-editorial__detail-row">
                <div class="ps-mesa-glass ps-mesa-editorial__detail-img">
                    <img alt="Mesa Mon&oacute;lito &mdash; Detalhe de Borda" src="<?= asset('images/portfolio/mesa-acrilico-03.jpg') ?>" loading="lazy"/>
                    <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 05 — mesa-acrilico-03.jpg</span>
                </div>
                <div class="ps-mesa-editorial__detail-text">
                    <div class="ps-mesa-editorial__detail-line"></div>
                    <h4>Lapida&ccedil;&atilde;o At&ocirc;mica</h4>
                    <p>Bordas polidas at&eacute; a perfei&ccedil;&atilde;o molecular, garantindo que a transi&ccedil;&atilde;o entre as faces seja quase invis&iacute;vel ao toque.</p>
                </div>
            </div>

            <!-- Highlights & Angle View -->
            <div class="ps-mesa-editorial__highlights">
                <div class="ps-mesa-editorial__specs">
                    <div class="ps-mesa-editorial__spec">
                        <h5>Pureza</h5>
                        <p>Acr&iacute;lico Cristalino 99.9%</p>
                    </div>
                    <div class="ps-mesa-editorial__spec">
                        <h5>Presen&ccedil;a</h5>
                        <p>Espessura Monumental</p>
                    </div>
                    <div class="ps-mesa-editorial__spec">
                        <h5>Dimens&otilde;es</h5>
                        <p>140 &times; 80 &times; 75 cm</p>
                    </div>
                    <div class="ps-mesa-editorial__cta">
                        <a href="<?= url('contato') ?>" class="ps-mesa-editorial__cta-btn">
                            Solicitar Or&ccedil;amento
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <div class="ps-mesa-glass ps-mesa-editorial__angle-img">
                    <img alt="Mesa Mon&oacute;lito &mdash; Perspectiva" style="aspect-ratio:3/4;" src="<?= asset('images/portfolio/mesa-acrilico-04.jpg') ?>" loading="lazy"/>
                    <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 06 — mesa-acrilico-04.jpg</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ MESA MONÓLITO — MOOD SHOT ═══ -->
<section class="ps-mesa-mood ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 819px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">07 — MESA MOOD</span>
    <img alt="Mesa Mon&oacute;lito &mdash; Atmosfera" class="ps-mesa-mood__img" src="<?= asset('images/portfolio/mesa-acrilico-05.jpg') ?>" loading="lazy"/>
    <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 07 — mesa-acrilico-05.jpg</span>
    <div class="ps-mesa-mood__gradient"></div>
    <div class="ps-mesa-mood__content">
        <h2 class="ps-mesa-mood__quote">
            &ldquo;A aus&ecirc;ncia de mat&eacute;ria como forma suprema de luxo.&rdquo;
        </h2>
        <div class="ps-mesa-mood__cities">
            <span class="ps-mesa-mood__city">Berlin</span>
            <span class="ps-mesa-mood__city">London</span>
            <span class="ps-mesa-mood__city">S&atilde;o Paulo</span>
        </div>
    </div>
</section>



<!-- ═══ CTA EDITORIAL ═══ -->
<section class="ps-cta-editorial ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 700px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">08b — CTA</span>

    <!-- Background -->
    <div class="ps-cta-editorial__bg"></div>
    <div class="ps-cta-editorial__bg-gradient"></div>

    <div class="ps-cta-editorial__inner">
        <!-- Left Content -->
        <div class="ps-cta-editorial__content">
            <div class="ps-cta-editorial__kicker">
                <div class="ps-cta-editorial__kicker-line"></div>
                <span class="ps-cta-editorial__kicker-text">Inova&ccedil;&atilde;o e Legado</span>
            </div>
            <h2 class="ps-cta-editorial__title">
                Elevando o padr&atilde;o da <br/> manufactura contempor&acirc;nea.
            </h2>
            <div class="ps-cta-editorial__features">
                <div>
                    <div class="ps-cta-editorial__feature-icon">
                        <span class="material-symbols-outlined">precision_manufacturing</span>
                    </div>
                    <h3 class="ps-cta-editorial__feature-title">Precis&atilde;o Brutalista</h3>
                    <p class="ps-cta-editorial__feature-desc">A estrutura encontra a sua forma final atrav&eacute;s de processos industriais refinados por m&atilde;os humanas experientes.</p>
                </div>
                <div>
                    <div class="ps-cta-editorial__feature-icon">
                        <span class="material-symbols-outlined">auto_awesome</span>
                    </div>
                    <h3 class="ps-cta-editorial__feature-title">Est&eacute;tica Fluida</h3>
                    <p class="ps-cta-editorial__feature-desc">Capturamos a ess&ecirc;ncia da luz em materiais s&oacute;lidos, criando uma experi&ecirc;ncia visual sem precedentes em cada pe&ccedil;a.</p>
                </div>
            </div>
        </div>

        <!-- Right Glass Card -->
        <div class="ps-cta-editorial__card-wrap">
            <div class="ps-cta-editorial__card">
                <div class="ps-cta-editorial__card-corner--tr"></div>
                <div class="ps-cta-editorial__card-corner--bl"></div>
                <div class="ps-cta-editorial__card-inner">
                    <h4 class="ps-cta-editorial__card-title">Inicie seu projeto exclusivo</h4>
                    <p class="ps-cta-editorial__card-desc">Entre em contato com nossos especialistas para uma consulta privada sobre design e viabilidade t&eacute;cnica.</p>
                    <div>
                        <a href="<?= url('contato') ?>" class="ps-cta-editorial__card-btn">
                            Agendar Consulta
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                    <div class="ps-cta-editorial__card-meta">
                        <span class="ps-cta-editorial__card-meta-label">Tempo m&eacute;dio de resposta</span>
                        <span class="ps-cta-editorial__card-meta-value">24 HORAS &Uacute;TEIS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ CTA HERO SPLIT ═══ -->
<section class="ps-cta-split ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 921px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">08b — CTA HERO</span>
    <div class="ps-cta-split__grid">
        <!-- Left: Engineering Focus -->
        <div class="ps-cta-split__left">
            <div>
                <span class="ps-cta-split__tag">Rigor T&eacute;cnico</span>
                <h2 class="ps-cta-split__title">
                    Onde a Engenharia <br/> Encontra a Alma
                </h2>
                <p class="ps-cta-split__desc">
                    Polimento manual de 12 est&aacute;gios, acr&iacute;lico de 50mm com pureza de 99.9%. Cada componente &eacute; submetido a testes de toler&acirc;ncia microm&eacute;trica antes da montagem final.
                </p>
            </div>
            <div class="ps-cta-split__stats">
                <div>
                    <span class="ps-cta-split__stat-value">99.9%</span>
                    <span class="ps-cta-split__stat-label">Pureza de Material</span>
                </div>
                <div>
                    <span class="ps-cta-split__stat-value">12</span>
                    <span class="ps-cta-split__stat-label">Etapas de Polimento</span>
                </div>
            </div>
        </div>
        <!-- Right: Visual -->
        <div class="ps-cta-split__right">
            <img alt="Escultura acr&iacute;lica &mdash; refra&ccedil;&atilde;o de luz" src="<?= asset('images/portfolio/mesa-acrilico-06.jpg') ?>" loading="lazy"/>
            <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 08 — mesa-acrilico-06.jpg</span>
            <div class="ps-cta-split__quote">
                <p>&ldquo;Pe&ccedil;as que n&atilde;o apenas ocupam o espa&ccedil;o, mas o transformam atrav&eacute;s da luz e da geometria.&rdquo;</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ NEWSLETTER "O INÉDITO" ═══ -->
<section class="ps-newsletter ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 716px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">09 — NEWSLETTER</span>
    <div class="ps-newsletter__texture"></div>
    <div class="ps-newsletter__grid">
        <!-- Headline Left -->
        <div class="ps-newsletter__headline">
            <div class="ps-newsletter__headline-inner">
                <span class="ps-newsletter__edition">Journal / Edition 024</span>
                <div>
                    <h2 class="ps-newsletter__title ps-text-reveal">O In&eacute;dito</h2>
                    <p class="ps-newsletter__desc">
                        Insights exclusivos sobre design experimental, tecnologia e a est&eacute;tica vanguardista que define o futuro do <span class="ps-highlight">INDUZI Studio</span>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Decorative Divider -->
        <div class="ps-newsletter__divider">
            <div class="ps-newsletter__divider-line"></div>
        </div>

        <!-- Form Right -->
        <div class="ps-newsletter__form-wrap">
            <div class="ps-newsletter__card">
                <div class="ps-newsletter__badge">
                    <span class="ps-newsletter__pulse"></span>
                    Newsletter Semanal
                </div>
                <form action="<?= url('api/v1/newsletter') ?>" method="post" class="ps-newsletter__form">
                    <div>
                        <input class="ps-newsletter__input" type="email" name="email" placeholder="seu@email.com" required autocomplete="email"/>
                        <div class="ps-newsletter__input-line"></div>
                    </div>
                    <button class="ps-newsletter__submit" type="submit">
                        <span class="ps-newsletter__submit-text">Inscrever-se</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </form>
                <p class="ps-newsletter__privacy">
                    Ao assinar, voc&ecirc; concorda com nossos termos de privacidade. Sem spam, apenas curadoria pura.
                </p>
            </div>
        </div>

        <!-- Decorative Lines -->
        <div class="ps-newsletter__line-h"></div>
        <div class="ps-newsletter__line-v"></div>

        <!-- Decorative Badge -->
        <div class="ps-newsletter__decor">
            <div class="ps-newsletter__decor-circle">
                <img alt="INDUZI abstract" src="<?= asset('images/logo-icon.png') ?>" loading="lazy"/>
                <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 09 — logo-icon.png</span>
            </div>
            <div class="ps-newsletter__decor-meta">
                <span class="ps-newsletter__decor-code">DS-V02/2024</span>
                <span class="ps-newsletter__decor-label">Creative Protocol</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══ MATERIAL — HERO TITLE ═══ -->
<section class="ps-material-hero ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 400px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">11 — MATERIAL HERO</span>
    <div class="ps-material-hero__inner">
        <span class="ps-material-hero__kicker">Manifesto 01</span>
        <h2 class="ps-material-hero__title">
            A Alquimia da<br/>Mat&eacute;ria
        </h2>
        <p class="ps-material-hero__desc">
            Exploramos a tens&atilde;o entre o bruto e o refinado. Onde a subst&acirc;ncia encontra a forma, o Studio Induzi molda o intang&iacute;vel atrav&eacute;s de um rigor t&eacute;cnico obsessivo.
        </p>
    </div>
</section>

<!-- ═══ MATERIAL — EDITORIAL GRID ═══ -->
<section class="ps-material-grid ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 900px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">12 — MATERIAL GRID</span>
    <div class="ps-material-grid__wrap">
        <!-- Acrílico (8 cols) -->
        <div class="ps-material-card ps-material-card--acrilico">
            <img alt="Acr&iacute;lico &mdash; Transpar&ecirc;ncia como mist&eacute;rio" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0llAfMUrEG7ozoW_l28K-vV1ZCgUL-YXkx5n5maJ09-8XWRzaZYiLLRN5jREyNZ5ZEJ08w27tW0LBeeHRPaqKyeWNnt9WmxQFcDFVJjwMKrGoDD9NzY4q2J0vZ-kHCqesxhw4H_IxUXTJVYtAuNbGlMbToHy9_mak3wYLLbfhFdEhGlt5iYg-araRLMatFH2pKG31oETeTdJkHJ17GGia6nBBQ2Kpf_mAcJqc6RVOgvxp4_iOVrr2ASsmLkb2y67LIT38mDnCyOFg" loading="lazy"/>
            <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 11 — acrilico.jpg</span>
            <div class="ps-material-card__gradient"></div>
            <div class="ps-material-card__info">
                <div class="ps-material-card__glass">
                    <h3 class="ps-material-card__title">Acr&iacute;lico</h3>
                    <p class="ps-material-card__desc">A transpar&ecirc;ncia como mist&eacute;rio. O acr&iacute;lico captura a luz e a suspende no espa&ccedil;o, criando di&aacute;logos entre o vis&iacute;vel e o oculto em cada refra&ccedil;&atilde;o precisa.</p>
                </div>
            </div>
        </div>
        <!-- Concreto (4 cols) -->
        <div class="ps-material-card ps-material-card--concreto">
            <img alt="Concreto &mdash; Brutalismo po&eacute;tico" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBUy5NndmAWbOwCtk4iZ3KaS8nMXYIYaASr3CelkRnVMsVwBFeRjIcYQrtmFoOL-LPkwAZWm8yiwkmVErTVlypF2v03oxw1qP5UmXFRvo1OjJb2Z26UxjuWQt2MZgTMTxnZdByYxe4JVfynISFRu8HJH74qTdh4f_zbj1dAE0f0mx5L63DzxQrwKcn8yWRHyx3oLq9z9iB_N8_QScNciok6QQ7ax565bK3XNKR1JjuJuyOpx5X1br-0PvVgu_wEY0WOfsbwGUYDBGeD" loading="lazy"/>
            <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 12 — concreto.jpg</span>
            <div class="ps-material-card__gradient"></div>
            <div class="ps-material-card__info">
                <div class="ps-material-card__glass">
                    <h3 class="ps-material-card__title">Concreto</h3>
                    <p class="ps-material-card__desc">Brutalismo po&eacute;tico. A pedra moldada pelo homem que ancora nossas cria&ccedil;&otilde;es com sua gravidade honesta e textura implac&aacute;vel.</p>
                </div>
            </div>
        </div>
        <!-- Metal (5 cols) -->
        <div class="ps-material-card ps-material-card--metal">
            <img alt="Metal &mdash; Precis&atilde;o e resist&ecirc;ncia" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnd5sokSVAVpUvHxB-n47R3949r9oBNCRrW2fQuddoMSD_1WbmLqHqcQySOKCUZHm2UDq2ArTBBF9b6Istqgf6tiKXV1PhjPD5wNzpd83KssXRXFnDBaXx34Y28VimK6N0dIljSFrPoL8OHJNHa3aOalA4u5UwFH9Wmx3qDVlzV4Wfy6767ypi14brP4Ft6xO_fUKuJQ4SLzDJ04bhjB1C1zsm1Gyz8VbHY9fYO56c36L9crkl1lgXcNNkp8A6ePsH5sX3qwWiaHr6" loading="lazy"/>
            <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 13 — metal.jpg</span>
            <div class="ps-material-card__gradient"></div>
            <div class="ps-material-card__info">
                <div class="ps-material-card__glass">
                    <h3 class="ps-material-card__title">Metal</h3>
                    <p class="ps-material-card__desc">Precis&atilde;o e resist&ecirc;ncia. O metal &eacute; a espinha dorsal de nossa est&eacute;tica, dobrado ao desejo atrav&eacute;s do calor e da engenharia.</p>
                </div>
            </div>
        </div>
        <!-- Madeira (7 cols) -->
        <div class="ps-material-card ps-material-card--madeira">
            <img alt="Madeira &mdash; Calor org&acirc;nico" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPGCKLCwCjUotMeGreudijbQVKUpxnNAOEmRVnJy9fevAvRA14MAvOdSeUiEUZPN6pE5Livu1kWDmWc4MwVOXp-d_mrqBFf7cld0DFQzW-zwWCjkMyrOzo06hTSnLtbtb8-6QGejnbkzxabg_4yRvaaQFN2zT0z07Kzqjdev2kpwufEgNX4040fph0VBPj5r6rDlEO1nd9XXAIp9T0aaze2ab9MT2filziUzjMP3RzTq7zlHs0KY8y3-PY5FvEwrSE0zjwMWKRH0Ds" loading="lazy"/>
            <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 14 — madeira.jpg</span>
            <div class="ps-material-card__gradient"></div>
            <div class="ps-material-card__info">
                <div class="ps-material-card__glass">
                    <h3 class="ps-material-card__title">Madeira</h3>
                    <p class="ps-material-card__desc">O calor da vida org&acirc;nica. Cada veio conta uma hist&oacute;ria de tempo, equilibrando a frieza do industrial com o toque ancestral da natureza.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ MATERIAL — TECH DETAIL ═══ -->
<section class="ps-material-tech ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 300px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">13 — MATERIAL TECH</span>
    <div class="ps-material-tech__inner">
        <div class="ps-material-tech__text">
            <h2 class="ps-material-tech__title">O Rigor do Atelier</h2>
            <p class="ps-material-tech__desc">
                No Studio Induzi, n&atilde;o apenas selecionamos materiais; n&oacute;s os interrogamos. Cada pe&ccedil;a de acr&iacute;lico ou viga de carvalho passa por um processo de curadoria que prioriza a integridade estrutural e a resson&acirc;ncia est&eacute;tica. Nossa &ldquo;alquimia&rdquo; &eacute; o resultado de anos de experimenta&ccedil;&atilde;o com processos industriais e manuais.
            </p>
        </div>
        <div class="ps-material-tech__stats">
            <div>
                <span class="ps-material-tech__stat-label">Toler&acirc;ncia</span>
                <span class="ps-material-tech__stat-value">0.02mm</span>
            </div>
            <div>
                <span class="ps-material-tech__stat-label">Curadoria</span>
                <span class="ps-material-tech__stat-value">Global</span>
            </div>
            <div>
                <span class="ps-material-tech__stat-label">Acabamento</span>
                <span class="ps-material-tech__stat-value">Manual</span>
            </div>
            <div>
                <span class="ps-material-tech__stat-label">Origem</span>
                <span class="ps-material-tech__stat-value">Manchester</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══ STUDIO — ESSÊNCIA ═══ -->
<section class="ps-studio-essence ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 500px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">14 — STUDIO ESS&Ecirc;NCIA</span>
    <div class="ps-studio-essence__inner">
        <span class="ps-studio-essence__kicker">A Ess&ecirc;ncia</span>
        <blockquote class="ps-studio-essence__quote">
            &ldquo;N&atilde;o se trata apenas de est&eacute;tica. Se trata de composi&ccedil;&atilde;o, <span class="ps-accent-text">leitura</span> e profundidade.&rdquo;
        </blockquote>
        <div class="ps-studio-essence__pillars">
            <div class="ps-studio-essence__pillar">
                <h4 class="ps-studio-essence__pillar-label">Composi&ccedil;&atilde;o</h4>
                <p class="ps-studio-essence__pillar-desc">O equil&iacute;brio exato entre o peso visual e a funcionalidade silenciosa de cada pe&ccedil;a.</p>
            </div>
            <div class="ps-studio-essence__pillar">
                <h4 class="ps-studio-essence__pillar-label">Leitura</h4>
                <p class="ps-studio-essence__pillar-desc">A capacidade de traduzir o invis&iacute;vel em estruturas que dialogam com o ambiente.</p>
            </div>
            <div class="ps-studio-essence__pillar">
                <h4 class="ps-studio-essence__pillar-label">Profundidade</h4>
                <p class="ps-studio-essence__pillar-desc">Camadas de significado que se revelam atrav&eacute;s do toque e da luz.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ STUDIO — O STUDIO ═══ -->
<section class="ps-studio-founder ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 600px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">15 — O STUDIO</span>
    <div class="ps-studio-founder__grid">
        <div class="ps-studio-founder__text">
            <span class="ps-studio-founder__kicker">Nossa Origem</span>
            <h2 class="ps-studio-founder__name">Studio INDUZI</h2>
            <p class="ps-studio-founder__bio">
                A hist&oacute;ria do Induzi n&atilde;o come&ccedil;a em um escrit&oacute;rio de design, mas no ch&atilde;o de uma oficina. O que come&ccedil;ou como curiosidade infantil evoluiu para uma maestria t&eacute;cnica refinada por d&eacute;cadas de experimenta&ccedil;&atilde;o. De Manchester a S&atilde;o Paulo, a jornada foi marcada pela busca incessante por materiais que pudessem expressar o que as palavras n&atilde;o conseguiam.
            </p>
            <p class="ps-studio-founder__cite">
                &ldquo;O Induzi Studio &eacute; o ponto de converg&ecirc;ncia entre a heran&ccedil;a artesanal e o design contempor&acirc;neo mais arrojado.&rdquo;
            </p>
        </div>
        <div class="ps-studio-founder__portrait-wrap">
            <img class="ps-studio-founder__portrait" alt="INDUZI Studio &mdash; Ateli&ecirc;" src="<?= asset('images/hero-profile.jpeg') ?>" loading="lazy"/>
            <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 16 — hero-profile.jpeg</span>
            <div class="ps-studio-founder__portrait-overlay"></div>
        </div>
    </div>
</section>

<!-- ═══ STUDIO — VALORES ═══ -->
<section class="ps-studio-values ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 400px;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">16 — STUDIO VALORES</span>
    <div class="ps-studio-values__inner">
        <div class="ps-studio-values__grid">
            <div class="ps-studio-values__card">
                <span class="ps-studio-values__card-label">Vis&atilde;o</span>
                <h4 class="ps-studio-values__card-title">Enxergar al&eacute;m do &oacute;bvio.</h4>
                <p class="ps-studio-values__card-desc">Identificamos oportunidades onde outros veem obst&aacute;culos. O design como antecipa&ccedil;&atilde;o do futuro.</p>
            </div>
            <div class="ps-studio-values__card">
                <span class="ps-studio-values__card-label">Prepara&ccedil;&atilde;o</span>
                <h4 class="ps-studio-values__card-title">Base s&oacute;lida para o voo.</h4>
                <p class="ps-studio-values__card-desc">Nenhuma decis&atilde;o &eacute; aleat&oacute;ria. Cada detalhe &eacute; planejado com rigor t&eacute;cnico e sensibilidade est&eacute;tica.</p>
            </div>
            <div class="ps-studio-values__card">
                <span class="ps-studio-values__card-label">Excel&ecirc;ncia</span>
                <h4 class="ps-studio-values__card-title">O padr&atilde;o &eacute; a exce&ccedil;&atilde;o.</h4>
                <p class="ps-studio-values__card-desc">N&atilde;o buscamos apenas o bom, mas o extraordin&aacute;rio que resiste ao teste do tempo.</p>
            </div>
            <div class="ps-studio-values__card">
                <span class="ps-studio-values__card-label">Responsabilidade</span>
                <h4 class="ps-studio-values__card-title">Legado em cada pe&ccedil;a.</h4>
                <p class="ps-studio-values__card-desc">Cuidamos de cada etapa com a consci&ecirc;ncia de que entregamos mais que um objeto, entregamos um valor.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══ PENSAMENTO ═══ -->
<section class="ps-pensamento ps-animate-on-scroll" style="content-visibility:auto;contain-intrinsic-size:auto 100vh;position:relative;">
    <span class="__dev-label" style="position:absolute;top:8px;left:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">17 — PENSAMENTO</span>

    <!-- Background Portrait -->
    <div class="ps-pensamento__bg">
        <img alt="Bruno Duzi &mdash; Profundidade" src="<?= asset('images/pensamento.jpeg') ?>" loading="lazy"/>
        <span class="__dev-label" style="position:absolute;bottom:8px;right:8px;z-index:9999;background:#ff0000;color:#fff;font-size:10px;font-family:monospace;padding:2px 8px;border-radius:2px;pointer-events:none;line-height:1.4;opacity:0.9;">IMG 15 — pensamento.jpeg</span>
        <div class="ps-pensamento__vignette"></div>
        <div class="ps-pensamento__overlay"></div>
    </div>

    <!-- Central Typography -->
    <div class="ps-pensamento__center">
        <h2 class="ps-pensamento__title">INDUZI: PROFUNDIDADE</h2>
        <div class="ps-pensamento__line"></div>
    </div>

    <!-- Philosophy Text -->
    <div class="ps-pensamento__text">
        <p>O sil&ecirc;ncio &eacute; a mat&eacute;ria-prima do alquimista. Entre o vis&iacute;vel e o oculto, Bruno Duzi transforma a ess&ecirc;ncia bruta em profundidade est&eacute;tica, onde cada sombra conta uma hist&oacute;ria e cada vazio &eacute; preenchido pela inten&ccedil;&atilde;o pura do artes&atilde;o.</p>
    </div>
</section>
