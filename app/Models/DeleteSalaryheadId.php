<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteSalaryheadId extends Model
{
    use HasFactory;
    protected $fillable = [
        'salary_head_id',
        'involve_head_id'

    ];
}
