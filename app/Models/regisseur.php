<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find($id)
 */
class regisseur extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cu(): BelongsTo
    {
        return $this->belongsTo(CU::class, 'c_u_id', 'id');
    }
    public function cr(): BelongsTo
    {
        return $this->belongsTo(CU::class);
    }
}
