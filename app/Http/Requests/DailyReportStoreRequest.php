<?php

namespace App\Http\Requests;

use App\Rules\UniqueDailyReport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DailyReportStoreRequest extends FormRequest
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
            'date' => [
                'required',
                'date',
                Rule::unique('daily_reports')
                    ->where(fn($query) => $query->where('shipbuilding_id', $this->input('shipbuilding_id'))),
            ],
            'actual_progress' => ['nullable', 'numeric'],
            'morning_weather_id' => ['nullable', 'exists:weathers,id'],
            'morning_humidity_id' => ['nullable', 'exists:humidities,id'],
            'midday_weather_id' => ['nullable', 'exists:weathers,id'],
            'midday_humidity_id' => ['nullable', 'exists:humidities,id'],
            'afternoon_weather_id' => ['nullable', 'exists:weathers,id'],
            'afternoon_humidity_id' => ['nullable', 'exists:humidities,id'],
            'temperature' => ['nullable', 'numeric'],
            'summary' => ['nullable', 'max:255', 'string'],
        ];
    }
}
