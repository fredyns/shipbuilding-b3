@php $editing = isset($shipbuildingTask) @endphp

<style>
    .ts-control {
        border: none;
        padding: 0;
    }

    .ts-dropdown,
    .ts-control,
    .ts-control input {
        color: rgb(31 41 55 / var(--tw-text-opacity));
        font-family: inherit;
        font-size: 1rem;
        line-height: 1.5;
    }
</style>

<x-partials.card>
    {{--
    <x-slot name="title">
        <span>@lang('card.title')</span>
    </x-slot>
    --}}

    <div class="flex flex-wrap">
        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="shipbuilding_id"
                label="{{ __('crud.shipbuilding_tasks.inputs.shipbuilding_id') }}"
                required
            >
                @php $selected = old('shipbuilding_id', ($editing ? $shipbuildingTask->shipbuilding_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Shipbuilding</option>
                @foreach($shipbuildings as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="parent_task_id"
                label="{{ __('crud.shipbuilding_tasks.inputs.parent_task_id') }}"
            >
                @php $selected = old('parent_task_id', ($editing ? $shipbuildingTask->parent_task_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Shipbuilding Task</option>
                @foreach($shipbuildingTasks as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.select
                name="item_type"
                label="{{ __('crud.shipbuilding_tasks.inputs.item_type') }}"
            >
                @php $selected = old('item_type', ($editing ? $shipbuildingTask->item_type : 'work-item')) @endphp
                <option value="work-item" {{ $selected == 'work-item' ? 'selected' : '' }} >Work item</option>
                <option value="category" {{ $selected == 'category' ? 'selected' : '' }} >Category</option>
            </x-inputs.select>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.text
                name="name"
                :value="old('name', ($editing ? $shipbuildingTask->name : ''))"
                label="{{ __('crud.shipbuilding_tasks.inputs.name') }}"
                placeholder="{{ __('crud.shipbuilding_tasks.inputs.name') }}"
                maxlength="255"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="description"
                label="{{ __('crud.shipbuilding_tasks.inputs.description') }}"
                placeholder="{{ __('crud.shipbuilding_tasks.inputs.description') }}"
            >
                {{ old('description', ($editing ? $shipbuildingTask->description
                : '')) }}
            </x-inputs.textarea>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.slider
                name="weight"
                :value="old('weight', ($editing ? $shipbuildingTask->weight : '0'))"
                label="{{ __('crud.shipbuilding_tasks.inputs.weight') }}"
                placeholder="{{ __('crud.shipbuilding_tasks.inputs.weight') }}"
                max="9999999"
                step="0.001"
                required
            ></x-inputs.slider>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.select
                name="enable_sub_progress"
                label="{{ __('crud.shipbuilding_tasks.inputs.enable_sub_progress') }}"
            >
                @php $selected = old('enable_sub_progress', ($editing ? $shipbuildingTask->enable_sub_progress : 'none')) @endphp
                <option value="work-item" {{ $selected == 'work-item' ? 'selected' : '' }} >Work item</option>
                <option value="category" {{ $selected == 'category' ? 'selected' : '' }} >Category</option>
            </x-inputs.select>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.slider
                name="progress"
                :value="old('progress', ($editing ? $shipbuildingTask->progress : '0'))"
                label="{{ __('crud.shipbuilding_tasks.inputs.progress') }}"
                placeholder="{{ __('crud.shipbuilding_tasks.inputs.progress') }}"
                max="100"
                step="0.01"
                required
            ></x-inputs.slider>
        </x-inputs.group>
    </div>
</x-partials.card>
