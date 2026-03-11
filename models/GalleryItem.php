<?php namespace ChiragPatel\PhotoSwipe\Models;

use Model;

class GalleryItem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;

    public $table = 'chiragpatel_photoswipe_gallery_items';

    public $rules = [];

    protected $guarded = ['*'];

    protected $fillable = [
        'gallery_id',
        'type',
        'title',
        'caption',
        'video_url',
        'video_thumb_url',
        'width',
        'height',
        'sort_order',
    ];

    public $belongsTo = [
        'gallery' => [Gallery::class],
    ];

    public $attachOne = [
        'image' => ['System\Models\File'],
    ];

    public function getTypeOptions()
    {
        return [
            'image' => 'Image',
            'video' => 'Video',
        ];
    }

    public function getIsVideoAttribute()
    {
        return $this->type === 'video';
    }

    public function getVideoEmbedUrlAttribute()
    {
        $url = $this->video_url;
        if (!$url) {
            return null;
        }

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        return $url;
    }

    public function getThumbnailUrl($width = 400, $height = 300, $mode = 'crop')
    {
        if ($this->type === 'video' && $this->video_thumb_url) {
            return $this->video_thumb_url;
        }

        if ($this->image) {
            return $this->image->getThumb($width, $height, ['mode' => $mode]);
        }

        return null;
    }

    public function beforeSave()
    {
        if ($this->type === 'image' && $this->image && (!$this->width || !$this->height)) {
            $path = $this->image->getLocalPath();
            if ($path && file_exists($path)) {
                $size = @getimagesize($path);
                if ($size) {
                    $this->width = $size[0];
                    $this->height = $size[1];
                }
            }
        }
    }
}
