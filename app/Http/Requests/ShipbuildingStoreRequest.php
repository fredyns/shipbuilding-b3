<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipbuildingStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'cover_image' => ['image', 'max:1024', 'nullable'],
            'number' => ['required', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'progress' => ['required', 'numeric'],
            'ship_type_id' => ['nullable', 'exists:ship_types,id'],
            'shipyard_id' => ['nullable', 'exists:shipyards,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ];
    }
}
