<?php

namespace Modules\Telegram\Entities;

use Illuminate\Database\Eloquent\Model;

class TelegramSetting extends Model
{
    protected $table = 'telegram_settings';

    protected $fillable = [
        'business_id',
        'telegram_chat_id',
        'telegram_bot_token',
        'notify_on_close_register',
        'connect_token',
        'connect_token_expires_at',
    ];

    protected $casts = [
        'notify_on_close_register' => 'boolean',
        'connect_token_expires_at' => 'datetime',
    ];
}
