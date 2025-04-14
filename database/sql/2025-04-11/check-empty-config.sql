select *
from shipbuilding_tasks
where item_type = 'category'
  and enable_sub_progress = 'none'
  and subtasks_count > 0;
