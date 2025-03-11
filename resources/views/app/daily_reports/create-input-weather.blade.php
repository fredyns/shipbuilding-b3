<?php
/* @var $label string */
/* @var $daytime string */
?>
<x-inputs.group class="w-full lg:w-1/2 md:w-1/2">
    <label class="label font-medium text-gray-700">
        Morning
    </label>
    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/2 md:w-1/2">
            <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach($weathers as $weatherID => $weatherName)
                    <li class="w-full border-b border-gray-200 rounded-t-lg">
                        <div class="flex items-center ps-3">
                            <input
                                type="radio"
                                name="morning_weather_id"
                                value="{{ $weatherID }}"
                                id="morning_weather_id-{{ $weatherID }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                            />
                            <label
                                for="morning_weather_id-{{ $weatherID }}"
                                class="w-full py-3 ms-2 text-sm font-medium text-gray-900"
                            >
                                {{ $weatherName }}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full lg:w-1/2 md:w-1/2">
            <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach($humidities as $humidityID => $humidityName)
                    <li class="w-full border-b border-gray-200 rounded-t-lg">
                        <div class="flex items-center ps-3">
                            <input
                                type="radio"
                                name="morning_humidity_id"
                                value="{{ $humidityID }}"
                                id="morning_humidity_id-{{ $humidityID }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                            />
                            <label
                                for="morning_humidity_id-{{ $humidityID }}"
                                class="w-full py-3 ms-2 text-sm font-medium text-gray-900"
                            >
                                {{ $humidityName }}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-inputs.group>
