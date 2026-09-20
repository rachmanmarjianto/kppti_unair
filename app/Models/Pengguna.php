<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['nama', 'email', 'no_wa', 'password', 'idinstitusi_asal'])]
#[Hidden(['password'])]
class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $primaryKey = 'idpengguna';

    public $timestamps = false;

    /**
     * The "pengguna" table has no remember_token column, so the
     * "remember me" session token is disabled for this model.
     *
     * @var string
     */
    protected $rememberTokenName = '';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function rolePengguna(): HasMany
    {
        return $this->hasMany(RolePengguna::class, 'idpengguna', 'idpengguna');
    }

    /**
     * Roles the user currently holds with an active status.
     */
    public function activeRoles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_pengguna', 'idpengguna', 'idrole')
            ->wherePivot('status', true);
    }
}
