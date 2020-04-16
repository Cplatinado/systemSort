<?php

namespace App;

use App\suport\Crooper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PromoImage extends Model
{
    public function getUrlCroppedAttribute()
    {
        return Storage::url(Crooper::thumb($this->path, 1366, 768));
    }
}
