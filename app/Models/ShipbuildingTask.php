<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snippet\Helpers\JsonField;

/**
 * This is the model class for table "shipbuilding_tasks".
 *
 * @property string $id
 * @property string $shipbuilding_id
 * @property string $level = parent.level + 1
 * @property string $sort_order = lastPeer.sort_order + 1
 * @property string $parent_task_id
 * @property string $item_type = parent.enable_sub_progress
 * @property string $name
 * @property string $description
 * @property float $weight
 * @property string $enable_sub_progress
 * @property integer $lock_element_set = worksheet.id
 * @property array $progress_options
 * @property float $progress
 *                  (sub_tasks_count>0) = sub_tasks_score_sum / sub_tasks_weight_sum
 * @property float $target {calculate weekly}
 * @property float $deviation = target - progress {calculate weekly}
 * @property float $score = progress * weight
 * @property string $sub_tasks_count = count(subtasks)
 * @property float $sub_tasks_weight_sum = sum(subtasks.weight)
 * @property float $sub_tasks_score_sum = sum(subtasks.score)
 * @property float $on_group_progress = score / parent.sub_tasks_weight_sum
 * @property float $on_project_weight
 *                 (level==1) = weight
 *                 (level>1) = (weight / parent.sub_tasks_weight_sum) * parent.weight
 * @property float $on_project_progress
 *                  (level==1) = progress
 *                  (level>1) = progress * on_project_weight
 * @property array $metadata
 *
 * @property Shipbuilding $shipbuilding
 *
 * @property ShipbuildingTask $parentTask
 * @property ShipbuildingTask $shipbuildingTask
 *
 * @property ShipbuildingTask[] $subTasks
 * @property ShipbuildingTask[] $shipbuildingTasks
 *
 *
 */
class ShipbuildingTask extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'shipbuilding_id',
        'level',
        'sort_order',
        'parent_task_id',
        'item_type',
        'name',
        'description',
        'weight',
        'enable_sub_progress',
        'lock_element_set',
        'progress_options',
        'progress',
        'target',
        'deviation',
        'score',
        'sub_tasks_count',
        'sub_tasks_weight_sum',
        'sub_tasks_score_sum',
        'on_group_progress',
        'on_project_weight',
        'on_project_progress',
        'metadata',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'shipbuilding_tasks';

    protected $casts = [
        'progress_options' => 'array',
        'metadata' => 'array',
    ];

    public function progress_options($key = null, $default = null)
    {
        return JsonField::getField($this, 'progress_options', $key, $default);
    }

    public function metadata($key = null, $default = null)
    {
        return JsonField::getField($this, 'metadata', $key, $default);
    }

    public function shipbuilding()
    {
        return $this->belongsTo(Shipbuilding::class);
    }

    public function parentTask()
    {
        return $this->belongsTo(ShipbuildingTask::class, 'parent_task_id');
    }

    public function shipbuildingTask()
    {
        return $this->belongsTo(ShipbuildingTask::class, 'parent_task_id');
    }

    public function subTasks()
    {
        return $this->hasMany(ShipbuildingTask::class, 'parent_task_id');
    }

    public function shipbuildingTasks()
    {
        return $this->hasMany(ShipbuildingTask::class, 'parent_task_id');
    }

    public function children()
    {
        return $this->shipbuilding->breakdownTasks($this);
    }
}
