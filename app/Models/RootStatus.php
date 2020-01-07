<?php

namespace App\Models;

class RootStatus extends BaseModel
{

	protected $with = ['status'];
    protected $hidden = ['root_id','status_id','user_id'];
    
    public static function create($root, $user, $status = null)
    {
    	$model = new self();
    	$model->root_id = $root;
    	$model->user_id = $user;
    	$model->status_id = $status;
    	$model->save();
    }


    public function root()
    {
    	return $this->hasOne(Root::class, 'id', 'root_id');
    }


    public function status()
    {
    	return $this->hasOne(Status::class, 'id', 'status_id');
    }


    public function user()
    {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }   

}
