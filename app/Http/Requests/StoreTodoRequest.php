<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'body' => "required|string|min:3|max:255"
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'The todo is required',
            'body.string' => 'The todo must be a string',
            'body.min' => 'The todo can\'t be less than 3 characters',
            'body.max' => 'The todo can\'t be more than 255 characters',
        ];
    }
}
