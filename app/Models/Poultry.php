<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poultry extends Model
{
    use HasFactory;

    protected $table = 'poultries';
    protected $fillable = [
        'generation',
        'qty',
        'vaccine',
        'date_of_birth',
        'status',
        'category',
        'icon',
    ];

    use SoftDeletes;

}
