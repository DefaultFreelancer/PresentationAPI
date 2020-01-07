<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends BaseModel
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
