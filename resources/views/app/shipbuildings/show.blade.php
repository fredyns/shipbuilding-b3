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
                {{--
                <x-slot name="title">
                    <span>@lang('card.title')</span>
                </x-slot>
                --}}

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
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuildings.inputs.description')
                        </h5>
                        <span> {{ $shipbuilding->description ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuildings.inputs.progress')
                        </h5>
                        <span> {{ $shipbuilding->progress ?? '-' }} </span>
                    </div>
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
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuildings.inputs.start_date')
                        </h5>
                        <span>
                            {{ optional($shipbuilding->start_date)->format('l, d
                            F Y') }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuildings.inputs.end_date')
                        </h5>
                        <span>
                            {{ optional($shipbuilding->end_date)->format('l, d F
                            Y') }}
                        </span>
                    </div>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    <span>@lang('text.actions')</span>
                </x-slot>
                <div class="mt-4 px-4">
                    <a href="{{ route('shipbuildings.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('update', $shipbuilding)
                        <a
                            href="{{ route('shipbuildings.edit', $shipbuilding) }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-create"></i>
                            @lang('crud.common.edit')
                        </a>
                    @endcan @can('delete', $shipbuilding)
                        <div class="float-right">
                            <form
                                action="{{ route('shipbuildings.destroy', $shipbuilding) }}"
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

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    @lang('crud.shipbuilding_shipbuilding_tasks.name')
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
        </div>
    </div>
</x-app-layout>
