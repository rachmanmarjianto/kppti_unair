<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['idpengguna', 'idrole', 'status'])]
class RolePengguna extends Model
{
    protected $table = 'role_pengguna';

    protected $primaryKey = 'idrole_pengguna';

    public $timestamps = false;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'idpengguna', 'idpengguna');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }
}
