<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snippet\Helpers\JsonField;

/**
 * This is the model class for table "weathers".
 *
 * @property string $id
 * @property string $name
 * @property array $metadata
 *
 * @property DailyReport[] $morningReports
 *
 * @property DailyReport[] $middayReports
 *
 * @property DailyReport[] $afternoonReports
 *
 *
 */
class Weather extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'weathers';

    protected $fillable = ['name', 'metadata'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function metadata($key = null, $default = null)
    {
        return JsonField::getField($this, 'metadata', $key, $default);
    }

    public function morningReports()
    {
        return $this->hasMany(DailyReport::class, 'morning_weather_id');
    }

    public function middayReports()
    {
        return $this->hasMany(DailyReport::class, 'midday_weather_id');
    }

    public function afternoonReports()
    {
        return $this->hasMany(DailyReport::class, 'afternoon_weather_id');
    }
}
