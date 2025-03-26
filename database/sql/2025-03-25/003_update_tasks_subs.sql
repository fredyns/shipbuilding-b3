update shipbuilding_tasks
set enable_sub_progress = 'none'
where subtasks_count = 0;
