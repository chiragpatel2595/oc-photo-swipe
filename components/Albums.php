<?php namespace ChiragPatel\PhotoSwipe\Components;

use ChiragPatel\PhotoSwipe\Models\Gallery;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;

class Albums extends ComponentBase
{
    public $albums;
    public $galleryPage;
    public $sortBy;
    public $sortType;

    public function componentDetails()
    {
        return [
            'name' => 'chiragpatel.photoswipe::lang.components.albums.title',
            'description' => 'chiragpatel.photoswipe::lang.components.albums.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'sortBy' => [
                'title' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.title',
                'description' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.description',
                'type' => 'dropdown',
                'default' => 'title-asc',
                'showExternalParam' => false,
                'options' => [
                    'title-asc' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.options.title-asc',
                    'title-desc' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.options.title-desc',
                    'updated_at-asc' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.options.updated_at-asc',
                    'updated_at-desc' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.options.updated_at-desc',
                    'published_at-asc' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.options.published_at-asc',
                    'published_at-desc' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.options.published_at-desc',
                ],
            ],
            'galleryPage' => [
                'title' => 'chiragpatel.photoswipe::lang.components.albums.properties.galleryPage',
                'description' => 'chiragpatel.photoswipe::lang.components.albums.properties.galleryPage.description',
                'type' => 'dropdown',
                'default' => 'album/gallery',
                'group' => 'chiragpatel.photoswipe::lang.components.albums.properties.links',
            ],
        ];
    }

    public function getGalleryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function init()
    {
        if ($this->property('sortBy')) {
            $sorting = explode('-', $this->property('sortBy'));
            $this->sortBy = $sorting[0];
            $this->sortType = $sorting[1];
        }
    }

    public function onRun()
    {
        $base = '/plugins/chiragpatel/photoswipe/assets';
        $this->addCss($base . '/css/gallery.css');

        $this->galleryPage = $this->page['galleryPage'] = $this->property('galleryPage');
        $this->albums = $this->page['albums'] = $this->loadAlbums();
    }

    public function loadAlbums()
    {
        $albums = Gallery::published()
            ->with(['cover', 'images'])
            ->orderBy($this->sortBy, $this->sortType)
            ->get();

        $albums->each(function ($album) {
            $album->url = $this->controller->pageUrl($this->galleryPage, [
                'id' => $album->id,
                'slug' => $album->slug,
            ]);
        });

        return $albums;
    }
}
