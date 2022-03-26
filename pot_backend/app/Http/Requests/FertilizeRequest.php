<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FertilizeRequest extends FormRequest
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
            'fertilize' => 'required|integer|min:0',
            'period' => 'required|integer|min:1|max:30',
            'amount' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fertilize.required' => 'Fertilizer is required',
            'fertilize.integer' => 'Fertilizer must be an integer',
            'fertilize.min' => 'Fertilizer must be a positive integer',
            'period.required' => 'The period field is required.',
            'period.integer' => 'The period field must be an integer.',
            'period.min' => 'The period field must be at least 1.',
            'period.max' => 'The period field must be at most 30.',
            'amount.required' => 'The amount field is required.',
            'amount.float' => 'The amount field must be a float.',
        ];   
    }
}
