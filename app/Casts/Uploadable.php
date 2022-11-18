<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

/**

 * @since 2020/11/30
 *
 * Purpose
 *  This cast allows you to quickly upload any uploadable files
 *  without repeating yourself
 *  This Cast supports local, public, s3 and plain-text path (Valid URL)
 *
 *  Usage <https://laravel.com/docs/8.x/eloquent-mutators#custom-casts>
 *
 *  Simply add the cast in your model
 *      e.g. image' => Uploadable::class
 *
 *  With S3 you must define the AWS_URL and AWS_ENDPOINT TOO
 *
 *  Samples
 *      AWS_URL = https://BUCKET_NAME_HERE.s3-ap-southeast-1.amazonaws.com
 *      AWS_ENDPOINT = https://s3.ap-southeast-1.amazonaws.com
 *
 *  Behavior
 *      If the column is defined in $fillable
 *      then this should work on ::create() or ::update() function too
 *      Otherwise, use $model->column = $request->file
 */
class Uploadable implements CastsAttributes
{
    /**
     * Automatically appends the file location
     */
    public function get($model, $key, $value, $attributes)
    {
        if (is_null($value) || $value == '') {
            return NULL;
        }

        // check if already a url
        if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
            // if not, then take from default storage
            return Storage::url($value);
        }

        // otherwise return URL
        return  $value;
    }

    /**
     * If an instance of Illuminate\Http\UploadedFile
     * then automatically upload to default disk and set the file name as such
     * otherwise save as-is
     */
    public function set($model, $key, $value, $attributes)
    {
        if ($value instanceof UploadedFile) {

            // hash the table name to use as folder name
            // this is also not to expose table name while maintaining a foldered structure
            $tableHash = md5($model->getTable());

            // the filename will be the unixtimestamp along with the image hash
            $filename = Carbon::now()->format('U') . '_' . $value->hashName();

            $uploadedFile = $value->storeAs($tableHash, $filename);

            // if upload is successful then save it as-is
            if ($uploadedFile !== FALSE) {
                return $uploadedFile;
            } else {
                // else, set to NULL
                return NULL;
            }

        }

        return $value;
    }
}
