<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppliedBenefit extends Model
{
    use HasFactory;
        use SoftDeletes; 
       protected $fillable = [
        'user_id',
        'benefit_id',
        'status',
        'detail'

    ];

    public function EmployeeBenefit()
    {
        return $this->hasMany(EmployeeBenefit::class, 'id' , 'benefit_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id' , 'user_id'); 
    }
}
