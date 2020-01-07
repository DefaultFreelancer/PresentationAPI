<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NounAttribution extends BaseModel
{
    protected $table = 'noun_attribution';
    protected $hidden = ['created_at', 'updated_at'];
}
