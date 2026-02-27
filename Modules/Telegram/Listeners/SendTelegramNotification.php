<?php

namespace Modules\Telegram\Listeners;

use App\BusinessLocation;
use Modules\Telegram\Jobs\SendTelegramMessage;
use Modules\Telegram\Entities\TelegramSetting;

class SendTelegramNotification
{
    public function handle($event): void
    {
        $register_details = $event->register_details ?? null;

        if (!$register_details && method_exists($event, 'getRegisterDetails')) {
            $register_details = $event->getRegisterDetails();
        }

        if (!$register_details) {
            return;
        }

        // Resolve business_id from session or location
        $business_id = request()->session()->get('user.business_id');
        if (empty($business_id) && isset($register_details->location_id)) {
            $business_id = optional(BusinessLocation::find($register_details->location_id))->business_id;
        }

        if (!$business_id) {
            return;
        }

        $setting = TelegramSetting::where('business_id', $business_id)->first();

        // Guard: must be connected and enabled
        if (!$setting || empty($setting->telegram_chat_id)) {
            return;
        }

        if (!$setting->notify_on_close_register) {
            return;
        }

        // Resolve location name
        $location_name = $register_details->location_name ?? '';
        if (empty($location_name) && isset($register_details->location_id)) {
            $location_name = optional(BusinessLocation::find($register_details->location_id))->name ?? '';
        }

        $user_name = auth()->check() ? auth()->user()->user_full_name : 'Unknown';

        // Prepare data for the queue job
        $user_id = $register_details->user_id ?? ($business_id ? auth()->id() : null);
        $open_time = $register_details->open_time ?? null;
        $close_time = $register_details->closed_at ?? \Carbon\Carbon::now()->toDateTimeString();

        // Convert register details to array to prevent nested serialization errors
        $register_details_array = is_object($register_details) ? (object) $register_details->toArray() : (object) $register_details;

        dispatch(new \Modules\Telegram\Jobs\ProcessTelegramRegisterClose(
            $setting->telegram_chat_id,
            $business_id,
            $location_name,
            $user_name,
            $user_id,
            $open_time,
            $close_time,
            $register_details_array
        ));
    }
}
