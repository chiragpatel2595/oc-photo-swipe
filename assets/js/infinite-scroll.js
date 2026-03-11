/**
 * Infinite scroll for ChiragPatel.PhotoSwipe gallery using IntersectionObserver.
 * Triggered by a sentinel element at the bottom of the gallery.
 */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-pswp-infinite]').forEach(function (galleryEl) {
        var sentinel = galleryEl.querySelector('.pswp-gallery__sentinel');
        if (!sentinel) return;

        var page = 1;
        var loading = false;
        var hasMore = galleryEl.dataset.pswpHasMore === 'true';
        var handler = galleryEl.dataset.pswpHandler;

        if (!handler || !hasMore) return;

        var observer = new IntersectionObserver(function (entries) {
            if (!entries[0].isIntersecting || loading || !hasMore) return;

            loading = true;
            page++;

            var loadingEl = sentinel.querySelector('.pswp-gallery__loading');
            if (loadingEl) loadingEl.style.display = 'inline-block';

            var request = new XMLHttpRequest();
            request.open('POST', window.location.href, true);
            request.setRequestHeader('X-OCTOBER-REQUEST-HANDLER', handler);
            request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);

                    if (data.markup) {
                        var temp = document.createElement('div');
                        temp.innerHTML = data.markup;
                        while (temp.firstChild) {
                            galleryEl.insertBefore(temp.firstChild, sentinel);
                        }
                    }

                    hasMore = data.hasMore;
                    if (!hasMore) {
                        sentinel.style.display = 'none';
                        observer.disconnect();
                    }
                }

                loading = false;
                if (loadingEl) loadingEl.style.display = 'none';
            };

            request.onerror = function () {
                loading = false;
                if (loadingEl) loadingEl.style.display = 'none';
            };

            request.send('page=' + page);
        }, {
            rootMargin: '200px'
        });

        observer.observe(sentinel);
    });
});
