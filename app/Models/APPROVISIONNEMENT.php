<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class APPROVISIONNEMENT extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function regisseur(): BelongsTo
    {
        return $this->belongsTo(regisseur::class);
    }
}
