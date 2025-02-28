<div>
    <div>
        @can('create', App\Models\WeeklyReport::class)
            <button class="button" wire:click="newWeeklyReport">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
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
                            @lang('crud.shipbuilding_weekly_reports.inputs.week')
                        </h5>
                        <span> {{ $weeklyReport->week ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_weekly_reports.inputs.date')
                        </h5>
                        <span>
                            {{ optional($weeklyReport->date)->format('l, d F Y') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_weekly_reports.inputs.planned_progress')
                        </h5>
                        <span>
                            {{ \App\Helpers\Format::percent($weeklyReport->planned_progress, '-') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_weekly_reports.inputs.actual_progress')
                        </h5>
                        <span>
                            {{ \App\Helpers\Format::percent($weeklyReport->actual_progress, '-') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_weekly_reports.inputs.summary')
                        </h5>
                        <span> {{ $weeklyReport->summary ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_weekly_reports.inputs.report_file')
                        </h5>
                        @if($weeklyReport->report_file)
                            <a
                                href="{{ \Storage::url($weeklyReport->report_file) }}"
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
            @can('update', $weeklyReport)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editWeeklyReport('{{ $weeklyReport->id }}')"
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
                    @role('super-admin')
                    <x-inputs.group class="w-full">
                        <x-inputs.slider
                            name="weeklyReport.week"
                            wire:model="weeklyReport.week"
                            label="{{ __('crud.weekly_reports.inputs.week') }}"
                            placeholder="{{ __('crud.weekly_reports.inputs.week') }}"
                        ></x-inputs.slider>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.date
                            name="weeklyReportDate"
                            wire:model="weeklyReportDate"
                            label="{{ __('crud.weekly_reports.inputs.date') }}"
                            placeholder="{{ __('crud.weekly_reports.inputs.date') }}"
                        ></x-inputs.date>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.slider
                            name="weeklyReport.planned_progress"
                            wire:model="weeklyReport.planned_progress"
                            label="{{ __('crud.weekly_reports.inputs.planned_progress') }}"
                            placeholder="{{ __('crud.weekly_reports.inputs.planned_progress') }}"
                            step="0.01"
                        ></x-inputs.slider>
                    </x-inputs.group>
                    @else
                        <div class="mb-4 px-4 w-full">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuilding_weekly_reports.inputs.week')
                            </h5>
                            <span> {{ $weeklyReport->week ?? '-' }} </span>
                        </div>
                        <div class="mb-4 px-4 w-full">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuilding_weekly_reports.inputs.date')
                            </h5>
                            <span>
                                {{ optional($weeklyReport->date)->format('l, d F Y') }}
                            </span>
                        </div>
                        <div class="mb-4 px-4 w-full">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuilding_weekly_reports.inputs.planned_progress')
                            </h5>
                            <span>
                                {{ \App\Helpers\Format::percent($weeklyReport->planned_progress, '-') }}
                            </span>
                        </div>
                        @endrole
                        <x-inputs.group class="w-full">
                            <x-inputs.number
                                name="weeklyReport.actual_progress"
                                wire:model="weeklyReport.actual_progress"
                                label="{{ __('crud.weekly_reports.inputs.actual_progress') }}"
                                placeholder="{{ __('crud.weekly_reports.inputs.actual_progress') }}"
                                step="0.01"
                                min="0"
                                max="100"
                            ></x-inputs.number>
                        </x-inputs.group>
                        <x-inputs.group class="w-full">
                            <x-inputs.textarea
                                name="weeklyReport.summary"
                                wire:model="weeklyReport.summary"
                                label="{{ __('crud.weekly_reports.inputs.summary') }}"
                                placeholder="{{ __('crud.weekly_reports.inputs.summary') }}"
                            >
                                {{ old('summary', ($editing ? $weeklyReport->summary : '')) }}
                            </x-inputs.textarea>
                        </x-inputs.group>
                        <x-inputs.group class="w-full">
                            <x-inputs.partials.label
                                name="weeklyReportReportFile"
                                label="{{ __('crud.weekly_reports.inputs.report_file') }}"
                            ></x-inputs.partials.label>
                            <br/>

                            <input
                                type="file"
                                name="weeklyReportReportFile"
                                id="weeklyReportReportFile{{ $uploadIteration }}"
                                wire:model="weeklyReportReportFile"
                                class="form-control-file"
                            />

                            @if($editing && $weeklyReport->report_file)
                                <div class="mt-2">
                                    <a
                                        href="{{ \Storage::url($weeklyReport->report_file) }}"
                                        target="_blank"
                                    >
                                        <i class="icon ion-md-download"></i>
                                        Download
                                    </a>
                                </div>
                            @endif @error('weeklyReportReportFile')
                            @include('components.inputs.partials.error') @enderror
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
                <th class="px-4 py-3 text-center">
                    @lang('crud.shipbuilding_weekly_reports.inputs.week')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.shipbuilding_weekly_reports.inputs.date')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.shipbuilding_weekly_reports.inputs.planned_progress')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.shipbuilding_weekly_reports.inputs.actual_progress')
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @foreach ($weeklyReports as $weeklyReport)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-center">
                        {{ $weeklyReport->week ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($weeklyReport->date)->format('D, d M Y') }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ \App\Helpers\Format::percent($weeklyReport->planned_progress, '-') }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ \App\Helpers\Format::percent($weeklyReport->actual_progress, '-') }}
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
                                wire:click="viewWeeklyReport('{{ $weeklyReport->id }}')"
                            >
                                <i class="icon ion-md-eye"></i>
                            </button>
                            @can('update', $weeklyReport)
                                <button
                                    type="button"
                                    class="button mr-1"
                                    wire:click="editWeeklyReport('{{ $weeklyReport->id }}')"
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
                        {{ $weeklyReports->render() }}
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
