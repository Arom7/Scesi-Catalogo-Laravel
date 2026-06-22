<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Foundation\Http\Attributes\FailOnUnknownFields;


#[FailOnUnknownFields]
class StoreProductRequest extends FormRequest
{
    public function __construct(
        private StoreImageProductRequest $storeImageProductRequest
    ){}

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
        return array_merge($this->storeImageProductRequest->rules(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:10',
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return array_merge($this->storeImageProductRequest->messages(), [
            'name.required' => 'El nombre es requerido',
            'name.max' => 'El nombre no puede exceder los 255 caracteres',
            'description.string' => 'La descripción debe ser un texto',
            'base_price.required' => 'El precio base es requerido',
            'base_price.numeric' => 'El precio base debe ser un número',
            'base_price.min' => 'El precio base debe ser al menos 10',
        ]);
    }
}
