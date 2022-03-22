<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WateringRequest extends FormRequest
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
            'period' => 'required|integer|min:1|max:30',
        ];
    }

    public function messages()
    {
        return [
            'period.required' => 'A period is required',
            'period.integer' => 'A period should be an integer',
            'period.min' => 'A period should be at least 1',
            'period.max' => 'A period should be at most 30',
        ];
    }
}
