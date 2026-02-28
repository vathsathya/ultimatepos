<div class="pos-tab-content">
    <div class="row">
        <div class="col-xs-12">
            <h4>Bakong / KHQR Payment Settings</h4>
            <hr>
        </div>

        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                {!! Form::label('BAKONG_APP_ID', 'Bakong App ID:') !!}
                {!! Form::text('BAKONG_APP_ID', env('BAKONG_APP_ID'), ['class' => 'form-control', 'placeholder' => 'Enter your Bakong App ID']) !!}
                <p class="help-block" style="margin-top:.4rem;">APP ID provided by your acquiring bank or Bakong portal.
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                {!! Form::label('BAKONG_TOKEN', 'Bakong Token / Secret Key:') !!}
                {!! Form::text('BAKONG_TOKEN', env('BAKONG_TOKEN'), ['class' => 'form-control', 'placeholder' => 'Enter your Token or Secret Key']) !!}
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('BAKONG_ACCOUNT_ID', 'Bakong Account ID (Merchant ID):') !!}
                {!! Form::text('BAKONG_ACCOUNT_ID', env('BAKONG_ACCOUNT_ID'), ['class' => 'form-control', 'placeholder' => 'e.g. dev_bakong@acleda']) !!}
                <p class="help-block" style="margin-top:.4rem;">The Merchant Account ID registered with Bakong. This is
                    the KHQR target account.</p>
            </div>
        </div>
    </div>
</div>