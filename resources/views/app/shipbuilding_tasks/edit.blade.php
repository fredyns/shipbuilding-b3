<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.shipbuilding_tasks.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form
                method="PUT"
                action="{{ route('shipbuilding-tasks.update', $shipbuildingTask) }}"
            >
                @include('app.shipbuilding_tasks.form-inputs')

                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        <span>@lang('text.actions')</span>
                    </x-slot>
                    <div class="mt-4 px-4">
                        <a
                            href="{{ route('shipbuilding-tasks.index') }}"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a
                            href="{{ route('shipbuilding-tasks.show', $shipbuildingTask) }}"
                            class="button"
                        >
                            <i class="mr-1 icon ion-md-backspace text-primary">
                            </i>
                            @lang('crud.common.cancel')
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>
                    </div>
                </x-partials.card>
            </x-form>

            @can('view-any', App\Models\ShipbuildingTask::class)
                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        @lang('crud.shipbuilding_task_shipbuilding_tasks.name')
                    </x-slot>

                    <livewire:shipbuilding-task-shipbuilding-tasks-detail
                        :shipbuildingTask="$shipbuildingTask"
                    />
                </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
