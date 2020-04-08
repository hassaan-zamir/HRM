<?php

namespace App\Http\Requests;

use App\Employees;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'machine_id' => [
              Rule::unique((new Employees)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'full_name' => [
                'required', 'min:3'
            ],
            'designation' => [
              'required',
            ],
            'department' => [
              'required'
            ],
            'join_date' => [
              'required','date',
            ],
        ];
    }
}
