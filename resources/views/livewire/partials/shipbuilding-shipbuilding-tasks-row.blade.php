<tr class="hover:bg-gray-100">
    <td class="px-4 py-3 text-left">
        <input
            type="checkbox"
            value="{{ $task->id }}"
            wire:model="selected"
        />
    </td>
    <td class="px-4 py-3 text-left">
        @if($task->level > 1)
            @php $tab = ($task->level - 1) * 2 @endphp
            <span style="font-family: monospace;">{!! str_repeat("&nbsp;", $tab) !!}Ͱ&nbsp;</span>
        @endif
        <span>{{ $task->name ?? '-' }}</span>
    </td>
    <td class="px-4 py-3 text-right">
        {{ $task->weight ?? '-' }}
    </td>
    <td class="px-4 py-3 text-right">
        {{ $task->progress ?? '-' }}
    </td>
    <td class="px-4 py-3 text-right">
        {{ $task->target ?? '-' }}
    </td>
    <td class="px-4 py-3 text-right">
        {{ $task->deviation ?? '-' }}
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
                wire:click="viewShipbuildingTask('{{ $task->id }}')"
            >
                <i class="icon ion-md-eye"></i>
            </button>
            @can('update', $task)
                <button
                    type="button"
                    class="button mr-1"
                    wire:click="editShipbuildingTask('{{ $task->id }}')"
                >
                    <i class="icon ion-md-create"></i>
                </button>
            @endcan
        </div>
    </td>
</tr>
@php $children = $shipbuilding->breakdownTasks($task) @endphp
@if($children)
    @foreach ($children as $child)
        @include('livewire.partials.shipbuilding-shipbuilding-tasks-row', ['task' => $child])
    @endforeach
@endif
