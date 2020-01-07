<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends BaseModel
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
