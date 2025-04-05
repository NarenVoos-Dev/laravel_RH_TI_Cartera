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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Agregamos el nombre del empleado
            $table->foreignId('user_id')->nullable()->unique()->constrained()->onDelete('cascade'); // Puede ser NULL hasta que se asigne
            $table->string('document_identification')->unique();
            $table->decimal('salary', 10, 2);
            $table->decimal('transport_aid', 10, 2)->nullable();
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
