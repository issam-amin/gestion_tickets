<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $id)
 */
class total extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function regisseur(): BelongsTo
    {
        return $this->BelongsTo(regisseur::class);
    }
}
