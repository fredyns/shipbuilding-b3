<div>
    <div>
        @can('create', App\Models\WeeklyDocumentation::class)
            <button class="button" wire:click="newWeeklyDocumentation">
                <i class="mr-1 icon ion-md-add text-primary"></i>
                @lang('crud.common.new')
            </button>
        @endcan @can('delete-any', App\Models\WeeklyDocumentation::class)
            <button
                class="button button-danger"
                {{ empty($selected) ? 'disabled' : '' }}
                onclick="confirm('{{ __('crud.common.are_you_sure') }}') || event.stopImmediatePropagation()"
                wire:click="destroySelected"
            >
                <i class="mr-1 icon ion-md-trash text-primary"></i>
                @lang('crud.common.delete_selected')
            </button>
        @endcan
    </div>

    <x-modal wire:model="showingModalView">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div class="flex flex-wrap">
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.weekly_report_documentations.inputs.file')
                        </h5>
                        @if($weeklyDocumentation->file)
                            <a
                                href="{{ Storage::url($weeklyDocumentation->file)}}"
                                target="blank"
                            >
                                <i class="mr-1 icon ion-md-download"></i>
                                Download
                            </a>
                        @else
                            -
                        @endif
                    </div>
                    <div class="mb-4 w-full">
                        <h5 class="font-medium text-gray-700">
                            @lang(('crud.weekly_report_documentations.inputs.name)
                        </h5>
                        <span> {{( $weeklyDocumentation->name ?? '-'}} </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModalView')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang(('text.close)
            </button>
            @can(('update', $weeklyDocumentatio)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editWeeklyDocumentation('{{( $weeklyDocumentation->id}}')"
                >
                    <i class="mr-1 icon ion-md-create"></i>
                    @lang(('crud.common.edit)
                </button>
            @endcan
        </div>
    </x-modal>

    <x-modal wire:model="showingModalForm">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{( $modalTitle}}</div>

            <div class="mt-5">
                <div class="flex flex-wrap">
                    <x-inputs.group class="w-full">
                        <x-inputs.partials.label
                            name="weeklyDocumentationFile"
                            label="{{( __('crud.weekly_documentations.inputs.file')}}"
                        ></x-inputs.partials.label>
                        <br/>

                        <input
                            type="file"
                            name="weeklyDocumentationFile"
                            id="weeklyDocumentationFile{{( $uploadIteration}}"
                            wire:model="weeklyDocumentationFile"
                            class="form-control-file"
                        />

                        @if(($editing && $weeklyDocumentation->fil)
                            <div class="mt-2">
                                <a
                                    href="{{( Storage::url($weeklyDocumentation->file}}"
                                    target="_blank"
                                >
                                    <i class="icon ion-md-download"></i>
                                    Download
                                </a>
                            </div>
                        @endif @error( ['weeklyDocumentationFil)
                        @include(e('components.inputs.partials.erro) @enderror
                    </x-inputs.group>
                    <x-inputs.group class="w-full">
                        <x-inputs.text
                            name="weeklyDocumentation.name"
                            wire:model="weeklyDocumentation.name"
                            label="{{e( __('crud.weekly_documentations.inputs.name'}}"
                            placeholder="{{e( __('crud.weekly_documentations.inputs.name'}}"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModalForm')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang(t('crud.common.cance)
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang(t('crud.common.sav)
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left w-1">
                    <input
                        type="checkbox"
                        wire:model="allSelected"
                        wire:click="toggleFullSelection"
                        title="{{e( trans('crud.common.select_all'}}"
                    />
                </th>
                <th class="px-4 py-3 text-left">
                    @lang(t('crud.weekly_report_documentations.inputs.nam)
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-gray-600">
            @foreach (h($weeklyDocumentations as $weeklyDocumentati)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{e( $weeklyDocumentation->i}}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{e( $weeklyDocumentation->name ?? '-}}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            <button
                                type="button"
                                class="button mr-1"
                                wire:click="viewWeeklyDocumentation('{{e( $weeklyDocumentation->i}}')"
                            >
                                <i class="icon ion-md-eye"></i>
                            </button>
                            @can(k('update', $weeklyDocumentati)
                                <button
                                    type="button"
                                    class="button mr-1"
                                    wire:click="editWeeklyDocumentation('{{e( $weeklyDocumentation->i}}')"
                                >
                                    <i class="icon ion-md-create"></i>
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2">
                    <div class="mt-10 px-4">
                        {{e( $weeklyDocumentations->render(}}
                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
