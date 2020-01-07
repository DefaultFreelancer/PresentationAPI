<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noun extends BaseModel
{

    protected $with = ['pattern', 'type', 'patternPlural', 'classPlural', 'sex', 'sexHow', 'attribution', 'minimize'];
    protected $hidden = ['pattern_id', 'type_id', 'class_plural_id', 'sex_id', 'sex_how_id', 'attribution_id', 'minimize_id', 'pattern_plural_id'];

    public function pattern(){
        return $this->hasOne(Pattern::class,'id', 'pattern_id');
    }

    public function type(){
        return $this->hasOne(NounType::class,'id', 'type_id');
    }

    public function patternPlural(){
        return $this->hasOne(Pattern::class,'id', 'pattern_plural_id');
    }

    public function classPlural(){
        return $this->hasOne(NounClassPlural::class,'id', 'class_plural_id');
    }

    public function sex(){
        return $this->hasOne(NounSex::class,'id', 'sex_id');
    }

    public function sexHow(){
        return $this->hasOne(NounSexHow::class,'id', 'sex_how_id');
    }

    public function attribution(){
        return $this->hasOne(NounAttribution::class,'id', 'attribution_id');
    }

    public function minimize(){
        return $this->hasOne(NounMinimize::class,'id', 'minimize_id');
    }

}
