<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'images' => 'required|array|min:1',
            'images.*' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Se requiere al menos una imagen',
            'images.min' => 'Se requiere al menos una imagen',
            'images.array' => 'El campo de imágenes debe ser un arreglo',
            'images.*.required' => 'Cada imagen es obligatoria',
            'images.*.image' => 'Cada archivo debe ser una imagen',
            'images.*.mimes' => 'Solo se permiten archivos de tipo: jpeg, png, jpg, gif',
            'images.*.max' => 'Cada imagen no debe exceder los 10MB',
        ];
    }
}
