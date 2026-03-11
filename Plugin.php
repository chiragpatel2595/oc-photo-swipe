<?php namespace ChiragPatel\PhotoSwipe;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'ChiragPatel\PhotoSwipe\Components\Albums' => 'albums',
            'ChiragPatel\PhotoSwipe\Components\Gallery' => 'gallery',
        ];
    }

    public function registerPageSnippets()
    {
        return [
            'ChiragPatel\PhotoSwipe\Components\Albums' => 'albums',
            'ChiragPatel\PhotoSwipe\Components\Gallery' => 'gallery',
        ];
    }
}
