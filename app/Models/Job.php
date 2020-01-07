<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends BaseModel
{

    protected $fillable = [];

    protected $hidden = ['user_id', 'parent'];

    protected $with = ['user'];

    protected $attributes = [
      'review_threshold' => 0,
      'strict_down' => false,
      'strict_up' => false,
      'display_vertical' => false,
      'display_open' => false
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
