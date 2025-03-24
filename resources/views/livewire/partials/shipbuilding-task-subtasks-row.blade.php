<?php
use App\Helpers\Format;
/**
 * @var $parentTask \App\Models\ShipbuildingTask
 * @var $shipbuildingTask \App\Models\ShipbuildingTask
 * @var $task \App\Models\ShipbuildingTask
 *
 * @var $selected array
 * @var $editing bool
 * @var $allSelected bool
 * @var $showingModalView bool
 * @var $showingModalForm bool
 *
 * @var $modalTitle string
 *
 * @var $parentOptions string[]
 * @var $numbering int[]
 */

$level = $task->level - $parentTask->level;
$tab = ($level - 1) * 2;
$children = $task->children();
$newNumberingLevel = count($numbering);
?>
<tr class="hover:bg-gray-100">
    <td class="px-4 py-3 text-left">
        {{ implode('.', $numbering) }}
    </td>
    <td class="px-4 py-3 text-left">
        <a wire:click="editShipbuildingTask('{{ $task->id }}')" class="cursor-pointer">
            @if($tab > 0)
                <span style="font-family: monospace;">{!! str_repeat("&nbsp;", $tab) !!}Ͱ&nbsp;</span>
            @endif
            <span>{{ $task->name ?? '-' }}</span>
        </a>
    </td>
    <td class="px-4 py-3 text-right">
        {{ Format::percent($task->weight, "-") }}
    </td>
    <td class="px-4 py-3 text-right">
        {{ Format::percent($task->progress, "-") }}
    </td>
    <td class="px-4 py-3 text-right">
        {{ Format::percent($task->target, "-") }}
    </td>
    <td class="px-4 py-3 text-right">
        {{ Format::percent($task->deviation, "-") }}
    </td>
</tr>
@if($children)
    @php $i = 0 @endphp
    @foreach ($children as $child)
        @php
            $numbering[$newNumberingLevel] = ++$i;
            $data = [
                'task' => $child,
                'numbering' => $numbering,
            ];
        @endphp
        @include('livewire.partials.shipbuilding-task-subtasks-row', $data)
    @endforeach
@endif
