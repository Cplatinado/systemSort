<?php

namespace App;

use App\suport\Crooper;
use Faker\Provider\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Sorteio extends Model
{



    public function images()
    {
        return $this->hasMany(SortImage::class, 'sort','id')
            ->orderBy('cover','ASC');
    }

    public function cover()
    {
        $image = $this->images();

        $cover = $image->where('cover', 1)->first(['path']);
        if(!$cover){
            $image = $this->images();
            $cover = $image->first(['path']);
        }

        if(empty($cover['path']) || !File::fileExtension('../public/storage' .$cover['path'])){
            return url(asset('undraw_gift_card_6ekc.svg'));
        }


        return Storage::url(Crooper::thumb($cover['path'], 1366, 768));
    }

    public function scopeAvailable($query){

        return $query->where('status', 1)->where('finalized', 0);

    }

    public function scopeUnavailable($query){
        return $query->where('status', 0);
    }


    public function getDateAttribute($value){


        return date('d/m/Y', strtotime($value));
    }

    public function setDateAttribute($value){


        if (!empty($value)) {
            $this->attributes['date'] = $this->convertStringToDate($value);
        }
    }


    public function setTitleAttribute($value){
        $this->attributes['title']= $value;
        $this->attributes['slug'] = Str::slug($value).$this->attributes['id'] ;
    }


    private function convertStringToDate($param)
    {
        if (empty($param)) {
            return null;
        }

        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
}
