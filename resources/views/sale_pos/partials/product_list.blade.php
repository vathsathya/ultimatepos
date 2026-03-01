@forelse($products as $product)
	<div class="col-md-3 col-xs-4 product_list no-print tw-mb-4">
		<div class="product_box tw-bg-white tw-border tw-border-gray-100 tw-rounded-2xl tw-shadow-sm hover:tw-shadow-lg hover:tw--translate-y-1 tw-transition-all tw-duration-300 tw-cursor-pointer tw-overflow-hidden"
			data-variation_id="{{$product->id}}"
			title="{{$product->name}} @if($product->type == 'variable')- {{$product->variation}} @endif {{ '(' . $product->sub_sku . ')'}} @if(!empty($show_prices)) @lang('lang_v1.default') - @format_currency($product->selling_price) @foreach($product->group_prices as $group_price) @if(array_key_exists($group_price->price_group_id, $allowed_group_prices)) {{$allowed_group_prices[$group_price->price_group_id]}} - @format_currency($group_price->price_inc_tax) @endif @endforeach @endif">

			<div class="image-container tw-h-24 tw-w-full tw-bg-gray-50 tw-border-b tw-border-gray-100" style="background-image: url(
							@if(count($product->media) > 0)
								{{$product->media->first()->display_url}}
							@elseif(!empty($product->product_image))
								{{asset('/uploads/img/' . rawurlencode($product->product_image))}}
							@else
								{{asset('/img/default.png')}}
							@endif
						);
					background-repeat: no-repeat; background-position: center;
					background-size: cover;">

			</div>

			<div class="text_div tw-p-3 tw-flex tw-flex-col tw-justify-between tw-h-full">
				<div class="tw-font-semibold tw-text-gray-800 tw-text-sm tw-leading-tight tw-line-clamp-2 tw-mb-1">
					{{$product->name}}
					@if($product->type == 'variable')
						- {{$product->variation}}
					@endif
				</div>

				<div class="tw-text-xs tw-text-gray-400 tw-truncate tw-mb-1">
					({{$product->sub_sku}})
				</div>

				<div
					class="tw-text-xs tw-font-medium tw-text-indigo-600 tw-bg-indigo-50 tw-px-2 tw-py-1 tw-rounded-md tw-inline-block tw-w-fit">
					@if($product->enable_stock)
						{{ @num_format($product->qty_available) }} {{$product->unit}}
					@else
						--
					@endif
				</div>
			</div>

		</div>
	</div>
@empty
	<input type="hidden" id="no_products_found">
	<div class="col-md-12">
		<h4 class="text-center">
			@lang('lang_v1.no_products_to_display')
		</h4>
	</div>
@endforelse