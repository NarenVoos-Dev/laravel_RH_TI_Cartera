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
        Schema::create('payroll_detail_items', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('payroll_detail_id')->constrained()->onDelete('cascade');
        
            // Referencia a catálogo de conceptos (puede ser earnings o deductions)
            $table->unsignedBigInteger('concept_id');
            $table->enum('type', ['earning', 'deduction']); // Para saber a qué tabla pertenece
        
            $table->string('description')->nullable(); // Ej: "Salario básico 15 días", "Horas extra nocturna"
            $table->decimal('amount', 12, 2)->default(0);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_detail_items');
    }
};
