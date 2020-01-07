<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Root;

class Pattern extends BaseModel {

    protected $table = 'patterns';
    protected $fillable = [
        'id',
        'text',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function roots() {
        return $this->hasMany(Root::class);
    }
}