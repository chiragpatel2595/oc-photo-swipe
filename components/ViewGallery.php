<?php namespace ChiragPatel\PhotoSwipe\Components;

use ChiragPatel\PhotoSwipe\Models\Gallery;
use Cms\Classes\ComponentBase;

class ViewGallery extends ComponentBase
{
    protected $albums;
    protected $gallery;

    public function componentDetails()
    {
        return [
            'name' => 'chiragpatel.photoswipe::lang.components.viewGallery.title',
            'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.slug.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.slug.description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'loop' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.loop.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.loop.description',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Display Properties'
            ],
            'closeOnScroll' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.closeOnScroll.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.closeOnScroll.description',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Display Properties'
            ],
            'closeOnVerticalDrag' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.closeOnVerticalDrag.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.closeOnVerticalDrag.description',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Display Properties'
            ],
            'escKey' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.escKey.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.escKey.description',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Display Properties'
            ],
            'pinchToClose' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.pinchToClose.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.pinchToClose.description',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Display Properties'
            ],
            'captionEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.captionEl.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.captionEl.description',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Display Properties'
            ],
            'swipeWhileZoom' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.swipeWhileZoom.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.swipeWhileZoom.description',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Zoom Properties'
            ],
            'maxSpreadZoom' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.maxSpreadZoom.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.maxSpreadZoom.description',
                'type' => 'string',
                'default' => '2',
                'showExternalParam' => false,
                'group' => 'Zoom Properties'
            ],
            'getDoubleTapZoom' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.getDoubleTapZoom.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.getDoubleTapZoom.description',
                'type' => 'string',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Zoom Properties'
            ],
            'shareEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.shareEl.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.shareEl.description',
                'type' => 'checkbox',
                'default' => '0',
                'showExternalParam' => false,
                'group' => 'Buttons'
            ],
            'zoomEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.zoomEl.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.zoomEl.description',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons'
            ],
            'fullscreenEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.fullscreenEl.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.fullscreenEl.description',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons'
            ],
            'arrowEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.arrowEl.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.arrowEl.description',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons'
            ],
            'counterEl' => [
                'title' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.counterEl.title',
                'description' => 'chiragpatel.photoswipe::lang.components.viewGallery.properties.counterEl.description',
                'type' => 'checkbox',
                'default' => '1',
                'showExternalParam' => false,
                'group' => 'Buttons'
            ],
        ];
    }

    public function onRun()
    {
        $this->addCss('/plugins/chiragpatel/photoswipe/assets/resources/custom.css');
        $this->addCss('/plugins/chiragpatel/photoswipe/assets/resources/default-skin/default-skin.css');
        $this->addCss('/plugins/chiragpatel/photoswipe/assets/resources/photoswipe.css');

        $this->addJs('/plugins/chiragpatel/photoswipe/assets/resources/photoswipe.min.js');
        $this->addJs('/plugins/chiragpatel/photoswipe/assets/resources/photoswipe-ui-default.js');

        $this->prepareOptions();
        $gallery = $this->loadGallery($this->property('slug'));
        $this->gallery = $this->page['gallery'] = $gallery;

    }

    public function prepareOptions()
    {
        //Option is always false on devices that don't have hardware touch support.
        if ($this->property('swipeWhileZoom') == 1) {
            $this->page['swipeWhileZoom'] = "true";
        } else {
            $this->page['swipeWhileZoom'] = "false";
        }

        if ($this->property('loop') == 1) {
            $this->page['loop'] = "true";
        } else {
            $this->page['loop'] = "false";
        }

        if ($this->property('closeOnScroll') == 1) {
            $this->page['closeOnScroll'] = "true";
        } else {
            $this->page['closeOnScroll'] = "false";
        }

        if ($this->property('pinchToClose') == 1) {
            $this->page['pinchToClose'] = "true";
        } else {
            $this->page['pinchToClose'] = "false";
        }

        if ($this->property('closeOnVerticalDrag') == 1) {
            $this->page['closeOnVerticalDrag'] = "true";
        } else {
            $this->page['closeOnVerticalDrag'] = "false";
        }

        if ($this->property('escKey') == 1) {
            $this->page['escKey'] = "true";
        } else {
            $this->page['escKey'] = "false";
        }

        if ($this->property('shareEl') == 1) {
            $this->page['shareEl'] = "true";
        } else {
            $this->page['shareEl'] = "false";
        }

        if ($this->property('zoomEl') == 1) {
            $this->page['zoomEl'] = "true";
        } else {
            $this->page['zoomEl'] = "false";
        }

        if ($this->property('fullscreenEl') == 1) {
            $this->page['fullscreenEl'] = "true";
        } else {
            $this->page['fullscreenEl'] = "false";
        }

        if ($this->property('counterEl') == 1) {
            $this->page['counterEl'] = "true";
        } else {
            $this->page['counterEl'] = "false";
        }

        if ($this->property('arrowEl') == 1) {
            $this->page['arrowEl'] = "true";
        } else {
            $this->page['arrowEl'] = "false";
        }

        if ($this->property('captionEl') == 1) {
            $this->page['captionEl'] = "true";
        } else {
            $this->page['captionEl'] = "false";
        }

        $this->page['maxSpreadZoom'] = $this->property('maxSpreadZoom');
        $this->page['tapZoomLevel'] = $this->property('getDoubleTapZoom');
    }

    public function loadGallery($gallerySlug)
    {

        $gallery = Gallery::where('slug',$gallerySlug)->first();

        if (!empty($gallery)) {
            $this->gallery = $this->page['gallery'] = $gallery;

            $images = $this->gallery->images;

            foreach ($images as $image) {
                $dimensions = $this->getDimensions($image->getPath());
                $image->height = $dimensions['height'];
                $image->width = $dimensions['width'];
            }
        }

        return $gallery;
    }

    public function getDimensions($bytes)
    {
        $size = getimagesize($bytes);
        $dimensions = explode(" ", $size[3]);
        preg_match('/"([^"]+)"/', $dimensions[0], $width);
        preg_match('/"([^"]+)"/', $dimensions[1], $height);
        $resolution['height'] = $height[1];
        $resolution['width'] = $width[1];
        return $resolution;
    }
}
