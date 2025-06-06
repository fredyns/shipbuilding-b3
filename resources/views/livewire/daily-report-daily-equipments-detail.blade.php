<div>
    <div>
        @can('create', App\Models\DailyEquipment::class)
            <button class="button" wire:click="newDailyEquipment">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
        @endcan @can('delete-any', App\Models\DailyEquipment::class)
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
                            @lang('crud.daily_report_equipments.inputs.name')
                        </h5>
                        <span> {{ $dailyEquipment->name ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_report_equipments.inputs.quantity')
                        </h5>
                        <span> {{ $dailyEquipment->quantity ?? '-' }} </span>
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.daily_report_equipments.inputs.remark')
                        </h5>
                        <span> {{ $dailyEquipment->remark ?? '-' }} </span>
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
            @can('update', $dailyEquipment)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editDailyEquipment('{{ $dailyEquipment->id }}')"
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
                            name="dailyEquipment.name"
                            wire:model="dailyEquipment.name"
                            label="{{ __('crud.daily_report_equipments.inputs.name') }}"
                            placeholder="{{ __('crud.daily_report_equipments.inputs.name') }}"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.number
                            name="dailyEquipment.quantity"
                            wire:model="dailyEquipment.quantity"
                            label="{{ __('crud.daily_report_equipments.inputs.quantity') }}"
                            placeholder="{{ __('crud.daily_report_equipments.inputs.quantity') }}"
                        ></x-inputs.number>
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="dailyEquipment.remark"
                            wire:model="dailyEquipment.remark"
                            label="{{ __('crud.daily_report_equipments.inputs.remark') }}"
                            placeholder="{{ __('crud.daily_report_equipments.inputs.remark') }}"
                            maxlength="255"
                        ></x-inputs.text>
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
                    @lang('crud.daily_report_equipments.inputs.name')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.daily_report_equipments.inputs.quantity')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.daily_report_equipments.inputs.remark')
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @foreach ($dailyEquipments as $dailyEquipment)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $dailyEquipment->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $dailyEquipment->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $dailyEquipment->quantity ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $dailyEquipment->remark ?? '-' }}
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
                                wire:click="viewDailyEquipment('{{ $dailyEquipment->id }}')"
                            >
                                <i class="icon ion-md-eye"></i>
                            </button>
                            @can('update', $dailyEquipment)
                                <button
                                    type="button"
                                    class="button mr-1"
                                    wire:click="editDailyEquipment('{{ $dailyEquipment->id }}')"
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
                <td colspan="4">
                    <div class="mt-10 px-4">
                        {{ $dailyEquipments->render() }}
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
