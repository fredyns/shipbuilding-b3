@props([
    'name',
    'label',
    'placeholder',
    'type' => 'text',
    'settings' => '{maxItems: 1, persist: false}',
])

@if($label ?? null)
    @include('components.inputs.partials.label')
@endif

<select
    id="{{ $name }}"
    name="{{ $name }}"
    {{ ($placeholder ?? false) ? 'data-placeholder="'.$placeholder.'"' : '' }}
    {{ ($required ?? false) ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'tomselect block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded']) }}
    autocomplete="off"
>{{ $slot }}</select>

@error($name)
    @include('components.inputs.partials.error')
@enderror

@push('scripts')
    <script>
        new TomSelect("#{{ $name }}",{{ $settings }});
    </script>
@endpush
