<?php

namespace App\Http\Requests;

use App\RosterShifts;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RosterShiftsRequest extends FormRequest
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

    if ($this->attributes->get('start_time_hr') == 24) {
      $this->attributes->set('start_time_min' , 0);
    }

    $rules = [
      'name' => [
        'required',
      ],
      'description' => [
        'required','min:3',
      ],
      'start_time_hr' => [
        'required','integer','between:1,24',
      ],
      'start_time_min' => [
        'required','integer','between:0,60',
      ],
      'duration_hour' => [
        'required','integer','between:0,12',
      ],
      'duration_mins' => [
        'required','integer','between:0,60',
      ],
      'late_duration_hour' => [
        'required','integer','between:0,12',
      ],
      'late_duration_mins' => [
        'required','integer','between:0,60',
      ],
      'early_duration_hour' => [
        'required','integer','between:0,12',
      ],
      'early_duration_mins' => [
        'required','integer','between:0,60',
      ],
      'overtime_duration_hour' => [
        'required','integer','between:0,12',
      ],
      'overtime_duration_mins' => [
        'required','integer','between:0,60',
      ],
      'sunday_check' => [
        'required'
      ],
      'sunday_start_time_hr' => [],
      'sunday_start_time_min' => [],
      'sunday_duration_hour' => [],
      'sunday_duration_mins' => [],
      'sunday_late_duration_hour' => [],
      'sunday_late_duration_mins' => [],
      'sunday_early_duration_hour' => [],
      'sunday_early_duration_mins' => [],
      'sunday_overtime_duration_hour' => [],
      'sunday_overtime_duration_mins' => [],
    ];

    if ($this->attributes->get('sunday_check') == '2' || $this->attributes->get('sunday_check') == 2) {

        $rules['sunday_start_time_hr'] = [
          'required','integer','between:1,24',
        ];
        $rules['sunday_start_time_min'] = [
          'required','integer','between:0,60',
        ];
        $rules['sunday_duration_hour'] = [
          'required','integer','between:0,12',
        ];
        $rules['sunday_duration_mins'] = [
          'required','integer','between:0,60',
        ];
        $rules['sunday_late_duration_hour'] = [
          'required','integer','between:0,12',
        ];
        $rules['sunday_late_duration_mins'] = [
          'required','integer','between:0,60',
        ];
        $rules['sunday_early_duration_hour'] = [
          'required','integer','between:0,12',
        ];
        $rules['sunday_early_duration_mins'] = [
          'required','integer','between:0,60',
        ];
        $rules['sunday_overtime_duration_hour'] = [
          'required','integer','between:0,12',
        ];
        $rules['sunday_overtime_duration_mins'] = [
          'required','integer','between:0,60',
        ];

    }

    return $rules;
  }
}
