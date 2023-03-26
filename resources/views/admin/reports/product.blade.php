@extends('layouts.app')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Product Report</h2>
					</div>
					<div class="card-body">
						@include('admin.reports.filter')
						<table id="data-table" class="table table-bordered table-striped">
							<thead>
								<th>Name</th>
								<th>SKU</th>
								<th>Items Sold</th>
								<th>Net Revenue</th>
								<th>Orders</th>
								<th>Stock</th>
							</thead>
							<tbody>
								@php
									$totalNetRevenue = 0;
								@endphp
								@forelse ($products as $product)
									<tr>    
										<td>{{ $product->name }}</td>
										<td>{{ $product->sku }}</td>
										<td>{{ $product->items_sold }}</td>
										<td>Rp{{ number_format($product->net_revenue, 0, ",", ".") }}</td>
										<td>{{ $product->num_of_orders }}</td>
										<td>{{ $product->stock }}</td>
									</tr>
									
									@php
										$totalNetRevenue += $product->net_revenue;
									@endphp
								@empty
									<tr>
										<td colspan="6">No records found</td>
									</tr>
								@endforelse

								@if ($products)
									<tr>
										<td class="d-none">z &nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>Rp{{ number_format($totalNetRevenue, 0, ",", ".") }}</td>
										<td>&nbsp;</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('style-alt')
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("#data-table").DataTable();
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
	</script>
@endpush