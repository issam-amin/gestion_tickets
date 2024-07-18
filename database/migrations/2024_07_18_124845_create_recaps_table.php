<?php

use App\Models\regisseur;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recaps', function (Blueprint $table) {
            $table->id();
            $table->double(DB::raw('`0.5`'))->nullable();
            $table->double(DB::raw('`1`'))->nullable();
            $table->double(DB::raw('`5`'))->nullable();
            $table->double(DB::raw('`2`'))->nullable();
            $table->double(DB::raw('`50`'))->nullable();
            $table->unsignedInteger('annee');
            $table->foreignIdFor(Regisseur::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recaps');
    }
};
