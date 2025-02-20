<?php

namespace App\Models;

use Datetime;
use Snippet\Helpers\JsonField;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * This is the model class for table "shipyards".
 *
 * @property string $id
 * @property string $name
 *
 * @property Shipbuilding[] $shipbuildings
 *
 *
 */
class Shipyard extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public function shipbuildings()
    {
        return $this->hasMany(Shipbuilding::class);
    }
}
