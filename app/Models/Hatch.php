<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "hatches";
    protected $fillable = [
        'generation',
        'date_of_birth',
        'type_eggs'
    ];
}
