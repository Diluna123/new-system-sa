const CACHE_VERSION = "new-system-cache-v1";
const OFFLINE_ASSETS = [
  "/manifest.json",
  "/genaral/index.php",
  "/genaral/gscript.js",
  "/sign-in.css",
  "/dashboard.css",
  "/sansa192.png",
  "/sanasalogo.png"
];

self.addEventListener("install", function(event) {
  event.waitUntil(
    caches.open(CACHE_VERSION).then(function(cache) {
      return cache.addAll(OFFLINE_ASSETS);
    })
  );
  self.skipWaiting();
});

self.addEventListener("activate", function(event) {
  event.waitUntil(
    caches.keys().then(function(keys) {
      return Promise.all(
        keys.map(function(key) {
          if (key !== CACHE_VERSION) {
            return caches.delete(key);
          }
          return Promise.resolve();
        })
      );
    })
  );
  self.clients.claim();
});

self.addEventListener("fetch", function(event) {
  if (event.request.method !== "GET") {
    return;
  }

  event.respondWith(
    fetch(event.request)
      .then(function(networkResponse) {
        const clone = networkResponse.clone();
        caches.open(CACHE_VERSION).then(function(cache) {
          cache.put(event.request, clone);
        });
        return networkResponse;
      })
      .catch(function() {
        return caches.match(event.request).then(function(cachedResponse) {
          return cachedResponse || caches.match("/genaral/index.php");
        });
      })
  );
});
  