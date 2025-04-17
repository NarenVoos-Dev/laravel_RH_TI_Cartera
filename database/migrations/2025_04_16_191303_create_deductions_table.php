<?php

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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Salud, Pensión, Fondo de solidaridad
            $table->decimal('percentage', 5, 2)->nullable(); // Ej: 4.00 (%)
            $table->boolean('is_mandatory')->default(true); // Si se aplica automáticamente según condiciones
            $table->boolean('is_editable')->default(true); // Si se puede ajustar en liquidación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
