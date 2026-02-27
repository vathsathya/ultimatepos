@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
    @include('superadmin::layouts.nav')
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">
            @lang('superadmin::lang.welcome_superadmin')
        </h1>
    </section>

    <section class="content">

        @include('superadmin::layouts.partials.currency')

        <div class="tw-mb-8 tw-flex tw-justify-end">
            <div class="tw-inline-flex tw-bg-gray-100 tw-rounded-lg tw-p-1" data-toggle="buttons">
                <label
                    class="btn btn-sm tw-bg-white tw-text-gray-700 tw-font-medium tw-shadow-sm tw-border-none hover:tw-bg-gray-50 active">
                    <input type="radio" name="date-filter" data-start="{{ date('Y-m-d') }}" data-end="{{ date('Y-m-d') }}"
                        checked class="tw-hidden"> {{ __('home.today') }}
                </label>
                <label
                    class="btn btn-sm tw-bg-transparent tw-text-gray-500 tw-font-medium tw-border-none hover:tw-text-gray-700 hover:tw-bg-gray-200">
                    <input type="radio" name="date-filter" data-start="{{ $date_filters['this_week']['start'] }}"
                        data-end="{{ $date_filters['this_week']['end'] }}" class="tw-hidden"> {{ __('home.this_week') }}
                </label>
                <label
                    class="btn btn-sm tw-bg-transparent tw-text-gray-500 tw-font-medium tw-border-none hover:tw-text-gray-700 hover:tw-bg-gray-200">
                    <input type="radio" name="date-filter" data-start="{{ $date_filters['this_month']['start'] }}"
                        data-end="{{ $date_filters['this_month']['end'] }}" class="tw-hidden"> {{ __('home.this_month') }}
                </label>
                <label
                    class="btn btn-sm tw-bg-transparent tw-text-gray-500 tw-font-medium tw-border-none hover:tw-text-gray-700 hover:tw-bg-gray-200">
                    <input type="radio" name="date-filter" data-start="{{ $date_filters['this_yr']['start'] }}"
                        data-end="{{ $date_filters['this_yr']['end'] }}" class="tw-hidden">
                    {{ __('superadmin::lang.this_year') }}
                </label>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6 tw-mb-8">
            <!-- New Subscriptions -->
            <div
                class="tw-bg-white tw-rounded-2xl tw-p-6 tw-border tw-border-gray-100 tw-shadow-sm hover:tw-shadow-md tw-transition-all tw-duration-300">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                            @lang('superadmin::lang.new_subscriptions')
                        </p>
                        <h3 class="tw-text-3xl tw-font-bold tw-text-gray-900 tw-mt-2 new_subscriptions">
                            &nbsp;
                        </h3>
                    </div>
                    <div class="tw-p-3 tw-bg-indigo-50 tw-rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="tw-text-indigo-600">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                        </svg>
                    </div>
                </div>
                <div class="tw-mt-6">
                    <a href="{{ action([\Modules\Superadmin\Http\Controllers\SuperadminSubscriptionsController::class, 'index']) }}"
                        class="tw-text-sm tw-text-indigo-600 hover:tw-text-indigo-800 tw-font-medium tw-flex tw-items-center">
                        @lang('superadmin::lang.more_info') <i class="fa fa-arrow-right tw-ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- New Registrations -->
            <div
                class="tw-bg-white tw-rounded-2xl tw-p-6 tw-border tw-border-gray-100 tw-shadow-sm hover:tw-shadow-md tw-transition-all tw-duration-300">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                            @lang('superadmin::lang.new_registrations')
                        </p>
                        <h3 class="tw-text-3xl tw-font-bold tw-text-gray-900 tw-mt-2 new_registrations">
                            &nbsp;
                        </h3>
                    </div>
                    <div class="tw-p-3 tw-bg-blue-50 tw-rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="tw-text-blue-600">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M16 19h6" />
                            <path d="M19 16v6" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                        </svg>
                    </div>
                </div>
                <div class="tw-mt-6">
                    <a href="{{ action([\Modules\Superadmin\Http\Controllers\BusinessController::class, 'index']) }}"
                        class="tw-text-sm tw-text-blue-600 hover:tw-text-blue-800 tw-font-medium tw-flex tw-items-center">
                        @lang('superadmin::lang.more_info') <i class="fa fa-arrow-right tw-ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Not Subscribed -->
            <div
                class="tw-bg-white tw-rounded-2xl tw-p-6 tw-border tw-border-gray-100 tw-shadow-sm hover:tw-shadow-md tw-transition-all tw-duration-300">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-sm tw-font-medium tw-text-gray-500 tw-uppercase tw-tracking-wider">
                            @lang('superadmin::lang.not_subscribed')
                        </p>
                        <h3 class="tw-text-3xl tw-font-bold tw-text-gray-900 tw-mt-2">
                            {{ $not_subscribed }}
                        </h3>
                    </div>
                    <div class="tw-p-3 tw-bg-red-50 tw-rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="tw-text-red-500">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10 3.2a9 9 0 1 0 10.8 10.8a1 1 0 0 0 -1 -1h-6.8a2 2 0 0 1 -2 -2v-7a.9 .9 0 0 0 -1 -.8" />
                            <path d="M15 3.5a9 9 0 0 1 5.5 5.5h-4.5a1 1 0 0 1 -1 -1v-4.5" />
                        </svg>
                    </div>
                </div>
                <div class="tw-mt-6">
                    <a href="{{ action([\Modules\Superadmin\Http\Controllers\BusinessController::class, 'index']) }}"
                        class="tw-text-sm tw-text-red-500 hover:tw-text-red-700 tw-font-medium tw-flex tw-items-center">
                        @lang('superadmin::lang.more_info') <i class="fa fa-arrow-right tw-ml-2"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="row tw-mt-6">
            <div class="col-sm-12">
                <div
                    class="tw-transition-all tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md tw-ring-gray-200">
                    <div class="tw-p-4 sm:tw-p-5">
                        <div class="tw-flex tw-items-center tw-gap-2.5 tw-mb-4">
                            <svg aria-hidden="true" style="width:20px;height:20px;" class="tw-text-sky-500 tw-shrink-0"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M17 17h-11v-14h-2"></path>
                                <path d="M6 5l14 1l-1 7h-13"></path>
                            </svg>
                            <h3
                                class="tw-m-0 tw-flex-1 tw-min-w-0 tw-text-base tw-font-semibold tw-tracking-tight tw-text-gray-900 tw-truncate tw-whitespace-nowrap sm:tw-text-lg">
                                {{ __('superadmin::lang.monthly_sales_trend') }}
                            </h3>
                        </div>
                        {!! $monthly_sells_chart->container() !!}
                    </div>
                </div>
            </div>
        </div>



    </section>
@endsection

@section('javascript')
    {!! $monthly_sells_chart->script() !!}

    <script type="text/javascript">
        $(document).ready(function () {

            var start = $('input[name="date-filter"]:checked').data('start');
            var end = $('input[name="date-filter"]:checked').data('end');
            update_statistics(start, end);
            $(document).on('change', 'input[name="date-filter"]', function () {
                var start = $('input[name="date-filter"]:checked').data('start');
                var end = $('input[name="date-filter"]:checked').data('end');
                update_statistics(start, end);
            });
        });

        function update_statistics(start, end) {
            var data = {
                start: start,
                end: end
            };

            //get purchase details
            var loader = '<i class="fa fa-refresh fa-spin fa-fw"></i>';
            $('.new_subscriptions').html(loader);
            $('.new_registrations').html(loader);
            $.ajax({
                method: "GET",
                url: '/superadmin/stats',
                dataType: "json",
                data: data,
                success: function (data) {
                    $('.new_subscriptions').html(__currency_trans_from_en(data.new_subscriptions, true, true));
                    $('.new_registrations').html(data.new_registrations);
                }
            });
        }
    </script>
@endsection