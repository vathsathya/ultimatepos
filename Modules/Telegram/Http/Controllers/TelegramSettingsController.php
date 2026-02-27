<?php

namespace Modules\Telegram\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Telegram\Entities\TelegramSetting;

class TelegramSettingsController extends Controller
{
    /**
     * Show the connect-to-bot page.
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        $settings = TelegramSetting::where('business_id', $business_id)->first();
        $bot_username = config('telegram.bot_username');

        return view('telegram::settings.index', compact('settings', 'bot_username'));
    }

    /**
     * Generate a short-lived connect token and return it as JSON.
     * The token is embedded in the bot deep-link so we can match the user.
     */
    public function generateToken()
    {
        $business_id = request()->session()->get('user.business_id');

        $token = Str::random(32);

        TelegramSetting::updateOrCreate(
            ['business_id' => $business_id],
            [
                'connect_token' => $token,
                'connect_token_expires_at' => now()->addMinutes(10),
            ]
        );

        return response()->json([
            'success' => true,
            'token' => $token,
            'bot_username' => config('telegram.bot_username'),
            'expires_in' => 600, // seconds
        ]);
    }

    /**
     * Poll Telegram getUpdates and look for a /start <token> message.
     * If found, save the sender's chat_id and clear the token.
     */
    public function verifyConnection()
    {
        $business_id = request()->session()->get('user.business_id');
        $settings = TelegramSetting::where('business_id', $business_id)->first();

        if (!$settings || !$settings->connect_token) {
            return response()->json(['success' => false, 'msg' => 'No pending connection. Please regenerate.']);
        }

        if ($settings->connect_token_expires_at && $settings->connect_token_expires_at->isPast()) {
            return response()->json(['success' => false, 'msg' => 'Token expired. Please try again.', 'expired' => true]);
        }

        $bot_token = config('telegram.bot_token');
        if (empty($bot_token)) {
            return response()->json(['success' => false, 'msg' => 'Bot token not configured on server.']);
        }

        // Fetch recent updates from Telegram
        try {
            $response = Http::timeout(8)->get(
                "https://api.telegram.org/bot{$bot_token}/getUpdates",
                ['limit' => 100, 'allowed_updates' => json_encode(['message'])]
            );
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Could not reach Telegram API.']);
        }

        if (!$response->ok()) {
            return response()->json(['success' => false, 'msg' => 'Telegram API error: ' . $response->body()]);
        }

        $updates = $response->json('result') ?? [];
        $expected_text = '/start ' . $settings->connect_token;

        foreach ($updates as $update) {
            $text = $update['message']['text'] ?? '';
            $chat_id = $update['message']['chat']['id'] ?? null;

            // Accept both "/start TOKEN" and "/start TOKEN@botname"
            if (
                $chat_id && (
                    $text === '/start ' . $settings->connect_token ||
                    str_starts_with($text, '/start ' . $settings->connect_token)
                )
            ) {
                // Save chat_id and clear the connect token
                $settings->telegram_chat_id = (string) $chat_id;
                $settings->connect_token = null;
                $settings->connect_token_expires_at = null;
                $settings->notify_on_close_register = $settings->notify_on_close_register ?? true;
                $settings->save();

                // Greet the user in Telegram
                $this->sendGreeting($bot_token, $chat_id);

                return response()->json([
                    'success' => true,
                    'chat_id' => $chat_id,
                    'msg' => 'Connected successfully! You will now receive register notifications.',
                ]);
            }
        }

        return response()->json(['success' => false, 'msg' => 'Not found yet. Send /start to the bot then try again.']);
    }

    /**
     * Save the notify toggle via AJAX or form.
     */
    public function store(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');

        try {
            TelegramSetting::updateOrCreate(
                ['business_id' => $business_id],
                ['notify_on_close_register' => $request->boolean('notify_on_close_register')]
            );
            $output = ['success' => 1, 'msg' => __('messages.updated_success')];
        } catch (\Exception $e) {
            \Log::emergency('Telegram settings: ' . $e->getMessage());
            $output = ['success' => 0, 'msg' => __('messages.something_went_wrong')];
        }

        return redirect()->back()->with('status', $output);
    }

    /**
     * Disconnect: remove the chat_id association.
     * Used as a standard form POST (not AJAX) to avoid CSRF header issues.
     */
    public function disconnect()
    {
        $business_id = request()->session()->get('user.business_id');

        TelegramSetting::where('business_id', $business_id)->update([
            'telegram_chat_id' => null,
            'connect_token' => null,
            'connect_token_expires_at' => null,
        ]);

        $output = ['success' => true, 'msg' => 'Disconnected from Telegram successfully.'];

        return redirect()->route('telegram-settings')->with('status', $output);
    }

    /**
     * Send a welcome message after successful link.
     */
    private function sendGreeting(string $bot_token, $chat_id): void
    {
        try {
            Http::timeout(5)->post(
                "https://api.telegram.org/bot{$bot_token}/sendMessage",
                [
                    'chat_id' => $chat_id,
                    'text' => "✅ <b>Connected successfully!</b>\n\nYou will now receive register close summaries from the POS system.",
                    'parse_mode' => 'HTML',
                ]
            );
        } catch (\Exception $e) {
            // Non-critical, swallow
        }
    }
}
