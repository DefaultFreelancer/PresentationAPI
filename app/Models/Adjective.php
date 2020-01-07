<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjective extends BaseModel
{
    protected $with = ['adjectivePattern', 'typePattern', 'patternPastParticiple', 'patternAssimilated', 'patternMobalagha', 'patternComperative', 'patternPeriodParticiple', 'patternPlaceParticiple', 'patternMachineParticiple', 'patternVerb'];
    protected $hidden = ['adjective_pattern_id', 'type_pattern_id', 'pattern_past_participle_id', 'pattern_assimilated_id', 'pattern_mobalagha_id', 'pattern_comperative_id', 'pattern_period_participle_id', 'pattern_place_participle_id', 'pattern_machine_participle_id', 'pattern_verb_id'];

    public function adjectivePattern(){
        return $this->hasOne(Pattern::class,'id', 'adjective_pattern_id');
    }

    public function typePattern(){
        return $this->hasOne(AdjectiveTypePattern::class,'id', 'type_pattern_id');
    }

    public function patternPastParticiple(){
        return $this->hasOne(Pattern::class,'id', 'pattern_past_participle_id');
    }

    public function patternAssimilated(){
        return $this->hasOne(Pattern::class,'id', 'pattern_assimilated_id');
    }

    public function patternMobalagha(){
        return $this->hasOne(Pattern::class,'id', 'pattern_mobalagha_id');
    }

    public function patternComperative(){
        return $this->hasOne(Pattern::class,'id', 'pattern_comperative_id');
    }

    public function patternPeriodParticiple(){
        return $this->hasOne(Pattern::class,'id', 'pattern_period_participle_id');
    }

    public function patternPlaceParticiple(){
        return $this->hasOne(Pattern::class,'id', 'pattern_place_participle_id');
    }

    public function patternMachineParticiple(){
        return $this->hasOne(Pattern::class,'id', 'pattern_machine_participle_id');
    }

    public function patternVerb(){
        return $this->hasOne(Pattern::class,'id', 'pattern_verb_id');
    }

}
