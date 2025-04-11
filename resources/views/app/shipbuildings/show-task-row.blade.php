<?php

use App\Helpers\Format;

/**
 * @var $task \App\Models\ShipbuildingTask
 * @var $iterate int
 * @var $prefix string
 */
$iterate = $iterate ?? 1;
$prefix = $prefix ?? '';
$numbering = trim($prefix . "." . $iterate, '.');
$subIterate = 0;

?>
<tr class="hover:bg-gray-100">
    <td class="px-4 text-left">
        {{ $numbering }}
    </td>
    <td class="px-4 text-left">
        @if($task->enable_sub_progress == 'work-item')
            <a href="{{ route('shipbuilding-tasks.show', $task) }}">
                @include('app.shipbuildings.show-task-label', ['task' => $task])
            </a>
        @else
            @include('app.shipbuildings.show-task-label', ['task' => $task])
        @endif
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
@if($task->enable_sub_progress == "category")
    @php $children = $task->children() @endphp
    @if($children)
        @foreach ($children as $child)
            @include('app.shipbuildings.show-task-row', [
                'task' => $child,
                'iterate' => ++$subIterate,
                'prefix' => $numbering,
            ])
        @endforeach
    @endif
@endif
