<?php
namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest as BaseRequest;

use App\Exceptions\UnauthorizedException;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class FormRequest extends BaseRequest
{
  public function cannotBeGuest()
  {
    if (Auth::guard('api')->check()) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  public function mustBeGuest()
  {
    if (Auth::guard('api')->check()) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  /**
   * Implement your Admin-checker
   */
  public function mustBeAdmin()
  {
    if (Auth::guard('api')->check()) {
      $user = Auth::guard('api')->user();
      
      return TRUE;
    } else {
      return FALSE;
    }
  }
  protected function failedAuthorization()
  {
    throw new UnauthorizedException;
  }

  protected function failedValidation(Validator $validator)
  {
    throw new ValidationException($validator);
  }
}
