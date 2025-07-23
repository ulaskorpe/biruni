<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $content_type_id = last($this->segments());
        return [
            'name' => ['required','string', 'max:50','unique:content_types,name,'.$content_type_id],
            'slug' => ['required','string','unique:content_types,slug,'.$content_type_id],
        ];
    }
}
