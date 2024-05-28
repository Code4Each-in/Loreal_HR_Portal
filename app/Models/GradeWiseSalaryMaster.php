<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class GradeWiseSalaryMaster extends Model
{
    protected $table = 'grade_wise_salary_masters';
    use HasFactory;
    protected $fillable = [
        'head_title',
        'amount',
        'method',
        'formula',
        'grade',
    ];


    public function grade(): BelongsTo
    {
        return $this->belongsTo(BasicGrade::class, 'grade');
    }

}
