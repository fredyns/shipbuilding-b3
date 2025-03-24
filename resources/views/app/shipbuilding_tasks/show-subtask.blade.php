<?php

use App\Helpers\Format;

/**
 * @var $task \App\Models\ShipbuildingTask
 * @var $offset int
 */

$offset = $offset ?? 1;
$task->level -= $offset;

?>
<tr class="hover:bg-gray-100">
    <td class="px-4 text-left">
        <a href="{{ route('shipbuilding-tasks.show', $task) }}">
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
</tr>
@php $children = $task->children() @endphp
@if($children)
    @foreach ($children as $child)
        @include('app.shipbuilding_tasks.show-subtask', ['task' => $child, 'offset'=> $offset])
    @endforeach
@endif
