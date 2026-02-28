@extends('layouts.app')
@section('title', 'Telegram Notifications')

@section('css')
    <style>
        /* ── Telegram theme colours ─────────────────────────────── */
        :root {
            --tg-blue: #2AABEE;
            --tg-blue-dk: #1d93d2;
            --tg-blue-lt: #e8f6fd;
        }

        /* ── Card shell ─────────────────────────────────────────── */
        .tg-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .07);
            border: 1px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .tg-card-head {
            padding: .85rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            background: #f9fafb;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .tg-card-head h3 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 600;
            color: #1f2937;
        }

        .tg-card-body {
            padding: 1.5rem;
        }

        .tg-card-body-lg {
            padding: 2rem;
        }

        /* ── Primary CTA button ─────────────────────────────────── */
        .btn-telegram {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: var(--tg-blue);
            color: #fff !important;
            font-weight: 700;
            font-size: 1rem;
            padding: .75rem 2rem;
            border-radius: .75rem;
            border: none;
            box-shadow: 0 4px 14px rgba(42, 171, 238, .35);
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            text-decoration: none;
        }

        .btn-telegram:hover,
        .btn-telegram:focus {
            background: var(--tg-blue-dk);
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(42, 171, 238, .45);
            text-decoration: none;
        }

        .btn-telegram:active {
            transform: translateY(0);
        }

        .btn-telegram:disabled,
        .btn-telegram[disabled] {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        /* ── Secondary nav button ───────────────────────────────── */
        .btn-outline-nav {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: #fff;
            color: #374151;
            font-weight: 700;
            font-size: .9rem;
            padding: .65rem 1.4rem;
            border-radius: .75rem;
            border: 1px solid #d1d5db;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-outline-nav:hover {
            background: #f9fafb;
        }

        .btn-indigo {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: #4f46e5;
            color: #fff !important;
            font-weight: 700;
            font-size: .9rem;
            padding: .65rem 1.4rem;
            border-radius: .6rem;
            border: none;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-indigo:hover {
            background: #4338ca;
        }

        .btn-green {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: #16a34a;
            color: #fff !important;
            font-weight: 700;
            font-size: .9rem;
            padding: .65rem 1.75rem;
            border-radius: .75rem;
            border: none;
            box-shadow: 0 4px 10px rgba(22, 163, 74, .25);
            cursor: pointer;
            transition: background .2s, transform .15s;
        }

        .btn-green:hover {
            background: #15803d;
            transform: translateY(-1px);
        }

        /* ── Status banner ──────────────────────────────────────── */
        .tg-status-ok {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: .75rem;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .tg-status-ok h4 {
            color: #166534;
            font-weight: 700;
            margin: 0 0 .25rem;
        }

        .tg-status-ok p {
            color: #15803d;
            font-size: .875rem;
            margin: 0 0 .2rem;
        }

        /* ── Toggle pill ────────────────────────────────────────── */
        .tg-toggle {
            display: flex;
            background: #e5e7eb;
            border-radius: .5rem;
            padding: .25rem;
            flex-shrink: 0;
        }

        .tg-toggle a {
            padding: .45rem 1rem;
            font-size: .85rem;
            font-weight: 700;
            border-radius: .35rem;
            text-decoration: none;
            transition: background .15s, color .15s;
            color: #6b7280;
        }

        .tg-toggle a:hover {
            color: #111827;
            text-decoration: none;
        }

        .tg-toggle a.active-on {
            background: #16a34a;
            color: #fff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        }

        .tg-toggle a.active-off {
            background: #ef4444;
            color: #fff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        }

        /* ── Intro icon box ─────────────────────────────────────── */
        .tg-intro {
            text-align: center;
            padding: 2.5rem 1rem;
        }

        .tg-intro h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin: .5rem 0 .75rem;
        }

        .tg-intro p {
            color: #6b7280;
            max-width: 32rem;
            margin: 0 auto 2rem;
            font-size: .95rem;
        }

        /* ── Step wizard ────────────────────────────────────────── */
        .tg-step-indicators {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2.5rem;
            gap: .5rem;
        }

        .tg-ind {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 6rem;
        }

        .tg-ind-circle {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: #e5e7eb;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            transition: background .25s, color .25s;
        }

        .tg-ind-circle.active {
            background: var(--tg-blue);
            color: #fff;
            box-shadow: 0 2px 8px rgba(42, 171, 238, .4);
        }

        .tg-ind span {
            font-size: .72rem;
            font-weight: 500;
            margin-top: .35rem;
            color: #6b7280;
        }

        .tg-ind-line {
            height: 3px;
            width: 4rem;
            background: #e5e7eb;
            border-radius: 99px;
        }

        .tg-step-box {
            border: 2px solid var(--tg-blue);
            background: var(--tg-blue-lt);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .tg-step-box-gray {
            border: 2px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .tg-step-box-teal {
            border: 2px solid #99f6e4;
            background: #f0fdfa;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .tg-step-box-amber {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* ── Countdown badge ────────────────────────────────────── */
        .tg-countdown {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: #eff6ff;
            color: #1d4ed8;
            padding: .35rem 1rem;
            border-radius: 99px;
            font-size: .85rem;
            font-weight: 500;
            border: 1px solid #dbeafe;
            margin-bottom: 1.25rem;
        }

        .tg-countdown strong {
            font-family: monospace;
            font-size: 1rem;
        }

        /* ── Disconnect btn ─────────────────────────────────────── */
        .btn-disconnect {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .5rem 1rem;
            border: 1px solid #fca5a5;
            background: #fff;
            color: #ef4444;
            border-radius: .5rem;
            font-weight: 700;
            font-size: .85rem;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-disconnect:hover {
            background: #fef2f2;
        }

        /* ── How it works ───────────────────────────────────────── */
        .tg-how-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media(min-width:768px) {
            .tg-how-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .tg-how-item {
            text-align: center;
        }

        .tg-how-item .icon {
            font-size: 2.5rem;
            margin-bottom: .75rem;
        }

        .tg-how-item strong {
            display: block;
            font-size: 1rem;
            color: #1f2937;
            margin-bottom: .35rem;
        }

        .tg-how-item p {
            font-size: .875rem;
            color: #6b7280;
            margin: 0;
        }

        /* ── Example snippet ────────────────────────────────────── */
        .tg-snippet {
            background: #fff;
            border-left: 4px solid var(--tg-blue);
            border-radius: .35rem;
            padding: 1rem;
            font-size: .875rem;
            color: #374151;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .07);
            line-height: 1.75;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black tw-flex tw-items-center tw-gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;color:var(--tg-blue)" viewBox="0 0 24 24"
                fill="currentColor">
                <path
                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
            </svg>
            Telegram Notifications
        </h1>
    </section>

    <section class="content">
        @include('layouts.partials.error')

        <div style="max-width:880px;margin:1.5rem auto;">

            {{-- ========== CONNECTED STATE ========== --}}
            @if(!empty($settings) && !empty($settings->telegram_chat_id))

                <div class="tg-card">
                    <div class="tg-card-head">
                        <i class="fa fa-check-circle" style="color:#16a34a;"></i>
                        <h3>Connected Status</h3>
                    </div>
                    <div class="tg-card-body">

                        {{-- Status banner --}}
                        <div class="tg-status-ok">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                style="width:52px;height:52px;color:var(--tg-blue);flex-shrink:0" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                            </svg>
                            <div>
                                <h4>✅ Successfully Connected</h4>
                                <p>Target Chat ID:
                                    <code
                                        style="background:#f3f4f6;padding:.15rem .5rem;border-radius:.3rem;font-family:monospace;color:#374151;">
                                                {{ $settings->telegram_chat_id }}
                                            </code>
                                </p>
                                <p>Your business is fully synchronized with Telegram for real-time notifications.</p>
                            </div>
                        </div>

                        {{-- Notify toggle --}}
                        <div
                            style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:.75rem;padding:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;">
                            <div>
                                <strong style="color:#1f2937;font-size:.95rem;">🔔 Notify on Close Register</strong>
                                <p style="color:#6b7280;font-size:.85rem;margin:.25rem 0 0;">
                                    Automatically send a Telegram message containing a sales summary when a cash register is
                                    closed.
                                </p>
                            </div>
                            <div class="tg-toggle">
                                <a href="javascript:void(0)" onclick="submitNotify(1)"
                                    class="{{ !empty($settings->notify_on_close_register) ? 'active-on' : '' }}">
                                    ON
                                </a>
                                <a href="javascript:void(0)" onclick="submitNotify(0)"
                                    class="{{ empty($settings->notify_on_close_register) ? 'active-off' : '' }}">
                                    OFF
                                </a>
                            </div>
                        </div>

                        {{-- Hidden form for notify toggle --}}
                        <form action="{{ route('telegram-settings.store') }}" method="POST" id="notify_form"
                            style="display:none;">
                            @csrf
                            <input type="hidden" name="notify_on_close_register" id="notify_value"
                                value="{{ !empty($settings->notify_on_close_register) ? '1' : '0' }}">
                        </form>

                        {{-- Disconnect --}}
                        <div style="text-align:right;margin-top:1rem;">
                            <form action="{{ route('telegram-settings.disconnect') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-disconnect">
                                    <i class="fa fa-unlink"></i> Disconnect Telegram
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                {{-- ========== NOT CONNECTED STATE ========== --}}
            @else
                <div class="tg-card" id="connect_box">
                    <div class="tg-card-head">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:20px;height:20px;color:var(--tg-blue)"
                            viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                        </svg>
                        <h3>Connect to Telegram</h3>
                    </div>
                    <div class="tg-card-body-lg">

                        {{-- Intro screen --}}
                        <div id="step_intro" class="tg-intro">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                style="width:88px;height:88px;color:var(--tg-blue);margin:0 auto 1.25rem;display:block;"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                            </svg>
                            <h4>Get Instant Insights on Telegram</h4>
                            <p>Connect your business to our Telegram bot and receive instant notifications whenever a cash
                                register is closed. No technical setup required.</p>

                            {{-- ★ THE CONNECT BUTTON ─ fully inline-styled so it ALWAYS renders ★ --}}
                            <button id="start_connect_btn" type="button" class="btn-telegram">
                                <i class="fa fa-link"></i> Connect to Telegram
                            </button>
                        </div>

                        {{-- Step wizard --}}
                        <div id="step_wizard" style="display:none;max-width:640px;margin:0 auto;">

                            {{-- Step indicators --}}
                            <div class="tg-step-indicators">
                                <div class="tg-ind" id="ind_1">
                                    <div class="tg-ind-circle active" id="ind_circle_1">1</div>
                                    <span>Open Bot</span>
                                </div>
                                <div class="tg-ind-line"></div>
                                <div class="tg-ind" id="ind_2">
                                    <div class="tg-ind-circle" id="ind_circle_2">2</div>
                                    <span id="ind_label_2">Click START</span>
                                </div>
                                <div class="tg-ind-line"></div>
                                <div class="tg-ind" id="ind_3">
                                    <div class="tg-ind-circle" id="ind_circle_3">3</div>
                                    <span id="ind_label_3">Confirm</span>
                                </div>
                            </div>

                            {{-- Step 1 --}}
                            <div id="step_1" style="text-align:center;">
                                <div class="tg-step-box">
                                    <p style="font-weight:700;color:#1f2937;margin-bottom:1.25rem;font-size:1rem;">
                                        👇 Click below to open our bot on Telegram
                                    </p>
                                    <a id="open_bot_link" href="#" target="_blank" class="btn-telegram"
                                        style="font-size:1.05rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:22px;height:22px;"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z" />
                                        </svg>
                                        Open Telegram Bot
                                    </a>
                                    <p style="margin-top:.85rem;font-size:.85rem;color:#6b7280;">
                                        Or search <strong id="bot_username_label" style="color:#374151;"></strong> in Telegram
                                    </p>
                                </div>
                                <div style="margin-bottom:1.25rem;">
                                    <span class="tg-countdown">
                                        <i class="fa fa-clock-o"></i> Link expires in
                                        <strong id="countdown_timer">10:00</strong>
                                    </span>
                                </div>
                                <button id="next_to_step2" type="button" class="btn-indigo">
                                    I've opened Telegram <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>

                            {{-- Step 2 --}}
                            <div id="step_2" style="display:none;text-align:center;">
                                <div class="tg-step-box-gray">
                                    <div style="font-size:3rem;margin-bottom:1rem;">👆</div>
                                    <p style="font-weight:700;color:#1f2937;font-size:1.15rem;margin-bottom:.75rem;">
                                        In Telegram, click the
                                        <span
                                            style="background:#dcfce7;color:#166534;padding:.15rem .5rem;border-radius:.25rem;font-size:.9rem;">START</span>
                                        button
                                    </p>
                                    <p style="color:#6b7280;font-size:.95rem;">
                                        The bot will send you a welcome message.<br>
                                        Come back here once you have done that.
                                    </p>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap;">
                                    <button id="back_to_step1" type="button" class="btn-outline-nav">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </button>
                                    <button id="next_to_step3" type="button" class="btn-green">
                                        <i class="fa fa-check"></i> I've clicked START
                                    </button>
                                </div>
                            </div>

                            {{-- Step 3 --}}
                            <div id="step_3" style="display:none;text-align:center;">
                                <div id="verify_pending" class="tg-step-box-teal">
                                    <div style="font-size:2.5rem;color:#0d9488;margin-bottom:1rem;">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                    <h4 style="font-weight:700;color:#1f2937;font-size:1.15rem;margin-bottom:.5rem;">
                                        Verifying your connection...
                                    </h4>
                                    <p style="color:#374151;">
                                        Checking if Telegram received your START. This takes just a moment.
                                    </p>
                                </div>
                                <div id="verify_error" class="tg-step-box-amber" style="display:none;">
                                    <div style="font-size:2.5rem;color:#d97706;margin-bottom:1rem;">
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </div>
                                    <p id="verify_error_msg"
                                        style="font-weight:700;color:#1f2937;font-size:1.05rem;margin-bottom:1.25rem;">
                                        Not found yet.
                                    </p>
                                    <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                                        <button id="retry_verify_btn" type="button" class="btn-indigo">
                                            <i class="fa fa-refresh"></i> Try Again
                                        </button>
                                        <button id="back_to_step2" type="button" class="btn-outline-nav">
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
            <div class="tg-card">
                <div class="tg-card-head">
                    <i class="fa fa-lightbulb-o" style="color:#eab308;"></i>
                    <h3>How it Works</h3>
                </div>
                <div class="tg-card-body">
                    <div class="tg-how-grid">
                        <div class="tg-how-item">
                            <div class="icon" style="color:#6366f1;"><i class="fas fa-cash-register"></i></div>
                            <strong>Register Closed</strong>
                            <p>Triggered whenever staff closes a cash register shift.</p>
                        </div>
                        <div class="tg-how-item">
                            <div class="icon" style="color:#eab308;"><i class="fas fa-bolt"></i></div>
                            <strong>Instant Delivery</strong>
                            <p>The summary report is pushed instantly to your phone.</p>
                        </div>
                        <div class="tg-how-item">
                            <div class="icon" style="color:#16a34a;"><i class="fas fa-shield-alt"></i></div>
                            <strong>Per-Business Secure</strong>
                            <p>Isolated, secure chat streams per business branch.</p>
                        </div>
                    </div>

                    <div style="background:#f9fafb;border-radius:.75rem;padding:1.25rem;border:1px solid #e5e7eb;">
                        <strong
                            style="color:#4b5563;font-size:.8rem;display:block;margin-bottom:.75rem;text-transform:uppercase;letter-spacing:.05em;">
                            Example Summary Snippet
                        </strong>
                        <div class="tg-snippet">
                            🏪 <strong>Register Closed</strong><br>
                            📅 Date: <strong>30-12-2026 05:00 PM</strong><br>
                            📍 Location: <strong>Main Branch</strong><br>
                            👤 Closed By: <strong>John Doe</strong><br>
                            <span style="color:#9ca3af;">──────────────</span><br><br>
                            <span style="font-family:monospace;">📦 Products Sold:<br>
                                ▪️ cafe (0002)<br>
                                &nbsp;&nbsp;&nbsp;Qty: 16.00 &nbsp;|&nbsp; $ 40.00<br>
                                ▪️ cafe late (0003)<br>
                                &nbsp;&nbsp;&nbsp;Qty: 5.00 &nbsp;&nbsp;|&nbsp; $ 9.40<br>
                                Total Items: 21.00<br>
                                Subtotal: $ 49.40<br>
                                <span style="color:#9ca3af;">──────────────</span>
                            </span><br><br>
                            <strong>📊 Summary:</strong><br>
                            <span style="font-family:monospace;">
                                Total Sales:&nbsp;&nbsp;&nbsp;<strong>$ 49.40</strong><br>
                                Total Refund:&nbsp;&nbsp;<strong>$ &nbsp;0.00</strong><br>
                                Total Payment:&nbsp;<strong>$ 49.40</strong><br>
                                Credit Sales:&nbsp;&nbsp;<strong>$ &nbsp;0.00</strong><br>
                                Total Expense:&nbsp;<strong>$ &nbsp;0.00</strong>
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
                var $btn = $(this).prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i>&nbsp; Generating link...');

                $.ajax({
                    url: GENERATE_URL,
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    data: {},
                    dataType: 'json',
                    success: function (r) {
                        if (!r.success) {
                            toastr.error(r.msg || 'Failed to generate link.');
                            $btn.prop('disabled', false).html('<i class="fa fa-link"></i> Connect to Telegram');
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
                        $btn.prop('disabled', false).html('<i class="fa fa-link"></i> Connect to Telegram');
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
                        $c.addClass('active');
                    } else {
                        $c.removeClass('active');
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

        // Global helper for notify toggle (called via onclick - outside ready)
        function submitNotify(val) {
            $('#notify_value').val(val);
            $('#notify_form').submit();
        }
    </script>
@endsection