update shipbuilding_tasks
set enable_sub_progress = 'work-item'
where item_type = 'work-item'
  and level > 1
  and subtasks_count > 0;
