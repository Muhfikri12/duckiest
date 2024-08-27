<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'treatments';
    protected $fillable = [
        'feed_id',
        'room_id',
        'feed_qty',
        'description',
        'egg_qty'
    ];

    public function room(): BelongsTo {

        return $this->belongsTo(Room::class);
    }

    public function feed(): BelongsTo {

        return $this->belongsTo(Feed::class);
    }
}
