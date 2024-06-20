<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'role_id',
        'module_id'

    ];

    public function module()
    {
        return $this->hasMany(Module::class, 'page_id' , 'module_id');
    }

}
