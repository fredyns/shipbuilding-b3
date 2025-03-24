<?php

use App\Helpers\Format;

?>
@if($task->parentTask)
    @include('app.shipbuilding_tasks.show-lineage', ['task' => $task->parentTask])
@endif
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
        {{ Format::percent($task->weight, "-") }}
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->progress, "-") }}
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->target, "-") }}
    </td>
    <td class="px-4 text-right">
        {{ Format::percent($task->deviation, "-") }}
    </td>
</tr>
