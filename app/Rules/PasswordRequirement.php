<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordRequirement implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $toUpper = preg_match('@[A-Z]@', $value);
        $toLower = preg_match('@[a-z]@', $value);
        $integer    = preg_match('@[0-9]@', $value);
        $specialChars = preg_match('@[^\w]@', $value);
        $minimum = 8;
        $maximum = 30;
        
        if(!$toUpper || !$toLower || !$integer || !$specialChars || strlen($value) < $minimum || strlen($value) > $maximum) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your password must be more than 8 characters long, should contain at-least 1 uppercase, 1 lowercase, 1 numeric and 1 special character.';
    }
}
