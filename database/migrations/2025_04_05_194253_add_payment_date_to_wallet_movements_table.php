<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallet_movements', function (Blueprint $table) {
            $table->date('payment_date')->after('amount');
        });
    }
    
    public function down(): void
    {
        Schema::table('wallet_movements', function (Blueprint $table) {
            $table->dropColumn('payment_date');
        });
    }
};
