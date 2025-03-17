<?php
/**
 * @var $dailyReport \App\Models\DailyReport
 */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.daily_reports.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                {{--
                <x-slot name="title">
                    <span>@lang('card.title')</span>
                </x-slot>
                --}}

                <div class="flex flex-wrap mt-2 px-4">
                    <div class="mb-4 w-full md:w-1/3 lg:w-1/3">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_reports.inputs.date')
                        </h5>
                        <span>
                            {{ optional($dailyReport->date)->format('l, d F Y') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full md:w-1/3 lg:w-1/3">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_reports.inputs.week')
                        </h5>
                        <span> {{ $dailyReport->week ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full md:w-1/3 lg:w-1/3">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_reports.inputs.actual_progress')
                        </h5>
                        <span>
                            {{ $dailyReport->actual_progress ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full md:w-1/3 lg:w-1/3">
                        <h5 class="font-medium text-gray-700">
                            Pagi
                        </h5>
                        <span>
                            {{ optional($dailyReport->morningWeather)->name ?? '-' }} /
                            {{ optional($dailyReport->morningHumidity)->name ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full md:w-1/3 lg:w-1/3">
                        <h5 class="font-medium text-gray-700">
                            Siang
                        </h5>
                        <span>
                            {{ optional($dailyReport->middayWeather)->name ?? '-' }} /
                            {{ optional($dailyReport->middayHumidity)->name ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full md:w-1/3 lg:w-1/3">
                        <h5 class="font-medium text-gray-700">
                            Sore
                        </h5>
                        <span>
                            {{ optional($dailyReport->afternoonWeather)->name ?? '-' }} /
                            {{ optional($dailyReport->afternoonHumidity)->name ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_reports.inputs.temperature')
                        </h5>
                        <span> {{ $dailyReport->temperature ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_reports.inputs.summary')
                        </h5>
                        <span> {{ $dailyReport->summary ?? '-' }} </span>
                    </div>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    <span>@lang('text.actions')</span>
                </x-slot>
                <div class="mt-4 px-4">
                    <a href="{{ route('shipbuildings.show', $dailyReport->shipbuilding) }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        Kembali ke Pembangunan Kapal
                    </a>

                    @can('update', $dailyReport)
                        <a
                            href="{{ route('daily-reports.edit', $dailyReport) }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-create"></i>
                            @lang('crud.common.edit')
                        </a>
                    @endcan @can('delete', $dailyReport)
                        <div class="float-right">
                            <form
                                action="{{ route('daily-reports.destroy', $dailyReport) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                                <button type="submit" class="button">
                                    <i class="mr-1 icon ion-md-trash text-red-600">
                                    </i>
                                    <span class="text-red-600">
                                    @lang('crud.common.delete')
                                </span>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </x-partials.card>

            @can('view-any', App\Models\DailyPersonnel::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        Personil Harian
                    </x-slot>

                    <livewire:daily-report-daily-personnels-detail
                        :dailyReport="$dailyReport"
                    />
                </x-partials.card>
            @endcan @can('view-any', App\Models\DailyEquipment::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        Peralatan Harian
                    </x-slot>

                    <livewire:daily-report-daily-equipments-detail
                        :dailyReport="$dailyReport"
                    />
                </x-partials.card>
            @endcan @can('view-any', App\Models\DailyMaterial::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        @lang('crud.daily_report_materials.name')
                    </x-slot>

                    <livewire:daily-report-daily-materials-detail
                        :dailyReport="$dailyReport"
                    />
                </x-partials.card>
            @endcan @can('view-any', App\Models\DailyActivity::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        @lang('crud.daily_report_activities.name')
                    </x-slot>

                    <livewire:daily-report-daily-activities-detail
                        :dailyReport="$dailyReport"
                    />
                </x-partials.card>
            @endcan @can('view-any', App\Models\DailyDocumentation::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        @lang('crud.daily_report_documentations.name')
                    </x-slot>

                    <livewire:daily-report-daily-documentations-detail
                        :dailyReport="$dailyReport"
                    />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
