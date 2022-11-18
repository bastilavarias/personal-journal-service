<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**

 * @since 2020/11/30
 *
 * Usage
 *  This Cast will simply encode the value
 *      if the given value can be encoded
 *
 *  This will also return the decoded (array) value
 *      of the the value
 */
class JSONable implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        $array = json_decode($value);

        if (json_last_error() == JSON_ERROR_NONE) {
            return json_decode($value, TRUE);
        }

        return $value;
    }

    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}
