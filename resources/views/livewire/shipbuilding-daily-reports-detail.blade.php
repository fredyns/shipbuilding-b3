<div>
    <div>
        @can('create', App\Models\DailyReport::class)
            <button class="button" wire:click="newDailyReport">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
        @endcan @can('delete-any', App\Models\DailyReport::class)
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
                            @lang('crud.shipbuilding_daily_reports.inputs.date')
                        </h5>
                        <span>
                            {{ optional($dailyReport->date)->translatedFormat('l, d F Y')
                            }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.week')
                        </h5>
                        <span> {{ $dailyReport->week ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.actual_progress')
                        </h5>
                        <span>
                            {{ \App\Helpers\Format::percent($dailyReport->actual_progress, '-') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.morning_weather_id')
                        </h5>
                        <span>
                            {{ optional($dailyReport->morningWeather)->name ??
                            '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.morning_humidity_id')
                        </h5>
                        <span>
                            {{ optional($dailyReport->morningHumidity)->name ??
                            '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.midday_weather_id')
                        </h5>
                        <span>
                            {{ optional($dailyReport->middayWeather)->name ??
                            '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.midday_humidity_id')
                        </h5>
                        <span>
                            {{ optional($dailyReport->middayHumidity)->name ??
                            '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.afternoon_weather_id')
                        </h5>
                        <span>
                            {{ optional($dailyReport->afternoonWeather)->name ??
                            '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.afternoon_humidity_id')
                        </h5>
                        <span>
                            {{ optional($dailyReport->afternoonHumidity)->name
                            ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.temperature')
                        </h5>
                        <span> {{ $dailyReport->temperature ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_daily_reports.inputs.summary')
                        </h5>
                        <span> {{ $dailyReport->summary ?? '-' }} </span>
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
            @can('update', $dailyReport)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editDailyReport('{{ $dailyReport->id }}')"
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
                        <x-inputs.date
                            name="dailyReportDate"
                            wire:model="dailyReportDate"
                            label="{{ __('crud.daily_reports.inputs.date') }}"
                            placeholder="{{ __('crud.daily_reports.inputs.date') }}"
                        ></x-inputs.date>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.slider
                            name="dailyReport.actual_progress"
                            wire:model="dailyReport.actual_progress"
                            label="{{ __('crud.daily_reports.inputs.actual_progress') }}"
                            placeholder="{{ __('crud.daily_reports.inputs.actual_progress') }}"
                            max="255"
                            step="0.01"
                        ></x-inputs.slider>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.tomselect
                            name="dailyReport.morning_weather_id"
                            wire:model="dailyReport.morning_weather_id"
                            label="{{ __('crud.daily_reports.inputs.morning_weather_id') }}"
                        >
                            <option value="null" disabled>Please select the Weather</option>
                            @foreach($weathersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.tomselect>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.tomselect
                            name="dailyReport.morning_humidity_id"
                            wire:model="dailyReport.morning_humidity_id"
                            label="{{ __('crud.daily_reports.inputs.morning_humidity_id') }}"
                        >
                            <option value="null" disabled>Please select the Humidity</option>
                            @foreach($humiditiesForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.tomselect>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.tomselect
                            name="dailyReport.midday_weather_id"
                            wire:model="dailyReport.midday_weather_id"
                            label="{{ __('crud.daily_reports.inputs.midday_weather_id') }}"
                        >
                            <option value="null" disabled>Please select the Weather</option>
                            @foreach($weathersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.tomselect>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.tomselect
                            name="dailyReport.midday_humidity_id"
                            wire:model="dailyReport.midday_humidity_id"
                            label="{{ __('crud.daily_reports.inputs.midday_humidity_id') }}"
                        >
                            <option value="null" disabled>Please select the Humidity</option>
                            @foreach($humiditiesForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.tomselect>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.tomselect
                            name="dailyReport.afternoon_weather_id"
                            wire:model="dailyReport.afternoon_weather_id"
                            label="{{ __('crud.daily_reports.inputs.afternoon_weather_id') }}"
                        >
                            <option value="null" disabled>Please select the Weather</option>
                            @foreach($weathersForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.tomselect>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.tomselect
                            name="dailyReport.afternoon_humidity_id"
                            wire:model="dailyReport.afternoon_humidity_id"
                            label="{{ __('crud.daily_reports.inputs.afternoon_humidity_id') }}"
                        >
                            <option value="null" disabled>Please select the Humidity</option>
                            @foreach($humiditiesForSelect as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-inputs.tomselect>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.slider
                            name="dailyReport.temperature"
                            wire:model="dailyReport.temperature"
                            label="{{ __('crud.daily_reports.inputs.temperature') }}"
                            placeholder="{{ __('crud.daily_reports.inputs.temperature') }}"
                            max="100"
                        ></x-inputs.slider>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.textarea
                            name="dailyReport.summary"
                            wire:model="dailyReport.summary"
                            label="{{ __('crud.daily_reports.inputs.summary') }}"
                            placeholder="{{ __('crud.daily_reports.inputs.summary') }}"
                            maxlength="255"
                        >
                            {{ old('summary', ($editing ? $dailyReport->summary
                            : '')) }}
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
                    Tanggal
                </th>
                <th class="px-4 py-3 text-right">
                    Mgg
                </th>
                <th class="px-4 py-3 text-right">
                    Progres
                </th>
                <th class="px-4 py-3 text-left">
                    Pagi
                </th>
                <th class="px-4 py-3 text-left">
                    Siang
                </th>
                <th class="px-4 py-3 text-left">
                    Sore
                </th>
                <th class="px-4 py-3 text-right">
                    Suhu
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @foreach ($dailyReports as $dailyReport)
                @php /* @var $dailyReport \App\Models\DailyReport */ @endphp
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $dailyReport->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($dailyReport->date)->translatedFormat("D, d M'y") }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $dailyReport->week ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ \App\Helpers\Format::percent($dailyReport->actual_progress, '-') }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($dailyReport->morningWeather)->name ?? '-' }} /
                        {{ optional($dailyReport->morningHumidity)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($dailyReport->middayWeather)->name ?? '-' }} /
                        {{ optional($dailyReport->middayHumidity)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ optional($dailyReport->afternoonWeather)->name ?? '-' }} /
                        {{ optional($dailyReport->afternoonHumidity)->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $dailyReport->temperature ?? '-' }}
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
                                wire:click="viewDailyReport('{{ $dailyReport->id }}')"
                            >
                                <i class="icon ion-md-eye"></i>
                            </button>
                            @can('update', $dailyReport)
                                <button
                                    type="button"
                                    class="button mr-1"
                                    wire:click="editDailyReport('{{ $dailyReport->id }}')"
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
                <td colspan="9">
                    <div class="mt-10 px-4">
                        {{ $dailyReports->render() }}
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
