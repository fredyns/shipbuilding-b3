update shipbuilding_tasks as children
set worksheet_id = parent.id
from shipbuilding_tasks as parent
where children.level = 2
  and children.item_type = 'work-item'
  and parent.item_type = 'category';

update shipbuilding_tasks as children
set worksheet_id = parent.id
from shipbuilding_tasks as parent
where children.level = 3
  and children.item_type = 'work-item'
  and parent.item_type = 'category';

update shipbuilding_tasks as children
set worksheet_id = parent.worksheet_id
from shipbuilding_tasks as parent
where children.level > 2
  and children.item_type = 'work-item'
  and parent.item_type = 'work-item';
