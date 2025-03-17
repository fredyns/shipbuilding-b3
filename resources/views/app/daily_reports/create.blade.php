<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="javascript: history.go(-1)" class="mr-4">
                <i class="mr-1 icon ion-md-arrow-back"></i>
            </a>
            @lang('crud.daily_reports.create_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-form method="POST" action="{{ route('daily-reports.store') }}">

                @include('app.daily_reports.form-inputs')

                <x-partials.card class="mt-5">
                    <x-slot name="title">
                        <span>@lang('text.actions')</span>
                    </x-slot>
                    <div class="mt-4 px-4">
                        <a
                            href="javascript: history.go(-1)"
                            class="button"
                        >
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            >
                            </i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.save')
                        </button>
                    </div>
                </x-partials.card>
            </x-form>
        </div>
    </div>
</x-app-layout>
