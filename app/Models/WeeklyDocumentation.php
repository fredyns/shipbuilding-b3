<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Snippet\Helpers\JsonField;

/**
 * This is the model class for table "weekly_documentations".
 *
 * @property string $id
 * @property string $weekly_report_id
 * @property string $file
 * @property string $name
 * @property string $type
 * @property array $metadata
 * @property string $thumbnail
 *
 * @property WeeklyReport $weeklyDocumentation
 *
 *
 */
class WeeklyDocumentation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'weekly_report_id',
        'file',
        'name',
        'type',
        'metadata',
        'thumbnail',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'weekly_documentations';

    protected $casts = [
        'metadata' => 'array',
    ];

    public function metadata($key = null, $default = null)
    {
        return JsonField::getField($this, 'metadata', $key, $default);
    }

    public function weeklyDocumentation()
    {
        return $this->belongsTo(WeeklyReport::class, 'weekly_report_id');
    }
}
