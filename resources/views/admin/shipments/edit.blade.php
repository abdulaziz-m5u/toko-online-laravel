@extends('layouts.app')

@section('content')
<div class="content pt-4">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>Order Shipment #{{ $shipment->order->code }}</h2>
				</div>
				<div class="card-body">
                    <form action="{{ route('admin.shipments.update', $shipment) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="track_number">Nomer Resi</label>
                            <input type="text" name="track_number" class="form-control">
                        </div>
                        <div class="form-footer pt-5 border-top">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="{{ url('admin/orders/'. $shipment->order->id) }}" class="btn bg-dark">Kembali</a>
                        </div>
                    </form>
				</div>
			</div>  
		</div>
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>Detail Order</h2>
				</div>
				<div class="card-body">
					<div class="row mb-2">
						<div class="col-xl-6 col-lg-6">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
							<address>
								{{ $shipment->order->customer_first_name }} {{ $shipment->order->customer_last_name }}
								{{ $shipment->order->customer_address1 }}
								{{ $shipment->order->customer_address2 }}
								<br> Email: {{ $shipment->order->customer_email }}
								<br> Phone: {{ $shipment->order->customer_phone }}
								<br> Postcode: {{ $shipment->order->customer_postcode }}
							</address>
						</div>
						<div class="col-xl-6 col-lg-6">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
							<address>
								ID: <span class="text-dark">#{{ $shipment->order->code }}</span>
								<br> {{ $shipment->order->order_date }}
								<br> Status: {{ $shipment->order->status }}
								<br> Payment Status: {{ $shipment->order->payment_status }}
								<br> Shipped by: {{ $shipment->order->shipping_service_name }}
							</address>
						</div>
					</div>
					<div class="table-responsive">
                        <table id="data-table" class="table mt-3 table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shipment->order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->sub_total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Order item not found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
					<div class="row justify-content-end">
						<div class="col-lg-5 col-xl-6 col-xl-3 ml-sm-auto">
							<ul class="list-unstyled mt-4">
								<li class="mid pb-3 text-dark">Subtotal
									<span class="d-inline-block float-right text-default">{{ $shipment->order->base_total_price }}</span>
								</li>
								<li class="mid pb-3 text-dark">Tax(10%)
									<span class="d-inline-block float-right text-default">{{ $shipment->order->tax_amount }}</span>
								</li>
								<li class="mid pb-3 text-dark">Shipping Cost
									<span class="d-inline-block float-right text-default">{{ $shipment->order->shipping_cost }}</span>
								</li>
								<li class="pb-3 text-dark">Total
									<span class="d-inline-block float-right">{{ $shipment->order->grand_total }}</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('style-alt')
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
@endpush

@push('script-alt') 
    <script
        src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"
    >
    </script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
    $("#data-table").DataTable();
    </script>
@endpush