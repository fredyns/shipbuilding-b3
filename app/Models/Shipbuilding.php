<?php

namespace App\Models;

use App\Lib\SCurve;
use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Datetime;
use Generator;
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
 * @property Carbon $start_date
 * @property Carbon $end_date
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
 * @property WeeklyReport[] $weeklyReports
 *
 * @property DailyReport[] $dailyReports
 *
 * @property MonthlyReport[] $monthlyReports
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

    protected $_week;

    public function week()
    {
        if ($this->_week !== null) return $this->_week;

        if (empty($this->start_date)) {
            return null;
        }

        $now = new DateTime();

        $diff = $now->diff($this->start_date);

        return $this->_week = ceil($diff->days / 7);
    }

    protected $_sCurve;

    public function getSCurve(): SCurve
    {
        if (is_null($this->_sCurve)) {
            $this->_sCurve = new SCurve($this);
        }

        return $this->_sCurve;
    }

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

    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class);
    }

    protected $tasksFamily;

    /**
     * @param ShipbuildingTask|null $parentTask
     * @return Generator
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

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function monthlyReports()
    {
        return $this->hasMany(MonthlyReport::class);
    }
}
