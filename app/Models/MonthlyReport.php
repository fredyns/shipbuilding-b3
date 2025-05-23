<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snippet\Helpers\JsonField;

/**
 * This is the model class for table "monthly_reports".
 *
 * @property string $id
 * @property Carbon $month
 * @property string $shipbuilding_id
 * @property float $planned_progress
 * @property float $actual_progres
 * @property string $report_file
 * @property string $summary
 * @property array $metadata
 *
 * @property Shipbuilding $shipbuilding
 *
 *
 */
class MonthlyReport extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'month',
        'shipbuilding_id',
        'planned_progress',
        'actual_progres',
        'report_file',
        'summary',
        'metadata',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'monthly_reports';

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
}
