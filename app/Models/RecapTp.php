<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecapTp extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function commune(): BelongsTo
    {
        return $this->BelongsTo(commune::class);
    }
}
