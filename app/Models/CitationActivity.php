<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CitationActivity extends BaseModel
{
    const COMMENT = 0;
    const SYSTEM = 1;
    const VERSION = 2;

    protected $with = ['citation', 'user'];

    static function new(Citation $citation, User $user, $type, $content, $data){
        try{
            DB::beginTransaction();

            $citationActivity = new CitationActivity();

            $citationActivity->citation = $citation->id;
            $citationActivity->user     = $user->id;
            $citationActivity->type     = $type;
            $citationActivity->content  = $content;
            $citationActivity->data     = $data;

            $citationActivity->save();

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return CitationActivity::find($citationActivity->id);
    }

    public function citation(){
        return $this->hasOne(Citation::class, 'id', 'citation');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user');
    }
}
