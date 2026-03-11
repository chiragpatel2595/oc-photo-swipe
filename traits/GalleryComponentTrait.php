<?php namespace ChiragPatel\PhotoSwipe\Traits;

use ChiragPatel\PhotoSwipe\Models\Gallery;

trait GalleryComponentTrait
{
    protected $gallery;
    protected $items;

    protected function defineGalleryProperties()
    {
        return [
            'layout' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.layout.title',
                'description' => 'chiragpatel.photoswipe::lang.components.gallery.properties.layout.description',
                'type' => 'dropdown',
                'default' => 'grid',
                'options' => [
                    'grid' => 'Grid',
                    'masonry' => 'Masonry',
                    'justified' => 'Justified',
                    'slider' => 'Slider',
                ],
                'showExternalParam' => false,
            ],
            'thumbWidth' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.thumbWidth.title',
                'type' => 'string',
                'default' => '400',
                'showExternalParam' => false,
                'group' => 'Thumbnails',
            ],
            'thumbHeight' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.thumbHeight.title',
                'type' => 'string',
                'default' => '300',
                'showExternalParam' => false,
                'group' => 'Thumbnails',
            ],
            'thumbMode' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.thumbMode.title',
                'type' => 'dropdown',
                'default' => 'crop',
                'options' => [
                    'crop' => 'Crop',
                    'auto' => 'Auto',
                    'exact' => 'Exact',
                ],
                'showExternalParam' => false,
                'group' => 'Thumbnails',
            ],
            'perPage' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.perPage.title',
                'description' => 'chiragpatel.photoswipe::lang.components.gallery.properties.perPage.description',
                'type' => 'string',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Pagination',
            ],
            'loop' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.loop.title',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Display',
            ],
            'closeOnVerticalDrag' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.closeOnVerticalDrag.title',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Display',
            ],
            'escKey' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.escKey.title',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Display',
            ],
            'pinchToClose' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.pinchToClose.title',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Display',
            ],
            'zoom' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.zoom.title',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons',
            ],
            'arrowEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.arrowEl.title',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons',
            ],
            'counterEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.counterEl.title',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons',
            ],
        ];
    }

    protected function getAssetBase()
    {
        return '/plugins/chiragpatel/photoswipe/assets';
    }

    protected function loadGalleryAssets()
    {
        $base = $this->getAssetBase();

        $this->addCss($base . '/vendor/photoswipe/photoswipe.css');
        $this->addCss($base . '/css/gallery.css');

        $layout = $this->getEffectiveLayout();
        if ($layout !== 'grid') {
            $this->addCss($base . '/css/layout-' . $layout . '.css');
        }

        $this->addJs($base . '/vendor/photoswipe/photoswipe.umd.min.js');
        $this->addJs($base . '/vendor/photoswipe/photoswipe-lightbox.umd.min.js');
        $this->addJs($base . '/js/gallery-init.js');

        $perPage = (int) $this->property('perPage', 0);
        if ($perPage > 0) {
            $this->addJs($base . '/js/infinite-scroll.js');
        }
    }

    protected function getEffectiveLayout()
    {
        $layout = $this->property('layout', 'grid');
        if ($layout === 'grid' && $this->gallery && $this->gallery->layout) {
            $layout = $this->gallery->layout;
        }
        return $layout;
    }

    protected function prepareGalleryItems($gallery)
    {
        if (!$gallery) {
            return collect();
        }

        // Use new GalleryItem model if items exist
        if ($gallery->items->count() > 0) {
            return $gallery->items;
        }

        // Fallback to legacy attachMany images
        return $this->prepareLegacyImages($gallery);
    }

    protected function prepareLegacyImages($gallery)
    {
        $images = $gallery->images;
        $cached = $gallery->image_dimensions ?: [];

        foreach ($images as $image) {
            $fileId = $image->id;
            if (isset($cached[$fileId])) {
                $image->setAttribute('width', $cached[$fileId]['w']);
                $image->setAttribute('height', $cached[$fileId]['h']);
            } else {
                $path = $image->getLocalPath();
                if ($path && file_exists($path)) {
                    $size = @getimagesize($path);
                    if ($size) {
                        $image->setAttribute('width', $size[0]);
                        $image->setAttribute('height', $size[1]);
                        $cached[$fileId] = ['w' => $size[0], 'h' => $size[1]];
                    }
                }
            }
        }

        // Persist newly computed dimensions
        if ($cached && $cached !== ($gallery->image_dimensions ?: [])) {
            $gallery->newQuery()->where('id', $gallery->id)->update([
                'image_dimensions' => json_encode($cached),
            ]);
        }

        return $images;
    }

    protected function paginateItems($items, $page = 1)
    {
        $perPage = (int) $this->property('perPage', 0);
        if ($perPage <= 0) {
            return [
                'items' => $items,
                'hasMore' => false,
            ];
        }

        $offset = ($page - 1) * $perPage;
        $paged = $items->slice($offset, $perPage)->values();

        return [
            'items' => $paged,
            'hasMore' => ($offset + $perPage) < $items->count(),
        ];
    }

    public function onLoadMore()
    {
        $page = (int) post('page', 1);

        $gallery = $this->loadGalleryModel();
        $allItems = $this->prepareGalleryItems($gallery);
        $result = $this->paginateItems($allItems, $page);

        $this->page['items'] = $result['items'];
        $this->page['gallery'] = $gallery;
        $this->page['thumbWidth'] = (int) $this->property('thumbWidth', 400);
        $this->page['thumbHeight'] = (int) $this->property('thumbHeight', 300);
        $this->page['thumbMode'] = $this->property('thumbMode', 'crop');

        return [
            'markup' => $this->renderPartial('@items'),
            'hasMore' => $result['hasMore'],
        ];
    }

    protected function getPswpOptions()
    {
        return [
            'loop' => (bool) $this->property('loop', true),
            'closeOnVerticalDrag' => (bool) $this->property('closeOnVerticalDrag', false),
            'escKey' => (bool) $this->property('escKey', true),
            'pinchToClose' => (bool) $this->property('pinchToClose', true),
            'zoom' => (bool) $this->property('zoom', true),
            'arrowEl' => (bool) $this->property('arrowEl', true),
            'counter' => (bool) $this->property('counterEl', true),
        ];
    }
}
