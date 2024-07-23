<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static select(string $string)
 */
class CR extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function regisseur(): HasOne
    {
        return $this->hasOne(regisseur::class);
    }

}
