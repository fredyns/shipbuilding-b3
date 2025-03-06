<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "daily_activities".
 *
 * @property string $id
 * @property string $daily_report_id
 * @property string $name
 * @property string $pic
 *
 * @property DailyReport $dailyReport
 *
 *
 */
class DailyActivity extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['daily_report_id', 'name', 'pic'];

    protected $searchableFields = ['*'];

    protected $table = 'daily_activities';

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
