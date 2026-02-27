@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
    @include('superadmin::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('superadmin::lang.packages') <small>@lang('superadmin::lang.all_packages')</small></h1>
        <!-- <ol class="breadcrumb">
            <a href="#"><i class="fa fa-dashboard"></i> Level</a><br/>
            <li class="active">Here<br/>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('superadmin::layouts.partials.currency')

        {{-- <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">&nbsp;</h3>
        	<div class="box-tools">
                <a href="{{action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'create'])}}" 
                    class="btn btn-block btn-primary">
                	<i class="fa fa-plus"></i> @lang( 'messages.add' )</a>
            </div>
        </div>

        <div class="box-body">
        	@foreach ($packages as $package)
                <div class="col-md-4">
					<div class="box box-success hvr-grow-shadow">
						<div class="box-header with-border text-center">
							<h2 class="box-title">{{$package->name}}</h2>
								@if ($package->mark_package_as_popular == 1)
								<div class="pull-right">
									<span class="badge bg-green">
										@lang('superadmin::lang.popular')
									</span>
								</div>
								@endif
							<div class="row">
								@if ($package->is_private)
									<a href="#!" class="btn btn-box-tool">
										<i class="fas fa-lock fa-lg text-warning" data-toggle="tooltip"
										title="@lang('superadmin::lang.private_superadmin_only')"></i>
									</a>
								@endif

								@if ($package->is_one_time)
									<a href="#!" class="btn btn-box-tool">
										<i class="fas fa-dot-circle fa-lg text-info" data-toggle="tooltip"
										title="@lang('superadmin::lang.one_time_only_subscription')"></i>
									</a>
								@endif
								
								@if ($package->is_active == 1)
									<span class="badge bg-green">
										@lang('superadmin::lang.active')
									</span>
								@else
									<span class="badge bg-red">
									@lang('superadmin::lang.inactive')
									</span>
								@endif
								
								<a href="{{action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'edit'], [$package->id])}}" class="btn btn-box-tool" title="edit"><i class="fa fa-edit"></i></a>
								<a href="{{action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'destroy'], [$package->id])}}" class="btn btn-box-tool link_confirmation" title="delete"><i class="fa fa-trash"></i></a>
              					
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body text-center">

							@if ($package->location_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->location_count}}
							@endif

							@lang('business.business_locations')
							<br/>

							@if ($package->user_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->user_count}}
							@endif

							@lang('superadmin::lang.users')
							<br/>
						
							@if ($package->product_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->product_count}}
							@endif

							@lang('superadmin::lang.products')
							<br/>

							@if ($package->invoice_count == 0)
								@lang('superadmin::lang.unlimited')
							@else
								{{$package->invoice_count}}
							@endif

							@lang('superadmin::lang.invoices')
							<br/>

							@if ($package->trial_days != 0)
									{{$package->trial_days}} @lang('superadmin::lang.trial_days')
								<br/>
							@endif

							@if (!empty($package->custom_permissions))
								@foreach ($package->custom_permissions as $permission => $value)
									@isset($permission_formatted[$permission])
										{{$permission_formatted[$permission]}}
										<br/>
									@endisset
								@endforeach
							@endif
							
							<h3 class="text-center">
								@if ($package->price != 0)
									<span class="display_currency" data-currency_symbol="true">
										{{$package->price}}
									</span>

									<small>
										/ {{$package->interval_count}} {{__('lang_v1.' . $package->interval)}}
									</small>
								@else
									@lang('superadmin::lang.free_for_duration', ['duration' => $package->interval_count . ' ' . __('lang_v1.' . $package->interval)])
								@endif
							</h3>

						</div>
						<!-- /.box-body -->

						<div class="box-footer text-center">
							{{$package->description}}
						</div>
					</div>
					<!-- /.box -->
                </div>
                @if ($loop->iteration % 3 == 0)
    				<div class="clearfix"></div>
    			@endif
            @endforeach

            <div class="col-md-12">
                {{ $packages->links() }}
            </div>
        </div>

    </div> --}}

        <div class="tw-transition-all lg:tw-col-span-1 tw-duration-200 tw-bg-white tw-shadow-sm tw-rounded-xl tw-ring-1 hover:tw-shadow-md tw-ring-gray-200 tw-mt-4">
            <div class="tw-p-6 sm:tw-p-8">
                <div class="tw-flex tw-justify-between tw-items-center tw-mb-8">
                    <h2 class="tw-text-2xl tw-font-bold tw-text-gray-900">Manage Packages</h2>
                    <a class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full"
                        href="{{ action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'create']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tw-mr-1">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg> @lang('messages.add')
                    </a>
                </div>

                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-8">
                    @foreach ($packages as $package)
                        <div class="tw-relative tw-flex tw-flex-col tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-2xl tw-shadow-sm hover:tw-shadow-xl tw-transition-all tw-duration-300 {{ $package->mark_package_as_popular ? 'tw-ring-2 tw-ring-indigo-600' : '' }}">
                            
                            @if ($package->mark_package_as_popular == 1)
                                <div class="tw-absolute tw--top-4 tw-left-1/2 tw--translate-x-1/2">
                                    <span class="tw-bg-indigo-600 tw-text-white tw-text-xs tw-font-bold tw-uppercase tw-tracking-wider tw-py-1 tw-px-3 tw-rounded-full">
                                        @lang('superadmin::lang.popular')
                                    </span>
                                </div>
                            @endif

                            <div class="tw-flex tw-justify-between tw-items-start tw-mb-4">
                                <h3 class="tw-text-xl tw-font-bold tw-text-gray-900">{{ $package->name }}</h3>
                                <div class="tw-flex tw-gap-2">
                                    @if ($package->is_private)
                                        <i class="fas fa-lock tw-text-yellow-500" data-toggle="tooltip" title="@lang('superadmin::lang.private_superadmin_only')"></i>
                                    @endif
                                    @if ($package->is_one_time)
                                        <i class="fas fa-dot-circle tw-text-blue-500" data-toggle="tooltip" title="@lang('superadmin::lang.one_time_only_subscription')"></i>
                                    @endif
                                </div>
                            </div>

                            <p class="tw-text-gray-500 tw-text-sm tw-flex-grow tw-mb-6">{{ $package->description }}</p>

                            <div class="tw-mb-6">
                                <div class="tw-flex tw-items-baseline tw-gap-x-2">
                                    @if ($package->price != 0)
                                        <span class="tw-text-4xl tw-font-extrabold tw-tracking-tight tw-text-gray-900 display_currency" data-currency_symbol="true">
                                            {{ $package->price }}
                                        </span>
                                        <span class="tw-text-sm tw-font-medium tw-text-gray-500">/ {{ $package->interval_count }} {{ __('lang_v1.' . $package->interval) }}</span>
                                    @else
                                        <span class="tw-text-2xl tw-font-extrabold tw-text-green-600">
                                            @lang('superadmin::lang.free_for_duration', ['duration' => $package->interval_count . ' ' . __('lang_v1.' . $package->interval)])
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <ul role="list" class="tw-space-y-3 tw-text-sm tw-leading-6 tw-text-gray-600 tw-mb-8">
                                <li class="tw-flex tw-gap-x-3">
                                    <i class="fas fa-check-circle tw-text-indigo-600 tw-mt-1"></i>
                                    <span>
                                        @if ($package->location_count == 0) @lang('superadmin::lang.unlimited') @else <b>{{ $package->location_count }}</b> @endif 
                                        @lang('business.business_locations')
                                    </span>
                                </li>
                                <li class="tw-flex tw-gap-x-3">
                                    <i class="fas fa-check-circle tw-text-indigo-600 tw-mt-1"></i>
                                    <span>
                                        @if ($package->user_count == 0) @lang('superadmin::lang.unlimited') @else <b>{{ $package->user_count }}</b> @endif 
                                        @lang('superadmin::lang.users')
                                    </span>
                                </li>
                                <li class="tw-flex tw-gap-x-3">
                                    <i class="fas fa-check-circle tw-text-indigo-600 tw-mt-1"></i>
                                    <span>
                                        @if ($package->product_count == 0) @lang('superadmin::lang.unlimited') @else <b>{{ $package->product_count }}</b> @endif 
                                        @lang('superadmin::lang.products')
                                    </span>
                                </li>
                                <li class="tw-flex tw-gap-x-3">
                                    <i class="fas fa-check-circle tw-text-indigo-600 tw-mt-1"></i>
                                    <span>
                                        @if ($package->invoice_count == 0) @lang('superadmin::lang.unlimited') @else <b>{{ $package->invoice_count }}</b> @endif 
                                        @lang('superadmin::lang.invoices')
                                    </span>
                                </li>
                                @if ($package->trial_days != 0)
                                    <li class="tw-flex tw-gap-x-3">
                                        <i class="fas fa-gift tw-text-indigo-600 tw-mt-1"></i>
                                        <span><b>{{ $package->trial_days }}</b> @lang('superadmin::lang.trial_days')</span>
                                    </li>
                                @endif
                                
                                @if (!empty($package->custom_permissions))
                                    @foreach ($package->custom_permissions as $permission => $value)
                                        @isset($permission_formatted[$permission])
                                            <li class="tw-flex tw-gap-x-3">
                                                <i class="fas fa-check tw-text-green-500 tw-mt-1"></i>
                                                <span>{{ $permission_formatted[$permission] }}</span>
                                            </li>
                                        @endisset
                                    @endforeach
                                @endif
                            </ul>

                            <div class="tw-mt-auto tw-flex tw-items-center tw-justify-between tw-pt-4 tw-border-t tw-border-gray-100">
                                <div>
                                    @if ($package->is_active == 1)
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-green-100 tw-text-green-800">
                                            @lang('superadmin::lang.active')
                                        </span>
                                    @else
                                        <span class="tw-inline-flex tw-items-center tw-px-2.5 tw-py-0.5 tw-rounded-full tw-text-xs tw-font-medium tw-bg-red-100 tw-text-red-800">
                                            @lang('superadmin::lang.inactive')
                                        </span>
                                    @endif
                                </div>
                                <div class="tw-flex tw-gap-2">
                                    <a href="{{ action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'edit'], [$package->id]) }}" 
                                       class="tw-p-2 tw-text-gray-400 hover:tw-text-indigo-600 tw-transition-colors" title="Edit">
                                        <i class="fa fa-edit tw-text-lg"></i>
                                    </a>
                                    <a href="{{ action([\Modules\Superadmin\Http\Controllers\PackagesController::class, 'destroy'], [$package->id]) }}" 
                                       class="tw-p-2 tw-text-gray-400 hover:tw-text-red-600 tw-transition-colors link_confirmation" title="Delete">
                                        <i class="fa fa-trash tw-text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="tw-mt-8 tw-flex tw-justify-center">
                    {{ $packages->links() }}
                </div>
            </div>
        </div>

        <div class="modal fade brands_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    </section>
    <!-- /.content -->

@endsection
