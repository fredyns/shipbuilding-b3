@php $editing = isset($dailyReport) @endphp

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
                @php $selected = old('shipbuilding_id', ($editing ? $dailyReport->shipbuilding_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Shipbuilding</option>
                @foreach($shipbuildings as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.date
                name="date"
                value="{{ old('date', ($editing ? optional($dailyReport->date)->format('Y-m-d') : '')) }}"
                label="{{ __('crud.daily_reports.inputs.date') }}"
                placeholder="{{ __('crud.daily_reports.inputs.date') }}"
                required
            ></x-inputs.date>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.slider
                name="actual_progress"
                :value="old('actual_progress', ($editing ? $dailyReport->actual_progress : ''))"
                label="{{ __('crud.daily_reports.inputs.actual_progress') }}"
                placeholder="{{ __('crud.daily_reports.inputs.actual_progress') }}"
                max="100"
                step="0.01"
            ></x-inputs.slider>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="morning_weather_id"
                label="{{ __('crud.daily_reports.inputs.morning_weather_id') }}"
            >
                @php $selected = old('morning_weather_id', ($editing ? $dailyReport->morning_weather_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Weather</option>
                @foreach($weathers as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="morning_humidity_id"
                label="{{ __('crud.daily_reports.inputs.morning_humidity_id') }}"
            >
                @php $selected = old('morning_humidity_id', ($editing ? $dailyReport->morning_humidity_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Humidity</option>
                @foreach($humidities as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="midday_weather_id"
                label="{{ __('crud.daily_reports.inputs.midday_weather_id') }}"
            >
                @php $selected = old('midday_weather_id', ($editing ? $dailyReport->midday_weather_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Weather</option>
                @foreach($weathers as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="midday_humidity_id"
                label="{{ __('crud.daily_reports.inputs.midday_humidity_id') }}"
            >
                @php $selected = old('midday_humidity_id', ($editing ? $dailyReport->midday_humidity_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Humidity</option>
                @foreach($humidities as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="afternoon_weather_id"
                label="{{ __('crud.daily_reports.inputs.afternoon_weather_id') }}"
            >
                @php $selected = old('afternoon_weather_id', ($editing ? $dailyReport->afternoon_weather_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Weather</option>
                @foreach($weathers as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="afternoon_humidity_id"
                label="{{ __('crud.daily_reports.inputs.afternoon_humidity_id') }}"
            >
                @php $selected = old('afternoon_humidity_id', ($editing ? $dailyReport->afternoon_humidity_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Humidity</option>
                @foreach($humidities as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.slider
                name="temperature"
                :value="old('temperature', ($editing ? $dailyReport->temperature : ''))"
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
                {{ old('summary', ($editing ? $dailyReport->summary : '')) }}
            </x-inputs.textarea>
        </x-inputs.group>
    </div>
</x-partials.card>
