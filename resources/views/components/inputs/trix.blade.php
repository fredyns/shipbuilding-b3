@props([
    'name',
    'label',
    'value',
])

{{-- source: https://devdojo.com/tnylea/laravel-livewire-trix-editor-component --}}

@if($label ?? null)
    <label
        class="{{ ($required ?? false) ? 'label label-required font-medium text-gray-700' : 'label font-medium text-gray-700' }}"
        for="trix_{{ $name }}"
    >
        {{ $label }}
    </label>
@endif

<input
    type="hidden"
    id="{{ $name }}"
    name="{{ $name }}"
    value="{!! addslashes($value) !!}"
/>

<div wire:ignore>
    <trix-editor
        wire:ignore
        id="trix_{{ $name }}"
        input="{{ $name }}"
        @trix-file-accept.prevent
        {{ $attributes->merge(['class' => 'block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded']) }}
    ></trix-editor>
</div>

@error($name)
    @include('components.inputs.partials.error')
@enderror
