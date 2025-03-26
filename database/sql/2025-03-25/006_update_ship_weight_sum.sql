update shipbuildings
set tasks_weight_sum = weight_sum,
    tasks_score_sum = score_sum
from (
         select shipbuilding_id,
                sum(weight) as weight_sum,
                sum(score) as score_sum
         from shipbuilding_tasks
         where level = 1
         group by shipbuilding_id
     ) as tasks
where tasks.shipbuilding_id = shipbuildings.id;
