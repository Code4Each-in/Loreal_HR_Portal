<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBenefit extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'grade_id',
        'amount',
    ];

    public function grade()
    {
        return $this->belongsTo(BasicGrade::class);
    }
}