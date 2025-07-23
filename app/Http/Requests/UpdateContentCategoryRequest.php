<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContentCategoryRequest extends FormRequest
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
        $id = last($this->segments());
        return [
            'name' => 'required|string|max:50',
            'language' => 'required|string|max:2',
            'content_type_id' => 'required|numeric',
            'slug' => ['required','string','unique:content_categories,slug,'.$id],
            'parent_id' => Rule::notIn([$id]),
        ];
    }
}
