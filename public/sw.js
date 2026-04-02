/**
 * INDUZI Service Worker
 * Strategies: Cache-first for assets, Network-first for pages
 * Includes offline fallback page
 */

const CACHE_NAME = 'induzi-cache-v2';
const ASSETS_CACHE = 'induzi-assets-v2';

// App shell — precached on install
const PRECACHE_ASSETS = [
  '/',
  '/assets/css/tokens.css',
  '/assets/css/base.css',
  '/assets/css/components.css',
  '/assets/css/pages.css',
  '/assets/css/site.css',
  '/assets/css/spa.css',
  '/assets/js/main.js',
  '/assets/js/spa.js'
];

// Install — precache app shell
self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      return cache.addAll(PRECACHE_ASSETS);
    }).then(function () {
      return self.skipWaiting();
    })
  );
});

// Activate — clean old caches
self.addEventListener('activate', function (event) {
  event.waitUntil(
    caches.keys().then(function (cacheNames) {
      return Promise.all(
        cacheNames
          .filter(function (name) {
            return name !== CACHE_NAME && name !== ASSETS_CACHE;
          })
          .map(function (name) {
            return caches.delete(name);
          })
      );
    }).then(function () {
      return self.clients.claim();
    })
  );
});

// Fetch — strategy per request type
self.addEventListener('fetch', function (event) {
  var request = event.request;
  var url = new URL(request.url);

  // Skip non-GET and cross-origin
  if (request.method !== 'GET' || url.origin !== location.origin) {
    return;
  }

  // API calls — network only, no caching
  if (url.pathname.startsWith('/api/')) {
    return;
  }

  // Static assets — cache-first with background update
  if (isStaticAsset(url.pathname)) {
    event.respondWith(cacheFirst(request));
    return;
  }

  // Pages — network-first with cache fallback + offline page
  event.respondWith(networkFirst(request));
});

/**
 * Cache-first: serve from cache, update in background.
 */
function cacheFirst(request) {
  return caches.open(ASSETS_CACHE).then(function (cache) {
    return cache.match(request).then(function (cached) {
      if (cached) {
        // Update cache in background (stale-while-revalidate)
        fetch(request).then(function (response) {
          if (response && response.ok) {
            cache.put(request, response);
          }
        }).catch(function () {});
        return cached;
      }
      return fetch(request).then(function (response) {
        if (response && response.ok) {
          cache.put(request, response.clone());
        }
        return response;
      });
    });
  });
}

/**
 * Network-first: try network, fallback to cache, then offline page.
 */
function networkFirst(request) {
  return fetch(request).then(function (response) {
    if (response && response.ok) {
      var clone = response.clone();
      caches.open(CACHE_NAME).then(function (cache) {
        cache.put(request, clone);
      });
    }
    return response;
  }).catch(function () {
    return caches.match(request).then(function (cached) {
      if (cached) return cached;
      // Offline fallback
      if (request.headers.get('Accept') && request.headers.get('Accept').indexOf('text/html') !== -1) {
        return offlinePage();
      }
      return new Response('Offline', { status: 503, statusText: 'Service Unavailable' });
    });
  });
}

/**
 * Generate offline fallback page.
 */
function offlinePage() {
  var html = '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>INDUZI — Offline</title><style>*{margin:0;padding:0;box-sizing:border-box}body{font-family:"Space Grotesk","Inter",-apple-system,sans-serif;background:#0D0D0D;color:#FFF;display:flex;align-items:center;justify-content:center;min-height:100vh;text-align:center;padding:2rem}.container{max-width:500px}h1{font-size:3rem;margin-bottom:1rem;letter-spacing:-.02em}p{color:#A0A0A0;font-size:1.125rem;line-height:1.7;margin-bottom:2rem}.btn{display:inline-block;padding:.75rem 2rem;background:#B8E0C8;color:#000;border-radius:9999px;text-decoration:none;font-weight:600;text-transform:uppercase;letter-spacing:.1em;font-size:.875rem;cursor:pointer;border:none}.offline-icon{font-size:4rem;margin-bottom:1.5rem;opacity:.3}</style></head><body><div class="container"><div class="offline-icon">&#x1F310;</div><h1>Offline</h1><p>Voce esta sem conexao com a internet. Verifique sua rede e tente novamente.</p><button class="btn" onclick="location.reload()">Tentar Novamente</button></div></body></html>';
  return new Response(html, {
    status: 200,
    headers: { 'Content-Type': 'text/html; charset=utf-8' }
  });
}

/**
 * Check if request is for a static asset.
 */
function isStaticAsset(pathname) {
  return /\.(css|js|woff2?|ttf|eot|svg|png|jpe?g|gif|webp|avif|ico|mp4|webm|json|webmanifest)$/i.test(pathname);
}

/**
 * Handle messages from clients.
 */
self.addEventListener('message', function (event) {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});
