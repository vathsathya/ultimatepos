<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Models\MerchantInfo;
use KHQR\Helpers\KHQRData;

class BakongController extends Controller
{
    /**
     * Generate KHQR for POS
     */
    public function generateQr(Request $request)
    {
        try {
            $business_id = request()->session()->get('user.business_id');
            $pos_settings = empty($business_id) ? [] : json_decode(request()->session()->get('business.pos_settings'), true);
            $bakong_account_id = $pos_settings['bakong_account_id'] ?? env('BAKONG_ACCOUNT_ID');

            if (!$bakong_account_id) {
                return response()->json(['success' => false, 'msg' => 'Bakong Account ID is not configured.']);
            }

            $amount = (float) $request->input('amount', 0);

            // Assume USD by default, could be dynamic depending on business settings or system currency
            $currency = KHQRData::CURRENCY_USD;
            if (isset($request->currency) && $request->currency === 'KHR') {
                $currency = KHQRData::CURRENCY_KHR;
            }

            $merchantInfo = new MerchantInfo(
                $bakong_account_id, // bakongAccountID
                env('APP_NAME', 'UltimatePOS'), // merchantName
                'Phnom Penh', // merchantCity
                'POS_MERCHANT', // merchantID
                'ACLEDA' // acquiringBank
            );
            $merchantInfo->amount = $amount;
            $merchantInfo->currency = $currency;

            $khqrResp = BakongKHQR::generateMerchant($merchantInfo);

            $responseData = is_array($khqrResp) ? ($khqrResp['data'] ?? null) : ($khqrResp->data ?? null);
            $data = is_object($responseData) ? (array) $responseData : (is_array($responseData) ? $responseData : []);
            $khqr_string = $data['qr'] ?? null;
            $md5 = $data['md5'] ?? null;

            if ($khqr_string && $md5) {
                return response()->json([
                    'success' => true,
                    'qr_string' => $khqr_string,
                    'qr_url' => 'https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=' . urlencode($khqr_string),
                    'md5' => $md5
                ]);
            }

            return response()->json(['success' => false, 'msg' => 'Failed to generate KHQR']);
        } catch (\Exception $e) {
            \Log::error('Bakong KHQR Generation Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'msg' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Check Bakong Payment Status
     */
    public function checkPayment(Request $request)
    {
        try {
            $md5 = $request->input('md5');
            $business_id = request()->session()->get('user.business_id');
            $pos_settings = empty($business_id) ? [] : json_decode(request()->session()->get('business.pos_settings'), true);
            $token = $pos_settings['bakong_token'] ?? env('BAKONG_TOKEN');

            if (!$token) {
                return response()->json(['success' => false, 'msg' => 'Bakong Token is missing!']);
            }

            $response = \KHQR\Api\Transaction::checkTransactionByMD5($token, $md5, false);
            $data = $response['data'] ?? null;

            if ($data && isset($data['hash'])) {
                // Return success
                return response()->json([
                    'success' => true,
                    'msg' => 'Payment successful',
                    'transaction_id' => $data['hash'],
                    'amount' => $data['amount'] ?? 0
                ]);
            }

            // Fallback for missing hash but success
            if (isset($response['responseCode']) && $response['responseCode'] == '0') {
                return response()->json([
                    'success' => true,
                    'msg' => 'Payment successful',
                    'transaction_id' => 'bakong_' . time()
                ]);
            }

            return response()->json([
                'success' => false,
                'msg' => 'Payment not successful or pending. Try again.',
            ]);

        } catch (\Exception $e) {
            \Log::error("Bakong Check Payment Error: " . $e->getMessage());
            return response()->json(['success' => false, 'msg' => "Validation Error: " . $e->getMessage()]);
        }
    }
}
