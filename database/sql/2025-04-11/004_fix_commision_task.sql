update shipbuilding_tasks
set enable_sub_progress = 'work-item'
where name = 'Commisioning'
  or name = 'Legal Document';
