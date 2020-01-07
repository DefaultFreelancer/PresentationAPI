<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infinitive extends BaseModel
{   
    protected $with = ['pattern', 'patternHayaah', 'patternMeme', 'patternMaking', 'patternTime', 'patternVerb'];
    protected $hidden = ['pattern_id', 'pattern_hayaah_id', 'pattern_meme_id', 'pattern_making_id', 'pattern_time_id'];

    public function pattern(){
        return $this->hasOne(Pattern::class,'id', 'pattern_id');
    }

    public function patternHayaah(){
        return $this->hasOne(Pattern::class,'id', 'pattern_hayaah_id');
    }

    public function patternMeme(){
        return $this->hasOne(Pattern::class,'id', 'pattern_meme_id');
    }

    public function patternMaking(){
        return $this->hasOne(Pattern::class,'id', 'pattern_making_id');
    }
    
    public function patternTime(){
        return $this->hasOne(Pattern::class,'id', 'pattern_time_id');
    }

    public function patternVerb(){
        return $this->hasOne(Pattern::class,'id', 'pattern_verb_id');
    }

}
