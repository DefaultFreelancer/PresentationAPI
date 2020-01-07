<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends BaseModel
{

    protected $fillable = ['name', 'email', 'country', 'phoneNumber', 'description', 'status', 'institution', 'roles'];

    protected $hidden = ['password'];

    protected $with = ['country', 'institution', 'roles'];

    public function country(){
        return $this->hasOne(Country::class, 'id', 'country');
    }

    public function institution(){
        return $this->hasOne(Institution::class, 'id', 'institution');
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function jobs(){
        return $this->belongsTo(Job::class, 'id', 'user_id');
    }
}
