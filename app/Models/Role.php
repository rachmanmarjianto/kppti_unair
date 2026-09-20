<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_role'])]
class Role extends Model
{
    protected $table = 'role';

    protected $primaryKey = 'idrole';

    public $timestamps = false;
}
