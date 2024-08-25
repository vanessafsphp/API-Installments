<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carne extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor_total',
        'qtd_parcelas',
        'data_primeiro_vencimento',
        'periodicidade',
        'valor_entrada'
    ];

    public function parcelas(): HasMany
    {
        return $this->hasMany(Parcela::class);
    }
}
