<?php
/**
 * @var $weeklyReport \App\Models\WeeklyReport
 */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('shipbuildings.show', $weeklyReport->shipbuilding_id) }}" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.weekly_reports.show_title')
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
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.shipbuilding_id')
                        </h5>
                        <span>
                            {{ optional($weeklyReport->shipbuilding)->name ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.week')
                        </h5>
                        <span> {{ $weeklyReport->week ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.date')
                        </h5>
                        <span>
                            {{ optional($weeklyReport->date)->format('l, d F Y')
                            }}
                        </span>
                    </div>
                    <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.planned_progress')
                        </h5>
                        <span>
                            {{ $weeklyReport->planned_progress ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full lg:w-1/2 md:w-1/2">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.actual_progress')
                        </h5>
                        <span>
                            {{ $weeklyReport->actual_progress ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.summary')
                        </h5>
                        <span> {{ $weeklyReport->summary ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_reports.inputs.report_file')
                        </h5>
                        @if($weeklyReport->report_file)
                            <a
                                href="{{ Storage::url($weeklyReport->report_file) }}"
                                target="blank"
                            >
                                <i class="mr-1 icon ion-md-download"></i>
                                Download
                            </a>
                        @else
                            -
                        @endif
                    </div>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    <span>@lang('text.actions')</span>
                </x-slot>
                <div class="mt-4 px-4">
                    <a
                        href="{{ route('shipbuildings.show', $weeklyReport->shipbuilding_id) }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('update', $weeklyReport)
                        <a
                            href="{{ route('weekly-reports.edit', $weeklyReport) }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-create"></i>
                            @lang('crud.common.edit')
                        </a>
                    @endcan @can('delete', $weeklyReport)
                        <div class="float-right">
                            <form
                                action="{{ route('weekly-reports.destroy', $weeklyReport) }}"
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
