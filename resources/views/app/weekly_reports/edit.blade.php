<?php

use App\Helpers\Format;

/**
 * @var $shipbuildings \App\Models\Shipbuilding|\Illuminate\Database\Eloquent\Collection
 * @var $weeklyReport \App\Models\WeeklyReport
 * @var $lastReport \App\Models\WeeklyReport
 */
$shipbuilding = $weeklyReport->shipbuilding;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.weekly_reports.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form
                method="PUT"
                action="{{ route('weekly-reports.update', $weeklyReport) }}"
                has-files
            >

                <x-partials.card>
                    <x-slot name="title">
                        <span>Pembangunan Kapal</span>
                    </x-slot>

                    <div class="flex flex-wrap mt-2">
                        <div class="w-full md:w-4/12 lg:w-3/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.number')
                            </h5>
                            <span> {{ $shipbuilding->number ?? '-' }} </span>
                        </div>
                        <div class="w-full md:w-4/12 lg:w-3/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.name')
                            </h5>
                            <span> {{ $shipbuilding->name ?? '-' }} </span>
                        </div>
                        <div class="w-full md:w-4/12 lg:w-3/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.progress')
                            </h5>
                            <span>
                                {{ Format::percent($shipbuilding->progress,"-") }}
                            </span>
                        </div>
                        <div class="w-full md:w-4/12 lg:w-3/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.start_date')
                            </h5>
                            <span>
                                {{ optional($shipbuilding->start_date)->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                    </div>

                </x-partials.card>

                @include('app.weekly_reports.form-inputs')

                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        <span>@lang('text.actions')</span>
                    </x-slot>
                    <div class="mt-4 px-4">
                        <a
                            href="javascript: history.go(-1)"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a
                            href="{{ route('weekly-reports.show', $weeklyReport) }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-backspace text-primary">
                            </i>
                            @lang('crud.common.cancel')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-partials.card>
            </x-form>

            @can('view-any', App\Models\WeeklyDocumentation::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        @lang('crud.weekly_report_documentations.name')
                    </x-slot>

                    <livewire:weekly-report-weekly-documentations-detail
                        :weeklyReport="$weeklyReport"
                    />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
