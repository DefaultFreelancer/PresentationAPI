	<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NounSex extends BaseModel
{
    protected $table = 'noun_sex';
    protected $hidden = ['created_at', 'updated_at'];
}
