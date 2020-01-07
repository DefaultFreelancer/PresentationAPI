<?php

namespace App\Models;

class NounNatureCitation extends BaseModel
{

    public static function create($citation, $nature)
    {
        try{
            $model = new self();
            $model->citation_id  = $citation;
            $model->nature_id   = $nature;
            $model->save();
        } catch (\Exception $e){
            return false;
        }

        return true;
    }
}
