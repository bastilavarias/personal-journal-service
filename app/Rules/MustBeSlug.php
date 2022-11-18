<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

/**
 * @author James Carlo Luchavez <jluchavez@umindanao.edu.ph>
 * @since 2020/12/10
 * The input must be in slug format (example: james_carlo_luchavez)
 */
class MustBeSlug implements Rule
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
        return Str::of($value)->slug('_')->exactly($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a lowercase string with no spaces and can have underscore as separator.';
    }
}
