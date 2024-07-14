<?php

use App\Models\CR;
use App\Models\CU;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(CU::class)->nullable()->constrained('c_u_s')->cascadeOnDelete(); // Specify the correct table name
            $table->foreignIdFor(CR::class)->nullable()->constrained('c_r_s')->cascadeOnDelete(); // Specify the correct table name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regisseurs');
    }
};
