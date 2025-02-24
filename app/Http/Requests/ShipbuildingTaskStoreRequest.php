<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipbuildingTaskStoreRequest extends FormRequest
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
            'shipbuilding_id' => ['required', 'exists:shipbuildings,id'],
            'parent_task_id' => ['nullable', 'exists:shipbuilding_tasks,id'],
            'item_type' => ['required', 'in:work-item,category'],
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'weight' => ['required', 'numeric'],
            'enable_sub_progress' => ['required', 'in:none,category,work-item'],
            'progress' => ['required', 'numeric'],
            'target' => ['required', 'numeric'],
            'deviation' => ['required', 'numeric'],
        ];
    }
}
