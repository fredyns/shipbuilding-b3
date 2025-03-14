<?php

use App\Helpers\Format;

?>
<div>
    <div>
        @can('create', App\Models\MonthlyReport::class)
            <button class="button" wire:click="newMonthlyReport">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
        @endcan @can('delete-any', App\Models\MonthlyReport::class)
            <button
                class="button button-danger"
                {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('{{ __('crud.common.are_you_sure') }}') || event.stopImmediatePropagation()"
                wire:click="destroySelected"
            >
                <i class="mr-1 icon ion-md-trash text-primary"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModalView">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div class="flex flex-wrap">
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_monthly_reports.inputs.month')
                        </h5>
                        <span>
                            {{ optional($monthlyReport->month)->translatedFormat('F Y') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_monthly_reports.inputs.planned_progress')
                        </h5>
                        <span>
                            {{ $monthlyReport->planned_progress ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_monthly_reports.inputs.actual_progres')
                        </h5>
                        <span>
                            {{ $monthlyReport->actual_progres ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_monthly_reports.inputs.report_file')
                        </h5>
                        @if($monthlyReport->report_file)
                            <a
                                href="{{ \Storage::url($monthlyReport->report_file) }}"
                                target="blank"
                            >
                                <i class="mr-1 icon ion-md-download"></i>
                                Download
                            </a>
                        @else
                            -
                        @endif
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_monthly_reports.inputs.summary')
                        </h5>
                        <span> {{ $monthlyReport->summary ?? '-' }} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModalView')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('text.close')
            </button>
            @can('update', $monthlyReport)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editMonthlyReport('{{ $monthlyReport->id }}')"
                >
                    <i class="mr-1 icon ion-md-create"></i>
                    @lang('crud.common.edit')
                </button>
            @endcan
        </div>
    </x-modal>

    <x-modal wire:model="showingModalForm">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div class="flex flex-wrap">
                    <x-inputs.group class="w-full">
                        <x-inputs.basic
                            type="month"
                            name="monthlyReportMonth"
                            wire:model="monthlyReportMonth"
                            label="{{ __('crud.shipbuilding_monthly_reports.inputs.month') }}"
                            placeholder="{{ __('crud.shipbuilding_monthly_reports.inputs.month') }}"
                        ></x-inputs.basic>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="monthlyReport.planned_progress"
                            wire:model="monthlyReport.planned_progress"
                            label="{{ __('crud.shipbuilding_monthly_reports.inputs.planned_progress') }} (%)"
                            placeholder="{{ __('crud.shipbuilding_monthly_reports.inputs.planned_progress') }}"
                            max="100"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="monthlyReport.actual_progres"
                            wire:model="monthlyReport.actual_progres"
                            label="{{ __('crud.shipbuilding_monthly_reports.inputs.actual_progres') }} (%)"
                            placeholder="{{ __('crud.shipbuilding_monthly_reports.inputs.actual_progres') }}"
                            max="100"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.partials.label
                            name="monthlyReportReportFile"
                            label="{{ __('crud.shipbuilding_monthly_reports.inputs.report_file') }}"
                        ></x-inputs.partials.label>
                        <br/>

                        <input
                            type="file"
                            name="monthlyReportReportFile"
                            id="monthlyReportReportFile{{ $uploadIteration }}"
                            wire:model="monthlyReportReportFile"
                            class="form-control-file"
                        />

                        @if($editing && $monthlyReport->report_file)
                            <div class="mt-2">
                                <a
                                    href="{{ \Storage::url($monthlyReport->report_file) }}"
                                    target="_blank"
                                >
                                    <i class="icon ion-md-download"></i>
                                    Download
                                </a>
                            </div>
                        @endif @error('monthlyReportReportFile')
                        @include('components.inputs.partials.error') @enderror
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="monthlyReport.summary"
                            wire:model="monthlyReport.summary"
                            label="{{ __('crud.shipbuilding_monthly_reports.inputs.summary') }}"
                            placeholder="{{ __('crud.shipbuilding_monthly_reports.inputs.summary') }}"
                        >
                            {{ old('summary', ($editing ?
                            $monthlyReport->summary : '')) }}
                        </x-inputs.textarea>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModalForm')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left w-1">
                    <input
                        type="checkbox"
                        wire:model="allSelected"
                        wire:click="toggleFullSelection"
                        title="{{ trans('crud.common.select_all') }}"
                    />
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.shipbuilding_monthly_reports.inputs.month')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.shipbuilding_monthly_reports.inputs.planned_progress')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.shipbuilding_monthly_reports.inputs.actual_progres')
                </th>
                <th class="px-4 py-3 text-center">
                    File
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @foreach ($monthlyReports as $monthlyReport)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $monthlyReport->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($monthlyReport->month)->translatedFormat('M Y') }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ Format::percent($monthlyReport->planned_progress, '-') }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ Format::percent($monthlyReport->actual_progres, '-') }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($monthlyReport->report_file)
                            <a
                                href="{{ \Storage::url($monthlyReport->report_file) }}"
                                class="button button-primary"
                                target="blank"
                            >
                                <i class="icon ion-md-download"></i>
                            </a>
                        @else - @endif
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            <button
                                type="button"
                                class="button mr-1"
                                wire:click="viewMonthlyReport('{{ $monthlyReport->id }}')"
                            >
                                <i class="icon ion-md-eye"></i>
                            </button>
                            @can('update', $monthlyReport)
                                <button
                                    type="button"
                                    class="button mr-1"
                                    wire:click="editMonthlyReport('{{ $monthlyReport->id }}')"
                                >
                                    <i class="icon ion-md-create"></i>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <div class="mt-10 px-4">
                        {{ $monthlyReports->render() }}
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
