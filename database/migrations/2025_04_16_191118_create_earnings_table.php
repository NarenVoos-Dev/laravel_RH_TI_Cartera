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
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Sueldo básico, Auxilio de transporte, Horas extra
            $table->decimal('default_value', 12, 2)->nullable(); // Para conceptos fijos (opcional)
            $table->boolean('is_editable')->default(true); // Si el valor puede cambiar al momento de liquidar
            $table->boolean('is_taxable')->default(true); // Si afecta retención
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('earnings');
    }
};
