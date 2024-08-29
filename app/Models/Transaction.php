<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';
    protected $fillable = [
        'category_id',
        'poultry_id',
        'name',
        'image',
        'date_transaction',
        'qty',
        'price',
        'total',

    ];

    public function poultry(): BelongsTo {

        return $this->belongsTo(Poultry::class);
    }

    public function category(): BelongsTo {

        return $this->belongsTo(Category::class);
    }
}
