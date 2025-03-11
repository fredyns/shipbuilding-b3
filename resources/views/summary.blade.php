<?php
/* @var \App\Models\Shipbuilding[] $shipbuildings */
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}">
                Building Summary
            </a>
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-wrap justify-between">
                <div class="w-full p-2">
                    <x-partials.card>
                        <div class="my-2">
                            <div class="flex flex-wrap justify-between">
                                <div class="md:w-1/2">
                                    <form>
                                        <div class="flex items-center w-full">
                                            <x-inputs.text
                                                name="search"
                                                value="{{ $search ?? '' }}"
                                                placeholder="{{ __('crud.common.search') }}"
                                                autocomplete="off"
                                            ></x-inputs.text>

                                            <div class="ml-1">
                                                <button
                                                    type="submit"
                                                    class="button button-primary"
                                                >
                                                    <i class="icon ion-md-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="md:w-1/2 text-right">
                                    <div class="float-end">
                                        <a
                                            href="{{ route('shipbuildings.index') }}"
                                            class="button mx-1"
                                        >
                                            <i class="mr-1 icon ion-md-add"></i>
                                            Tabel Pembangunan
                                        </a>
                                    </div>
                                    @if($search)
                                        <div class="float-end">
                                            <a
                                                href="{{ route('dashboard') }}"
                                                class="button"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                                                </svg>
                                                Reset Pencarian
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-partials.card>

                </div>

                @forelse($shipbuildings as $shipbuilding)
                    <div class="md:w-1/2 lg:w-1/2 p-2">
                        <x-partials.card class="">
                            <x-slot name="title">
                                <a href="{{ route('shipbuildings.show',$shipbuilding) }}">
                                    {{ $shipbuilding->number }} |
                                    <b>{{ $shipbuilding->name }}</b> |
                                    week #{{ $shipbuilding->week() ?? "-" }} |
                                    progress <b>{{ \App\Helpers\Format::percent($shipbuilding->progress) }}</b>
                                </a>
                            </x-slot>

                            <div class="block w-full overflow-auto scrolling-touch mt-4">
                                <canvas id="scurve_{{ $shipbuilding->id }}" width="500" height="250"></canvas>
                            </div>
                        </x-partials.card>
                    </div>
                    @push('scripts')
                        <script>
                            const sCurve{{ $shipbuilding->id }} = new Chart(
                                document.getElementById('scurve_{{ $shipbuilding->id }}'),
                                {
                                    type: 'line',
                                    data: {
                                        labels: {!! $shipbuilding->getSCurve()->getLabels() !!},
                                        datasets: [
                                            {
                                                label: 'Plan',
                                                data: {!! $shipbuilding->getSCurve()->getDatasetPlan() !!},
                                                fill: false,
                                                borderColor: 'gray',
                                                borderWidth: 1,
                                                tension: 0.1,
                                            },
                                            {
                                                label: 'Progress',
                                                data: {!! $shipbuilding->getSCurve()->getDatasetProgress() !!},
                                                fill: false,
                                                borderColor: 'rgb(75, 192, 192)',
                                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                                tension: 0.1,
                                            },
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            x: {
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Week'
                                                },
                                            },
                                            y: {
                                                type: 'linear',
                                                display: true,
                                                title: {
                                                    display: true,
                                                    text: 'Progress'
                                                },
                                            },
                                        },
                                    },
                                }
                            );
                        </script>
                    @endpush
                @empty
                    <div class="md:w-1/2 lg:w-1/2 p-2">
                        <x-partials.card class="">
                            Data tidak ditemukan
                        </x-partials.card>
                    </div>
                @endforelse

                <div class="w-full p-2 mb-10">
                    <x-partials.card>
                        <div class="my-2">
                            <div class="flex flex-wrap justify-between">
                                <div class="w-full">
                                    {!! $shipbuildings->render() !!}
                                </div>
                            </div>
                        </div>
                    </x-partials.card>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
