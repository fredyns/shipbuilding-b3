update shipbuildings
set tasks_level_deep = level_deep,
    tasks_count = total
from (
    select shipbuilding_id,
           count(*) as total,
           max(level) as level_deep
    from shipbuilding_tasks
    group by shipbuilding_id
     ) as tasks
where shipbuilding_id = shipbuildings.id;
