<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['nama', 'email', 'no_wa', 'idrole', 'password', 'idinstitusi_asal'])]
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
}
