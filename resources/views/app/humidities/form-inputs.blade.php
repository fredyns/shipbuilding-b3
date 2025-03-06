@php $editing = isset($humidity) @endphp

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
            <x-inputs.text
                name="name"
                :value="old('name', ($editing ? $humidity->name : ''))"
                label="{{ __('crud.humidities.inputs.name') }}"
                placeholder="{{ __('crud.humidities.inputs.name') }}"
                maxlength="255"
                required
            ></x-inputs.text>
        </x-inputs.group>
    </div>
</x-partials.card>
