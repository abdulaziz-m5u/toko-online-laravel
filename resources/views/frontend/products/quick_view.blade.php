<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span class="pe-7s-close" aria-hidden="true"></span>
</button>
<div class="modal-dialog modal-quickview-width" role="document">
	<div class="modal-content">
		<div class="modal-body">
			<div class="qwick-view-left">
				<div class="quick-view-learg-img">
					<div class="quick-view-tab-content tab-content">
						@php
							$i = 1
						@endphp
						@foreach ($product->productImages as $image)
							<div class="tab-pane fade {{ ($i == 1) ? 'active show' : '' }}" id="modal{{ $i}}" role="tabpanel">
								@if ($image->path)
									<img src="{{ asset('storage/'.$image->path) }}" alt="{{ $product->name }}" style="width:320px;">
								@else
									<img src="{{ asset('themes/ezone/assets/img/quick-view/l3.jpg') }}" alt="">
								@endif
							</div>
							@php
								$i++
							@endphp
						@endforeach
					</div>
				</div>
				<div class="quick-view-list nav" role="tablist">
					@php
						$i = 1
					@endphp
					@foreach ($product->productImages as $image)
						<a class="{{ ($i == 1) ? 'active' : '' }} mr-12" href="#modal{{ $i }}" data-toggle="tab" role="tab">
							@if ($image->path)
								<img src="{{ asset('storage/'.$image->path) }}" alt="{{ $product->name }}" style="width:100px; height:112px">
							@else
								<img src="{{ asset('themes/ezone/assets/img/quick-view/s3.jpg') }}" alt="{{ $product->name }}">
							@endif
						</a>
						@php
							$i++
						@endphp
					@endforeach
				</div>
			</div>
			<div class="qwick-view-right">
				<div class="qwick-view-content">
					<h3>{{ $product->name }}</h3>
					<div class="price">
						<span class="new">{{ number_format($product->priceLabel()) }}</span>
						{{-- <span class="old">$120.00  </span> --}}
					</div>
					<p>{{ $product->short_description }}</p>
					<form action="{{ route('carts.store') }}" method="post">
						@csrf 
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
						@if ($product->configurable())
							<div class="quick-view-select">
								<div class="select-option-part">
									<label>Size*</label>
									<select name="size" class="select" id="">
										@foreach($sizes as $size)
											<option value="{{ $size }}">{{ $size }}</option>
										@endforeach
									</select>
								</div>
								<div class="select-option-part">
									<label>Color*</label>
									<select name="color" class="select" id="">
										@foreach($colors as $color)
											<option value="{{ $color }}">{{ $color }}</option>
										@endforeach
									</select>
								</div>
							</div>
						@endif

						<div class="quickview-plus-minus">
							<div class="cart-plus-minus">
								<input type="number" name="qty" value="1" class="cart-plus-minus-box" min="1">
							</div>
							<div class="quickview-btn-cart">
								<button type="submit" class="submit contact-btn btn-hover">add to cart</button>
							</div>
							<div class="quickview-btn-wishlist">
								<a class="btn-hover" href="#"><i class="pe-7s-like"></i></a>
							</div>
						</div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>