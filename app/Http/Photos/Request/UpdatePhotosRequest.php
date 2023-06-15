<?php

namespace App\Http\Photos\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotosRequest extends FormRequest
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
            'photos' => 'required|string|max:255',
            'caption' => 'required|string',
            'tags' => 'nullable|array'
        ];
    }
}
