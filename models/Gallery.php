<?php namespace ChiragPatel\PhotoSwipe\Models;

use Model;

class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    public $table = 'chiragpatel_photoswipe_galleries';

    public $rules = [
        'title' => 'required',
    ];

    protected $guarded = ['*'];

    protected $fillable = ['title', 'slug', 'description', 'layout'];

    protected $slugs = ['slug' => 'title'];

    protected $jsonable = ['image_dimensions'];

    protected $dates = ['published_at'];

    public $hasMany = [
        'items' => [
            GalleryItem::class,
            'order' => 'sort_order',
        ],
    ];

    public $attachMany = [
        'images' => ['System\Models\File', 'order' => 'sort_order'],
    ];

    public $attachOne = [
        'cover' => ['System\Models\File'],
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function afterSave()
    {
        $this->cacheImageDimensions();
    }

    protected function cacheImageDimensions()
    {
        $dimensions = [];

        foreach ($this->items as $item) {
            if ($item->type === 'image' && $item->image) {
                $dimensions[$item->id] = [
                    'w' => $item->width,
                    'h' => $item->height,
                ];
            }
        }

        if ($dimensions && $this->image_dimensions !== $dimensions) {
            $this->newQuery()->where('id', $this->id)->update([
                'image_dimensions' => json_encode($dimensions),
            ]);
        }
    }
}
