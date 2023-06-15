<?php

namespace App\Http\UploadService;

use Illuminate\Foundation\Http\FormRequest;

class UploadServiceFileRequest extends FormRequest
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
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5120',
        ];
    }
}
