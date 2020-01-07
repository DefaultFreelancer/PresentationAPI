<?php

namespace App\Models;

class Era extends BaseModel
{
    protected $hidden = ['created_at', 'updated_at'];
    /**
     * @return array
     */
    public function citationsData()
    {
        $datas = [];
        $model = Citation::where(['era' => $this->id])->get();
        foreach ($model as $item){
            array_push($datas,$item);
        }

        return $datas;
    }



}
