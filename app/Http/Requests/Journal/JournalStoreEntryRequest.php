<?php

namespace App\Http\Requests\Journal;

use App\Http\Requests\FormRequest;

class JournalStoreEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'string|required',
            'title' => 'string|required',
        ];
    }
}
