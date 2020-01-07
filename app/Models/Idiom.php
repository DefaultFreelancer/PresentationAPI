<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idiom extends BaseModel
{
    protected $with = ['root', 'word'];

    public function root(){
        return $this->hasOne(Root::class,'id', 'root');
    }

    public function word(){
        return $this->hasOne(Word::class,'id', 'word');
    }
}
