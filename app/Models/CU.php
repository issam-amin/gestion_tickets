<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CU extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'c_u_s';



    public function regisseur(): HasMany
    {
        return $this->hasMany(regisseur::class);
    }
}
