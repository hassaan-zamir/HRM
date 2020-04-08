<?php

namespace App\Http\Requests;

use App\Leaves;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LeavesRequest extends FormRequest
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
      'start_date' => [ 'required' ],
      'end_date' => [ 'required' ],
      'emp_id' => [ 'required' ],
      'user_id' => [ 'required' ],
      'subject' => [ 'required' ],
      'description' => [ 'required' ],
      'type' => [ 'required' ]
    ];
  }
}
