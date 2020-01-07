<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    public function user(){
        $this->belongsTo(User::class);
    }
}
