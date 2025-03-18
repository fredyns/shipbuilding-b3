<?php
/**
 * @var $shipbuildings \App\Models\Shipbuilding|\Illuminate\Database\Eloquent\Collection
 * @var $weeklyReport \App\Models\WeeklyReport
 * @var $lastReport \App\Models\WeeklyReport
 */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.weekly_reports.create_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form
                method="POST"
                action="{{ route('weekly-reports.store') }}"
                has-files
            >

                <x-partials.card class="mb-5">
                    <x-slot name="title">
                        <span>Laporan Terakhir</span>
                    </x-slot>

                    @if($lastReport)
                        <div class="flex flex-wrap mt-2 px-4">
                            <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.weekly_reports.inputs.week')
                                </h5>
                                <span> {{ $lastReport->week ?? '-' }} </span>
                            </div>
                            <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.weekly_reports.inputs.date')
                                </h5>
                                <span>
                                    {{ optional($lastReport->date)->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.weekly_reports.inputs.planned_progress')
                                </h5>
                                <span>
                                    {{ App\Helpers\Format::percent($lastReport->planned_progress, '-')}}
                                </span>
                            </div>
                            <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.weekly_reports.inputs.actual_progress')
                                </h5>
                                <span>
                                    {{ App\Helpers\Format::percent($lastReport->actual_progress, '-')}}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-wrap mt-2 px-4">
                            <div class="mb-4 w-full">
                                <span>
                                    <i>tidak ditemukan</i>
                                </span>
                            </div>
                        </div>
                    @endif
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
                            >
                            </i>
                            @lang('crud.common.back')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.create')
                        </button>
                    </div>
                </x-partials.card>
            </x-form>
        </div>
    </div>
</x-app-layout>
