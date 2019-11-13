<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string image_path
 * @property string image
 */
class Product extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $appends = [
        'image'
    ];

    protected $hidden = [
        'image_path'
    ];

    /**
     * Return the full path to the image of the product
     *
     * @return string
     */
    public function getImageAttribute()
    {
        if (!$this->image_path) {
            return '';
        }

        return env('APP_URL') . '/storage/images/' . $this->image_path;
    }
}
