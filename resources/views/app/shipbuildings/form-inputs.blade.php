@php $editing = isset($shipbuilding) @endphp

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
            <div
                x-data="imageViewer('{{ $editing && $shipbuilding->cover_image ? Storage::url($shipbuilding->cover_image) : '' }}')"
            >
                <x-inputs.partials.label
                    name="cover_image"
                    label="{{ __('crud.shipbuildings.inputs.cover_image') }}"
                ></x-inputs.partials.label>
                <br/>

                <!-- Show the image -->
                <template x-if="imageUrl">
                    <img
                        :src="imageUrl"
                        class="object-cover rounded border border-gray-200"
                        style="width: 100px; height: 100px;"
                    />
                </template>

                <!-- Show the gray box when image is not available -->
                <template x-if="!imageUrl">
                    <div
                        class="border rounded border-gray-200 bg-gray-100"
                        style="width: 100px; height: 100px;"
                    ></div>
                </template>

                <div class="mt-2">
                    <input
                        type="file"
                        name="cover_image"
                        id="cover_image"
                        @change="fileChosen"
                    />
                </div>

                @error('cover_image')
                @include('components.inputs.partials.error') @enderror
            </div>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.text
                name="number"
                :value="old('number', ($editing ? $shipbuilding->number : ''))"
                label="{{ __('crud.shipbuildings.inputs.number') }}"
                placeholder="{{ __('crud.shipbuildings.inputs.number') }}"
                maxlength="255"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.text
                name="name"
                :value="old('name', ($editing ? $shipbuilding->name : ''))"
                label="{{ __('crud.shipbuildings.inputs.name') }}"
                placeholder="{{ __('crud.shipbuildings.inputs.name') }}"
                maxlength="255"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.textarea
                name="description"
                label="{{ __('crud.shipbuildings.inputs.description') }}"
                placeholder="{{ __('crud.shipbuildings.inputs.description') }}"
                maxlength="255"
            >
                {{ old('description', ($editing ? $shipbuilding->description :
                '')) }}
            </x-inputs.textarea>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.slider
                name="progress"
                :value="old('progress', ($editing ? $shipbuilding->progress : '0'))"
                label="{{ __('crud.shipbuildings.inputs.progress') }}"
                placeholder="{{ __('crud.shipbuildings.inputs.progress') }}"
                max="255"
                step="0.01"
                required
            ></x-inputs.slider>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="ship_type_id"
                label="{{ __('crud.shipbuildings.inputs.ship_type_id') }}"
            >
                @php $selected = old('ship_type_id', ($editing ? $shipbuilding->ship_type_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Ship Type</option>
                @foreach($shipTypes as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.tomselect
                name="shipyard_id"
                label="{{ __('crud.shipbuildings.inputs.shipyard_id') }}"
            >
                @php $selected = old('shipyard_id', ($editing ? $shipbuilding->shipyard_id : '')) @endphp
                <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Shipyard</option>
                @foreach($shipyards as $value => $label)
                    <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
                @endforeach
            </x-inputs.tomselect>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.date
                name="start_date"
                value="{{ old('start_date', ($editing ? optional($shipbuilding->start_date)->format('Y-m-d') : '')) }}"
                label="{{ __('crud.shipbuildings.inputs.start_date') }}"
                placeholder="{{ __('crud.shipbuildings.inputs.start_date') }}"
                max="255"
            ></x-inputs.date>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.date
                name="end_date"
                value="{{ old('end_date', ($editing ? optional($shipbuilding->end_date)->format('Y-m-d') : '')) }}"
                label="{{ __('crud.shipbuildings.inputs.end_date') }}"
                placeholder="{{ __('crud.shipbuildings.inputs.end_date') }}"
                max="255"
            ></x-inputs.date>
        </x-inputs.group>
    </div>
</x-partials.card>
