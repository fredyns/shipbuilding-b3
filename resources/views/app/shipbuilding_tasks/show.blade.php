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
                {{--
                <x-slot name="title">
                    <span>@lang('card.title')</span>
                </x-slot>
                --}}

                <div class="flex flex-wrap mt-2 px-4">
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.shipbuilding_id')
                        </h5>
                        <span>
                            {{ optional($shipbuildingTask->shipbuilding)->name
                            ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.parent_task_id')
                        </h5>
                        <span>
                            {{
                            optional($shipbuildingTask->shipbuildingTask)->name
                            ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.item_type')
                        </h5>
                        <span> {{ $shipbuildingTask->item_type ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.name')
                        </h5>
                        <span> {{ $shipbuildingTask->name ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.description')
                        </h5>
                        <span>
                            {{ $shipbuildingTask->description ?? '-' }}
                        </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.weight')
                        </h5>
                        <span> {{ $shipbuildingTask->weight ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.progress')
                        </h5>
                        <span> {{ $shipbuildingTask->progress ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.target')
                        </h5>
                        <span> {{ $shipbuildingTask->target ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.shipbuilding_tasks.inputs.deviation')
                        </h5>
                        <span> {{ $shipbuildingTask->deviation ?? '-' }} </span>
                    </div>
                </div>
            </x-partials.card>

            <x-partials.card class="mt-5">
                <x-slot name="title">
                    <span>@lang('text.actions')</span>
                </x-slot>
                <div class="mt-4 px-4">
                    <a
                        href="{{ route('shipbuilding-tasks.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('update', $shipbuildingTask)
                        <a
                            href="{{ route('shipbuilding-tasks.edit', $shipbuildingTask) }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-create"></i>
                            @lang('crud.common.edit')
                        </a>
                    @endcan @can('delete', $shipbuildingTask)
                        <div class="float-right">
                            <form
                                action="{{ route('shipbuilding-tasks.destroy', $shipbuildingTask) }}"
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

            @can('view-any', App\Models\ShipbuildingTask::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        @lang('crud.shipbuilding_task_shipbuilding_tasks.name')
                    </x-slot>

                    <livewire:shipbuilding-task-shipbuilding-tasks-detail
                        :parentTask="$shipbuildingTask"
                    />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
