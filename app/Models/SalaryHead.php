<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryHead extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'head_title',
        'salary_component',
        'symbol',
        'amount',
        'formula', 
        'percentage',
        'method'

    ];
    protected $table = 'salary_heads';

    public function head()
    {
        return $this->belongsTo(GradeWiseSalaryMaster::class, 'head_title', 'head_title');
    } 

   
}
