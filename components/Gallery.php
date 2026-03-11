<?php namespace ChiragPatel\PhotoSwipe\Components;

use Cms\Classes\ComponentBase;
use ChiragPatel\PhotoSwipe\Models\Gallery as GalleryModel;
use ChiragPatel\PhotoSwipe\Traits\GalleryComponentTrait;

class Gallery extends ComponentBase
{
    use GalleryComponentTrait;

    public function componentDetails()
    {
        return [
            'name' => 'chiragpatel.photoswipe::lang.components.gallery.title',
            'description' => 'chiragpatel.photoswipe::lang.components.gallery.description',
        ];
    }

    public function defineProperties()
    {
        return array_merge([
            'source' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.source.title',
                'description' => 'chiragpatel.photoswipe::lang.components.gallery.properties.source.description',
                'type' => 'dropdown',
                'default' => 'slug',
                'options' => [
                    'slug' => 'URL Slug',
                    'dropdown' => 'Select from list',
                ],
                'showExternalParam' => false,
            ],
            'slug' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.slug.title',
                'description' => 'chiragpatel.photoswipe::lang.components.gallery.properties.slug.description',
                'default' => '{{ :slug }}',
                'type' => 'string',
            ],
            'galleryId' => [
                'title' => 'chiragpatel.photoswipe::lang.components.gallery.properties.galleryId.title',
                'description' => 'chiragpatel.photoswipe::lang.components.gallery.properties.galleryId.description',
                'type' => 'dropdown',
                'placeholder' => 'Select Gallery',
                'showExternalParam' => false,
            ],
        ], $this->defineGalleryProperties());
    }

    public function getGalleryIdOptions()
    {
        return GalleryModel::published()
            ->orderBy('title', 'asc')
            ->pluck('title', 'id')
            ->toArray();
    }

    public function onRun()
    {
        $this->loadGalleryAssets();

        $gallery = $this->loadGalleryModel();
        if (!$gallery) {
            $this->page['notFound'] = true;
            return;
        }

        $this->gallery = $gallery;
        $allItems = $this->prepareGalleryItems($gallery);
        $result = $this->paginateItems($allItems);

        $layout = $this->getEffectiveLayout();
        $perPage = (int) $this->property('perPage', 0);

        $this->page['gallery'] = $gallery;
        $this->page['items'] = $result['items'];
        $this->page['hasMore'] = $result['hasMore'];
        $this->page['layout'] = $layout;
        $this->page['pswpOptions'] = json_encode($this->getPswpOptions());
        $this->page['thumbWidth'] = (int) $this->property('thumbWidth', 400);
        $this->page['thumbHeight'] = (int) $this->property('thumbHeight', 300);
        $this->page['thumbMode'] = $this->property('thumbMode', 'crop');
        $this->page['useInfiniteScroll'] = $perPage > 0;
    }

    protected function loadGalleryModel()
    {
        $source = $this->property('source', 'slug');

        if ($source === 'dropdown') {
            $galleryId = $this->property('galleryId');
            return GalleryModel::published()
                ->with(['items.image', 'images', 'cover'])
                ->find($galleryId);
        }

        $slug = $this->property('slug');
        return GalleryModel::published()
            ->with(['items.image', 'images', 'cover'])
            ->where('slug', $slug)
            ->first();
    }
}
