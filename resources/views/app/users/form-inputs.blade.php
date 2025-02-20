@php $editing = isset($user) @endphp

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
                :value="old('name', ($editing ? $user->name : ''))"
                label="{{ __('crud.users.inputs.name') }}"
                placeholder="{{ __('crud.users.inputs.name') }}"
                maxlength="255"
                required
            ></x-inputs.text>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.email
                name="email"
                :value="old('email', ($editing ? $user->email : ''))"
                label="{{ __('crud.users.inputs.email') }}"
                placeholder="{{ __('crud.users.inputs.email') }}"
                maxlength="255"
                required
            ></x-inputs.email>
        </x-inputs.group>

        <x-inputs.group class="w-full">
            <x-inputs.password
                name="password"
                label="{{ __('crud.users.inputs.password') }}"
                placeholder="{{ __('crud.users.inputs.password') }}"
                maxlength="255"
                :required="!$editing"
            ></x-inputs.password>
        </x-inputs.group>

        <div class="px-4 my-4">
            <h4 class="font-bold text-lg text-gray-700">
                Assign @lang('crud.roles.name')
            </h4>

            <div class="py-2">
                @foreach ($roles as $role)
                <div>
                    <x-inputs.checkbox
                        id="role{{ $role->id }}"
                        name="roles[]"
                        label="{{ ucfirst($role->name) }}"
                        value="{{ $role->id }}"
                        :checked="isset($user) ? $user->hasRole($role) : false"
                        :add-hidden-value="false"
                    ></x-inputs.checkbox>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-partials.card>
