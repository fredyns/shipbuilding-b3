<?php

namespace App\Lib;

use App\Models\Shipbuilding;
use App\Models\ShipbuildingTask;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskParents
{
    protected Shipbuilding|null $shipbuilding;
    protected ShipbuildingTask|null $rootTask;
    protected array $options = [];

    public function __construct(Shipbuilding|ShipbuildingTask $root)
    {
        if ($root instanceof ShipbuildingTask) {
            $this->rootTask = $root;
            $this->shipbuilding = $root->shipbuilding;
        } else {
            $this->shipbuilding = $root;
        }
    }

    public function getOptions()
    {
        if (empty($this->options)) {
            $this->generateOptions();
        }

        return $this->options;
    }

    protected function generateOptions()
    {
        if ($this->rootTask) {
            $this->addFromQuery($this->rootTask->shipbuildingTasks());
        } else {
            $this->addFromQuery($this->shipbuilding->shipbuildingTasks());
        }
    }

    protected function addFromQuery(HasMany $query, $level = 1)
    {
        $parentMarking = [TaskType::CATEGORY, TaskType::WORK_ITEM];
        $collection = $query->whereIn('enable_sub_progress', $parentMarking)
            ->get(['id', 'name', 'enable_sub_progress']);

        if ($collection->isEmpty()) return;

        foreach ($collection as $task) {
            /* @var $task ShipbuildingTask */
            $this->addOption($task, $level);
            $this->addFromQuery($task->shipbuildingTasks(), $level + 1);
        }
    }

    protected function addOption(ShipbuildingTask $option, $level = 1)
    {
        $label = str_repeat('- ', $level) . $option->name;
        $this->options[$option->id] = $label;
    }
}
