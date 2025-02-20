@props([
    'name',
    'label',
    'value',
])

<x-inputs.basic
    type="text"
    :name="$name"
    label="{{ $label ?? ''}}"
    :value="$value ?? ''"
    x-data
    x-mask="99.999.999.9-999.999"
    placeholder="99.999.999.9-999.999"
    :attributes="$attributes"
></x-inputs.basic>
