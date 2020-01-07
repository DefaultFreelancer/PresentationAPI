<?php

namespace App\Models;

class NounNature extends BaseModel
{
    protected $fillable = ['nature'];

    protected $hidden = ['created_at', 'updated_at'];

    public function citation()
    {
        return $this->hasMany(Citation::class, 'nounNature','id');
    }

}
