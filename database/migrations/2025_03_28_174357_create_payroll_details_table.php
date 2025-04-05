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
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('base_salary', 10, 2);
            $table->decimal('days_worked', 10, 2)->default(0); // Días trabajados
            $table->decimal('transport_aid', 10, 2)->nullable();
            $table->decimal('total_earnings', 10, 2)->default(0); // Total de devengados
            $table->decimal('total_deductions', 10, 2)->default(0); // Total de descuentos
            $table->decimal('net_salary', 10, 2)->default(0); // Salario final después de descuentos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};
