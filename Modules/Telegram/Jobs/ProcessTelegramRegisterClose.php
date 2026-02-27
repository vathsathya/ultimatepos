<?php

namespace Modules\Telegram\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTelegramRegisterClose implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chat_id;
    public $business_id;
    public $location_name;
    public $user_name;
    public $user_id;
    public $open_time;
    public $close_time;
    public $register_details;

    public function __construct($chat_id, $business_id, $location_name, $user_name, $user_id, $open_time, $close_time, $register_details)
    {
        $this->chat_id = $chat_id;
        $this->business_id = $business_id;
        $this->location_name = $location_name;
        $this->user_name = $user_name;
        $this->user_id = $user_id;
        $this->open_time = $open_time;
        $this->close_time = $close_time;
        // Don't strongly type the eloquent model to prevent serialization errors out of process
        $this->register_details = $register_details;
    }

    public function handle(): void
    {
        $cashRegisterUtil = app(\App\Utils\CashRegisterUtil::class);
        $details = $cashRegisterUtil->getRegisterTransactionDetails($this->user_id, $this->open_time, $this->close_time);

        $product_details = $details['product_details'] ?? [];
        $transaction_details = $details['transaction_details'] ?? null;

        $cash_in_hand = $this->register_details->cash_in_hand ?? 0;
        $total_cash = $this->register_details->total_cash ?? 0;
        $total_cash_refund = $this->register_details->total_cash_refund ?? 0;

        $total_payment = $cash_in_hand + $total_cash - $total_cash_refund;
        $total_sales = $transaction_details->total_sales ?? 0;
        $total_refund = $this->register_details->total_refund ?? 0;
        $credit_sales = $total_sales - ($this->register_details->total_sale ?? 0);
        $total_expense = $this->register_details->total_expense ?? 0;

        $formatted_date = \Carbon\Carbon::parse($this->close_time)->format('d-m-Y h:i A');

        $msg = "<b>🏪 Register Closed</b>\n";
        $msg .= "📅 Date: <b>{$formatted_date}</b>\n";
        $msg .= "📍 Location: <b>{$this->location_name}</b>\n";
        $msg .= "👤 Closed By: <b>{$this->user_name}</b>\n";
        $msg .= "──────────────\n\n";

        $msg .= "<pre>📦 Products Sold:\n";
        $sum_qty = 0;
        $sum_amt = 0;
        foreach ($product_details as $pd) {
            $qty = (float) $pd->total_quantity;
            $amt = (float) $pd->total_amount;
            $sum_qty += $qty;
            $sum_amt += $amt;

            $prod = trim($pd->product_name ?? '');
            if (!empty($pd->sku)) {
                $prod .= " ({$pd->sku})";
            }

            $msg .= "▪️ {$prod}\n";
            $msg .= "   Qty: " . number_format($qty, 2) . "  |  $ " . number_format($amt, 2) . "\n";
        }
        $msg .= "Total Items: " . number_format($sum_qty, 2) . "\n";
        $msg .= "Subtotal: $ " . number_format($sum_amt, 2) . "\n";
        $msg .= "──────────────</pre>\n\n";

        $msg .= "<b>📊 Summary:</b>\n";
        $msg .= "Total Sales:   <b>$ " . number_format((float) $total_sales, 2) . "</b>\n";
        $msg .= "Total Refund:  <b>$ " . number_format((float) $total_refund, 2) . "</b>\n";
        $msg .= "Total Payment: <b>$ " . number_format((float) $total_payment, 2) . "</b>\n";
        $msg .= "Credit Sales:  <b>$ " . number_format((float) $credit_sales, 2) . "</b>\n";
        $msg .= "Total Expense: <b>$ " . number_format((float) $total_expense, 2) . "</b>\n";

        dispatch(new SendTelegramMessage($this->chat_id, $msg));
    }
}
