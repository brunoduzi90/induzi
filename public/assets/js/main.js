/* ==========================================================================
   Poison Studio — Unified Main JS
   DS interactions + Business modules + SPA orchestrator
   ========================================================================== */

(function () {
  'use strict';

  /* ========================================================================
     PART A — Design System Interactions (20 of 28)
     ======================================================================== */

  /* 1. SCROLL PROGRESS BAR */
  function initScrollProgress() {
    var bar = document.querySelector('.ps-scroll-progress');
    if (!bar) return;
    function update() {
      var h = document.documentElement.scrollHeight - window.innerHeight;
      var pct = h > 0 ? (window.scrollY / h) * 100 : 0;
      bar.style.width = pct + '%';
    }
    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  /* 2. CUSTOM CURSOR — dot + ring follower */
  function initCustomCursor() {
    var dot = document.querySelector('.ps-cursor__dot');
    var ring = document.querySelector('.ps-cursor__ring');
    if (!dot || !ring) return;
    var mx = 0, my = 0, rx = 0, ry = 0;
    document.addEventListener('mousemove', function (e) {
      mx = e.clientX;
      my = e.clientY;
      dot.style.transform = 'translate(' + mx + 'px,' + my + 'px)';
    });
    (function followRing() {
      rx += (mx - rx) * 0.12;
      ry += (my - ry) * 0.12;
      ring.style.transform = 'translate(' + rx + 'px,' + ry + 'px)';
      requestAnimationFrame(followRing);
    })();
    var interactives = 'a, button, .ps-btn, .ps-card, .ps-tag, .ps-social__link, .ps-toggle, input, select, .ps-accordion__header';
    document.querySelectorAll(interactives).forEach(function (el) {
      el.addEventListener('mouseenter', function () { ring.classList.add('is-hover'); dot.classList.add('is-hover'); });
      el.addEventListener('mouseleave', function () { ring.classList.remove('is-hover'); dot.classList.remove('is-hover'); });
    });
  }

  /* 3. SCROLL REVEAL — IntersectionObserver */
  function initScrollReveal() {
    var elements = document.querySelectorAll('.ps-reveal, .ps-animate-on-scroll, .ps-stagger, .ps-text-reveal');
    if (!elements.length) return;
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    elements.forEach(function (el) { observer.observe(el); });
  }

  /* 4. GLITCH EFFECT */
  function initGlitchEffect() {
    document.querySelectorAll('.ps-glitch').forEach(function (el) {
      (function schedule() {
        var delay = 2000 + Math.random() * 5000;
        setTimeout(function () {
          el.classList.add('is-glitching');
          setTimeout(function () {
            el.classList.remove('is-glitching');
            schedule();
          }, 100 + Math.random() * 200);
        }, delay);
      })();
    });
  }

  /* 5. MOUSE PARALLAX */
  function initMouseParallax() {
    var els = document.querySelectorAll('[data-parallax]');
    if (!els.length) return;
    var mx = 0, my = 0, cx = 0, cy = 0;
    document.addEventListener('mousemove', function (e) {
      mx = (e.clientX / window.innerWidth - 0.5) * 2;
      my = (e.clientY / window.innerHeight - 0.5) * 2;
    });
    (function tick() {
      cx += (mx - cx) * 0.05;
      cy += (my - cy) * 0.05;
      els.forEach(function (el) {
        var s = parseFloat(el.getAttribute('data-parallax')) || 1;
        el.style.transform = 'translate(' + (cx * s * 15) + 'px,' + (cy * s * 15) + 'px)';
      });
      requestAnimationFrame(tick);
    })();
  }

  /* 6. MAGNETIC BUTTONS */
  function initMagneticButtons() {
    document.querySelectorAll('.ps-btn--magnetic').forEach(function (btn) {
      btn.addEventListener('mousemove', function (e) {
        var r = btn.getBoundingClientRect();
        btn.style.transform = 'translate(' + ((e.clientX - r.left - r.width / 2) * 0.3) + 'px,' + ((e.clientY - r.top - r.height / 2) * 0.3) + 'px)';
      });
      btn.addEventListener('mouseleave', function () { btn.style.transform = 'translate(0,0)'; });
    });
  }

  /* 7. CARD 3D TILT */
  function initCardTilt() {
    document.querySelectorAll('.ps-card[data-tilt]').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        card.style.transform = 'perspective(600px) rotateY(' + (x * 8) + 'deg) rotateX(' + (-y * 8) + 'deg) scale(1.02)';
      });
      card.addEventListener('mouseleave', function () {
        card.style.transform = 'perspective(600px) rotateY(0) rotateX(0) scale(1)';
      });
    });
  }

  /* 8. BUTTON RIPPLE */
  function initButtonRipple() {
    document.querySelectorAll('.ps-btn--ripple').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        var r = btn.getBoundingClientRect();
        var ripple = document.createElement('span');
        ripple.className = 'ps-ripple';
        ripple.style.left = (e.clientX - r.left) + 'px';
        ripple.style.top = (e.clientY - r.top) + 'px';
        btn.appendChild(ripple);
        setTimeout(function () { ripple.remove(); }, 600);
      });
    });
  }

  /* 9. MODALS */
  function initModals() {
    document.querySelectorAll('[data-modal-open]').forEach(function (trigger) {
      trigger.addEventListener('click', function (e) {
        e.preventDefault();
        var id = this.getAttribute('data-modal-open');
        var modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('is-opening');
        requestAnimationFrame(function () {
          modal.classList.add('is-open');
          modal.classList.remove('is-opening');
        });
        document.body.style.overflow = 'hidden';
      });
    });
    document.querySelectorAll('[data-modal-close]').forEach(function (btn) {
      btn.addEventListener('click', function () { closeModal(this.closest('.ps-modal')); });
    });
    document.querySelectorAll('.ps-modal').forEach(function (modal) {
      modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(modal); });
    });
    function closeModal(modal) {
      if (!modal) return;
      modal.classList.add('is-closing');
      modal.classList.remove('is-open');
      setTimeout(function () { modal.classList.remove('is-closing'); document.body.style.overflow = ''; }, 400);
    }
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        var open = document.querySelector('.ps-modal.is-open');
        if (open) closeModal(open);
        var fm = document.querySelector('.ps-fullmenu.is-open');
        if (fm) {
          fm.classList.add('is-closing');
          fm.classList.remove('is-open');
          document.body.style.overflow = '';
          document.querySelectorAll('[data-fullmenu-toggle]').forEach(function (t) { t.classList.remove('is-active'); });
          setTimeout(function () { fm.classList.remove('is-closing'); }, 1000);
        }
      }
    });
  }

  /* 10. MOBILE MENU */
  function initMobileMenu() {
    var triggers = document.querySelectorAll('[data-menu-toggle]');
    var menu = document.querySelector('.ps-mobile-menu');
    if (!menu) return;
    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        var isOpen = menu.classList.contains('is-open');
        if (isOpen) {
          menu.classList.add('is-closing');
          menu.classList.remove('is-open');
          this.classList.remove('is-active');
          document.body.style.overflow = '';
          setTimeout(function () { menu.classList.remove('is-closing'); }, 500);
        } else {
          menu.classList.add('is-open');
          this.classList.add('is-active');
          document.body.style.overflow = 'hidden';
          menu.querySelectorAll('.ps-mobile-menu__link').forEach(function (link, i) {
            link.style.transitionDelay = (i * 80) + 'ms';
          });
        }
      });
    });
  }

  /* 11. ACCORDION */
  function initAccordions() {
    document.querySelectorAll('.ps-accordion__header').forEach(function (header) {
      header.addEventListener('click', function () {
        var item = this.closest('.ps-accordion__item') || this.closest('details');
        if (!item) return;
        // For <details> elements, let the browser handle open/close
        if (item.tagName === 'DETAILS') return;
        var body = item.querySelector('.ps-accordion__body');
        var content = item.querySelector('.ps-accordion__content');
        var isOpen = item.classList.contains('is-open');
        var accordion = item.closest('.ps-accordion');
        if (accordion) {
          accordion.querySelectorAll('.ps-accordion__item').forEach(function (i) {
            if (i !== item) {
              i.classList.remove('is-open');
              var b = i.querySelector('.ps-accordion__body');
              if (b) b.style.maxHeight = '0';
            }
          });
        }
        if (isOpen) {
          item.classList.remove('is-open');
          if (body) body.style.maxHeight = '0';
        } else {
          item.classList.add('is-open');
          if (body && content) body.style.maxHeight = content.scrollHeight + 'px';
        }
      });
    });
  }

  /* 12. MARQUEE */
  function initMarquee() {
    document.querySelectorAll('.ps-marquee__inner').forEach(function (inner) {
      if (!inner.dataset.cloned) {
        inner.innerHTML += inner.innerHTML;
        inner.dataset.cloned = 'true';
      }
    });
  }

  /* 13. TOGGLES */
  function initToggles() {
    document.querySelectorAll('.ps-toggle__input').forEach(function (input) {
      input.addEventListener('change', function () {
        var status = this.closest('.ps-toggle').nextElementSibling;
        if (status && status.classList.contains('ds-toggle-status'))
          status.textContent = this.checked ? 'On' : 'Off';
      });
    });
  }

  /* 14. NOISE OVERLAY */
  function initNoiseAnimation() {
    var noise = document.querySelector('.ps-noise');
    if (!noise) return;
    (function tick() {
      noise.style.backgroundPosition = (Math.random() * 256) + 'px ' + (Math.random() * 256) + 'px';
      requestAnimationFrame(tick);
    })();
  }

  /* 15. HAMBURGER */
  function initHamburger() {
    document.querySelectorAll('.ps-hamburger:not([data-menu-toggle])').forEach(function (h) {
      h.addEventListener('click', function () { this.classList.toggle('is-active'); });
    });
  }

  /* 16. TEXT SCRAMBLE */
  function initTextScramble() {
    var chars = '!<>-_\\/[]{}—=+*^?#_~ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    document.querySelectorAll('[data-scramble]').forEach(function (el) {
      var original = el.textContent;
      el.addEventListener('mouseenter', function () {
        var iteration = 0;
        var len = original.length;
        var interval = setInterval(function () {
          el.textContent = original.split('').map(function (c, i) {
            if (i < iteration) return original[i];
            return chars[Math.floor(Math.random() * chars.length)];
          }).join('');
          iteration += 1 / 2;
          if (iteration >= len) { el.textContent = original; clearInterval(interval); }
        }, 30);
      });
    });
  }

  /* 17. COUNTER ANIMATION */
  function initCounters() {
    var counters = document.querySelectorAll('[data-count-to]');
    if (!counters.length) return;
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var target = parseInt(el.getAttribute('data-count-to'));
        var duration = 1500;
        var startTime = null;
        function step(ts) {
          if (!startTime) startTime = ts;
          var progress = Math.min((ts - startTime) / duration, 1);
          var eased = 1 - Math.pow(1 - progress, 3);
          el.textContent = Math.floor(eased * target);
          if (progress < 1) requestAnimationFrame(step);
          else el.textContent = target;
        }
        requestAnimationFrame(step);
        observer.unobserve(el);
      });
    }, { threshold: 0.5 });
    counters.forEach(function (el) { observer.observe(el); });
  }

  /* 18. NAVBAR SCROLL STATE */
  function initNavbarScroll() {
    var navbar = document.querySelector('.ps-navbar');
    if (!navbar) return;
    window.addEventListener('scroll', function () {
      navbar.classList.toggle('is-scrolled', window.scrollY > 50);
    }, { passive: true });
  }

  /* 19. SOCIAL HOVER */
  function initSocialHover() {
    document.querySelectorAll('.ps-social').forEach(function (bar) {
      var links = bar.querySelectorAll('.ps-social__link');
      links.forEach(function (link, idx) {
        link.addEventListener('mouseenter', function () {
          if (links[idx - 1]) links[idx - 1].style.transform = 'scale(1.06)';
          if (links[idx + 1]) links[idx + 1].style.transform = 'scale(1.06)';
        });
        link.addEventListener('mouseleave', function () {
          if (links[idx - 1]) links[idx - 1].style.transform = '';
          if (links[idx + 1]) links[idx + 1].style.transform = '';
        });
      });
    });
  }

  /* 20. SERVICES HOVER */
  function initServicesHover() {
    document.querySelectorAll('.ps-services').forEach(function (grid) {
      var items = grid.querySelectorAll('.ps-services__item');
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            items.forEach(function (item, i) {
              item.style.transition = 'opacity 0.5s ease ' + (i * 60) + 'ms, transform 0.5s ease ' + (i * 60) + 'ms';
              item.style.opacity = '1';
              item.style.transform = 'translateY(0)';
            });
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.2 });
      items.forEach(function (item) { item.style.opacity = '0'; item.style.transform = 'translateY(15px)'; });
      observer.observe(grid);
    });
  }

  /* 21. CONSENT BANNER — with localStorage check */
  function initConsent() {
    var banner = document.querySelector('.ps-consent');
    if (!banner) return;
    // Check if already consented
    try {
      if (localStorage.getItem('cookie_consent')) return;
    } catch (e) { /* storage unavailable */ }
    setTimeout(function () { banner.classList.add('is-visible'); }, 1500);
    banner.querySelectorAll('[data-consent-close]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        banner.classList.remove('is-visible');
      });
    });
  }

  /* 22. FULLSCREEN MENU — image reveal on hover */
  function initFullMenu() {
    var menus = document.querySelectorAll('.ps-fullmenu');
    menus.forEach(function (menu) {
      var links = menu.querySelectorAll('.ps-fullmenu__link');
      var images = menu.querySelectorAll('.ps-fullmenu__img');

      links.forEach(function (link, i) {
        link.style.transitionDelay = (i * 80) + 'ms';
      });

      var imgMap = {};
      images.forEach(function (img) {
        imgMap[img.getAttribute('data-link')] = img;
      });

      var targetX = 0, targetY = 0, curX = 0, curY = 0;

      links.forEach(function (link) {
        link.addEventListener('mouseenter', function () {
          var key = this.getAttribute('data-image');
          images.forEach(function (img) { img.classList.remove('is-visible'); });
          if (key && imgMap[key]) imgMap[key].classList.add('is-visible');
        });
        link.addEventListener('mouseleave', function () {
          images.forEach(function (img) { img.classList.remove('is-visible'); });
        });
      });

      menu.addEventListener('mousemove', function (e) {
        targetX = e.clientX;
        targetY = e.clientY;
      });

      (function followImages() {
        curX += (targetX - curX) * 0.1;
        curY += (targetY - curY) * 0.1;
        images.forEach(function (img) {
          img.style.left = (curX - 140) + 'px';
          img.style.top = (curY - 180) + 'px';
        });
        requestAnimationFrame(followImages);
      })();

      document.querySelectorAll('[data-fullmenu-toggle]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
          var isOpen = menu.classList.contains('is-open');
          if (isOpen) {
            menu.classList.add('is-closing');
            menu.classList.remove('is-open');
            this.classList.remove('is-active');
            document.body.style.overflow = '';
            setTimeout(function () { menu.classList.remove('is-closing'); }, 1000);
          } else {
            menu.classList.add('is-open');
            this.classList.add('is-active');
            document.body.style.overflow = 'hidden';
          }
        });
      });
    });
  }

  /* 23. LIGHTBOX */
  function initLightbox() {
    var lightbox = document.querySelector('.ps-lightbox');
    if (!lightbox) return;

    var img = lightbox.querySelector('.ps-lightbox__img');
    var prevBtn = lightbox.querySelector('.ps-lightbox__nav--prev');
    var nextBtn = lightbox.querySelector('.ps-lightbox__nav--next');
    var closeBtn = lightbox.querySelector('.ps-lightbox__close');
    var items = document.querySelectorAll('.ps-gallery__item');
    var sources = [];
    var current = 0;

    items.forEach(function (item, i) {
      var src = item.querySelector('img');
      if (src) sources.push(src.getAttribute('src'));
      item.addEventListener('click', function () {
        current = i;
        show();
      });
    });

    function show() {
      if (!sources[current]) return;
      img.src = sources[current];
      lightbox.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    }

    function hide() {
      lightbox.classList.remove('is-open');
      document.body.style.overflow = '';
    }

    if (closeBtn) closeBtn.addEventListener('click', hide);
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) hide();
    });

    if (prevBtn) prevBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      current = (current - 1 + sources.length) % sources.length;
      img.src = sources[current];
    });

    if (nextBtn) nextBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      current = (current + 1) % sources.length;
      img.src = sources[current];
    });

    document.addEventListener('keydown', function (e) {
      if (!lightbox.classList.contains('is-open')) return;
      if (e.key === 'Escape') hide();
      if (e.key === 'ArrowLeft' && prevBtn) prevBtn.click();
      if (e.key === 'ArrowRight' && nextBtn) nextBtn.click();
    });
  }

  /* 24. DEPTH PARALLAX — layered 3D (mouse + scroll + gyroscope) */
  function initDepthParallax() {
    var containers = document.querySelectorAll('.ps-depth');
    if (!containers.length) return;

    var mx = 0, my = 0;
    var useGyro = false;

    document.addEventListener('mousemove', function (e) {
      if (useGyro) return;
      mx = (e.clientX / window.innerWidth - 0.5) * 2;
      my = (e.clientY / window.innerHeight - 0.5) * 2;
    });

    if (window.DeviceOrientationEvent) {
      window.addEventListener('deviceorientation', function (e) {
        if (!e.gamma && !e.beta) return;
        useGyro = true;
        mx = Math.max(-1, Math.min(1, e.gamma / 45));
        my = Math.max(-1, Math.min(1, (e.beta - 45) / 45));
      }, true);
    }

    containers.forEach(function (container) {
      var layers = container.querySelectorAll('.ps-depth__layer');
      if (!layers.length) return;

      var section = container.closest('section') || container.parentElement;
      var cx = 0, cy = 0;
      var maxPx = 80, ease = 0.06;

      (function tick() {
        cx += (mx - cx) * ease;
        cy += (my - cy) * ease;

        var rect = section.getBoundingClientRect();
        var scrollY = (rect.bottom > 0 && rect.top < window.innerHeight) ? -rect.top : 0;

        layers.forEach(function (layer) {
          var depth = parseFloat(layer.getAttribute('data-depth')) || 0.3;
          var tx = cx * maxPx * depth;
          var ty = cy * maxPx * depth + (scrollY * depth * 0.15);
          layer.style.transform = 'translate3d(' + tx.toFixed(1) + 'px,' + ty.toFixed(1) + 'px,0)';
        });

        requestAnimationFrame(tick);
      })();
    });
  }

  /* 25. SNAP WIPE TRANSITION */
  function initSnapWipe() {
    var wipe = document.getElementById('snap-wipe');
    if (!wipe) return;
    wipe.classList.add('is-entering');
    setTimeout(function () {
      wipe.classList.remove('is-entering');
      wipe.classList.add('is-exiting');
      setTimeout(function () { wipe.classList.remove('is-exiting'); }, 400);
    }, 400);
  }

  /* 26. SMOOTH SCROLL for anchor links */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        var href = this.getAttribute('href');
        if (href && href.length > 1) {
          var target = document.querySelector(href);
          if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        }
      });
    });
  }

  /* 27. FILTER BAR — client-side category filter */
  function initFilterBar() {
    var bar = document.querySelector('.ps-filter-bar');
    if (!bar) return;
    var buttons = bar.querySelectorAll('.ps-filter-btn');
    var grid = document.querySelector('.ps-listing-grid');
    if (!grid) return;
    var cards = grid.querySelectorAll('[data-category]');
    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        buttons.forEach(function (b) { b.classList.remove('is-active'); });
        this.classList.add('is-active');
        var filter = this.getAttribute('data-filter');
        cards.forEach(function (card) {
          if (!filter || filter === 'all') card.style.display = '';
          else card.style.display = card.getAttribute('data-category') === filter ? '' : 'none';
        });
      });
    });
  }

  /* 28. BACK TO TOP — show only while actively scrolling */
  function initBackToTop() {
    var btn = document.getElementById('back-to-top');
    if (!btn) return;
    var hideTimer = null;
    window.addEventListener('scroll', function () {
      if (window.scrollY > 100) {
        btn.classList.add('is-visible');
        clearTimeout(hideTimer);
        hideTimer = setTimeout(function () {
          btn.classList.remove('is-visible');
        }, 1500);
      } else {
        btn.classList.remove('is-visible');
        clearTimeout(hideTimer);
      }
    }, { passive: true });
    btn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }


  /* ========================================================================
     PART B — Business Modules
     ======================================================================== */

  /* --- Toast (rewritten with ps-toast classes) --- */
  var Toast = (function () {
    var container = null;

    function getContainer() {
      if (!container) {
        container = document.createElement('div');
        container.className = 'ps-toast-container';
        document.body.appendChild(container);
      }
      return container;
    }

    function show(message, type, duration) {
      if (type === undefined) type = 'info';
      if (duration === undefined) duration = 4000;
      var c = getContainer();
      var el = document.createElement('div');
      el.className = 'ps-toast ps-toast--' + type;
      el.innerHTML = '<span class="ps-toast__message">' + message + '</span><button class="ps-toast__close" aria-label="Fechar">&times;</button>';
      c.appendChild(el);
      el.querySelector('.ps-toast__close').addEventListener('click', function () { remove(el); });
      if (duration > 0) setTimeout(function () { remove(el); }, duration);
      setTimeout(function () { el.classList.add('is-visible'); }, 10);
      return el;
    }

    function remove(el) {
      el.classList.remove('is-visible');
      setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 300);
    }

    return { show: show };
  })();

  /* --- Api (fetch wrapper) --- */
  var Api = (function () {
    var maxRetries = 2, retryDelay = 1000, timeout = 30000;

    function getCsrfToken() {
      var m = document.querySelector('meta[name="csrf-token"]');
      if (m) return m.getAttribute('content');
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var parts = cookies[i].trim().split('=');
        if (parts[0] === 'XSRF-TOKEN' || parts[0] === 'csrf_token') return decodeURIComponent(parts[1]);
      }
      return null;
    }

    function getHeaders() {
      var h = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
      var csrf = getCsrfToken();
      if (csrf) h['X-CSRF-TOKEN'] = csrf;
      return h;
    }

    function sleep(ms) { return new Promise(function (r) { setTimeout(r, ms); }); }

    async function request(url, options, retryCount) {
      if (!options) options = {};
      if (!retryCount) retryCount = 0;
      try {
        options.headers = Object.assign({}, getHeaders(), options.headers || {});
        var controller = new AbortController();
        var tid = setTimeout(function () { controller.abort(); }, timeout);
        options.signal = controller.signal;
        var response = await fetch(url, options);
        clearTimeout(tid);
        var data;
        var ct = response.headers.get('content-type');
        if (ct && ct.indexOf('application/json') !== -1) data = await response.json();
        else data = await response.text();
        if ((response.status === 500 || response.status === 503) && retryCount < maxRetries) {
          await sleep(retryDelay * Math.pow(2, retryCount));
          return request(url, options, retryCount + 1);
        }
        if (!response.ok) {
          if (response.status === 401) window.location.href = '/login';
          if (response.status === 429) Toast.show('Muitas requisicoes. Tente novamente.', 'warning', 5000);
        }
        return { success: response.ok, data: response.ok ? data : null, message: (data && data.message) || (response.ok ? 'Success' : 'Request failed'), errors: (data && data.errors) || null, status: response.status };
      } catch (error) {
        if (error.name === 'AbortError') return { success: false, data: null, message: 'Request timeout', errors: { timeout: true } };
        if (retryCount < maxRetries) { await sleep(retryDelay * Math.pow(2, retryCount)); return request(url, options, retryCount + 1); }
        return { success: false, data: null, message: error.message || 'Network error', errors: { network: error.message } };
      }
    }

    return {
      get: function (url, o) { return request(url, Object.assign({}, o, { method: 'GET' })); },
      post: function (url, data, o) { return request(url, Object.assign({}, o, { method: 'POST', body: data ? JSON.stringify(data) : null })); },
      put: function (url, data, o) { return request(url, Object.assign({}, o, { method: 'PUT', body: data ? JSON.stringify(data) : null })); },
      delete: function (url, o) { return request(url, Object.assign({}, o, { method: 'DELETE' })); }
    };
  })();

  /* --- Forms (validation with ps-form-error) --- */
  var Forms = (function () {
    var validators = {
      required: function (v) { return v.trim() !== ''; },
      email: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); },
      minlength: function (v, n) { return v.length >= parseInt(n); },
      maxlength: function (v, n) { return v.length <= parseInt(n); }
    };

    function init() {
      document.querySelectorAll('form[data-validate]').forEach(function (form) { setupValidation(form); });
      document.querySelectorAll('form[data-ajax]').forEach(function (form) { setupAjax(form); });
    }

    function setupValidation(form) {
      var inputs = form.querySelectorAll('input, textarea, select');
      inputs.forEach(function (input) {
        input.addEventListener('blur', function () { validateInput(input); });
        input.addEventListener('input', function () { if (input.classList.contains('is-invalid')) clearError(input); });
      });
      form.addEventListener('submit', function (e) {
        if (!validateForm(form)) { e.preventDefault(); e.stopPropagation(); }
      });
    }

    function validateInput(input) {
      var value = input.value;
      var errors = [];
      if (input.hasAttribute('required') && !validators.required(value)) errors.push('Campo obrigatorio');
      if (value.trim() === '' && !input.hasAttribute('required')) { clearError(input); return true; }
      var type = input.getAttribute('type');
      if (type === 'email' && !validators.email(value)) errors.push('Email invalido');
      if (input.hasAttribute('minlength') && !validators.minlength(value, input.getAttribute('minlength')))
        errors.push('Minimo ' + input.getAttribute('minlength') + ' caracteres');
      if (errors.length > 0) { showError(input, errors[0]); return false; }
      input.classList.remove('is-invalid');
      input.classList.add('is-valid');
      clearError(input);
      return true;
    }

    function validateForm(form) {
      var valid = true;
      form.querySelectorAll('input, textarea, select').forEach(function (input) {
        if (!validateInput(input)) valid = false;
      });
      return valid;
    }

    function showError(input, message) {
      input.classList.remove('is-valid');
      input.classList.add('is-invalid');
      var el = input.parentNode.querySelector('.ps-form-error');
      if (!el) { el = document.createElement('div'); el.className = 'ps-form-error'; input.parentNode.appendChild(el); }
      el.textContent = message;
    }

    function clearError(input) {
      input.classList.remove('is-invalid');
      var el = input.parentNode.querySelector('.ps-form-error');
      if (el) el.remove();
    }

    function setupAjax(form) {
      form.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (form.hasAttribute('data-validate') && !validateForm(form)) return;
        var btn = form.querySelector('button[type="submit"]');
        var originalText = btn ? btn.textContent : '';
        try {
          if (btn) { btn.disabled = true; btn.textContent = 'Enviando...'; }
          var formData = new FormData(form);
          var data = {};
          formData.forEach(function (value, key) { data[key] = value; });
          var method = (form.getAttribute('method') || 'POST').toLowerCase();
          var url = form.getAttribute('action') || window.location.href;
          var response;
          if (method === 'put') response = await Api.put(url, data);
          else if (method === 'delete') response = await Api.delete(url);
          else response = await Api.post(url, data);
          if (response.success) {
            Toast.show(response.message || 'Sucesso!', 'success');
            if (form.hasAttribute('data-reset-on-success')) form.reset();
            var redirect = form.getAttribute('data-redirect');
            if (redirect) setTimeout(function () { window.location.href = redirect; }, 1000);
          } else {
            if (response.message) Toast.show(response.message, 'error');
            if (response.errors && typeof response.errors === 'object') {
              Object.keys(response.errors).forEach(function (name) {
                var inp = form.querySelector('[name="' + name + '"]');
                if (inp) showError(inp, Array.isArray(response.errors[name]) ? response.errors[name][0] : response.errors[name]);
              });
            }
          }
        } catch (error) {
          Toast.show('Ocorreu um erro. Tente novamente.', 'error');
        } finally {
          if (btn) { btn.disabled = false; btn.textContent = originalText; }
        }
      });
    }

    return { init: init, validate: validateForm, showError: showError, clearError: clearError };
  })();

  /* --- Auth (state management) --- */
  var Auth = (function () {
    var currentUser = null, authenticated = false, listeners = [];

    function init() {
      var meta = document.querySelector('meta[name="user"]');
      if (meta) { try { setUser(JSON.parse(meta.getAttribute('content'))); } catch (e) { /* ignore */ } }
      var stored = sessionStorage.getItem('auth_user');
      if (stored) { try { setUser(JSON.parse(stored)); } catch (e) { /* ignore */ } }
      updateUI();
    }

    function setUser(user) {
      currentUser = user;
      authenticated = !!user;
      if (user) sessionStorage.setItem('auth_user', JSON.stringify(user));
      else sessionStorage.removeItem('auth_user');
      listeners.forEach(function (cb) { try { cb(authenticated, currentUser); } catch (e) { /* ignore */ } });
      updateUI();
    }

    function updateUI() {
      document.querySelectorAll('.auth-only').forEach(function (el) { el.style.display = authenticated ? '' : 'none'; });
      document.querySelectorAll('.guest-only').forEach(function (el) { el.style.display = authenticated ? 'none' : ''; });
      if (currentUser) {
        document.querySelectorAll('[data-user-name]').forEach(function (el) { el.textContent = currentUser.name || ''; });
        document.querySelectorAll('[data-user-email]').forEach(function (el) { el.textContent = currentUser.email || ''; });
      }
    }

    return {
      init: init,
      isLoggedIn: function () { return authenticated; },
      getUser: function () { return currentUser; },
      onAuthChange: function (cb) { listeners.push(cb); },
      hasRole: function (role) { return currentUser && currentUser.roles && currentUser.roles.indexOf(role) !== -1; }
    };
  })();

  /* --- Cache (localStorage with TTL) --- */
  var Cache = (function () {
    var prefix = 'cache_', version = '1.0', defaultTTL = 300;

    function available() {
      try { localStorage.setItem('__t', '__t'); localStorage.removeItem('__t'); return true; } catch (e) { return false; }
    }

    function set(key, data, ttl) {
      if (!available()) return false;
      if (ttl === undefined) ttl = defaultTTL;
      try {
        localStorage.setItem(prefix + key, JSON.stringify({ data: data, timestamp: Date.now(), ttl: ttl * 1000, version: version }));
        return true;
      } catch (e) { clearExpired(); return false; }
    }

    function get(key) {
      if (!available()) return null;
      try {
        var raw = localStorage.getItem(prefix + key);
        if (!raw) return null;
        var item = JSON.parse(raw);
        if (item.version !== version || Date.now() - item.timestamp > item.ttl) { remove(key); return null; }
        return item.data;
      } catch (e) { return null; }
    }

    function has(key) { return get(key) !== null; }
    function remove(key) { try { localStorage.removeItem(prefix + key); } catch (e) { /* ignore */ } }

    function clear() {
      if (!available()) return;
      var keys = [];
      for (var i = 0; i < localStorage.length; i++) {
        var k = localStorage.key(i);
        if (k && k.indexOf(prefix) === 0) keys.push(k);
      }
      keys.forEach(function (k) { localStorage.removeItem(k); });
    }

    function clearExpired() {
      if (!available()) return;
      var keys = [];
      for (var i = 0; i < localStorage.length; i++) {
        var k = localStorage.key(i);
        if (k && k.indexOf(prefix) === 0) {
          try {
            var item = JSON.parse(localStorage.getItem(k));
            if (Date.now() - item.timestamp > item.ttl || item.version !== version) keys.push(k);
          } catch (e) { keys.push(k); }
        }
      }
      keys.forEach(function (k) { localStorage.removeItem(k); });
    }

    async function remember(key, ttl, fn) {
      var cached = get(key);
      if (cached !== null) return cached;
      var result = await fn();
      set(key, result, ttl);
      return result;
    }

    if (available()) clearExpired();

    return { set: set, get: get, has: has, remove: remove, clear: clear, clearExpired: clearExpired, remember: remember };
  })();

  /* --- Utils --- */
  var Utils = (function () {
    function debounce(fn, delay) {
      if (!delay) delay = 300;
      var tid;
      return function () {
        var args = arguments, ctx = this;
        clearTimeout(tid);
        tid = setTimeout(function () { fn.apply(ctx, args); }, delay);
      };
    }

    function throttle(fn, limit) {
      if (!limit) limit = 300;
      var inThrottle;
      return function () {
        if (!inThrottle) { fn.apply(this, arguments); inThrottle = true; setTimeout(function () { inThrottle = false; }, limit); }
      };
    }

    function slugify(text) {
      return text.toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^\w\s-]/g, '').replace(/\s+/g, '-').replace(/--+/g, '-').trim().replace(/^-+|-+$/g, '');
    }

    function escapeHtml(str) { var d = document.createElement('div'); d.textContent = str; return d.innerHTML; }

    async function copyToClipboard(text) {
      if (navigator.clipboard && window.isSecureContext) { try { await navigator.clipboard.writeText(text); return true; } catch (e) { /* fall through */ } }
      try {
        var ta = document.createElement('textarea'); ta.value = text; ta.style.cssText = 'position:fixed;left:-9999px';
        document.body.appendChild(ta); ta.select(); var ok = document.execCommand('copy'); document.body.removeChild(ta); return ok;
      } catch (e) { return false; }
    }

    function isMobile() { return window.innerWidth <= 768; }
    function formatDate(dateStr) {
      var d = new Date(dateStr); if (isNaN(d.getTime())) return dateStr;
      return String(d.getDate()).padStart(2, '0') + '/' + String(d.getMonth() + 1).padStart(2, '0') + '/' + d.getFullYear();
    }

    return { debounce: debounce, throttle: throttle, slugify: slugify, escapeHtml: escapeHtml, copyToClipboard: copyToClipboard, isMobile: isMobile, formatDate: formatDate };
  })();

  /* --- LazyLoad --- */
  var LazyLoad = (function () {
    var observer = null;

    function init() {
      if (!('IntersectionObserver' in window)) { loadAll(); return; }
      observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) { loadElement(entry.target); observer.unobserve(entry.target); }
        });
      }, { rootMargin: '50px', threshold: 0.01 });
      observe();
    }

    function observe() {
      document.querySelectorAll('img[data-src], iframe[data-src]').forEach(function (el) { observer.observe(el); });
    }

    function loadElement(el) {
      var src = el.getAttribute('data-src');
      if (!src) return;
      if (el.tagName === 'IMG') {
        var img = new Image();
        img.onload = function () { el.src = src; el.classList.add('loaded'); el.removeAttribute('data-src'); };
        img.src = src;
      } else if (el.tagName === 'IFRAME') {
        el.src = src; el.classList.add('loaded'); el.removeAttribute('data-src');
      }
    }

    function loadAll() { document.querySelectorAll('img[data-src], iframe[data-src]').forEach(loadElement); }
    function refresh() { if (observer) observe(); }

    return { init: init, refresh: refresh, loadElement: loadElement };
  })();

  /* --- Pagination (AJAX) --- */
  var Pagination = (function () {
    var containers = new Map();

    function init() {
      document.querySelectorAll('[data-pagination]').forEach(function (container) {
        var url = container.getAttribute('data-pagination');
        var state = { url: url, currentPage: 1, hasMore: true, loading: false };
        containers.set(container, state);
        var btn = container.querySelector('[data-load-more]');
        if (btn) btn.addEventListener('click', function () { loadNext(container, state); });
      });
    }

    async function loadNext(container, state) {
      if (state.loading || !state.hasMore) return;
      state.loading = true;
      state.currentPage++;
      try {
        var url = new URL(state.url, window.location.origin);
        url.searchParams.set('page', state.currentPage);
        var response = await Api.get(url.toString());
        if (response.success && response.data) {
          var list = container.querySelector('[data-pagination-list]') || container;
          var items = response.data.items || response.data;
          if (typeof items === 'string') list.insertAdjacentHTML('beforeend', items);
          state.hasMore = response.data.hasMore !== false;
          LazyLoad.refresh();
        } else { state.hasMore = false; }
      } catch (e) { state.currentPage--; Toast.show('Erro ao carregar mais itens', 'error'); }
      finally { state.loading = false; if (!state.hasMore) { var btn = container.querySelector('[data-load-more]'); if (btn) btn.style.display = 'none'; } }
    }

    return { init: init };
  })();

  /* --- Keyboard shortcuts --- */
  var Keyboard = (function () {
    var shortcuts = new Map();

    function init() {
      shortcuts.set('ctrl+k', function () {
        var s = document.querySelector('input[type="search"], input[name="search"], input[data-search]');
        if (s) { s.focus(); s.select(); }
      });
      shortcuts.set('/', function () {
        var s = document.querySelector('input[type="search"], input[name="search"], input[data-search]');
        if (s) { s.focus(); s.select(); }
      });
      document.addEventListener('keydown', function (e) {
        if (e.target.matches('input, textarea, select, [contenteditable="true"]') && e.key !== 'Escape') return;
        var parts = [];
        if (e.ctrlKey) parts.push('ctrl');
        if (e.altKey) parts.push('alt');
        if (e.shiftKey) parts.push('shift');
        var key = e.key.toLowerCase();
        if (['control', 'alt', 'shift', 'meta'].indexOf(key) === -1) parts.push(key);
        var combo = parts.join('+');
        var fn = shortcuts.get(combo);
        if (fn) { e.preventDefault(); fn(e); }
      });
    }

    return {
      init: init,
      register: function (shortcut, cb) { shortcuts.set(shortcut.toLowerCase(), cb); },
      unregister: function (shortcut) { shortcuts.delete(shortcut.toLowerCase()); }
    };
  })();


  /* ========================================================================
     PART C — Cookie consent acceptCookies global
     ======================================================================== */
  window.acceptCookies = function (mode) {
    var consent = { necessary: true, analytics: false, marketing: false, timestamp: Date.now() };
    if (mode === 'all') {
      consent.analytics = true;
      consent.marketing = true;
    } else {
      var a = document.getElementById('cookieAnalytics');
      var m = document.getElementById('cookieMarketing');
      if (a) consent.analytics = a.checked;
      if (m) consent.marketing = m.checked;
    }
    try { localStorage.setItem('cookie_consent', JSON.stringify(consent)); } catch (e) { /* ignore */ }
    var banner = document.querySelector('.ps-consent');
    if (banner) banner.classList.remove('is-visible');
  };


  /* ========================================================================
     PART D — Orchestrator + SPA hook
     ======================================================================== */

  function initAllDS() {
    initScrollProgress();
    initScrollReveal();
    initGlitchEffect();
    initMouseParallax();
    initMagneticButtons();
    initCardTilt();
    initButtonRipple();
    initModals();
    initMobileMenu();
    initAccordions();
    initMarquee();
    initToggles();
    initNoiseAnimation();
    initHamburger();
    initTextScramble();
    initCounters();
    initNavbarScroll();
    initSocialHover();
    initServicesHover();
    initConsent();
    initBackToTop();
    initFullMenu();
    initLightbox();
    initDepthParallax();
    initSnapWipe();
    initSmoothScroll();
    initFilterBar();
  }

  function initAllBusiness() {
    Forms.init();
    Auth.init();
    LazyLoad.init();
    Pagination.init();
    Keyboard.init();
  }

  /* Re-init subset after SPA navigation */
  function reinitAfterSPA() {
    initScrollReveal();
    initAccordions();
    initCardTilt();
    initButtonRipple();
    initGlitchEffect();
    initCounters();
    initTextScramble();
    initMouseParallax();
    initMagneticButtons();
    initServicesHover();
    initMarquee();
    initLightbox();
    initDepthParallax();
    initSmoothScroll();
    initFilterBar();
    Forms.init();
    LazyLoad.refresh();
    Pagination.init();
  }

  /* 29. WORD CLOUD — Hero section only */
  function initWordCloud() {
    var canvas = document.getElementById('word-cloud-bg');
    if (!canvas || 'ontouchstart' in window) return;
    var hero = canvas.closest('.ps-hero');
    if (!hero) return;
    var ctx = canvas.getContext('2d');
    if (!ctx) return;

    var words = [
      'MADEIRA', 'ACO', 'CONCRETO', 'ACRILICO', 'DESIGN', 'FORMA',
      'MATERIA', 'INTENCAO', 'AUTORAL', 'METAL', 'TEXTURA', 'ESTRUTURA',
      'ARTESANAL', 'PROTOTIPO', 'CONCEITO', 'CRIACAO', 'ESPACO',
      'MOBILIARIO', 'SUPERFICIE', 'PROJETO', 'FABRICACAO', 'DETALHE',
      'GEOMETRIA', 'VOLUME', 'LUZ', 'SOMBRA', 'ACABAMENTO', 'CORTE',
      'SOLDA', 'MOLDE', 'RESINA', 'IMPRESSAO 3D', 'CORTEN', 'LATAO',
      'VIDRO', 'CERAMICA', 'CURVATURA', 'ENCAIXE', 'JUNTA', 'PLANO',
      'ATELIE', 'ESTUDIO', 'MARCENARIA', 'SERRALHERIA', 'SUSTENTAVEL',
      'HANDMADE', 'FUNCIONAL', 'ERGONOMIA', 'PROPORCAO', 'MODULAR',
      'BLUEPRINT', 'RENDER', 'MAQUETE', 'FRESA', 'TORNO', 'BANCADA',
      'PILAR', 'ARCO', 'VIGA', 'PISO', 'REVESTIMENTO', 'LUMINARIA',
      'PENDENTE', 'NICHO', 'PRATELEIRA', 'PAINEL', 'BIOMBO', 'ESTANTE',
      'APARADOR', 'MESA', 'CADEIRA', 'BANCO', 'POLTRONA', 'SOFÁ',
      'GAVETA', 'DOBRADIÇA', 'PUXADOR', 'VERNIZ', 'PATINA', 'CERA',
      'FIBRA', 'LAMINA', 'CHAPA', 'TUBO', 'PERFIL', 'CANTONEIRA',
      'REBITE', 'PARAFUSO', 'PORCA', 'ARRUELA', 'FLANGE', 'GRELHA'
    ];

    var particles = [];
    var mx = -9999, my = -9999;
    var dpr = window.devicePixelRatio || 1;
    var w, h;
    var time = 0;

    function resize() {
      var rect = hero.getBoundingClientRect();
      w = rect.width;
      h = rect.height;
      canvas.width = w * dpr;
      canvas.height = h * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function createParticles() {
      particles = [];
      var count = Math.floor((w * h) / 12000);
      if (count > 120) count = 120;
      if (count < 35) count = 35;
      for (var i = 0; i < count; i++) {
        var speed = 0.15 + Math.random() * 0.35;
        var angle = Math.random() * Math.PI * 2;
        particles.push({
          x: Math.random() * w,
          y: Math.random() * h,
          ox: 0, oy: 0,
          vx: Math.cos(angle) * speed,
          vy: Math.sin(angle) * speed,
          word: words[Math.floor(Math.random() * words.length)],
          size: 9 + Math.random() * 15,
          alpha: 0.25 + Math.random() * 0.55,
          rotation: (Math.random() - 0.5) * 0.5,
          // organic wandering params
          phaseX: Math.random() * Math.PI * 2,
          phaseY: Math.random() * Math.PI * 2,
          freqX: 0.003 + Math.random() * 0.008,
          freqY: 0.003 + Math.random() * 0.008,
          ampX: 0.3 + Math.random() * 0.6,
          ampY: 0.3 + Math.random() * 0.6,
          rotSpeed: (Math.random() - 0.5) * 0.0008
        });
      }
    }

    function draw() {
      ctx.clearRect(0, 0, w, h);
      time++;

      for (var i = 0; i < particles.length; i++) {
        var p = particles[i];

        // organic wandering: sine wave offsets that change direction over time
        var wanderX = Math.sin(time * p.freqX + p.phaseX) * p.ampX;
        var wanderY = Math.cos(time * p.freqY + p.phaseY) * p.ampY;

        p.x += p.vx + wanderX * 0.15;
        p.y += p.vy + wanderY * 0.15;

        // slow rotation drift
        p.rotation += p.rotSpeed;

        // wrap around edges
        if (p.x < -120) p.x = w + 60;
        if (p.x > w + 120) p.x = -60;
        if (p.y < -60) p.y = h + 40;
        if (p.y > h + 60) p.y = -40;

        // mouse repel
        var dx = p.x - mx;
        var dy = p.y - my;
        var dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 200 && dist > 0) {
          var force = (1 - dist / 200) * 30;
          p.ox += (dx / dist) * force * 0.08;
          p.oy += (dy / dist) * force * 0.08;
        }
        p.ox *= 0.92;
        p.oy *= 0.92;

        ctx.save();
        ctx.translate(p.x + p.ox, p.y + p.oy);
        ctx.rotate(p.rotation);
        ctx.font = '500 ' + p.size + 'px "Space Grotesk", sans-serif';
        ctx.fillStyle = 'rgba(184, 224, 200, ' + p.alpha + ')';
        ctx.fillText(p.word, 0, 0);
        ctx.restore();
      }

      requestAnimationFrame(draw);
    }

    resize();
    createParticles();

    window.addEventListener('resize', function () {
      resize();
      createParticles();
    });

    hero.addEventListener('mousemove', function (e) {
      var rect = hero.getBoundingClientRect();
      mx = e.clientX - rect.left;
      my = e.clientY - rect.top;
    });

    hero.addEventListener('mouseleave', function () {
      mx = -9999;
      my = -9999;
    });

    draw();
  }

  /* 30. CINEMATIC GALLERY ARROWS */
  function initCineGalleryArrows() {
    var strip = document.querySelector('.ps-cine-gallery__strip');
    if (!strip) return;
    var scroll = strip.querySelector('.ps-cine-gallery__scroll');
    var prev = strip.querySelector('.ps-cine-gallery__arrow--prev');
    var next = strip.querySelector('.ps-cine-gallery__arrow--next');
    if (!scroll || !prev || !next) return;

    function getSlideWidth() {
      var slide = scroll.querySelector('.ps-cine-gallery__slide');
      if (!slide) return scroll.clientWidth * 0.7;
      return slide.offsetWidth + 24; // gap
    }

    prev.addEventListener('click', function () {
      scroll.scrollBy({ left: -getSlideWidth(), behavior: 'smooth' });
    });
    next.addEventListener('click', function () {
      scroll.scrollBy({ left: getSlideWidth(), behavior: 'smooth' });
    });
  }

  /* 31. GRID DOTS MAGNIFIER */
  function initGridDotsMagnifier() {
    var el = document.querySelector('.ps-grid-dots');
    if (!el || 'ontouchstart' in window) return;

    var raf = null;
    var mx = -200;
    var my = -200;

    document.addEventListener('mousemove', function (e) {
      mx = e.clientX;
      my = e.clientY;
      if (!raf) {
        raf = requestAnimationFrame(function () {
          el.style.setProperty('--mx', mx + 'px');
          el.style.setProperty('--my', my + 'px');
          raf = null;
        });
      }
      if (!el.classList.contains('is-active')) {
        el.classList.add('is-active');
      }
    });

    document.addEventListener('mouseleave', function () {
      el.classList.remove('is-active');
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Custom cursor only on non-touch/public pages
    if (!('ontouchstart' in window) && !document.querySelector('.ps-admin-layout')) {
      initCustomCursor();
    }
    initAllDS();
    initAllBusiness();
    initWordCloud();
    initCineGalleryArrows();
    initGridDotsMagnifier();
  });

  document.addEventListener('spa:navigated', function () {
    reinitAfterSPA();
  });

  /* Expose modules globally */
  window.Toast = Toast;
  window.Api = Api;
  window.Forms = Forms;
  window.Auth = Auth;
  window.Cache = Cache;
  window.Utils = Utils;
  window.LazyLoad = LazyLoad;
  window.Pagination = Pagination;
  window.Keyboard = Keyboard;

})();
