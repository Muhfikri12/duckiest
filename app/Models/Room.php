<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $fillable = [
        'name',
        'qty_duck',
        'died_qty',
        'poultry_id',
        'type',
        'egg_qty'
    ];

    use SoftDeletes;

    public function poultry(): BelongsTo {

        return $this->belongsTo(Poultry::class);
    }

}
