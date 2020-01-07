<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CitationDateFormat implements Rule
{

    public function passes($attribute, $value)
    {

        if(preg_match('/^(-?\d+)-(\d{1,2})-(\d{1,2})$/', $value, $match)){

            $year  = (int)$match[1];
            $month = (int)$match[2];
            $day   = (int)$match[3];

            if($year == 0){
                return false;
            }

            if($month > 12)
                return false;

            if($day > 32)
                return false;

            return true;

        } else if(preg_match('/^(-?\d+)$/', $value, $match)){
            $year  = (int)$match[1];

            if($year == 0){
                return false;
            }

            return true;
        }

        return false;
    }

    public function message()
    {
        return "The :attribute wrong date format.";
    }

}
