<?php

namespace App\Models;

class CitationStatus extends BaseModel
{

    protected $with = ['status'];
    protected $hidden = ['word_id','status_id','user_id'];

    public static function create($word, $user, $status = null)
    {
        $model = new self();
        $model->word_id = $word;
        $model->user_id = $user;
        $model->status_id = $status;
        $model->save();
    }

    public function wordId()
    {
        return $this->hasOne(Word::class,'id','word_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id','status_id');
    }

    public function userId()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
