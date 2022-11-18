<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


/**
 * @author James Carlo Luchavez <jluchavez@umindanao.edu.ph>
 * @since 2020/12/10
 * If the input key was detected, this will throw an error.
 */
class Exclude implements Rule
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
        return FALSE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must not be present.';
    }
}
