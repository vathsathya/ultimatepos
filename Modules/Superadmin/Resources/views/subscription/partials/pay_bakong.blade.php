<div class="col-md-12 text-center" style="padding: 20px;">
    @if(!empty($khqr_string))
        <h4 class="tw-font-bold tw-text-xl tw-mb-4 text-primary">Scan with Bakong App</h4>

        <div
            style="background: white; padding: 15px; display: inline-block; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1);">
            {{-- We use a remote QR generator for maximum reliability, but you can also use DNS2D --}}
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($khqr_string) }}"
                alt="Bakong KHQR" style="width: 250px; height: 250px;">
        </div>

        <div class="tw-mt-4">
            <p class="tw-text-gray-600">Amount:
                <strong>{{ $system_currency->symbol }}{{ number_format($package_price_after_discount > 0 ? $package_price_after_discount : $package->price, 2) }}</strong>
            </p>
            <p class="tw-text-sm tw-text-gray-500">Account: {{ env('BAKONG_ACCOUNT_ID') }}</p>
        </div>

        <form
            action="{{ action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'confirm'], [$package->id]) }}"
            method="POST" id="bakong-payment-form">
            {{ csrf_field() }}
            <input type="hidden" name="gateway" value="{{ $v }}">
            <input type="hidden" name="price"
                value="{{ $package_price_after_discount > 0 ? $package_price_after_discount : $package->price }}">
            <input type="hidden" name="coupon_code" value="{{ request()->get('code') }}">
            <input type="hidden" name="payment_transaction_id" value="" id="bakong_transaction_id">

            <button type="button" class="btn btn-success tw-mt-4 btn-lg" id="verify-bakong-payment">
                <i class="fas fa-check-circle"></i> I have paid
            </button>
        </form>

        <p class="text-muted tw-mt-2 tw-text-xs">Once you scan and pay to the KHQR above, click "I have paid" to complete.
        </p>

        <script>
            document.getElementById('verify-bakong-payment').addEventListener('click', function () {
                var btn = this;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking transaction...';
                btn.disabled = true;

                var khqrString = "{{ $khqr_string }}";
                var md5Hash = "{{ md5($khqr_string) }}";
                
                $.ajax({
                    url: "{{ route('bakong.check') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        md5: md5Hash
                    },
                    success: function(response) {
                        if (response.success && response.data && response.data.responseCode == 0) {
                            var txId = response.data.data.hash || 'BAKONG-' + new Date().getTime();
                            document.getElementById('bakong_transaction_id').value = txId;
                            
                            toastr.success(response.msg || 'Payment successful!');
                            setTimeout(function() {
                                document.getElementById('bakong-payment-form').submit();
                            }, 1000);
                        } else {
                            toastr.error(response.msg || 'Payment pending. Try again later.');
                            btn.innerHTML = '<i class="fas fa-check-circle"></i> I have paid';
                            btn.disabled = false;
                        }
                    },
                    error: function() {
                        toastr.error('Could not verify transaction with Bakong server.');
                        btn.innerHTML = '<i class="fas fa-check-circle"></i> I have paid';
                        btn.disabled = false;
                    }
                });
            });
        </script>
    @else
        <div class="alert alert-danger">
            Bakong KHQR couldn't be generated. Please ensure BAKONG_ACCOUNT_ID is set correctly in Superadmin settings.
        </div>
    @endif
</div>