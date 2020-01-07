<?php

namespace App\Models;

class ScientificDomainCitation extends BaseModel
{

    public static function create($citation, $domain)
    {
        try{
            $model = new self();
            $model->citation_id  = $citation;
            $model->domain_id   = $domain;
            $model->save();
        } catch (\Exception $e){
            return false;
        }

        return true;
    }





}
