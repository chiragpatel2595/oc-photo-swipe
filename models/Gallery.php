<?php namespace ChiragPatel\PhotoSwipe\Models;

use Model;

/**
 * Gallery Model
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;


    public $rules = [
        'title' => 'required',
        'images' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'chiragpatel_photoswipe_galleries';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title','slug'];

    /**
     * @var array Relations
     */

    public $attachMany = [
        'images' => ['System\Models\File'],
    ];

    public $attachOne = [
        'cover' => ['System\Models\File'],
    ];
}