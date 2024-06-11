<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'page_id',
        'module_name',
        'route_name'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class,);
    }

   
 

   
}
