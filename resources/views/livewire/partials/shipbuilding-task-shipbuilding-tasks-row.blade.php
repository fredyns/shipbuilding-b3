<tr class="hover:bg-gray-100">
    <td class="px-4 py-3 text-left">
        @if($task->level > $levelOffset)
            @php $tab = ($task->level - $levelOffset) * 2 @endphp
            <span style="font-family: monospace;">{!! str_repeat("&nbsp;", $tab) !!}Ͱ&nbsp;</span>
        @endif
        <span>{{ $task->name ?? '-' }}</span>
    </td>
    <td class="px-4 py-3 text-right">
        @if($task->weight)
            {{ number_format($task->weight, 2) }}%
        @else
            -
        @endif
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
            <a
                href="{{ route('shipbuilding-tasks.show', $task) }}"
                class="mr-1" target="shipbuilding-task"
            >
                <button
                    type="button"
                    class="button"
                >
                    <i class="icon ion-md-eye"></i>
                </button>
            </a>
            @can('update', $task)
                <a
                    href="{{ route('shipbuilding-tasks.edit', $task) }}"
                    class="mr-1" target="shipbuilding-task"
                >
                    <button
                        type="button"
                        class="button"
                    >
                        <i class="icon ion-md-create"></i>
                    </button>
                </a>
            @endcan
        </div>
    </td>
</tr>

@php $children = $task->children() @endphp
@if($children)
    @foreach ($children as $child)
        @include('livewire.partials.shipbuilding-task-shipbuilding-tasks-row', ['task' => $child, 'levelOffset' => $levelOffset])
    @endforeach
@endif
