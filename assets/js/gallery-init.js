/**
 * PhotoSwipe v5 initialization for ChiragPatel.PhotoSwipe plugin.
 * Replaces the 250+ line inline v4 init script.
 */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-pswp-gallery]').forEach(function (galleryEl) {
        var optionsAttr = galleryEl.getAttribute('data-pswp-options');
        var userOptions = optionsAttr ? JSON.parse(optionsAttr) : {};

        var lightbox = new PhotoSwipeLightbox({
            gallery: galleryEl,
            children: 'a[data-pswp-width]',
            pswpModule: PhotoSwipe,

            loop: userOptions.loop !== undefined ? userOptions.loop : true,
            closeOnVerticalDrag: userOptions.closeOnVerticalDrag !== undefined ? userOptions.closeOnVerticalDrag : true,
            pinchToClose: userOptions.pinchToClose !== undefined ? userOptions.pinchToClose : true,
            escKey: userOptions.escKey !== undefined ? userOptions.escKey : true,
            arrowKeys: true,
            zoom: userOptions.zoom !== undefined ? userOptions.zoom : true,
            counter: userOptions.counter !== undefined ? userOptions.counter : true,
            arrowPrev: userOptions.arrowEl !== undefined ? userOptions.arrowEl : true,
            arrowNext: userOptions.arrowEl !== undefined ? userOptions.arrowEl : true,
        });

        // Video slide support
        lightbox.on('contentLoad', function (e) {
            var content = e.content;
            if (content.data.element && content.data.element.dataset.pswpType === 'video') {
                e.preventDefault();

                var videoSrc = content.data.element.dataset.pswpVideoSrc;
                content.element = document.createElement('div');
                content.element.className = 'pswp__video-container';

                var iframe = document.createElement('iframe');
                iframe.setAttribute('src', videoSrc);
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allowfullscreen', '');
                iframe.setAttribute('allow', 'autoplay');
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                iframe.style.position = 'absolute';
                iframe.style.top = '0';
                iframe.style.left = '0';

                content.element.style.position = 'relative';
                content.element.style.width = content.width + 'px';
                content.element.style.height = content.height + 'px';

                content.element.appendChild(iframe);
            }
        });

        lightbox.on('contentDestroy', function (e) {
            if (e.content.element && e.content.element.classList.contains('pswp__video-container')) {
                e.content.element.innerHTML = '';
            }
        });

        lightbox.init();
    });
});
