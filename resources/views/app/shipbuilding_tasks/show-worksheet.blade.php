<?php

use App\Helpers\Format;

/**
 * @var $shipbuildingTask \App\Models\ShipbuildingTask
 * @var $shipbuilding \App\Models\Shipbuilding
 */
$shipbuilding = $shipbuildingTask->shipbuilding;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.shipbuilding_tasks.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-partials.card>
                <x-slot name="title">
                    <span>Pembangunan Kapal</span>
                </x-slot>

                <a href="{{ route('shipbuildings.show', $shipbuilding) }}">
                    <div class="flex flex-wrap mt-2">
                        <div class="w-full md:w-3/12 lg:w-2/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.number')
                            </h5>
                            <span> {{ $shipbuilding->number ?? '-' }} </span>
                        </div>
                        <div class="w-full md:w-3/12 lg:w-2/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.name')
                            </h5>
                            <span> {{ $shipbuilding->name ?? '-' }} </span>
                        </div>
                        <div class="w-full md:w-3/12 lg:w-2/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.progress')
                            </h5>
                            <span>
                            {{ Format::percent($shipbuilding->progress,"-") }}
                        </span>
                        </div>
                        <div class="w-full md:w-3/12 lg:w-2/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.start_date')
                            </h5>
                            <span>
                            {{ optional($shipbuilding->start_date)->translatedFormat('l, d F Y') }}
                        </span>
                        </div>
                        <div class="w-full md:w-3/12 lg:w-2/12">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.shipbuildings.inputs.shipyard_id')
                            </h5>
                            <span>
                            {{ optional($shipbuilding->shipyard)->name ?? '-' }}
                        </span>
                        </div>
                    </div>
                </a>

            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    <span>Lembar Pekerjaan</span>
                </x-slot>

                <div class="flex flex-wrap mt-2 px-4">
                    <div class="mb-4 w-full lg:w-4/12 md:w-6/12 valign-middle">
                        @if($shipbuildingTask->parentTask)
                            {{ $shipbuildingTask->parentTask->name }}<br/>
                            <span style="font-family: monospace;">&nbsp; Ͱ&nbsp;</span>
                            <b> {{ $shipbuildingTask->name ?? '-' }} </b>
                        @else
                            <b> {{ $shipbuildingTask->name ?? '-' }} </b>
                        @endif
                    </div>
                    <div class="mb-4 w-full lg:w-2/12 md:w-3/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.weight')
                        </h5>
                        <span> {{ Format::percent($shipbuildingTask->weight, "-") }} </span>
                    </div>
                    <div class="mb-4 w-full lg:w-2/12 md:w-3/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.progress')
                        </h5>
                        <span> {{ Format::percent($shipbuildingTask->progress, "-") }} </span>
                    </div>
                    <div class="mb-4 w-full lg:w-2/12 md:w-3/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.target')
                        </h5>
                        <span> {{ Format::percent($shipbuildingTask->target, "-") }} </span>
                    </div>
                    <div class="mb-4 w-full lg:w-2/12 md:w-3/12">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.deviation')
                        </h5>
                        <span> {{ Format::percent($shipbuildingTask->deviation, "-") }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.description')
                        </h5>
                        <span>
                            {{ $shipbuildingTask->description ?? '-' }}
                        </span>
                    </div>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    Daftar Pekerjaan
                </x-slot>

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
                        </tr>
                        </thead>
                        <tbody class="text-gray-600">
                        @forelse($shipbuildingTask->children() as $subTask)
                            @include('app.shipbuilding_tasks.show-subtask', [
                                'task' => $subTask,
                                'offset' => $shipbuildingTask->level,
                            ])
                        @empty
                            <tr class="hover:bg-gray-100">
                                <td colspan="5" class="px-4 text-left">
                                    <i>tidak ditemukan</i>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </x-partials.card>

        </div>
    </div>
</x-app-layout>
