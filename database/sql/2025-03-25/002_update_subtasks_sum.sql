update shipbuilding_tasks
set subtasks_count = children.subtasks_count,
    subtasks_weight_sum = children.subtasks_weight_sum,
    subtasks_score_sum = children.subtasks_score_sum
from (
    select parent_task_id,
    count(*) as subtasks_count,
    sum(weight) as subtasks_weight_sum,
    sum(score) as subtasks_score_sum
    from shipbuilding_tasks
    where parent_task_id is not null
    group by parent_task_id
) as children
where id = children.parent_task_id
