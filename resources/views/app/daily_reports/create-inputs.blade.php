<?php
/**
 * @var $shipbuilding \App\Models\Shipbuilding
 * @var $dailyReport \App\Models\DailyReport
 * @var $weathers string[]
 * @var $humidities string[]
 */
$editing = false;
?>

<style>
    .ts-control {
        border: none;
        padding: 0;
    }

    .ts-dropdown,
    .ts-control,
    .ts-control input {
        color: rgb(31 41 55 / var(--tw-text-opacity));
        font-family: inherit;
        font-size: 1rem;
        line-height: 1.5;
    }
</style>

<x-partials.card>
    {{--
    <x-slot name="title">
        <span>@lang('card.title')</span>
    </x-slot>
    --}}

    <div class="flex flex-wrap">
        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="shipbuilding_id"
                label="{{ __('crud.daily_reports.inputs.shipbuilding_id') }}"
                required
            >
                <option value="{{ $shipbuilding->id }}" selected>{{ $shipbuilding->name }}</option>
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.date
                name="date"
                value="{{ old('date',  optional($dailyReport->date)->format('Y-m-d') ) }}"
                label="{{ __('crud.daily_reports.inputs.date') }}"
                placeholder="{{ __('crud.daily_reports.inputs.date') }}"
                required
                min="{{ optional($shipbuilding->start_date)->format('Y-m-d') }}"
            ></x-inputs.date>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.number
                name="actual_progress"
                :value="old('actual_progress',  $dailyReport->actual_progress )"
                label="{{ __('crud.daily_reports.inputs.actual_progress') }}"
                placeholder="{{ __('crud.daily_reports.inputs.actual_progress') }}"
                max="100"
                step="0.01"
            ></x-inputs.number>
        </x-inputs.group>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2 mt-3">
            <label for="morning_weather_id" class="label font-medium text-gray-700">
                Morning
            </label>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 md:w-1/2">
                    <x-inputs.radio-group
                        name="morning_weather_id"
                        :value="old('morning_weather_id',  $dailyReport->morning_weather_id )"
                        :options="$weathers"
                    ></x-inputs.radio-group>
                </div>
                <div class="w-full lg:w-1/2 md:w-1/2">
                    <x-inputs.radio-group
                        name="morning_humidity_id"
                        :value="old('morning_humidity_id',  $dailyReport->morning_humidity_id )"
                        :options="$humidities"
                    ></x-inputs.radio-group>
                </div>
            </div>
        </x-inputs.group>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2 mt-3">
            <label for="midday_weather_id" class="label font-medium text-gray-700">
                Midday
            </label>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 md:w-1/2">
                    <x-inputs.radio-group
                        name="midday_weather_id"
                        :value="old('midday_weather_id',  $dailyReport->midday_weather_id )"
                        :options="$weathers"
                    ></x-inputs.radio-group>
                </div>
                <div class="w-full lg:w-1/2 md:w-1/2">
                    <x-inputs.radio-group
                        name="midday_humidity_id"
                        :value="old('midday_humidity_id',  $dailyReport->midday_humidity_id )"
                        :options="$humidities"
                    ></x-inputs.radio-group>
                </div>
            </div>
        </x-inputs.group>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2 mt-3">
            <label for="afternoon_weather_id" class="label font-medium text-gray-700">
                Afternoon
            </label>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 md:w-1/2">
                    <x-inputs.radio-group
                        name="afternoon_weather_id"
                        :value="old('afternoon_weather_id',  $dailyReport->afternoon_weather_id )"
                        :options="$weathers"
                    ></x-inputs.radio-group>
                </div>
                <div class="w-full lg:w-1/2 md:w-1/2">
                    <x-inputs.radio-group
                        name="afternoon_humidity_id"
                        :value="old('afternoon_humidity_id',  $dailyReport->afternoon_humidity_id )"
                        :options="$humidities"
                    ></x-inputs.radio-group>
                </div>
            </div>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.slider
                name="temperature"
                :value="old('temperature',  $dailyReport->temperature )"
                label="{{ __('crud.daily_reports.inputs.temperature') }}"
                placeholder="{{ __('crud.daily_reports.inputs.temperature') }}"
            ></x-inputs.slider>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="summary"
                label="{{ __('crud.daily_reports.inputs.summary') }}"
                placeholder="{{ __('crud.daily_reports.inputs.summary') }}"
            >
                {{ old('summary',  $dailyReport->summary ) }}
            </x-inputs.textarea>
        </x-inputs.group>
    </div>
</x-partials.card>
