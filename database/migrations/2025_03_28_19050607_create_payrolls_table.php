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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
        
            // Relación con empresa
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        
            // Rango de fechas de la nómina
            $table->date('start_date');
            $table->date('end_date');
        
            // Fecha real de pago
            $table->date('payment_date');
        
            // Totales generales
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('total_net_pay', 15, 2)->default(0);
        
            $table->enum('status', ['generada', 'procesada', 'cerrada'])->default('generada');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
