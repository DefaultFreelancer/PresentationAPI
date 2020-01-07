<?php

namespace App\Models;

class Source extends BaseModel
{
    protected $fillable = ['source'];

    protected $hidden = ['created_at', 'updated_at'];

    public function citation()
    {
        return $this->hasMany(Citation::class, 'source','id');
    }

}
