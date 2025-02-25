<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.weekly_reports.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\WeeklyReport::class)
                                <a
                                    href="{{ route('weekly-reports.create') }}"
                                    class="button button-primary"
                                >
                                    <i class="mr-1 icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.weekly_reports.inputs.shipbuilding_id')
                            </th>
                            <th class="px-4 py-3 text-right">
                                @lang('crud.weekly_reports.inputs.week')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.weekly_reports.inputs.month')
                            </th>
                            <th class="px-4 py-3 text-right">
                                @lang('crud.weekly_reports.inputs.planned_progress')
                            </th>
                            <th class="px-4 py-3 text-right">
                                @lang('crud.weekly_reports.inputs.actual_progress')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.weekly_reports.inputs.summary')
                            </th>
                            <th class="px-4 py-3 text-left">
                                @lang('crud.weekly_reports.inputs.report_file')
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600">
                        @forelse($weeklyReports as $weeklyReport)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($weeklyReport->shipbuilding)->name
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $weeklyReport->week ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($weeklyReport->month)->format('D, d
                                    M Y') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $weeklyReport->planned_progress ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $weeklyReport->actual_progress ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $weeklyReport->summary ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    @if($weeklyReport->report_file)
                                        <a
                                            href="{{ Storage::url($weeklyReport->report_file) }}"
                                            target="blank"
                                        ><i
                                                class="mr-1 icon ion-md-download"
                                            ></i
                                            >&nbsp;Download</a
                                        >
                                    @else
                                        -
                                    @endif
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $weeklyReport)
                                            <a
                                                href="{{ route('weekly-reports.edit', $weeklyReport) }}"
                                                class="mr-1"
                                            >
                                                <button
                                                    type="button"
                                                    class="button"
                                                >
                                                    <i
                                                        class="icon ion-md-create"
                                                    ></i>
                                                </button>
                                            </a>
                                        @endcan @can('view', $weeklyReport)
                                            <a
                                                href="{{ route('weekly-reports.show', $weeklyReport) }}"
                                                class="mr-1"
                                            >
                                                <button
                                                    type="button"
                                                    class="button"
                                                >
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="mt-10 px-4">
                                    {!! $weeklyReports->render() !!}
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
