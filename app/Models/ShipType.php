<?php

namespace App\Models;

use Datetime;
use Snippet\Helpers\JsonField;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * This is the model class for table "ship_types".
 *
 * @property string $id
 * @property string $name
 *
 * @property Shipbuilding[] $shipbuildings
 *
 *
 */
class ShipType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    protected $table = 'ship_types';

    public function shipbuildings()
    {
        return $this->hasMany(Shipbuilding::class);
    }
}
