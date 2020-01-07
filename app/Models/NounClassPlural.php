<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NounClassPlural extends BaseModel
{
    protected $table = 'noun_class_plural';
    protected $hidden = ['created_at', 'updated_at'];
}
