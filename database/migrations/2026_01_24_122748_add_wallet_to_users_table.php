<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Saldo inicial de 100€ para que puedan probar
            $table->decimal('wallet_balance', 10, 2)->default(100.00)->after('email');
            // Historial de lo que han donado
            $table->decimal('total_donated', 10, 2)->default(0.00)->after('wallet_balance');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['wallet_balance', 'total_donated']);
        });
    }
};
