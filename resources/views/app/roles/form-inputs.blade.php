@php $editing = isset($role) @endphp

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
                :value="old('name', ($editing ? $role->name : ''))"
                label="{{ __('crud.roles.inputs.name') }}"
            ></x-inputs.text>
        </x-inputs.group>

        <div class="px-4 my-4">
            <h4 class="font-bold text-lg text-gray-700">
                Assign @lang('crud.permissions.name')
            </h4>

            <div class="py-2">
                @foreach ($permissions as $permission)
                <div>
                    <x-inputs.checkbox
                        id="permission{{ $permission->id }}"
                        name="permissions[]"
                        label="{{ ucfirst($permission->name) }}"
                        value="{{ $permission->id }}"
                        :checked="isset($role) ? $role->hasPermissionTo($permission) : false"
                        :add-hidden-value="false"
                    ></x-inputs.checkbox>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-partials.card>
