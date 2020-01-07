<?php

namespace App\Models;

class ScientificDomain extends BaseModel
{
    protected $fillable = ['model'];

    protected $hidden = ['created_at', 'updated_at'];

    public function citation()
    {
        return $this->hasMany(Citation::class, 'scientificDomain','id');
    }

}
