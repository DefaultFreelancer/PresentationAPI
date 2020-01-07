<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NounMinimize extends BaseModel
{
    protected $table = 'noun_minimize';
    protected $hidden = ['created_at', 'updated_at'];

    protected $with = ['pattern'];

    public function pattern(){
        return $this->hasOne(Pattern::class,'id', 'pattern_id');
    }
}
