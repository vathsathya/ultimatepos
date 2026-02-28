<div class="payment_details_div @if($payment_line['method'] !== 'card') {{ 'hide' }} @endif" data-type="card">
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label("card_number_$row_index", __('lang_v1.card_no')) !!}
			{!! Form::text("payment[$row_index][card_number]", $payment_line['card_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.card_no'), 'id' => "card_number_$row_index"]) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label("card_holder_name_$row_index", __('lang_v1.card_holder_name')) !!}
			{!! Form::text("payment[$row_index][card_holder_name]", $payment_line['card_holder_name'], ['class' => 'form-control', 'placeholder' => __('lang_v1.card_holder_name'), 'id' => "card_holder_name_$row_index"]) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label("card_transaction_number_$row_index", __('lang_v1.card_transaction_no')) !!}
			{!! Form::text("payment[$row_index][card_transaction_number]", $payment_line['card_transaction_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.card_transaction_no'), 'id' => "card_transaction_number_$row_index"]) !!}
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label("card_type_$row_index", __('lang_v1.card_type')) !!}
			{!! Form::select("payment[$row_index][card_type]", ['credit' => 'Credit Card', 'debit' => 'Debit Card', 'visa' => 'Visa', 'master' => 'MasterCard'], $payment_line['card_type'], ['class' => 'form-control', 'id' => "card_type_$row_index"]) !!}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label("card_month_$row_index", __('lang_v1.month')) !!}
			{!! Form::text("payment[$row_index][card_month]", $payment_line['card_month'], [
	'class' => 'form-control',
	'placeholder' => __('lang_v1.month'),
	'id' => "card_month_$row_index"
]) !!}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label("card_year_$row_index", __('lang_v1.year')) !!}
			{!! Form::text("payment[$row_index][card_year]", $payment_line['card_year'], ['class' => 'form-control', 'placeholder' => __('lang_v1.year'), 'id' => "card_year_$row_index"]) !!}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			{!! Form::label("card_security_$row_index", __('lang_v1.security_code')) !!}
			{!! Form::text("payment[$row_index][card_security]", $payment_line['card_security'], ['class' => 'form-control', 'placeholder' => __('lang_v1.security_code'), 'id' => "card_security_$row_index"]) !!}
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="payment_details_div @if($payment_line['method'] !== 'cheque') {{ 'hide' }} @endif" data-type="cheque">
	<div class="col-md-12">
		<div class="form-group">
			{!! Form::label("cheque_number_$row_index", __('lang_v1.cheque_no')) !!}
			{!! Form::text("payment[$row_index][cheque_number]", $payment_line['cheque_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.cheque_no'), 'id' => "cheque_number_$row_index"]) !!}
		</div>
	</div>
</div>
<div class="payment_details_div @if($payment_line['method'] !== 'bank_transfer') {{ 'hide' }} @endif"
	data-type="bank_transfer">
	<div class="col-md-12">
		<div class="form-group">
			{!! Form::label("bank_account_number_$row_index", __('lang_v1.bank_account_number')) !!}
			{!! Form::text("payment[$row_index][bank_account_number]", $payment_line['bank_account_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.bank_account_number'), 'id' => "bank_account_number_$row_index"]) !!}
		</div>
	</div>
</div>

@for ($i = 1; $i < 8; $i++)
	<div class="payment_details_div @if($payment_line['method'] !== 'custom_pay_' . $i) {{ 'hide' }} @endif"
		data-type="custom_pay_{{$i}}">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label("transaction_no_{$i}_{$row_index}", __('lang_v1.transaction_no')) !!}
				{!! Form::text("payment[$row_index][transaction_no_{$i}]", $payment_line['transaction_no'], ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no'), 'id' => "transaction_no_{$i}_{$row_index}"]) !!}
			</div>
		</div>
	</div>
@endfor

<div class="payment_details_div @if($payment_line['method'] !== 'bakong') {{ 'hide' }} @endif" data-type="bakong">
	<div class="col-md-12 text-center bakong_qr_section" id="bakong_qr_section_{{$row_index}}">
		<button type="button" class="btn btn-primary"
			onclick="generateBakongQr(this, '{{$row_index}}')">@lang('lang_v1.generate_khqr')</button>
		<div class="bakong_qr_container" style="display:none; padding: 15px;">
			<img src="" class="bakong_qr_img" style="width: 250px; height: 250px;" />
			<p class="text-muted mt-2">@lang('lang_v1.scan_with_bakong_app')</p>
			<button type="button" class="btn btn-success" onclick="checkBakongPayment(this, '{{$row_index}}')"
				data-md5="">@lang('lang_v1.check_payment_status')</button>
			<input type="hidden" name="payment[{{$row_index}}][transaction_no]" class="bakong_transaction_id" value="">
		</div>
	</div>
</div>

<script type="text/javascript">
	if (typeof window.generateBakongQr === 'undefined') {
		window.generateBakongQr = function (btn, row_index) {
			var btn_el = $(btn);
			var amount_el = $('#amount_' + row_index);

			if (!amount_el.length) {
				toastr.error('Amount field not found for row ' + row_index);
				return;
			}

			// try to use pos __read_number or fallback
			var amount = 0;
			if (typeof __read_number === 'function') {
				amount = __read_number(amount_el);
			} else {
				amount = amount_el.val() ? parseFloat(amount_el.val().toString().replace(/,/g, '')) : 0;
			}

			if (amount <= 0) {
				toastr.error('Please enter a valid amount');
				return;
			}

			btn_el.text('Generating...').attr('disabled', true);

			$.ajax({
				url: '/bakong/generate-qr',
				type: 'POST',
				data: { amount: amount },
				success: function (res) {
					btn_el.text('Generate KHQR').attr('disabled', false);
					if (res.success) {
						var container = $('#bakong_qr_section_' + row_index).find('.bakong_qr_container');
						container.find('.bakong_qr_img').attr('src', res.qr_url);
						container.find('.btn-success').attr('data-md5', res.md5);
						btn_el.hide();
						container.show();
					} else {
						toastr.error(res.msg);
					}
				},
				error: function () {
					btn_el.text('Generate KHQR').attr('disabled', false);
					toastr.error('Error generating QR!');
				}
			});
		};

		window.checkBakongPayment = function (btn, row_index) {
			var btn_el = $(btn);
			var md5 = btn_el.attr('data-md5');

			btn_el.text('Checking...').attr('disabled', true);

			$.ajax({
				url: '/bakong/check-payment',
				type: 'POST',
				data: { md5: md5 },
				success: function (res) {
					btn_el.text('Check Payment Status').attr('disabled', false);
					if (res.success) {
						toastr.success(res.msg);
						$('#bakong_qr_section_' + row_index).find('.bakong_transaction_id').val(res.transaction_id);
					} else {
						toastr.error(res.msg);
					}
				},
				error: function () {
					btn_el.text('Check Payment Status').attr('disabled', false);
					toastr.error('Error verifying payment!');
				}
			});
		};
	}
</script>