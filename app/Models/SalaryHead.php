<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryHead extends Model
{
    use HasFactory;
    protected $fillable = [
        'head_title',
        'salary_component',
        'symbol',
        'amount',
        'formula',
        'percentage'

    ];
    protected $table = 'salary_heads';
}
