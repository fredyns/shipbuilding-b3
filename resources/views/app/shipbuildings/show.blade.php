<?php

use App\Helpers\Format;

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.shipbuildings.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <span>Shipbuilding</span>
                    <!--
                    @can('delete', $shipbuilding)
                        <div class="float-end mr-1">
                            <form
                                action="{{ route('shipbuildings.destroy', $shipbuilding) }}"
                                method="POST"
                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                            >
                                @csrf @method('DELETE')
                        <button type="submit" class="button">
                            <i class="icon ion-md-trash text-red-600">
                            </i>
                            <span class="text-red-600">
                        </span>
                        </button>
                    </form>
                </div>



                    @endcan
                    -->
                    @can('update', $shipbuilding)
                        <div class="float-end mr-1">
                            <a
                                href="{{ route('shipbuildings.edit', $shipbuilding) }}"
                                class="button float-end"
                            >
                                <i class="icon ion-md-create"></i>
                            </a>
                        </div>
                    @endcan

                </x-slot>

                <div class="flex flex-wrap mt-2">
                    <div class="w-full md:w-4/12 lg:w-3/12">
                        <div class="flex flex-wrap mt-2 px-4">

                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.number')
                                </h5>
                                <span> {{ $shipbuilding->number ?? '-' }} </span>
                            </div>
                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.name')
                                </h5>
                                <span> {{ $shipbuilding->name ?? '-' }} </span>
                            </div>

                        </div>
                    </div>
                    <div class="w-full md:w-4/12 lg:w-3/12">
                        <div class="flex flex-wrap mt-2 px-4">

                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.progress')
                                </h5>
                                <span>
                                    {{ Format::percent($shipbuilding->progress,"-") }}
                                </span>
                            </div>

                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.start_date')
                                </h5>
                                <span>
                                    {{ optional($shipbuilding->start_date)->format('l, d F Y') }}
                                </span>
                            </div>
                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.end_date')
                                </h5>
                                <span>
                                    {!! optional($shipbuilding->end_date)->format('l, d F Y') ?? "<i>ongoing</i>" !!}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 lg:w-3/12">
                        <div class="flex flex-wrap mt-2 px-4">

                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.ship_type_id')
                                </h5>
                                <span>
                                    {{ optional($shipbuilding->shipType)->name ?? '-' }}
                                </span>
                            </div>
                            <div class="mb-4 w-full">
                                <h5 class="font-medium text-gray-700">
                                    @lang('crud.shipbuildings.inputs.shipyard_id')
                                </h5>
                                <span>
                                    {{ optional($shipbuilding->shipyard)->name ?? '-' }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    S-Curve
                </x-slot>

                <div class="block w-full overflow-auto scrolling-touch mt-4">
                    <canvas id="scurve" width="900" height="400"></canvas>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    Progress Worksheets
                </x-slot>
                <div>
                    <div>
                        @can('create', App\Models\ShipbuildingTask::class)
                            <a
                                href="{{ route('shipbuilding-tasks.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                Tambah Kategori
                            </a>
                            {{-- todo: tambahkan parameter default --}}
                        @endcan
                    </div>

                    <div class="block w-full overflow-auto scrolling-touch mt-4">
                        <table class="w-full max-w-full mb-4 bg-transparent">
                            <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.shipbuilding_shipbuilding_tasks.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.shipbuilding_shipbuilding_tasks.inputs.weight')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.shipbuilding_shipbuilding_tasks.inputs.progress')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.shipbuilding_shipbuilding_tasks.inputs.target')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.shipbuilding_shipbuilding_tasks.inputs.deviation')
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600">
                            @php
                                $shipbuildingTasks = $shipbuilding
                                    ->shipbuildingTasks()
                                    ->whereNull('parent_task_id')
                                    ->get();
                            @endphp
                            @foreach ($shipbuildingTasks as $shipbuildingTask)
                                @include('app.shipbuildings.show-task-row', ['task' => $shipbuildingTask])
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    Weekly Reports
                    <a
                        href="{{ route('shipbuildings.weeks', $shipbuilding) }}"
                        class="button float-end button-primary"
                        target="_blank"
                    >
                        <i class="icon ion-md-table-cells mr-1"></i>
                        All Weeks
                    </a>
                </x-slot>

                <livewire:shipbuilding-weekly-reports-detail
                    :shipbuilding="$shipbuilding"
                    :allWeek="false"
                />
            </x-partials.card>

        </div>
    </div>
    @php
        $sCurve = new \App\Lib\SCurve($shipbuilding);
    @endphp
    @push('scripts')
        <script>
            const sCurve = new Chart(
                document.getElementById('scurve'),
                {
                    type: 'line',
                    data: {
                        labels: {!! $sCurve->getLabels() !!},
                        datasets: [
                            {
                                label: 'Plan',
                                data: {!! $sCurve->getDatasetPlan() !!},
                                fill: false,
                                borderColor: 'gray',
                                borderWidth: 1,
                                tension: 0.1,
                            },
                            {
                                label: 'Progress',
                                data: {!! $shipbuilding->getSCurve()->getDatasetProgress() !!},
                                fill: false,
                                borderColor: 'rgb(135, 206, 235)',
                                tension: 0.1,
                            },
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Week'
                                },
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Progress'
                                },
                            },
                        },
                    },
                }
            );
        </script>
    @endpush
</x-app-layout>
