@extends('layouts.app')
@section('title', 'Telegram Notifications')

@section('content')
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black tw-flex tw-items-center tw-gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="tw-text-[#2AABEE]" style="width: 32px; height: 32px;"
                viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
            </svg>
            Telegram Notifications
        </h1>
    </section>

    <section class="content">
        @include('layouts.partials.error')

        <div class="tw-max-w-4xl tw-mx-auto tw-mt-4">

            {{-- ========== CONNECTED STATE ========== --}}
            @if(!empty($settings) && !empty($settings->telegram_chat_id))

                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-200 tw-overflow-hidden tw-mb-6">
                    <div class="tw-p-4 tw-border-b tw-border-gray-100 tw-bg-gray-50/50">
                        <h3 class="tw-m-0 tw-text-lg tw-font-semibold tw-text-gray-800 tw-flex tw-items-center tw-gap-2">
                            <i class="fa fa-check-circle tw-text-green-500"></i>
                            Connected Status
                        </h3>
                    </div>
                    <div class="tw-p-4">
                        {{-- Status banner --}}
                        <div
                            class="tw-bg-green-50 tw-border tw-border-green-200 tw-rounded-xl tw-p-5 tw-flex tw-items-center tw-gap-5 tw-mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-text-[#2AABEE] tw-flex-shrink-0"
                                style="width: 56px; height: 56px;" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                            </svg>
                            <div>
                                <h4 class="tw-text-green-800 tw-font-bold tw-text-lg tw-mb-1">✅ Successfully Connected</h4>
                                <p class="tw-text-green-700 tw-text-sm tw-mb-1">
                                    Target Chat ID: <code
                                        class="tw-bg-white tw-px-2 tw-py-1 tw-rounded-md tw-text-gray-700 tw-font-mono tw-shadow-sm">{{ $settings->telegram_chat_id }}</code>
                                </p>
                                <p class="tw-text-green-700 tw-text-sm">
                                    Your business is fully synchronized with Telegram for real-time notifications.
                                </p>
                            </div>
                        </div>

                        <div
                            class="tw-bg-gray-50 tw-border tw-border-gray-200 tw-rounded-xl tw-p-5 tw-flex tw-items-center tw-justify-between tw-mb-6 tw-mt-4">
                            <div>
                                <strong class="tw-text-gray-800 tw-text-base">🔔 Notify on Close Register</strong>
                                <p class="tw-text-gray-500 tw-text-sm tw-mt-1">Automatically send a Telegram message containing
                                    a sales summary when a cash register is closed.</p>
                            </div>
                            <div class="tw-flex tw-bg-gray-200 tw-rounded-lg tw-p-1 tw-shrink-0">
                                <a href="javascript:void(0)" onclick="submitNotify(1)"
                                    class="tw-px-4 tw-py-2 tw-text-sm tw-font-bold tw-rounded-md tw-transition-colors {{ !empty($settings->notify_on_close_register) ? 'tw-bg-green-500 tw-text-white tw-shadow-sm' : 'tw-text-gray-600 hover:tw-text-gray-800' }}">
                                    ON
                                </a>
                                <a href="javascript:void(0)" onclick="submitNotify(0)"
                                    class="tw-px-4 tw-py-2 tw-text-sm tw-font-bold tw-rounded-md tw-transition-colors {{ empty($settings->notify_on_close_register) ? 'tw-bg-red-500 tw-text-white tw-shadow-sm' : 'tw-text-gray-600 hover:tw-text-gray-800' }}">
                                    OFF
                                </a>
                            </div>
                        </div>

                        {{-- Hidden form for notify toggle submission --}}
                        <form action="{{ route('telegram-settings.store') }}" method="POST" id="notify_form" class="tw-hidden">
                            @csrf
                            <input type="hidden" name="notify_on_close_register" id="notify_value"
                                value="{{ !empty($settings->notify_on_close_register) ? '1' : '0' }}">
                        </form>

                        {{-- Disconnect --}}
                        <div class="tw-text-right tw-mt-4">
                            <form action="{{ route('telegram-settings.disconnect') }}" method="POST" id="disconnect_form"
                                class="tw-inline">
                                @csrf
                                <button type="submit"
                                    class="tw-inline-flex tw-items-center tw-gap-2 tw-px-4 tw-py-2 tw-border tw-border-red-200 tw-bg-white tw-text-red-500 hover:tw-bg-red-50 tw-rounded-lg tw-text-sm tw-font-bold tw-transition-colors">
                                    <i class="fa fa-unlink"></i> Disconnect Telegram
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                {{-- ========== NOT CONNECTED STATE ========== --}}
            @else
                <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-200 tw-overflow-hidden tw-mb-6"
                    id="connect_box">
                    <div class="tw-p-4 tw-border-b tw-border-gray-100 tw-bg-gray-50/50">
                        <h3 class="tw-m-0 tw-text-lg tw-font-semibold tw-text-gray-800 tw-flex tw-items-center tw-gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-text-[#2AABEE]" style="width: 20px; height: 20px;"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                            </svg>
                            Connect to Telegram
                        </h3>
                    </div>
                    <div class="tw-p-8">

                        {{-- Intro --}}
                        <div id="step_intro" class="tw-text-center tw-py-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-mx-auto tw-text-[#2AABEE] tw-mb-6"
                                style="width: 80px; height: 80px;" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                            </svg>
                            <h4 class="tw-text-2xl tw-font-bold tw-text-gray-900 tw-mb-3">Get Instant Insights on Telegram</h4>
                            <p class="tw-text-gray-500 tw-max-w-md tw-mx-auto tw-mb-8 tw-text-base">
                                Connect your business to our Telegram bot and receive instant notifications whenever a cash
                                register is closed. No technical setup required.
                            </p>
                            <button id="start_connect_btn"
                                class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-[#2AABEE] hover:tw-bg-[#2292cc] tw-text-white tw-font-bold tw-py-3 tw-px-8 tw-rounded-xl tw-shadow-md tw-transition-all hover:tw--translate-y-0.5">
                                <i class="fa fa-link"></i> Connect to Telegram
                            </button>
                        </div>

                        {{-- Step wizard --}}
                        <div id="step_wizard" class="tw-hidden tw-max-w-2xl tw-mx-auto">

                            {{-- Step indicators --}}
                            <div class="tw-flex tw-items-center tw-justify-center tw-mb-10">
                                <div id="ind_1" class="tw-flex tw-flex-col tw-items-center tw-w-24">
                                    <div id="ind_circle_1"
                                        class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-[#2AABEE] tw-text-white tw-flex tw-items-center tw-justify-center tw-font-bold tw-text-lg tw-shadow-sm tw-transition-colors">
                                        1</div>
                                    <span class="tw-text-xs tw-font-semibold tw-mt-2 tw-text-gray-700">Open Bot</span>
                                </div>
                                <div class="tw-h-1 tw-w-16 tw-bg-gray-200 tw-mx-2 tw-rounded-full"></div>
                                <div id="ind_2" class="tw-flex tw-flex-col tw-items-center tw-w-24">
                                    <div id="ind_circle_2"
                                        class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-gray-200 tw-text-gray-500 tw-flex tw-items-center tw-justify-center tw-font-bold tw-text-lg tw-transition-colors">
                                        2</div>
                                    <span id="ind_label_2" class="tw-text-xs tw-font-medium tw-mt-2 tw-text-gray-500">Click
                                        START</span>
                                </div>
                                <div class="tw-h-1 tw-w-16 tw-bg-gray-200 tw-mx-2 tw-rounded-full"></div>
                                <div id="ind_3" class="tw-flex tw-flex-col tw-items-center tw-w-24">
                                    <div id="ind_circle_3"
                                        class="tw-w-10 tw-h-10 tw-rounded-full tw-bg-gray-200 tw-text-gray-500 tw-flex tw-items-center tw-justify-center tw-font-bold tw-text-lg tw-transition-colors">
                                        3</div>
                                    <span id="ind_label_3"
                                        class="tw-text-xs tw-font-medium tw-mt-2 tw-text-gray-500">Confirm</span>
                                </div>
                            </div>

                            {{-- Step 1 --}}
                            <div id="step_1" class="tw-text-center">
                                <div class="tw-border-2 tw-border-[#2AABEE] tw-bg-[#f0f9ff] tw-rounded-2xl tw-p-8 tw-mb-6">
                                    <p class="tw-font-bold tw-text-gray-800 tw-mb-6 tw-text-lg">👇 Click below to open our bot
                                        on Telegram</p>
                                    <a id="open_bot_link" href="#" target="_blank"
                                        class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-[#2AABEE] hover:tw-bg-[#2292cc] tw-text-white tw-font-bold tw-py-3 tw-px-8 tw-rounded-xl tw-shadow-md tw-transition-all hover:tw--translate-y-0.5 tw-text-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px;"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                                        </svg>
                                        Open Telegram Bot
                                    </a>
                                    <p class="tw-mt-4 tw-text-sm tw-text-gray-500">
                                        Or search <strong id="bot_username_label" class="tw-text-gray-700"></strong> in Telegram
                                    </p>
                                </div>
                                <div class="tw-mb-6">
                                    <span
                                        class="tw-inline-flex tw-items-center tw-gap-1.5 tw-bg-blue-50 tw-text-blue-700 tw-px-4 tw-py-1.5 tw-rounded-full tw-text-sm tw-font-medium tw-border tw-border-blue-100">
                                        <i class="fa fa-clock-o"></i> Link expires in <strong id="countdown_timer"
                                            class="tw-font-mono tw-text-base">10:00</strong>
                                    </span>
                                </div>
                                <button id="next_to_step2"
                                    class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-indigo-600 hover:tw-bg-indigo-700 tw-text-white tw-font-bold tw-py-2.5 tw-px-6 tw-rounded-lg tw-shadow-sm tw-transition-colors">
                                    I've opened Telegram <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>

                            {{-- Step 2 --}}
                            <div id="step_2" class="tw-hidden tw-text-center">
                                <div class="tw-border-2 tw-border-gray-200 tw-bg-gray-50 tw-rounded-2xl tw-p-8 tw-mb-6">
                                    <div class="tw-text-5xl tw-mb-4">👆</div>
                                    <p class="tw-font-bold tw-text-gray-800 tw-text-xl tw-mb-3">
                                        In Telegram, click the <span
                                            class="tw-bg-green-100 tw-text-green-700 tw-px-2 tw-py-1 tw-rounded tw-text-sm">START</span>
                                        button
                                    </p>
                                    <p class="tw-text-gray-500 tw-text-base">
                                        The bot will send you a welcome message.<br>
                                        Come back here once you have done that.
                                    </p>
                                </div>
                                <div class="tw-flex tw-items-center tw-justify-center tw-gap-4">
                                    <button id="back_to_step1"
                                        class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-white tw-border tw-border-gray-300 tw-text-gray-700 hover:tw-bg-gray-50 tw-font-bold tw-py-3 tw-px-6 tw-rounded-xl tw-shadow-sm tw-transition-colors">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </button>
                                    <button id="next_to_step3"
                                        class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-green-500 hover:tw-bg-green-600 tw-text-white tw-font-bold tw-py-3 tw-px-8 tw-rounded-xl tw-shadow-md tw-transition-all hover:tw--translate-y-0.5">
                                        <i class="fa fa-check"></i> I've clicked START
                                    </button>
                                </div>
                            </div>

                            {{-- Step 3 --}}
                            <div id="step_3" class="tw-hidden tw-text-center">
                                <div id="verify_pending"
                                    class="tw-border-2 tw-border-teal-200 tw-bg-teal-50 tw-rounded-2xl tw-p-8 tw-mb-6">
                                    <div class="tw-text-4xl tw-text-teal-500 tw-mb-4"><i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                    <h4 class="tw-font-bold tw-text-gray-900 tw-text-xl tw-mb-2">Verifying your connection...
                                    </h4>
                                    <p class="tw-text-gray-600 tw-text-base">Checking if Telegram received your START. This
                                        takes just a moment.</p>
                                </div>
                                <div id="verify_error"
                                    class="tw-hidden tw-bg-amber-50 tw-border tw-border-amber-200 tw-rounded-2xl tw-p-8 tw-mb-6">
                                    <div class="tw-text-4xl tw-text-amber-500 tw-mb-4"><i
                                            class="fa fa-exclamation-triangle"></i></div>
                                    <p id="verify_error_msg" class="tw-font-bold tw-text-gray-800 tw-text-lg tw-mb-6">Not found
                                        yet.</p>
                                    <div class="tw-flex tw-justify-center tw-gap-4">
                                        <button id="retry_verify_btn"
                                            class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-indigo-600 hover:tw-bg-indigo-700 tw-text-white tw-font-bold tw-py-2.5 tw-px-6 tw-rounded-lg tw-shadow-sm tw-transition-colors">
                                            <i class="fa fa-refresh"></i> Try Again
                                        </button>
                                        <button id="back_to_step2"
                                            class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-white tw-border tw-border-gray-300 tw-text-gray-700 hover:tw-bg-gray-50 tw-font-bold tw-py-2.5 tw-px-6 tw-rounded-lg tw-shadow-sm tw-transition-colors">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /step_wizard --}}
                    </div>
                </div>
            @endif

            {{-- Help box --}}
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-200 tw-overflow-hidden tw-mt-4">
                <div
                    class="tw-p-4 tw-border-b tw-border-gray-100 tw-bg-gray-50/50 tw-flex tw-items-center tw-justify-between">
                    <h3 class="tw-m-0 tw-text-lg tw-font-semibold tw-text-gray-800 tw-flex tw-items-center tw-gap-2">
                        <i class="fa fa-lightbulb-o tw-text-yellow-500"></i> How it Works
                    </h3>
                </div>
                <div class="tw-p-4">
                    <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-8 tw-mb-8">
                        <div class="tw-text-center">
                            <div class="tw-text-4xl tw-mb-3 tw-text-indigo-500"><i class="fas fa-cash-register"></i></div>
                            <strong class="tw-block tw-text-gray-800 tw-text-lg tw-mb-2">Register Closed</strong>
                            <p class="tw-text-gray-500 tw-text-sm">Triggered whenever staff closes a cash register shift.
                            </p>
                        </div>
                        <div class="tw-text-center">
                            <div class="tw-text-4xl tw-mb-3 tw-text-yellow-500"><i class="fas fa-bolt"></i></div>
                            <strong class="tw-block tw-text-gray-800 tw-text-lg tw-mb-2">Instant Delivery</strong>
                            <p class="tw-text-gray-500 tw-text-sm">The summary report is pushed instantly to your phone.</p>
                        </div>
                        <div class="tw-text-center">
                            <div class="tw-text-4xl tw-mb-3 tw-text-green-500"><i class="fas fa-shield-alt"></i></div>
                            <strong class="tw-block tw-text-gray-800 tw-text-lg tw-mb-2">Per-Business Secure</strong>
                            <p class="tw-text-gray-500 tw-text-sm">Isolated, secure chat streams per business branch.</p>
                        </div>
                    </div>

                    <div class="tw-bg-gray-50 tw-rounded-xl tw-p-5 tw-border tw-border-gray-200">
                        <strong class="tw-text-gray-700 tw-text-sm tw-block tw-mb-3 tw-uppercase tw-tracking-wider">Example
                            Summary Snippet</strong>
                        <div
                            class="tw-bg-white tw-border-l-4 tw-border-[#2AABEE] tw-rounded tw-p-4 tw-font-sans tw-text-sm tw-text-gray-700 tw-shadow-sm tw-leading-relaxed">
                            🏪 <span class="tw-font-bold tw-text-black">Register Closed</span><br>
                            📅 Date: <span class="tw-font-bold tw-text-black">30-12-2026 05:00 PM</span><br>
                            📍 Location: <span class="tw-font-bold tw-text-black">Main Branch</span><br>
                            👤 Closed By: <span class="tw-font-bold tw-text-black">John Doe</span><br>
                            <span class="tw-text-gray-400">──────────────</span><br>
                            <br>
                            <span class="tw-font-mono">📦 Products Sold:<br>
                                ▪️ cafe (0002)<br>
                                &nbsp;&nbsp;&nbsp;Qty: 16.00 &nbsp;|&nbsp; $ 40.00<br>
                                ▪️ cafe late (0003)<br>
                                &nbsp;&nbsp;&nbsp;Qty: 5.00 &nbsp;&nbsp;|&nbsp; $ 9.40<br>
                                Total Items: 21.00<br>
                                Subtotal: $ 49.40<br>
                                <span class="tw-text-gray-400">──────────────</span></span><br>
                            <br>
                            <span class="tw-font-bold tw-text-black">📊 Summary:</span><br>
                            <span class="tw-font-mono">
                                Total Sales:&nbsp;&nbsp;&nbsp;<span class="tw-font-bold tw-text-black">$ 49.40</span><br>
                                Total Refund:&nbsp;&nbsp;<span class="tw-font-bold tw-text-black">$ &nbsp;0.00</span><br>
                                Total Payment:&nbsp;<span class="tw-font-bold tw-text-black">$ 49.40</span><br>
                                Credit Sales:&nbsp;&nbsp;<span class="tw-font-bold tw-text-black">$ &nbsp;0.00</span><br>
                                Total Expense:&nbsp;<span class="tw-font-bold tw-text-black">$ &nbsp;0.00</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var GENERATE_URL = '{{ route("telegram-settings.generate-token") }}';
            var VERIFY_URL = '{{ route("telegram-settings.verify") }}';

            var countdownInterval = null;
            var verifyInterval = null;
            var secondsLeft = 600;

            // ── CONNECT button ────────────────────────────────────────────────
            $('#start_connect_btn').on('click', function () {
                var $btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Generating link...');

                $.ajax({
                    url: GENERATE_URL,
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    data: {},
                    dataType: 'json',
                    success: function (r) {
                        if (!r.success) {
                            toastr.error(r.msg || 'Failed to generate link.');
                            $btn.prop('disabled', false).html('<i class="fa fa-link"></i>&nbsp; Connect to Telegram');
                            return;
                        }
                        var deepLink = 'https://t.me/' + r.bot_username + '?start=' + r.token;
                        $('#open_bot_link').attr('href', deepLink);
                        $('#bot_username_label').text('@' + r.bot_username);
                        $('#step_intro').hide();
                        $('#step_wizard').show();
                        showStep(1);
                        startCountdown(r.expires_in);
                    },
                    error: function () {
                        toastr.error('Could not reach server.');
                        $btn.prop('disabled', false).html('<i class="fa fa-link"></i>&nbsp; Connect to Telegram');
                    }
                });
            });

            // ── Step navigation ───────────────────────────────────────────────
            $('#next_to_step2').on('click', function () { showStep(2); });
            $('#back_to_step1').on('click', function () { showStep(1); });
            $('#next_to_step3').on('click', function () {
                showStep(3);
                $('#verify_pending').show();
                $('#verify_error').hide();
                startVerifying();
            });
            $('#back_to_step2').on('click', function () { stopVerifying(); showStep(2); });
            $('#retry_verify_btn').on('click', function () {
                $('#verify_pending').show();
                $('#verify_error').hide();
                startVerifying();
            });

            function showStep(n) {
                $('#step_1, #step_2, #step_3').hide();
                $('#step_' + n).show();
                for (var i = 1; i <= 3; i++) {
                    var $c = $('#ind_circle_' + i);
                    if (i <= n) {
                        $c.css({ background: '#2AABEE', color: '#fff' });
                    } else {
                        $c.css({ background: '#ddd', color: '#999' });
                    }
                }
            }

            // ── Countdown timer ───────────────────────────────────────────────
            function startCountdown(seconds) {
                secondsLeft = seconds;
                clearInterval(countdownInterval);
                countdownInterval = setInterval(function () {
                    secondsLeft--;
                    if (secondsLeft <= 0) {
                        clearInterval(countdownInterval);
                        $('#countdown_timer').text('00:00').css('color', 'red');
                        toastr.warning('Link expired — please start again.');
                        return;
                    }
                    var m = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
                    var s = String(secondsLeft % 60).padStart(2, '0');
                    $('#countdown_timer').text(m + ':' + s);
                }, 1000);
            }

            // ── Verify polling ────────────────────────────────────────────────
            function startVerifying() {
                stopVerifying();
                doVerify();
                verifyInterval = setInterval(doVerify, 4000);
            }
            function stopVerifying() { clearInterval(verifyInterval); verifyInterval = null; }

            function doVerify() {
                $.ajax({
                    url: VERIFY_URL,
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    dataType: 'json',
                    success: function (r) {
                        if (r.success) {
                            stopVerifying();
                            clearInterval(countdownInterval);
                            toastr.success(r.msg || 'Connected!');
                            setTimeout(function () { location.reload(); }, 1500);
                        } else {
                            $('#verify_pending').hide();
                            $('#verify_error').show();
                            $('#verify_error_msg').text(r.msg);
                            if (r.expired) stopVerifying();
                        }
                    },
                    error: function () {
                        $('#verify_pending').hide();
                        $('#verify_error').show();
                        $('#verify_error_msg').text('Server error. Please retry.');
                    }
                });
            }

        });

        // Global helper for the notify toggle (called via onclick - outside ready)
        function submitNotify(val) {
            $('#notify_value').val(val);
            $('#notify_form').submit();
        }
    </script>
@endsection