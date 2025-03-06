<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "daily_materials".
 *
 * @property string $id
 * @property string $daily_report_id
 * @property string $name
 * @property string $quantity
 * @property string $remark
 *
 * @property DailyReport $dailyReport
 *
 *
 */
class DailyMaterial extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['daily_report_id', 'name', 'quantity', 'remark'];

    protected $searchableFields = ['*'];

    protected $table = 'daily_materials';

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
