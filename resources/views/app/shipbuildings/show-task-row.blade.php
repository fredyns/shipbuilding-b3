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
