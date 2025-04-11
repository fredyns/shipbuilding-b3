@if($task->level > 1)
    @php $tab = ($task->level - 1) * 2 @endphp
    <span style="font-family: monospace;">{!! str_repeat("&nbsp;", $tab) !!}Ͱ&nbsp;</span>
@endif
<span>{{ $task->name ?? '-' }}</span>
