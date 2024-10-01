<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Custo extends Model
{
    use HasFactory;

    protected $fillable = [
        'competencia',
        'valor_documento',
        'data_vencimento',
        'descricao',
        'status',
        'user_id',
    ];


    public function valorDocumento(): Attribute
    {
        return Attribute::make(
            get: function(?string $value)   {
                    info($value ?? '');
                    return $value;
                },
            set: function (string $value) {
                info($value);
                return $value;
            });
    }


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
