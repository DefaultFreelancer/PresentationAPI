<?php

namespace App\Models;

class Word extends BaseModel
{
    protected $with = ['root', 'type', 'adjective', 'noun', 'verb', 'infinitive'];

    protected $hidden = ['noun_id', 'verb_id', 'adjective_id', 'infinitive_id'];

    protected $attributes = [
        'type' => null
    ];

    public function root(){
        return $this->hasOne(Root::class,'id', 'root');
    }

    public function type(){
        return $this->hasOne(WordType::class, 'id', 'type');
    }

    public function citation()
    {
        return $this->belongsTo(Citation::class, 'word');
    }

    public function adjective(){
        return $this->hasOne(Adjective::class,'id', 'adjective_id');
    }

    public function noun(){
        return $this->hasOne(Noun::class,'id', 'noun_id');
    }

    public function verb(){
        return $this->hasOne(Verb::class,'id', 'verb_id');
    }

    public function infinitive(){
        return $this->hasOne(Infinitive::class,'id', 'infinitive_id');
    }

    public function setType($typeId){
        
        if($this->type && $this->type != $typeId){
            $this->removeRelations();
        }

        $this->type = $typeId;
    }

    public function getType(){
        return $this->type;
    }

    public function removeRelations(){
        //remove related entries from ajectives, nouns, verbs and infinitives
        if($this->adjective_id){
            $id = $this->adjective_id;
            $this->adjective_id = null;
            $this->save();
            Adjective::findOrFail($id)->delete();
        }
        if($this->noun_id){
            $id = $this->noun_id;
            $this->noun_id = null;
            $this->save();
            Noun::findOrFail($id)->delete();
        }
        if($this->infinitive_id){
            $id = $this->infinitive_id;
            $this->infinitive_id = null;
            $this->save();
            Infinitive::findOrFail($id)->delete();
        }
        if($this->verb_id){
            $id = $this->verb_id;
            $this->verb_id = null;
            $this->save();
            Verb::findOrFail($id)->delete();
        }
    }
}
