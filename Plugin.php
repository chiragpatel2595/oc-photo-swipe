<?php namespace ChiragPatel\PhotoSwipe;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'ChiragPatel\PhotoSwipe\Components\Albums' => 'albums',
            'ChiragPatel\PhotoSwipe\Components\ViewGallery' => 'viewGallery',
            'ChiragPatel\PhotoSwipe\Components\DirectGallery' => 'directGallery',
        ];
    }

    public function registerSettings()
    {
    }

    public function registerPageSnippets()
    {
        return [
            'ChiragPatel\PhotoSwipe\Components\Albums' => 'albums',
            'ChiragPatel\PhotoSwipe\Components\ViewGallery' => 'viewGallery',
            'ChiragPatel\PhotoSwipe\Components\DirectGallery' => 'directGallery',
        ];
    }
}
