<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipe_name' => ['required', 'min:2', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
            'prep_time' => ['required', 'integer', 'min:1', 'max:1440'], 
            'ingredients' => ['required', 'string', 'min:5'],
            'steps' => ['required', 'string', 'min:5'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'additional_note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
