<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "daily_personnels".
 *
 * @property string $id
 * @property string $daily_report_id
 * @property string $role
 * @property bool $present
 * @property string $description
 *
 * @property DailyReport $dailyReport
 *
 *
 */
class DailyPersonnel extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['daily_report_id', 'role', 'present', 'description'];

    protected $searchableFields = ['*'];

    protected $table = 'daily_personnels';

    protected $casts = [
//        'present' => 'boolean',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }
}
