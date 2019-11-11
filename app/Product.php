<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    /**
     * Return the full path to the image of the product
     *
     * @return string
     */
    public function image()
    {
        return env('APP_URL') . '/storage/images/' . $this->image_url;
    }
}
