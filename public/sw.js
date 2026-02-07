const CACHE_NAME = 'comercioguajiro-v1';
const ASSETS = [
    '/',
    '/offline', // Placeholder for offline page if needed
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        }).catch(() => {
            if (event.request.mode === 'navigate') {
                return caches.match('/');
            }
        })
    );
});
