<?php

namespace App\Http\Requests;

use App\PublicHolidays;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PublicHolidaysRequest extends FormRequest
{
  /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    return auth()->check();
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules()
  {
    return [
      'date' => [
        'required',
      ],
      'title' => [
        'required','min:3'
      ],

    ];
  }
}
