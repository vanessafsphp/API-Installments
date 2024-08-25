<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parcela extends Model
{
    use HasFactory;

    protected $fillable = [
        'carne_id',
        'valor',
        'data_vencimento',
        'numero',
        'entrada'
    ];

    public function carne(): BelongsTo
    {
        return $this->belongsTo(Carne::class);
    }
}
