<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->foreignId('company_id')->after('employee_id')->constrained()->onDelete('cascade');
            $table->date('issue_date')->after('company_id');
            $table->string('concept')->after('issue_date');
            $table->decimal('total_amount', 10, 2)->after('concept');
            $table->dropColumn('balance'); // eliminamos el antiguo
            $table->decimal('balance', 10, 2)->after('total_amount');
        });
    }
    
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'issue_date', 'concept', 'total_amount', 'balance']);
            $table->decimal('balance', 10, 2)->default(0); // restauramos la anterior
        });
    }
};
