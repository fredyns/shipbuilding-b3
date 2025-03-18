<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WeeklyReportUpdateRequest extends FormRequest
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
            'week' => [
                'required',
                'numeric',
                Rule::unique('weekly_reports')
                    ->where(fn($query) => $query->where('shipbuilding_id', $this->input('shipbuilding_id')))
                    ->ignore($this->route('weekly_report')->id), // Ignore the current record during update
            ],
            'date' => ['nullable', 'date'],
            'planned_progress' => ['nullable', 'numeric'],
            'actual_progress' => ['nullable', 'numeric'],
            'summary' => ['nullable', 'max:255', 'string'],
            'report_file' => ['file', 'max:1024', 'nullable'],
        ];
    }
}
