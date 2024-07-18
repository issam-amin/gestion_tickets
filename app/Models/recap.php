<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recap extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function regisseur()
    {
        return $this->belongsTo(regisseur::class);
    }
}
