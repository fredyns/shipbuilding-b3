@props([
    'name',
    'value',
    'label',
    'options' => [],
])

@if($label ?? null)
    @include('components.inputs.partials.label')
@endif

<ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
    @foreach($options as $id => $text)
        <li class="w-full border-b border-gray-200 rounded-t-lg">
            <div class="flex items-center ps-3">
                <input
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $id }}"
                    id="{{ $name }}-{{ $id }}"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                    {{ ($value == $id) ? 'checked' : '' }}
                />
                <label
                    for="{{ $name }}-{{ $id }}"
                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900"
                >
                    {{ $text }}
                </label>
            </div>
        </li>
    @endforeach
</ul>

@error($name)
@include('components.inputs.partials.error')
@enderror
