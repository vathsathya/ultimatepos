<div class="pos-tab-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="callout callout-info" style="margin-bottom:1.5rem;">
                <h4><i class="fa fa-info-circle"></i> How to get a Bot Token</h4>
                <ol style="margin:0;padding-left:1.2rem;line-height:2;">
                    <li>Open Telegram and search for <strong>@BotFather</strong></li>
                    <li>Send the command <code>/newbot</code> and follow the instructions</li>
                    <li>Copy the <strong>Bot Token</strong> that BotFather gives you and paste it below</li>
                    <li>The <strong>Bot Username</strong> is the <code>@username</code> of your bot (without the <code>@</code>)</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                {!! Form::label('TELEGRAM_BOT_TOKEN', __('superadmin::lang.telegram_bot_token') . ':') !!}
                @show_tooltip(__('superadmin::lang.telegram_bot_token_help'))
                {!! Form::text('TELEGRAM_BOT_TOKEN', $default_values['TELEGRAM_BOT_TOKEN'], [
                    'class'       => 'form-control',
                    'placeholder' => '123456789:AAbbCCddEEff...',
                    'id'          => 'TELEGRAM_BOT_TOKEN',
                ]); !!}
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                {!! Form::label('TELEGRAM_BOT_USERNAME', __('superadmin::lang.telegram_bot_username') . ':') !!}
                @show_tooltip(__('superadmin::lang.telegram_bot_username_help'))
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    {!! Form::text('TELEGRAM_BOT_USERNAME', $default_values['TELEGRAM_BOT_USERNAME'], [
                        'class'       => 'form-control',
                        'placeholder' => 'your_bot_name_bot',
                        'id'          => 'TELEGRAM_BOT_USERNAME',
                    ]); !!}
                </div>
                <p class="help-block" style="margin-top:.4rem;">@lang('superadmin::lang.telegram_bot_username_note')</p>
            </div>
        </div>
    </div>

    {{-- Live test button --}}
    <div class="row">
        <div class="col-xs-12">
            <button type="button" id="test_telegram_bot_btn"
                class="tw-dw-btn tw-bg-[#2AABEE] tw-text-white tw-font-bold tw-border-none"
                style="background:#2AABEE;color:#fff;border:none;font-weight:700;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;vertical-align:middle;margin-right:.3rem;"
                    viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z"/>
                </svg>
                @lang('superadmin::lang.telegram_test_bot')
            </button>
            <span id="test_telegram_result" style="margin-left:1rem;font-weight:600;"></span>
        </div>
    </div>
</div>
