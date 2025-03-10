<?php

use App\Helpers\Format;

?>
<tr class="hover:bg-gray-100">
    <td class="px-4 text-left">
        <a href="{{ route('shipbuilding-tasks.show', $task) }}" class="text-blue-900 font-bold" target="_blank">
            @if($task->level > 1)
                @php $tab = ($task->level - 1) * 2 @endphp
                <span style="font-family: monospace;">{!! str_repeat("&nbsp;", $tab) !!}Ͱ&nbsp;</span>
            @endif
            <span>{{ $task->name ?? '-' }}</span>
        </a>
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->weight,"-") }}
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->progress,"-") }}
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->target,"-") }}
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->deviation,"-") }}
    </td>
    <td class="px-4 text-right" style="width: 134px;">
        <div
            role="group"
            aria-label="Row Actions"
            class="relative inline-flex align-middle"
        >
            <a
                href="{{ route('shipbuilding-tasks.show', $task) }}"
                class="mr-1" target="_blank"
            >
                <button
                    type="button"
                    class="button"
                >
                    <i class="icon ion-md-eye"></i>
                </button>
            </a>
        </div>
    </td>
</tr>
@if($task->enable_sub_progress == "category")
    @php $children = $task->children() @endphp
    @if($children)
        @foreach ($children as $child)
            @include('app.shipbuildings.show-task-row', ['task' => $child])
        @endforeach
    @endif
@endif
