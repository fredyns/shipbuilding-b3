<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Datetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snippet\Helpers\JsonField;

/**
 * This is the model class for table "weekly_reports".
 *
 * @property string $id
 * @property string $shipbuilding_id
 * @property string $week
 * @property Datetime $month
 * @property float $planned_progress
 * @property float $actual_progress
 * @property string $summary
 * @property string $report_file
 * @property array $metadata
 *
 * @property Shipbuilding $shipbuilding
 *
 * @property WeeklyDocumentation[] $weeklyDocumentations
 *
 *
 */
class WeeklyReport extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'shipbuilding_id',
        'week',
        'month',
        'planned_progress',
        'actual_progress',
        'summary',
        'report_file',
        'metadata',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'weekly_reports';

    protected $casts = [
        'month' => 'date',
        'metadata' => 'array',
    ];

    public function metadata($key = null, $default = null)
    {
        return JsonField::getField($this, 'metadata', $key, $default);
    }

    public function shipbuilding()
    {
        return $this->belongsTo(Shipbuilding::class);
    }

    public function weeklyDocumentations()
    {
        return $this->hasMany(WeeklyDocumentation::class);
    }
}
