<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class regisseur extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cu(): BelongsTo
    {
        return $this->belongsTo(CU::class);
    }
    public function cr(): BelongsTo
    {
        return $this->belongsTo(CU::class);
    }
}
