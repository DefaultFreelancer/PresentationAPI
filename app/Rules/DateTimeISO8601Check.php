<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateTimeISO8601Check implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(\.\d*)?(Z|((-|\+)\d{2}:\d{2}))$/', $value, $parts) == true)
        {
            try { new \DateTime($value); return true; }
            catch ( \Exception $e){ return false; }
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute is not in ISO 8601 format.";
    }
}
