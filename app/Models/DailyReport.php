<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Datetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snippet\Helpers\JsonField;

/**
 * This is the model class for table "daily_reports".
 *
 * @property string $id
 * @property string $shipbuilding_id
 * @property Datetime $date
 * @property string $week
 * @property float $actual_progress
 * @property string $morning_weather_id
 * @property string $morning_humidity_id
 * @property string $midday_weather_id
 * @property string $midday_humidity_id
 * @property string $afternoon_weather_id
 * @property string $afternoon_humidity_id
 * @property string $temperature
 * @property string $summary
 * @property array $metadata
 *
 * @property Shipbuilding $shipbuilding
 *
 * @property Weather $morningWeather
 *
 * @property Weather $middayWeather
 *
 * @property Weather $afternoonWeather
 *
 * @property Humidity $morningHumidity
 *
 * @property Humidity $middayHumidity
 *
 * @property Humidity $afternoonHumidity
 *
 * @property DailyPersonnel[] $dailyPersonnels
 *
 * @property DailyEquipment[] $dailyEquipments
 *
 * @property DailyMaterial[] $dailyMaterials
 *
 * @property DailyActivity[] $dailyActivities
 *
 * @property DailyDocumetation[] $dailyDocumetations
 *
 *
 */
class DailyReport extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'shipbuilding_id',
        'date',
        'week',
        'actual_progress',
        'morning_weather_id',
        'morning_humidity_id',
        'midday_weather_id',
        'midday_humidity_id',
        'afternoon_weather_id',
        'afternoon_humidity_id',
        'temperature',
        'summary',
        'metadata',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'daily_reports';

    protected $casts = [
        'date' => 'date',
        'metadata' => 'array',
    ];

    public function week()
    {
        if (empty($this->date)) return null;
        if (empty($this->shipbuilding->start_date)) return null;

        $diff = $this->date->diff($this->shipbuilding->start_date);

        return ceil($diff->days / 7);
    }

    public function metadata($key = null, $default = null)
    {
        return JsonField::getField($this, 'metadata', $key, $default);
    }

    public function shipbuilding()
    {
        return $this->belongsTo(Shipbuilding::class);
    }

    public function morningWeather()
    {
        return $this->belongsTo(Weather::class, 'morning_weather_id');
    }

    public function middayWeather()
    {
        return $this->belongsTo(Weather::class, 'midday_weather_id');
    }

    public function afternoonWeather()
    {
        return $this->belongsTo(Weather::class, 'afternoon_weather_id');
    }

    public function morningHumidity()
    {
        return $this->belongsTo(Humidity::class, 'morning_humidity_id');
    }

    public function middayHumidity()
    {
        return $this->belongsTo(Humidity::class, 'midday_humidity_id');
    }

    public function afternoonHumidity()
    {
        return $this->belongsTo(Humidity::class, 'afternoon_humidity_id');
    }

    public function dailyPersonnels()
    {
        return $this->hasMany(DailyPersonnel::class);
    }

    public function dailyEquipments()
    {
        return $this->hasMany(DailyEquipment::class);
    }

    public function dailyMaterials()
    {
        return $this->hasMany(DailyMaterial::class);
    }

    public function dailyActivities()
    {
        return $this->hasMany(DailyActivity::class);
    }

    public function dailyDocumetations()
    {
        return $this->hasMany(DailyDocumetation::class);
    }
}
