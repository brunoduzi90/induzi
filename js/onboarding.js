/**
 * InduziOnboarding — Tour de Onboarding (5 passos)
 */
var InduziOnboarding = (function() {
    var overlay = null;
    var spotlight = null;
    var tooltip = null;
    var currentStep = 0;
    var isActive = false;

    var STEPS = [
        {
            target: '.sidebar-house',
            title: 'Projeto Ativo',
            text: 'Aqui voce ve o projeto atualmente selecionado. Clique em "Trocar Projeto" no menu para mudar.',
            position: 'right'
        },
        {
            target: '#modulosSection',
            title: 'Modulos',
            text: 'Navegue pelos modulos de planejamento: Branding, Copywriter, Estrutura, SEO e mais.',
            position: 'right'
        },
        {
            target: '.top-bar-menu',
            title: 'Menu do Usuario',
            text: 'Acesse opcoes da conta, troque de projeto ou faca logout.',
            position: 'bottom'
        },
        {
            target: '.dash-card[data-route="copywriter"]',
            title: 'Cards de Modulos',
            text: 'Cada card mostra o progresso do modulo. Clique para abrir e comecar a preencher.',
            position: 'bottom'
        },
        {
            target: '.project-config-card',
            title: 'Configuracoes',
            text: 'Configure URL, nicho e notas do projeto. Use os botoes de exportar/importar para backup.',
            position: 'top'
        }
    ];

    function ensureDOM() {
        if (overlay) return;
        overlay = document.createElement('div');
        overlay.className = 'onboarding-overlay';
        document.body.appendChild(overlay);

        spotlight = document.createElement('div');
        spotlight.className = 'onboarding-spotlight';
        document.body.appendChild(spotlight);

        tooltip = document.createElement('div');
        tooltip.className = 'onboarding-tooltip';
        document.body.appendChild(tooltip);
    }

    function start() {
        if (isActive) return;
        ensureDOM();
        isActive = true;
        currentStep = 0;
        overlay.classList.add('active');
        showStep(0);
    }

    function showStep(idx) {
        currentStep = idx;
        var step = STEPS[idx];
        if (!step) { finish(); return; }

        var target = document.querySelector(step.target);
        if (!target) {
            // Skip this step if target not found
            if (idx < STEPS.length - 1) showStep(idx + 1);
            else finish();
            return;
        }

        var rect = target.getBoundingClientRect();
        var pad = 8;

        // Position spotlight
        spotlight.style.display = 'block';
        spotlight.style.top = (rect.top - pad) + 'px';
        spotlight.style.left = (rect.left - pad) + 'px';
        spotlight.style.width = (rect.width + pad * 2) + 'px';
        spotlight.style.height = (rect.height + pad * 2) + 'px';

        // Build tooltip content
        tooltip.innerHTML = '<h4>' + step.title + '</h4>' +
            '<p>' + step.text + '</p>' +
            '<div class="onboarding-footer">' +
            '<span class="onboarding-steps">' + (idx + 1) + ' / ' + STEPS.length + '</span>' +
            '<div class="onboarding-btns">' +
            '<button class="onboarding-btn-skip" onclick="InduziOnboarding.skip()">Pular</button>' +
            '<button class="onboarding-btn-next" onclick="InduziOnboarding.next()">' + (idx === STEPS.length - 1 ? 'Concluir' : 'Proximo') + '</button>' +
            '</div></div>';

        // Position tooltip
        tooltip.style.display = 'block';
        var tw = 320;
        var ttop, tleft;

        if (step.position === 'right') {
            ttop = rect.top;
            tleft = rect.right + pad + 12;
        } else if (step.position === 'bottom') {
            ttop = rect.bottom + pad + 12;
            tleft = rect.left;
        } else if (step.position === 'top') {
            ttop = rect.top - pad - 12 - 160;
            tleft = rect.left;
        } else {
            ttop = rect.top;
            tleft = rect.left - tw - pad - 12;
        }

        // Keep in viewport
        if (tleft + tw > window.innerWidth - 20) tleft = window.innerWidth - tw - 20;
        if (tleft < 10) tleft = 10;
        if (ttop < 10) ttop = 10;

        tooltip.style.top = ttop + 'px';
        tooltip.style.left = tleft + 'px';

        target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function next() {
        if (currentStep < STEPS.length - 1) showStep(currentStep + 1);
        else finish();
    }

    function skip() { finish(); }

    function finish() {
        isActive = false;
        if (overlay) overlay.classList.remove('active');
        if (spotlight) spotlight.style.display = 'none';
        if (tooltip) tooltip.style.display = 'none';
        // Save onboarding as done
        if (window.InduziAuth) InduziAuth.salvarPreferencias({ onboardingDone: true });
    }

    function shouldShow() {
        if (!window.InduziAuth || !InduziAuth.isLoggedIn()) return false;
        return !InduziAuth.getPreferencia('onboardingDone', false);
    }

    // Auto-trigger after first SPA navigation to painel
    function autoTrigger() {
        if (!shouldShow()) return;
        window.addEventListener('spa:routechange', function handler(e) {
            if (e.detail.route === 'painel' && shouldShow()) {
                window.removeEventListener('spa:routechange', handler);
                setTimeout(start, 800);
            }
        });
    }

    return {
        start: start,
        next: next,
        skip: skip,
        finish: finish,
        autoTrigger: autoTrigger
    };
})();
