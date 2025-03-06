<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyReportUpdateRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'week' => ['required', 'numeric'],
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
