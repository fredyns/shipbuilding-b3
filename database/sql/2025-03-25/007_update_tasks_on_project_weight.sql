update shipbuilding_tasks
set on_project_weight = weight
where level = 1;

update shipbuilding_tasks as children
set on_project_weight = (children.weight * parent.subtasks_weight_sum) * parent.on_project_weight
from shipbuilding_tasks as parent
where children.level = 2
and children.parent_task_id = parent.id;

update shipbuilding_tasks as children
set on_project_weight = (children.weight / parent.subtasks_weight_sum) * parent.on_project_weight
from shipbuilding_tasks as parent
where children.level = 3
  and children.parent_task_id = parent.id;


update shipbuilding_tasks as children
set on_project_weight = (children.weight / parent.subtasks_weight_sum) * parent.on_project_weight
from shipbuilding_tasks as parent
where children.level = 4
  and children.parent_task_id = parent.id;


update shipbuilding_tasks as children
set on_project_weight = (children.weight / parent.subtasks_weight_sum) * parent.on_project_weight
from shipbuilding_tasks as parent
where children.level = 5
  and children.parent_task_id = parent.id;


