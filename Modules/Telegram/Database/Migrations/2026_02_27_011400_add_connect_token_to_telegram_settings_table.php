<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('telegram_settings', function (Blueprint $table) {
            // Self-service connect flow columns
            $table->string('connect_token', 64)->nullable()->after('notify_on_close_register');
            $table->timestamp('connect_token_expires_at')->nullable()->after('connect_token');
        });
    }

    public function down(): void
    {
        Schema::table('telegram_settings', function (Blueprint $table) {
            $table->dropColumn(['connect_token', 'connect_token_expires_at']);
        });
    }
};
