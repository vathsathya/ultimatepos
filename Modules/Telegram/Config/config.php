<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Telegram Bot Token
    |--------------------------------------------------------------------------
    | Set TELEGRAM_BOT_TOKEN in your .env file.
    | Obtain a token from @BotFather on Telegram.
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Telegram Bot Username
    |--------------------------------------------------------------------------
    | The @username of your bot (without the @).
    | Used to generate the t.me deep-link for users to connect.
    | Set TELEGRAM_BOT_USERNAME in your .env file.
    */
    'bot_username' => env('TELEGRAM_BOT_USERNAME', ''),
];
