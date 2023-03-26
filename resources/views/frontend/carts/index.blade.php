@extends('frontend.layout')

@section('content')
	<!-- header end -->
	<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container">
			<div class="breadcrumb-content text-center">
				<h2>cart page</h2>
				<ul>
					<li><a href="{{ url('/') }}">home</a></li>
					<li> cart page</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- shopping-cart-area start -->
	<div class="cart-main-area pt-95 pb-100">
		<div class="container">
			@if(session()->has('message'))
				<div class="content-header mb-0 pb-0">
					<div class="container-fluid">
						<div class="mb-0 alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show" role="alert">
							<strong>{{ session()->get('message') }}</strong>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div> 
					</div><!-- /.container-fluid -->
				</div>
			@endif
			<div class="row mt-3">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1 class="cart-heading">Cart</h1>
					<form action="">
						<div class="table-content table-responsive">
							<table>
								<thead>
									<tr>
										<th>remove</th>
										<th>images</th>
										<th>Product</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($items as $item)
										@php
											$product = isset($item->model->parent) ? $item->model->parent : $item->model;
											$image = !empty($product->productImages->first()) ? asset('storage/'.$product->productImages->first()->path) : asset('themes/ezone/assets/img/cart/3.jpg');
										@endphp
										<tr>
											<td class="product-remove">
												<a href="{{ url('carts/remove/'. $item->rowId)}}" class="delete"><i class="pe-7s-close"></i></a>
											</td>
											<td class="product-thumbnail">
												<a href="{{ url('product/'. $product->slug) }}"><img src="{{ $image }}" alt="{{ $product->name }}" style="width:100px"></a>
											</td>
											<td class="product-name"><a href="{{ url('product/'. $product->slug) }}">{{ $item->name }}</a></td>
											<td class="product-price-cart"><span class="amount">Rp{{ number_format($item->price, 0, ",", ".") }}</span></td>
											<td class="product-quantity">
											<select
												className="form-control"
												id="change-qty"
												data-productId="{{ $item->rowId }}"
                                                value="{{ $item->qty }}"
                                            >
												@foreach(range(1, $item->model->productInventory->qty) as $qty)
													<option {{ $qty == $item->qty ? 'selected' : null }} value="{{ $qty }}">{{ $qty }}</option>
												@endforeach
                                            </select>
											</td>
											<td class="product-subtotal">Rp{{ number_format($item->price * $item->qty, 0, ",", ".")}}</td>
										</tr>
									@empty
										<tr>
											<td colspan="6">The cart is empty!</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<!-- <div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="coupon-all">
									<div class="coupon2">
										<input class="button" name="update_cart" value="Update cart" type="submit">
									</div>
								</div>
							</div>
						</div> -->
						<div class="row">
							<div class="col-md-5 ml-auto">
								<div class="cart-page-total">
									<h2>Cart totals</h2>
									<ul>
										<li>Total<span>Rp{{ Cart::subtotal(0, ",", ".") }}</span></li>
										<!-- <li>Total<span>Rp{{ Cart::total(0, ",", ".") }}</span></li> -->
									</ul>
									<a href="{{ url('orders/checkout') }}">Proceed to checkout</a>
								</div>
							</div>
						</div>
                        </form>
				</div>
			</div>
		</div>
	</div>
	<!-- shopping-cart-area end -->
@endsection

@push('script-alt')
<script>
	$(document).on("change", function (e) {
		var qty = e.target.value;
		var productId = e.target.attributes['data-productid'].value;

        $.ajax({
            type: "POST",
            url: "/carts/update",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                productId,
                qty
            },
            success: function (response) {
				location.reload(true);
				Swal.fire({
                        title: "Jumlah Produk",
                        text: "Berhasil di ganti !",
                        icon: "success",
                        confirmButtonText: "Close",
                    });
            },
        });
    });
</script>
@endpush