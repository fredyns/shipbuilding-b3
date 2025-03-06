<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "daily_documetations".
 *
 * @property string $id
 * @property string $daily_report_id
 * @property string $image
 * @property string $remark
 *
 * @property DailyReport $dailyReport
 *
 *
 */
class DailyDocumetation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['daily_report_id', 'image', 'remark'];

    protected $searchableFields = ['*'];

    protected $table = 'daily_documetations';

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
