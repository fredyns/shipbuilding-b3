<?php

namespace App\Models;

use Datetime;
use Snippet\Helpers\JsonField;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property Datetime $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property Datetime $two_factor_confirmed_at
 * @property string $current_team_id
 * @property string $profile_photo_path
 *
 *
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasTeams;
    use HasFactory;
    use Notifiable;
    use Searchable;
    use HasPermissions;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'password'];

    protected $searchableFields = ['*'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * Get the user's "personal" team.
     *
     * @return \App\Models\Team
     */
    public function personalTeam()
    {
        $personalTeam = $this->ownedTeams
            ->where('personal_team', true)
            ->first();

        if (empty($personalTeam)) {
            $personalTeam = $this->ownedTeams()->save(
                Team::forceCreate([
                    'user_id' => $this->id,
                    'name' => explode(' ', $this->name, 2)[0] . "'s Team",
                    'personal_team' => true,
                ])
            );
        }

        return $personalTeam;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }
}
