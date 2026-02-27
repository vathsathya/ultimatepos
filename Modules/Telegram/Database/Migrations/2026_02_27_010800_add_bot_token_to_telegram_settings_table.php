<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('telegram_settings', function (Blueprint $table) {
            $table->string('telegram_bot_token')->nullable()->after('telegram_chat_id');
            $table->boolean('notify_on_close_register')->default(true)->after('telegram_bot_token');
        });
    }

    public function down(): void
    {
        Schema::table('telegram_settings', function (Blueprint $table) {
            $table->dropColumn(['telegram_bot_token', 'notify_on_close_register']);
        });
    }
};
