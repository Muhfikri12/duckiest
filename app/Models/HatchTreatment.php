<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HatchTreatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hatch_treatments';
    protected $fillable = [
        'blocks_id',
        'fase',
        'temperature',
        'humadity',
        'died_qty',
        'description'
    ];

    public function Block(): BelongsTo {

        return $this->belongsTo(Block::class, 'blocks_id');
    }
}
