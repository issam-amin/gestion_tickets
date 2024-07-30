<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class commune extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function regisseurs(): HasMany
    {
        return $this->hasMany(Regisseur::class);
    }
    public function Chez_TP(): HasMany
    {
        return $this->hasMany(Chez_TP::class);
    }
    public function TotalTp(): HasMany
    {
        return $this->HasMany(TotalTp::class);
    }
    public function RecapTp(): HasMany
    {
        return $this->HasMany(RecapTp::class);
    }
}
