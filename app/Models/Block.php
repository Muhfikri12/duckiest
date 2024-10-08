<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'blocks';
    protected $fillable = [
        'name',
        'hatches_id',
        'qty',
        'reverse_time'
    ];

    public function hatch(): BelongsTo {

        return $this->belongsTo(Hatch::class, 'hatches_id');
    }
}
