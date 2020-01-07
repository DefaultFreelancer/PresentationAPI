<?php

namespace App\Models;

class ApproximateDate extends BaseModel
{
    protected $hidden = ['created_at', 'updated_at'];

    public static function create($text,$hijriFrom,$hijriTo)
    {
        $model = new self();
        $model->text = $text;
        $model->hijriFrom = $hijriFrom;
        $model->hijriTo = $hijriTo;
        $model->save();
    }

}
