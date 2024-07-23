<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static find($id)
 */
class regisseur extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function commune(): BelongsTo
    {
        return $this->belongsTo(commune::class);
    }

    public function total(): HasMany
    {
        return $this->HasMany(total::class);
    }
    public function recap(): HasMany
    {
        return $this->HasMany(recap::class);
    }
}
