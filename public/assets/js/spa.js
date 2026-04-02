/**
 * SPA Navigation Module
 * Intercepta links internos, carrega fragmentos via fetch,
 * gerencia History API, loading states e fallback.
 */
const SPA = (function () {
    'use strict';

    // ── Config ──
    const FRAGMENT_API = '/api/fragment?page=';
    const CACHE_PREFIX = 'spa_cache_';
    const CACHE_VERSION = 'v1';
    const CACHE_TTL = 5 * 60 * 1000; // 5 minutos
    const CONTENT_SELECTOR = '#spa-content';
    const PROGRESS_SELECTOR = '#spa-progress';

    let contentEl = null;
    let progressEl = null;
    let isNavigating = false;

    // ── Init ──
    function init() {
        contentEl = document.querySelector(CONTENT_SELECTOR);
        if (!contentEl) return; // Fallback: sem SPA

        createProgressBar();
        interceptLinks();
        handlePopState();
    }

    // ── Progress Bar (NProgress-style) ──
    function createProgressBar() {
        if (document.querySelector(PROGRESS_SELECTOR)) return;

        const bar = document.createElement('div');
        bar.id = 'spa-progress';
        bar.innerHTML = '<div class="spa-progress-bar"></div>';
        document.body.prepend(bar);
        progressEl = bar;
    }

    function showProgress() {
        if (!progressEl) return;
        progressEl.classList.add('active');
    }

    function hideProgress() {
        if (!progressEl) return;
        progressEl.classList.add('done');
        setTimeout(() => {
            progressEl.classList.remove('active', 'done');
        }, 300);
    }

    // ── Skeleton Loading ──
    function showSkeleton() {
        if (!contentEl) return;
        contentEl.style.opacity = '0.4';
        contentEl.style.transition = 'opacity 0.2s';

        const skeleton = document.createElement('div');
        skeleton.className = 'spa-skeleton';
        skeleton.innerHTML = `
            <div class="skeleton-line" style="width:60%;height:32px;margin-bottom:16px;"></div>
            <div class="skeleton-line" style="width:100%;height:16px;margin-bottom:8px;"></div>
            <div class="skeleton-line" style="width:90%;height:16px;margin-bottom:8px;"></div>
            <div class="skeleton-line" style="width:75%;height:16px;margin-bottom:24px;"></div>
            <div class="skeleton-line" style="width:100%;height:200px;border-radius:8px;"></div>
        `;
        contentEl.prepend(skeleton);
    }

    function hideSkeleton() {
        if (!contentEl) return;
        const skeleton = contentEl.querySelector('.spa-skeleton');
        if (skeleton) skeleton.remove();
        contentEl.style.opacity = '1';
    }

    // ── Link Interception (event delegation) ──
    function interceptLinks() {
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href');

            // Ignorar links externos, download, target, hash, etc.
            if (!href ||
                href.startsWith('http') ||
                href.startsWith('//') ||
                href.startsWith('#') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                link.hasAttribute('download') ||
                link.hasAttribute('target') ||
                link.dataset.spaIgnore !== undefined ||
                e.ctrlKey || e.metaKey || e.shiftKey) {
                return;
            }

            e.preventDefault();
            navigate(href);
        });
    }

    // ── Navigate ──
    function navigate(url, pushState = true) {
        if (isNavigating) return;
        if (url === window.location.pathname) return;

        isNavigating = true;
        showProgress();
        showSkeleton();

        // Extrair nome da pagina da URL
        const page = urlToPage(url);

        // Verificar cache
        const cached = getCache(page);
        if (cached) {
            applyFragment(cached, url, pushState);
            isNavigating = false;
            return;
        }

        // Fetch do fragmento
        fetch(FRAGMENT_API + encodeURIComponent(page), {
            headers: {
                'X-Fragment': 'true',
                'Accept': 'application/fragment+json'
            }
        })
        .then(function (res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function (fragment) {
            setCache(page, fragment);
            applyFragment(fragment, url, pushState);
        })
        .catch(function (err) {
            // Fallback: navegacao tradicional
            console.warn('[SPA] Fallback para navegacao tradicional:', err.message);
            window.location.href = url;
        })
        .finally(function () {
            isNavigating = false;
        });
    }

    // ── Apply Fragment to DOM ──
    function applyFragment(fragment, url, pushState) {
        if (!contentEl || !fragment.html) {
            hideProgress();
            hideSkeleton();
            return;
        }

        // Fade out
        contentEl.style.opacity = '0';
        contentEl.style.transform = 'translateY(8px)';

        setTimeout(function () {
            // Inserir HTML
            hideSkeleton();
            contentEl.innerHTML = fragment.html;

            // Inserir CSS inline do fragmento
            if (fragment.css) {
                const style = document.createElement('style');
                style.dataset.spaFragment = 'true';
                style.textContent = fragment.css;
                document.head.appendChild(style);
            }

            // Executar JS do fragmento
            if (fragment.js) {
                const script = document.createElement('script');
                script.textContent = fragment.js;
                document.body.appendChild(script);
            }

            // Atualizar titulo
            if (fragment.title) {
                document.title = fragment.title;
            }

            // History API
            if (pushState) {
                history.pushState({ page: url, fragment: true }, fragment.title || '', url);
            }

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Fade in
            contentEl.style.transition = 'opacity 0.3s, transform 0.3s';
            contentEl.style.opacity = '1';
            contentEl.style.transform = 'translateY(0)';

            hideProgress();

            // Disparar evento custom
            document.dispatchEvent(new CustomEvent('spa:navigated', { detail: { url, fragment } }));
        }, 200);
    }

    // ── Handle browser back/forward ──
    function handlePopState() {
        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.fragment) {
                navigate(e.state.page, false);
            } else {
                // Primeira pagina — reload
                navigate(window.location.pathname, false);
            }
        });
    }

    // ── URL to Page name ──
    function urlToPage(url) {
        let page = url.replace(/^\/+|\/+$/g, '');
        return page || 'home';
    }

    // ── Cache com localStorage ──
    function getCache(page) {
        try {
            const key = CACHE_PREFIX + CACHE_VERSION + '_' + page;
            const raw = localStorage.getItem(key);
            if (!raw) return null;

            const data = JSON.parse(raw);
            if (Date.now() - data._cached > CACHE_TTL) {
                localStorage.removeItem(key);
                return null;
            }
            return data;
        } catch (e) {
            return null;
        }
    }

    function setCache(page, fragment) {
        try {
            fragment._cached = Date.now();
            const key = CACHE_PREFIX + CACHE_VERSION + '_' + page;
            localStorage.setItem(key, JSON.stringify(fragment));
        } catch (e) {
            // localStorage cheio — ignorar
        }
    }

    /**
     * Limpar cache de fragmentos.
     */
    function clearCache() {
        Object.keys(localStorage).forEach(function (key) {
            if (key.startsWith(CACHE_PREFIX)) {
                localStorage.removeItem(key);
            }
        });
    }

    // ── Public API ──
    return {
        init: init,
        navigate: navigate,
        clearCache: clearCache
    };
})();

// Auto-init quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', SPA.init);

// Fix bfcache: reset SPA state when restored from back-forward cache
window.addEventListener('pageshow', function (e) {
  if (e.persisted) {
    var content = document.querySelector('#spa-content');
    if (content) {
      content.style.opacity = '1';
      content.style.transform = 'none';
      var skeleton = content.querySelector('.spa-skeleton');
      if (skeleton) skeleton.remove();
    }
    var progress = document.querySelector('#spa-progress');
    if (progress) progress.classList.remove('active', 'done');
  }
});
