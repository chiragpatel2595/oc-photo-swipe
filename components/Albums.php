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
            'name'        => 'chiragpatel.photoswipe::lang.components.albums.title',
            'description' => 'chiragpatel.photoswipe::lang.components.albums.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'sortBy' => [
                'title' => 'chiragpatel.photoswipe::lang.components.albums.properties.sortBy.title',
                'description' => 'Name of Gallery page file for the link on Album page.',
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
                ]
            ],
            'galleryPage' => [
                'title' => 'chiragpatel.photoswipe::lang.components.albums.properties.galleryPage',
                'description' => 'Name of Gallery page file for the link on Album page.',
                'type' => 'dropdown',
                'default' => 'album/gallery',
                'group' => 'chiragpatel.photoswipe::lang.components.albums.properties.links'
            ],
        ];
    }

    public function getGalleryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function init()
    {
        if (!empty($this->property('sortBy'))) {
            $sorting = explode('-', $this->property('sortBy'));
            $this->sortBy = $sorting[0];
            $this->sortType = $sorting[1];
        }
    }
    public function onRun()
    {
        $this->prepareVars();

        $this->addCss('/plugins/chiragpatel/photoswipe/assets/resources/custom.css');

        $this->albums = $this->page['albums'] = $this->loadAlbums();
    }

    protected function prepareVars()
    {
        /*
         * Page links
         */
        $this->galleryPage = $this->page['galleryPage'] = $this->property('galleryPage');
    }

    public function loadAlbums()
    {
        $albums = Gallery::where('is_published',true)->orderBy($this->sortBy, $this->sortType)->get();

        $albums->each(function($album) {
            $album->url = $this->setUrl($album, $this->galleryPage, $this->controller);
        });

        return $albums;
    }

    public function setUrl($gallery, $pageName, $controller)
    {
        $params = [
            'id'   => $gallery->id,
            'slug' => $gallery->slug,
        ];

        //expose published year, month and day as URL parameters
        /*if ($this->published) {
            $params['year'] = $this->published_at->format('Y');
            $params['month'] = $this->published_at->format('m');
            $params['day'] = $this->published_at->format('d');
        }*/

        return $controller->pageUrl($pageName, $params);
    }
}
