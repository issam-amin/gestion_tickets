<?php

use App\Models\Regisseur;
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
        Schema::create('v_e_r_s_e_m_e_n_t_s', function (Blueprint $table) {
            $table->id();
            $table->double(DB::raw('`0.5`'))->nullable();
            $table->double(DB::raw('`1`'))->nullable();
            $table->double(DB::raw('`5`'))->nullable();
            $table->double(DB::raw('`2`'))->nullable();
            $table->double(DB::raw('`50`'))->nullable();
            $table->string('mois');
            $table->unsignedInteger('annee');
            $table->double('Somme')->nullable();
            $table->foreignIdFor(Regisseur::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_e_r_s_e_m_e_n_t_s');
    }
};
