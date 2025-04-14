update shipbuilding_tasks
set enable_sub_progress = 'category'
where item_type = 'category'
  and enable_sub_progress = 'none'
  and subtasks_count > 0;
