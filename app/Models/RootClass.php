<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Root;

class RootClass extends BaseModel {

    protected $table = 'root_classes';
    protected $fillable = [
        'id',
        'class',

    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function roots() {
        return $this->hasMany(Root::class);
    }
}