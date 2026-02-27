@foreach($featured_products as $variation)
	<div class="col-md-3 col-xs-4 product_list no-print tw-mb-4">
		<div class="product_box tw-bg-white tw-border tw-border-gray-100 tw-rounded-2xl tw-shadow-sm hover:tw-shadow-lg hover:tw--translate-y-1 tw-transition-all tw-duration-300 tw-cursor-pointer tw-overflow-hidden"
			data-toggle="tooltip" data-placement="bottom" data-variation_id="{{$variation->id}}"
			title="{{$variation->full_name}}">

			<div class="image-container tw-h-24 tw-w-full tw-bg-gray-50 tw-border-b tw-border-gray-100" style="background-image: url(
						@if(count($variation->media) > 0)
							{{$variation->media->first()->display_url}}
						@elseif(!empty($variation->product->image_url))
							{{$variation->product->image_url}}
						@else
							{{asset('/img/default.png')}}
						@endif
					);
				background-repeat: no-repeat; background-position: center;
				background-size: cover;">

			</div>

			<div class="text_div tw-p-3 tw-flex tw-flex-col tw-justify-between tw-h-full">
				<div class="tw-font-semibold tw-text-gray-800 tw-text-sm tw-leading-tight tw-line-clamp-2 tw-mb-1">
					{{$variation->product->name}}
					@if($variation->product->type == 'variable')
						- {{$variation->name}}
					@endif
				</div>

				<div class="tw-text-xs tw-text-gray-400 tw-truncate tw-mb-1">
					({{$variation->sub_sku}})
				</div>
			</div>

		</div>
	</div>
@endforeach