<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**

 * @since 2020/11/24
 */
class ReservedName implements Rule
{
    protected $reservedWords;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->reservedWords = collect([
            'admin',
            'help',
            'support',
            'info',
        ]);
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
        $hasReservedWord = $this->reservedWords->contains(function ($reservedWord) {
            return Str::contains($value, $reservedWord);
        });

        return $hasReservedWord === FALSE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must not contain reserved words';
    }
}
