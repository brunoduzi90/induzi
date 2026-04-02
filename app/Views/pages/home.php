<style>
/* Home — hide layout footer (snap container has its own) */
.ps-footer--premium { display: none !important; }
.ps-snap-container .ps-footer--premium { display: block !important; }
.ps-scroll-progress,
.ps-back-to-top,
.ps-snap-wipe { display: none !important; }

/* Snap container — instant, no smooth */
.ps-snap-container {
    scroll-behavior: auto;
}

/* Centered section content */
.ps-home-section {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    background: #000;
}

/* Bigger biglink for fullscreen sections */
.ps-home-section .ps-footer__biglink {
    font-size: clamp(3rem, 8vw, 9rem);
    line-height: 1;
    z-index: 2;
    position: relative;
}
#section-studio .ps-footer__biglink-text {
    text-shadow: 0 0 40px rgba(0,0,0,0.9), 0 0 80px rgba(0,0,0,0.6);
    -webkit-text-stroke: 1px rgba(255,255,255,0.15);
}

/* Section inner content wrapper */
.ps-home-section__inner {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 4;
    text-align: center;
    transform: none !important;
    pointer-events: none;
}
.ps-home-section__inner a,
.ps-home-section__inner p {
    pointer-events: auto;
}

.ps-home-section__tagline {
    font-family: var(--ps-font-body);
    font-size: clamp(0.85rem, 1.1vw, 1.05rem);
    font-weight: var(--ps-weight-light);
    color: var(--ps-text-primary);
    letter-spacing: 0.02em;
    text-transform: none;
    line-height: var(--ps-leading-normal);
    max-width: 550px;
    margin-bottom: 0;
    position: absolute;
    bottom: clamp(2rem, 5vh, 4rem);
    left: 50%;
    transform: translateX(-50%);
}

/* ── Parallax Layers ── */
.ps-parallax-layer {
    position: absolute;
    pointer-events: none;
    will-change: transform;
    transition: transform 0.15s ease-out;
}

/* ── Studio Background ── */
.ps-studio-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
    pointer-events: none;
    opacity: 0.3;
    filter: brightness(0.35);
}

/* ── Studio Collage ── */
.ps-studio-collage {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ps-studio-collage__piece {
    position: absolute;
    pointer-events: auto;
    will-change: transform;
    transition: transform 0.18s ease-out, filter 0.5s ease;
    object-fit: contain;
    filter: sepia(20%) contrast(0.9) brightness(0.25) saturate(0.75);
}
.ps-studio-collage__piece.is-hovered {
    filter: sepia(0%) contrast(1.05) brightness(0.7) saturate(1.3);
}

/* Flowers — top */
.ps-studio-collage__piece--flowers {
    width: clamp(650px, 100vw, 1600px);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -48%);
    opacity: 0.92;
    z-index: 1;
}

/* Top of head — middle-upper */
.ps-studio-collage__piece--head-top {
    width: clamp(630px, 95vw, 1500px);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -48.5%);
    z-index: 2;
}

/* Bust — middle-lower */
.ps-studio-collage__piece--bust {
    width: clamp(700px, 105vw, 1700px);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -47.5%);
    z-index: 3;
}

/* Glass leaf — front layer */
.ps-studio-collage__piece--glass {
    width: clamp(650px, 100vw, 1600px);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -51%);
    z-index: 4;
}

@media (max-width: 768px) {
    .ps-studio-collage__piece--flowers { width: 550px; }
    .ps-studio-collage__piece--head-top { width: 530px; }
    .ps-studio-collage__piece--bust { width: 600px; }
    .ps-studio-collage__piece--glass { width: 550px; }
}

/* ── Wipe Transition ── */
.ps-wipe-out {
    position: fixed;
    inset: 0;
    z-index: 10000;
    pointer-events: none;
    background: var(--ps-accent);
    transform: scaleY(0);
    transform-origin: bottom;
    animation: ps-wipe-enter 0.4s cubic-bezier(.77, 0, .18, 1) forwards;
}

@keyframes ps-wipe-enter {
    from { transform: scaleY(0); }
    to   { transform: scaleY(1); }
}
</style>

<div class="ps-snap-container">
    <section class="ps-snap-section ps-home-section" id="section-studio" data-collage-parallax>
        <!-- Studio background -->
        <img src="<?= asset('images/Studio/bg-studio.jpeg') ?>" alt="" class="ps-studio-bg" aria-hidden="true"/>
        <!-- Studio collage artwork -->
        <div class="ps-studio-collage">
            <img src="<?= asset('images/Studio/4.png') ?>" alt="" class="ps-studio-collage__piece ps-studio-collage__piece--flowers" data-depth="0.04" aria-hidden="true"/>
            <img src="<?= asset('images/Studio/3.png') ?>" alt="" class="ps-studio-collage__piece ps-studio-collage__piece--head-top" data-depth="0.06" aria-hidden="true"/>
            <img src="<?= asset('images/Studio/2.png') ?>" alt="" class="ps-studio-collage__piece ps-studio-collage__piece--bust" data-depth="0.05" aria-hidden="true"/>
            <img src="<?= asset('images/Studio/1.png') ?>" alt="" class="ps-studio-collage__piece ps-studio-collage__piece--glass" data-depth="0.04" aria-hidden="true"/>
        </div>

        <div class="ps-home-section__inner">
            <a href="<?= url('/studio') ?>" class="ps-footer__biglink" data-wipe-nav data-spa-ignore><span class="ps-footer__biglink-text">Studio<span class="ps-scribble" aria-hidden="true"><img class="ps-scribble__img ps-scribble__img--1" src="<?= asset('images/Efeitos/1.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--2" src="<?= asset('images/Efeitos/2.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--3" src="<?= asset('images/Efeitos/3.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--4" src="<?= asset('images/Efeitos/4.svg') ?>" alt=""/></span></span></a>
            <p class="ps-home-section__tagline">Onde cada pe&ccedil;a nasce &mdash; da concep&ccedil;&atilde;o artesanal<br/>ao acabamento de precis&atilde;o com sensibilidade est&eacute;tica.</p>
        </div>
    </section>

    <section class="ps-snap-section ps-home-section" id="section-trabalhos">
        <div class="ps-home-section__inner">
            <a href="<?= url('/portfolio') ?>" class="ps-footer__biglink" data-wipe-nav data-spa-ignore><span class="ps-footer__biglink-text">Trabalhos<span class="ps-scribble" aria-hidden="true"><img class="ps-scribble__img ps-scribble__img--1" src="<?= asset('images/Efeitos/1.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--2" src="<?= asset('images/Efeitos/2.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--3" src="<?= asset('images/Efeitos/3.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--4" src="<?= asset('images/Efeitos/4.svg') ?>" alt=""/></span></span></a>
            <p class="ps-home-section__tagline">Mobili&aacute;rio autoral, arquitetura de interiores e pe&ccedil;as escult&oacute;ricas<br/>criadas com rigor t&eacute;cnico e alma artesanal.</p>
        </div>
    </section>

    <section class="ps-snap-section ps-home-section" id="section-produtos">
        <div class="ps-home-section__inner">
            <a href="<?= url('/portfolio') ?>" class="ps-footer__biglink" data-wipe-nav data-spa-ignore><span class="ps-footer__biglink-text">Produtos<span class="ps-scribble" aria-hidden="true"><img class="ps-scribble__img ps-scribble__img--1" src="<?= asset('images/Efeitos/1.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--2" src="<?= asset('images/Efeitos/2.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--3" src="<?= asset('images/Efeitos/3.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--4" src="<?= asset('images/Efeitos/4.svg') ?>" alt=""/></span></span></a>
            <p class="ps-home-section__tagline">Acr&iacute;lico, metal, concreto e impress&atilde;o 3D &mdash;<br/>cada produto &eacute; uma edi&ccedil;&atilde;o limitada feita sob medida.</p>
        </div>
    </section>

    <section class="ps-snap-section ps-home-section" id="section-contato">
        <div class="ps-home-section__inner">
            <a href="<?= url('/contato') ?>" class="ps-footer__biglink" data-wipe-nav data-spa-ignore><span class="ps-footer__biglink-text">Contato<span class="ps-scribble" aria-hidden="true"><img class="ps-scribble__img ps-scribble__img--1" src="<?= asset('images/Efeitos/1.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--2" src="<?= asset('images/Efeitos/2.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--3" src="<?= asset('images/Efeitos/3.svg') ?>" alt=""/><img class="ps-scribble__img ps-scribble__img--4" src="<?= asset('images/Efeitos/4.svg') ?>" alt=""/></span></span></a>
            <p class="ps-home-section__tagline">Tem um projeto em mente? Fale conosco para uma consulta<br/>sobre design, viabilidade t&eacute;cnica e prazos.</p>
        </div>
    </section>

    <section class="ps-snap-section">
        <?php require ROOT_PATH . '/app/Views/components/footer.php'; ?>
    </section>
</div>

<script>
(function () {
    /* Fix black screen on browser back */
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            var old = document.querySelector('.ps-wipe-out');
            if (old) old.parentNode.removeChild(old);
        }
    });

    /* ── Wipe nav transition ── */
    document.querySelectorAll('[data-wipe-nav]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var href = this.href;
            var wipe = document.createElement('div');
            wipe.className = 'ps-wipe-out';
            document.body.appendChild(wipe);

            setTimeout(function () {
                window.location.href = href;
            }, 400);
        });
    });

    /* ── Per-piece hover via pixel alpha detection ── */
    (function () {
        var pieces = document.querySelectorAll('.ps-studio-collage__piece');
        var canvasMap = new Map();

        /* Draw each image into an offscreen canvas for alpha lookup */
        pieces.forEach(function (img) {
            var c = document.createElement('canvas');
            var ctx = c.getContext('2d', { willReadFrequently: true });

            function drawToCanvas() {
                c.width = img.naturalWidth;
                c.height = img.naturalHeight;
                ctx.drawImage(img, 0, 0);
                canvasMap.set(img, { canvas: c, ctx: ctx });
            }

            if (img.complete && img.naturalWidth) {
                drawToCanvas();
            } else {
                img.addEventListener('load', drawToCanvas);
            }
        });

        /* Check if a screen point hits an opaque pixel of a given piece */
        function isOpaqueAt(img, clientX, clientY) {
            var data = canvasMap.get(img);
            if (!data) return false;
            var rect = img.getBoundingClientRect();
            /* Map screen coords to image natural coords */
            var scaleX = img.naturalWidth / rect.width;
            var scaleY = img.naturalHeight / rect.height;
            var px = Math.round((clientX - rect.left) * scaleX);
            var py = Math.round((clientY - rect.top) * scaleY);
            if (px < 0 || py < 0 || px >= img.naturalWidth || py >= img.naturalHeight) return false;
            var alpha = data.ctx.getImageData(px, py, 1, 1).data[3];
            return alpha > 30;
        }

        var container = document.querySelector('.ps-snap-container');
        if (container) {
            container.addEventListener('mousemove', function (e) {
                /* Walk pieces from top z-index to bottom; first opaque hit wins */
                var sorted = Array.from(pieces).sort(function (a, b) {
                    return (parseInt(getComputedStyle(b).zIndex) || 0) - (parseInt(getComputedStyle(a).zIndex) || 0);
                });
                var hitPiece = null;
                for (var i = 0; i < sorted.length; i++) {
                    if (isOpaqueAt(sorted[i], e.clientX, e.clientY)) {
                        hitPiece = sorted[i];
                        break;
                    }
                }
                pieces.forEach(function (p) {
                    if (p === hitPiece) {
                        p.classList.add('is-hovered');
                    } else {
                        p.classList.remove('is-hovered');
                    }
                });
            });
            container.addEventListener('mouseleave', function () {
                pieces.forEach(function (p) { p.classList.remove('is-hovered'); });
            });
        }
    })();

    /* ── Parallax mouse-follow on layers ── */
    var section = document.querySelector('[data-collage-parallax]');
    if (section) {
        var layers = section.querySelectorAll('.ps-parallax-layer, .ps-studio-collage__piece');
        var container = document.querySelector('.ps-snap-container');

        /* Store original translateY offsets for each collage piece */
        var offsets = { flowers: '-48%', 'head-top': '-48.5%', bust: '-47.5%', glass: '-51%' };

        container.addEventListener('mousemove', function (e) {
            /* -0.5 to 0.5 from center */
            var mx = (e.clientX / window.innerWidth) - 0.5;
            var my = (e.clientY / window.innerHeight) - 0.5;

            layers.forEach(function (layer) {
                var depth = parseFloat(layer.dataset.depth) || 0.05;
                var moveX = mx * depth * 800;
                var moveY = my * depth * 800;
                if (layer.classList.contains('ps-studio-collage__piece')) {
                    var key = layer.classList.contains('ps-studio-collage__piece--flowers') ? 'flowers'
                            : layer.classList.contains('ps-studio-collage__piece--head-top') ? 'head-top'
                            : layer.classList.contains('ps-studio-collage__piece--glass') ? 'glass' : 'bust';
                    var baseY = offsets[key];
                    if (key === 'head-top') {
                        /* Centro: move normal */
                        layer.style.transform = 'translate(calc(-50% + ' + moveX.toFixed(1) + 'px), calc(' + baseY + ' + ' + moveY.toFixed(1) + 'px))';
                    } else if (key === 'flowers') {
                        /* Flores: inverte X, mantém Y parado */
                        layer.style.transform = 'translate(calc(-50% + ' + (-moveX).toFixed(1) + 'px), calc(' + baseY + ' + 0px))';
                    } else if (key === 'glass') {
                        /* Glass: move invertido nos dois eixos */
                        layer.style.transform = 'translate(calc(-50% + ' + (-moveX).toFixed(1) + 'px), calc(' + baseY + ' + ' + (-moveY).toFixed(1) + 'px))';
                    } else {
                        /* Busto: mantém X parado, inverte Y */
                        layer.style.transform = 'translate(calc(-50% + 0px), calc(' + baseY + ' + ' + (-moveY).toFixed(1) + 'px))';
                    }
                } else {
                    layer.style.transform = 'translate(' + moveX.toFixed(1) + 'px, ' + moveY.toFixed(1) + 'px)';
                }
            });
        });
    }
})();
</script>
