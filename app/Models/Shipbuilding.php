<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Datetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "shipbuildings".
 *
 * @property string $id
 * @property string $number
 * @property string $name
 * @property string $description
 * @property float $progress
 * @property string $ship_type_id
 * @property string $shipyard_id
 * @property Datetime $start_date
 * @property Datetime $end_date
 * @property string $tasks_level_deep
 * @property string $tasks_count
 * @property float $tasks_weight_sum
 * @property float $tasks_score_sum
 * @property string $cover_image
 * @property float $target
 *
 * @property ShipType $shipType
 *
 * @property Shipyard $shipyard
 *
 * @property ShipbuildingTask[] $shipbuildingTasks
 *
 *
 */
class Shipbuilding extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'number',
        'name',
        'description',
        'progress',
        'ship_type_id',
        'shipyard_id',
        'start_date',
        'end_date',
        'tasks_level_deep',
        'tasks_count',
        'tasks_weight_sum',
        'tasks_score_sum',
        'cover_image',
        'target',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function shipType()
    {
        return $this->belongsTo(ShipType::class);
    }

    public function shipyard()
    {
        return $this->belongsTo(Shipyard::class);
    }

    public function shipbuildingTasks()
    {
        return $this->hasMany(ShipbuildingTask::class);
    }

    protected $tasksFamily;

    /**
     * @param ShipbuildingTask|null $parentTask
     * @return \Generator
     */
    public function breakdownTasks(ShipbuildingTask|null $parentTask = null)
    {
        if (!is_array($this->tasksFamily)) {
            foreach ($this->shipbuildingTasks as $shipbuildingTask) {
                $parentID = (int)$shipbuildingTask->parent_task_id;
                $this->tasksFamily[$parentID][$shipbuildingTask->id] = $shipbuildingTask;
            }
        }

        $parentID = (int)optional($parentTask)->id;
        return $this->tasksFamily[$parentID] ?? [];
    }
}
