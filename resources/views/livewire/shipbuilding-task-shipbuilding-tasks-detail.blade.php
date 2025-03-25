<div>
    <div>
        @can('create', App\Models\ShipbuildingTask::class)
            <button class="button" wire:click="newShipbuildingTask">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
        @endcan @can('delete-any', App\Models\ShipbuildingTask::class)
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
                            @lang('crud.subtasks.inputs.name')
                        </h5>
                        <span> {{ $shipbuildingTask->name ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.subtasks.inputs.weight')
                        </h5>
                        <span> {{ $shipbuildingTask->weight ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.subtasks.inputs.progress')
                        </h5>
                        <span> {{ $shipbuildingTask->progress ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.subtasks.inputs.target')
                        </h5>
                        <span> {{ $shipbuildingTask->target ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.subtasks.inputs.deviation')
                        </h5>
                        <span> {{ $shipbuildingTask->deviation ?? '-' }} </span>
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
            @can('update', $shipbuildingTask)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editShipbuildingTask('{{ $shipbuildingTask->id }}')"
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
                        <x-inputs.text
                            name="shipbuildingTask.name"
                            wire:model="shipbuildingTask.name"
                            label="{{ __('crud.shipbuilding_tasks.inputs.name') }}"
                            placeholder="{{ __('crud.shipbuilding_tasks.inputs.name') }}"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="shipbuildingTask.weight"
                            wire:model="shipbuildingTask.weight"
                            label="{{ __('crud.shipbuilding_tasks.inputs.weight') }}"
                            placeholder="{{ __('crud.shipbuilding_tasks.inputs.weight') }}"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full">
                        <x-inputs.select
                            name="shipbuildingTask.enable_sub_progress"
                            wire:model="shipbuildingTask.enable_sub_progress"
                            label="{{ __('crud.shipbuilding_tasks.inputs.enable_sub_progress') }}"
                        >
                            <option value="work-item" {{ $selected == 'work-item' ? 'selected' : '' }} >
                                Work item
                            </option>
                            <option value="category" {{ $selected == 'category' ? 'selected' : '' }} >Category</option>
                        </x-inputs.select>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="shipbuildingTask.progress"
                            wire:model="shipbuildingTask.progress"
                            label="{{ __('crud.shipbuilding_tasks.inputs.progress') }}"
                            placeholder="{{ __('crud.shipbuilding_tasks.inputs.progress') }}"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="shipbuildingTask.target"
                            wire:model="shipbuildingTask.target"
                            label="{{ __('crud.shipbuilding_tasks.inputs.target') }}"
                            placeholder="{{ __('crud.shipbuilding_tasks.inputs.target') }}"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="shipbuildingTask.deviation"
                            wire:model="shipbuildingTask.deviation"
                            label="{{ __('crud.shipbuilding_tasks.inputs.deviation') }}"
                            placeholder="{{ __('crud.shipbuilding_tasks.inputs.deviation') }}"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
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
                <th class="px-4 py-3 text-left">
                    @lang('crud.subtasks.inputs.name')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.subtasks.inputs.weight')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.subtasks.inputs.progress')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.subtasks.inputs.target')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.subtasks.inputs.deviation')
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @foreach ($shipbuildingTasks as $shipbuildingTask)
                @include('livewire.partials.shipbuilding-task-shipbuilding-tasks-row', ['task' => $shipbuildingTask, 'levelOffset' => (int)$shipbuildingTask->level])
            @endforeach
            </tbody>
        </table>
    </div>
</div>
