@props([
'name',
'label',
'value',
'type' => 'text',
'min' => null,
'max' => null,
'step' => null,
])

@if($label ?? null)
    @include('components.inputs.partials.label')
@endif

@php
    $value = old($name, $value ?? $min ?? 0);
    if (!is_numeric($value)) {
        $value = 0;
    }

    $sliderID = "slider" . \Illuminate\Support\Str::studly(str_replace(".", " ", $name));
@endphp

<div x-data="{ {{ $sliderID }}: {{ old($name, $value ?? $min ?? 0) }}, test: true }">

    <input
            type="number"
            id="{{ $name }}"
            name="{{ $name }}"
            x-model="{{ $sliderID }}"
            {{ ($required ?? false) ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded']) }}
            {{ is_numeric($min) ? "min={$min}" : '' }}
            {{ is_numeric($max) ? "max={$max}" : '' }}
            {{ $step ? "step={$step}" : '' }}
            autocomplete="off"
    />

    @if(is_numeric($min) && is_numeric($max))
        <input
                type="range"
                id="sliding{{ $name }}"
                name="sliding{{ $name }}"
                x-model="{{ $sliderID }}"
                {{ is_numeric($min) ? "min={$min}" : '' }}
                {{ is_numeric($max) ? "max={$max}" : '' }}
                {{ $step ? "step={$step}" : '' }}
                class="mt-3"
                style="width: 100%;"
        />
    @else
        <!-- add min & max to add slider -->
    @endif

</div>
@error($name)
@include('components.inputs.partials.error')
@enderror
