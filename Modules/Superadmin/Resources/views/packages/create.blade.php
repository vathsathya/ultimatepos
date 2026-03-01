@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
    @include('superadmin::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('superadmin::lang.packages')
            <small>@lang('superadmin::lang.add_package')</small></h1>
        <!-- <ol class="breadcrumb">
                                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                                <li class="active">Here</li>
                            </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Page level currency setting -->
        <input type="hidden" id="p_code" value="{{ $currency->code }}">
        <input type="hidden" id="p_symbol" value="{{ $currency->symbol }}">
        <input type="hidden" id="p_thousand" value="{{ $currency->thousand_separator }}">
        <input type="hidden" id="p_decimal" value="{{ $currency->decimal_separator }}">

        {{ html()->form('POST', action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'store']))->id('add_package_form')->open() }}
        <div
            class="tw-transition-all  lg:tw-col-span-1 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md  tw-ring-gray-200">
            <div class="tw-p-4 sm:tw-p-5">
                <div class="tw-flow-root tw-mt-5 tw-border-b tw-border-gray-200">
                    <div class="tw-mx-4 tw--my-2-auto sm:tw--mx-5">
                        <div class="tw-inline-block tw-min-w-full tw-py-2 tw-align-middle sm:tw-px-5">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('lang_v1.name') . ':', 'name') }}
                                    {{ html()->text('name')->class('form-control')->required() }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.description') . ':', 'description') }}
                                    {{ html()->text('description')->class('form-control')->required() }}
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.location_count') . ':', 'location_count') }}
                                    {{ html()->number('location_count')->class('form-control')->required()->attribute('min', 0) }}

                                    <span class="help-block">
                                        @lang('superadmin::lang.infinite_help')
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.user_count') . ':', 'user_count') }}
                                    {{ html()->number('user_count')->class('form-control')->required()->attribute('min', 0) }}

                                    <span class="help-block">
                                        @lang('superadmin::lang.infinite_help')
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.product_count') . ':', 'product_count') }}
                                    {{ html()->number('product_count')->class('form-control')->required()->attribute('min', 0) }}

                                    <span class="help-block">
                                        @lang('superadmin::lang.infinite_help')
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.invoice_count') . ':', 'invoice_count') }}
                                    {{ html()->number('invoice_count')->class('form-control')->required()->attribute('min', 0) }}

                                    <span class="help-block">
                                        @lang('superadmin::lang.infinite_help')
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.interval') . ':', 'interval') }}

                                    {{ html()->select('interval', $intervals)->class('form-control select2')->placeholder(__('messages.please_select'))->required() }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.interval_count'), 'interval_count') }}
                                    {{ html()->number('interval_count')->class('form-control')->required()->attribute('min', 1) }}
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.trial_days'), 'trial_days') }}
                                    {{ html()->number('trial_days')->class('form-control')->required()->attribute('min', 0) }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.price') . ':', 'price') }}
                                    @show_tooltip(__('superadmin::lang.tooltip_pkg_price'))

                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon3"><b>{{ $currency->code }}
                                                {{ $currency->symbol }}</b></span>
                                        {{ html()->text('price')->class('form-control input_number')->required() }}
                                    </div>
                                    <span class="help-block">
                                        0 = @lang('superadmin::lang.free_package')
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.sort_order'), 'sort_order') }}
                                    {{ html()->number('sort_order', 1)->class('form-control')->required() }}
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        {{ html()->checkbox('is_private', false, 1)->class('input-icheck') }}
                                        {{ __('superadmin::lang.private_superadmin_only') }}
                                    </label>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        {{ html()->checkbox('is_one_time', false, 1)->class('input-icheck') }}
                                        {{ __('superadmin::lang.one_time_only_subscription') }}
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        {{ html()->checkbox('enable_custom_link', false, 1)->id('enable_custom_link')->class('input-icheck') }}
                                        {{ __('superadmin::lang.enable_custom_subscription_link') }}
                                    </label>
                                    @show_tooltip(__('superadmin::lang.custom_link_help_text'))
                                </div>
                            </div>
                            <div id="custom_link_div" class="hide">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ html()->label(__('superadmin::lang.custom_link') . ':', 'custom_link') }}
                                        {{ html()->text('custom_link')->class('form-control') }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ html()->label(__('superadmin::lang.custom_link_text') . ':', 'custom_link_text') }}
                                        {{ html()->text('custom_link_text')->class('form-control') }}
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            @foreach ($permissions as $module => $module_permissions)
                                @foreach ($module_permissions as $permission)
                                    <div class="col-sm-3">
                                        @if (isset($permission['field_type']) && in_array($permission['field_type'], ['number', 'input']))
                                            <div class="form-group">
                                                {{ html()->label($permission['label'] . ':', "custom_permissions[$permission[name]]") }}
                                                @if (isset($permission['tooltip']))
                                                    @show_tooltip($permission['tooltip'])
                                                @endif

                                                {{ html()->input($permission['field_type'], "custom_permissions[$permission[name]]")->class('form-control') }}
                                            </div>
                                        @else
                                            <div class="checkbox">
                                                <label>
                                                    {{ html()->checkbox("custom_permissions[$permission[name]]", $permission['default'], 1)->class('input-icheck') }}
                                                    {{ $permission['label'] }}
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endforeach

                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        {{ html()->checkbox('is_active', true, 1)->class('input-icheck') }}
                                        {{ __('superadmin::lang.is_active') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        {{ html()->checkbox('mark_package_as_popular', false, 1)->class('input-icheck') }}
                                        {{ __('superadmin::lang.mark_package_as_popular') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {{ html()->label(__('superadmin::lang.only_for_businesses') . ':', 'businesses') }}
                                    @show_tooltip(__('superadmin::lang.tooltip_only_for_businesses'))
                                    {{ html()->select('businesses[]', $businesses)->class('form-control select2')->multiple() }}
                                </div>
                            </div>
                        </div>

                        <div class="row text-center">
                            <button type="submit"
                                class="tw-dw-btn tw-dw-btn-primary tw-text-white tw-dw-btn-lg">@lang('messages.save')</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </section>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('form#add_package_form').validate();
        });
        $('#enable_custom_link').on('ifChecked', function (event) {
            $("div#custom_link_div").removeClass('hide');
        });
        $('#enable_custom_link').on('ifUnchecked', function (event) {
            $("div#custom_link_div").addClass('hide');
        });
    </script>
@endsection