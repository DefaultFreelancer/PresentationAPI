<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WordActivity extends BaseModel
{
    const COMMENT = 0;
    const SYSTEM = 1;
    const VERSION = 2;

    protected $with = ['word', 'user'];

    static function new(Word $word, User $user, $type, $content, $data){
        try{
            DB::beginTransaction();

            $wordActivity = new WordActivity();

            $wordActivity->word     = $word->id;
            $wordActivity->user     = $user->id;
            $wordActivity->type     = $type;
            $wordActivity->content  = $content;
            $wordActivity->data     = $data;

            $wordActivity->save();

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return WordActivity::find($wordActivity->id);
    }

    public function word(){
        return $this->hasOne(Word::class, 'id', 'word');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
