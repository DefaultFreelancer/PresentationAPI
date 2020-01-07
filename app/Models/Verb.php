<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verb extends BaseModel
{
    protected $with = ['pattern', 'verbPhonologicalRule', 'verbSyntaxicalRule'];
    protected $hidden = ['pattern_id', 'syntaxical_rule_id','phonological_rule_id'];
    
    public function pattern(){
        return $this->hasOne(Pattern::class,'id', 'pattern_id');
    }

    public function verbPhonologicalRule(){
        return $this->hasOne(VerbPhonologicalRule::class,'id', 'phonological_rule_id');
    }

    public function verbSyntaxicalRule(){
        return $this->hasOne(VerbSyntaxicalRule::class,'id', 'syntaxical_rule_id');
    }
    
}
