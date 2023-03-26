@extends('frontend.layout')

@section('content')
	<!-- header end -->
	<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container">
			<div class="breadcrumb-content text-center">
				<h2>Order Received</h2>
				<ul>
					<li><a href="{{ url('/') }}">home</a></li>
					<li>Order Received</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- checkout-area start -->
	<div class="cart-main-area  ptb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
					<h1 class="cart-heading">Your Order:</h4>
					<div class="row">
						<div class="col-xl-3 col-lg-4">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
							<address>
								{{ $order->customer_first_name }} {{ $order->customer_last_name }}
								<br> {{ $order->customer_address1 }}
								<br> {{ $order->customer_address2 }}
								<br> Email: {{ $order->customer_email }}
								<br> Phone: {{ $order->customer_phone }}
								<br> Postcode: {{ $order->customer_postcode }}
							</address>
						</div>
						<div class="col-xl-3 col-lg-4">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Shipment Address</p>
							<address>
								{{ $order->shipment->first_name }} {{ $order->shipment->last_name }}
								<br> {{ $order->shipment->address1 }}
								<br> {{ $order->shipment->address2 }}
								<br> Email: {{ $order->shipment->email }}
								<br> Phone: {{ $order->shipment->phone }}
								<br> Postcode: {{ $order->shipment->postcode }}
							</address>
						</div>
						<div class="col-xl-3 col-lg-4">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
							<address>
								Invoice ID:
								<span class="text-dark">#{{ $order->code }}</span>
								<br> {{ $order->order_date }}
								<br> Status: {{ $order->status }}
								<br> Payment Status: {{ $order->payment_status }}
								<br> Shipped by: {{ $order->shipping_service_name }}
							</address>
						</div>
					</div>
					<div class="table-content table-responsive">
						<table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Item</th>
									<th>Description</th>
									<th>Quantity</th>
									<th>Unit Cost</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								@php 
									function showAttributes($jsonAttributes)
									{
										$jsonAttr = (string) $jsonAttributes;
										$attributes = json_decode($jsonAttr, true);
										$showAttributes = '';
										if ($attributes) {
											$showAttributes .= '<ul class="item-attributes list-unstyled">';
											foreach ($attributes as $key => $attribute) {
												if(count($attribute) != 0){
													foreach($attribute as $value => $attr){
														$showAttributes .= '<li>'.$value . ': <span>' . $attr . '</span><li>';
													}
												}else {
													$showAttributes .= '<li><span> - </span></li>';
												}
											}
											$showAttributes .= '</ul>';
										}
										return $showAttributes;
									}
								@endphp
								@forelse ($order->orderItems as $item)
									<tr>
										<td>{{ $item->sku }}</td>
										<td>{{ $item->name }}</td>
										<td>{!! showAttributes($item->attributes) !!}</td>
										<td>{{ $item->qty }}</td>
										<td>Rp{{ number_format($item->base_price,0,",",".") }}</td>
										<td>Rp{{ number_format($item->sub_total,0,",",".") }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="6">Order item not found!</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-5 ml-auto">
							<div class="cart-page-total">
								<ul>
									<li> Subtotal
										<span>Rp{{ number_format($order->base_total_price, 0 ,",", ".") }}</span>
									</li>
									<li>Tax (10%)
										<span>Rp{{ number_format($order->tax_amount,0,",",".") }}</span>
									</li>
									<li>Shipping Cost
										<span>Rp{{ number_format($order->shipping_cost,0,",",".") }}</span>
									</li>
									<li>Total
										<span>Rp{{ number_format($order->grand_total, 0,",", ".") }}</span>
									</li>
								</ul>
								@if (!$order->isPaid())
									<a href="{{ $order->payment_url }}">Proceed to payment</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection