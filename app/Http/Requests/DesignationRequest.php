<?php

namespace App\Http\Requests;

use App\Designations;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
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
            'title' => [
                'required', 'min:2',Rule::unique((new Designations)->getTable())->ignore($this->route()->department->id ?? null)
            ],
            'detail' => [
              'required',
            ],
        ];
    }
}
