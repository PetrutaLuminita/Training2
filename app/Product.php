<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string image_url
 * @property string image
 * @property Carbon start_date
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
        'image_url'
    ];
    /**
     * Return the full path to the image of the product
     *
     * @return string
     */
    public function getImageAttribute()
    {
        if (!$this->image_url) {
            return '';
        }

        return env('APP_URL') . '/storage/images/' . $this->image_url;
    }
}
