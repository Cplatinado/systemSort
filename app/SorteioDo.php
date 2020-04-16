<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SorteioDo extends Model
{

    public function scopeAvaliable($query)
    {
        return $query->where('email_confirmed', 1);


    }

}
