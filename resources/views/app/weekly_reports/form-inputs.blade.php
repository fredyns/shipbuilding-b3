@php $editing = isset($weeklyReport) @endphp

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

<x-partials.card class="mt-5">
    <x-slot name="title">
        <span>Form Laporan Mingguan</span>
    </x-slot>

    <div class="flex flex-wrap">
        <div style="display: none;">
            <input type="hidden" name="shipbuilding_id" value="{{ $weeklyReport->shipbuilding_id }}">
        </div>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2">
            <x-inputs.slider
                name="week"
                :value="old('week', ($editing ? $weeklyReport->week : ''))"
                label="{{ __('crud.weekly_reports.inputs.week') }}"
                placeholder="{{ __('crud.weekly_reports.inputs.week') }}"
                required
            ></x-inputs.slider>
        </x-inputs.group>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2">
            <x-inputs.date
                name="date"
                value="{{ old('date', ($editing ? optional($weeklyReport->date)->format('Y-m-d') : '')) }}"
                label="{{ __('crud.weekly_reports.inputs.date') }}"
                placeholder="{{ __('crud.weekly_reports.inputs.date') }}"
            ></x-inputs.date>
        </x-inputs.group>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2">
            <x-inputs.number
                name="planned_progress"
                :value="old('planned_progress', ($editing ? $weeklyReport->planned_progress : ''))"
                label="{{ __('crud.weekly_reports.inputs.planned_progress') }}"
                placeholder="{{ __('crud.weekly_reports.inputs.planned_progress') }}"
                max="100"
                step="0.01"
            ></x-inputs.number>
        </x-inputs.group>

        <x-inputs.group class="w-full lg:w-1/2 md:w-1/2">
            <x-inputs.number
                name="actual_progress"
                :value="old('actual_progress', ($editing ? $weeklyReport->actual_progress : ''))"
                label="{{ __('crud.weekly_reports.inputs.actual_progress') }}"
                placeholder="{{ __('crud.weekly_reports.inputs.actual_progress') }}"
                max="100"
                step="0.01"
            ></x-inputs.number>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="summary"
                label="{{ __('crud.weekly_reports.inputs.summary') }}"
                placeholder="{{ __('crud.weekly_reports.inputs.summary') }}"
            >
                {{ old('summary', ($editing ? $weeklyReport->summary : '')) }}
            </x-inputs.textarea>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.partials.label
                name="report_file"
                label="{{ __('crud.weekly_reports.inputs.report_file') }}"
            ></x-inputs.partials.label>
            <br/>

            <input
                type="file"
                name="report_file"
                id="report_file"
                class="form-control-file"
            />

            @if($editing && $weeklyReport->report_file)
                <div class="mt-2">
                    <a
                        href="{{ Storage::url($weeklyReport->report_file) }}"
                        target="_blank"
                    >
                        <i class="icon ion-md-download"></i>
                        Download
                    </a>
                </div>
            @endif @error('report_file')
            @include('components.inputs.partials.error') @enderror
        </x-inputs.group>
    </div>
</x-partials.card>
