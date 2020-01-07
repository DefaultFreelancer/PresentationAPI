<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NounType extends BaseModel
{
    protected $table = 'noun_type';
    protected $hidden = ['created_at', 'updated_at'];
}
