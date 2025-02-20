@props([
'name',
'label',
'value',
])

<!-- Boolean Toggle -->
<div
    x-data="{{ old($name, $value) ? "{ toggle{$name}: 1 }" : "{ toggle{$name}: 0 }" }}"

    x-id="['toggle-label-{{ $name }}']"
>

    <x-inputs.basic
        type="hidden"
        :name="$name"
        x-model="toggle{{ $name }}"
        :attributes="$attributes"
    ></x-inputs.basic>

    @if($label ?? null)
        <label
            @click="$refs.toggling{{ $name }}.click(); $refs.toggling{{ $name }}.focus()"
            :id="$id('toggle-label-{{ $name }}')"
            class="{{ ($required ?? false) ? 'label label-required font-medium text-gray-700' : 'label font-medium text-gray-700' }}"
            for="toggler{{ $name }}"
        >
            {{ $label }}
        </label>
        <br/>
    @endif

    <!-- Button -->
    <button
        id="toggler{{ $name }}"
        x-ref="toggling{{ $name }}"
        @click="toggle{{ $name }} = toggle{{ $name }} ? 0 : 1"
        type="button"
        role="switch"
        :aria-checked="toggle{{ $name }}"
        :aria-labelledby="$id('toggle-label-{{ $name }}')"
        :class="toggle{{ $name }} ? 'bg-slate-400' : 'bg-slate-300'"
        class="relative ml-4 inline-flex w-14 rounded-full py-1 transition"
    >
        <span
            :class="toggle{{ $name }} ? 'translate-x-7' : 'translate-x-1'"
            class="bg-white h-6 w-6 rounded-full transition shadow-md"
            aria-hidden="true"
        ></span>
    </button>
</div>
@error($name)
@include('components.inputs.partials.error')
@enderror
