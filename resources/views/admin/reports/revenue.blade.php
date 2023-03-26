@extends('layouts.app')

@section('content')
	<div class="content pt-4">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Revenue Report</h2>
					</div>
					<div class="card-body">
						@include('admin.reports.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>Date</th>
								<th>Orders</th>
								<th>Gross Revenue</th>
								<th>Taxes</th>
								<th>Shipping</th>
								<th>Net Revenue</th>
							</thead>
							<tbody>
								@php
									$totalOrders = 0;
									$totalGrossRevenue = 0;
									$totalTaxesAmount = 0;
									$totalShippingAmount = 0;
									$totalNetRevenue = 0;
								@endphp
								@forelse ($revenues as $revenue)
									<tr>    
										<td>{{ date('d M Y', strtotime($revenue->date)) }}</td>
										<td>
											<a href="{{ url('admin/orders?start='. $revenue->date .'&end='. $revenue->date . '&status=completed') }}">{{ $revenue->num_of_orders }}</a>
										</td>
										<td>Rp{{ number_format($revenue->gross_revenue, 0, ",", ".") }}</td>
										<td>Rp{{ number_format($revenue->taxes_amount, 0, ",", ".") }}</td>
										<td>Rp{{ number_format($revenue->shipping_amount, 0, ",", ".") }}</td>
										<td>Rp{{ number_format($revenue->net_revenue, 0, ",", ".") }}</td>
									</tr>

									@php
										$totalOrders += $revenue->num_of_orders;
										$totalGrossRevenue += $revenue->gross_revenue;
										$totalTaxesAmount += $revenue->taxes_amount;
										$totalShippingAmount += $revenue->shipping_amount;
										$totalNetRevenue += $revenue->net_revenue;
									@endphp
								@empty
									<tr>
										<td colspan="6">No records found</td>
									</tr>
								@endforelse
								
								@if ($revenues)
									<tr>
										<td>Total</td>
										<td><strong>{{ $totalOrders }}</strong></td>
										<td><strong>Rp{{ number_format($totalGrossRevenue, 0, ",", ".") }}</strong></td>
										<td><strong>Rp{{ number_format($totalTaxesAmount, 0, ",", ".") }}</strong></td>
										<td><strong>Rp{{ number_format($totalShippingAmount, 0, ",", ".") }}</strong></td>
										<td><strong>Rp{{ number_format($totalNetRevenue, 0, ",", ".") }}</strong></td>
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
 @endpush

@push('script-alt') 
    <script
        src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"
    >
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
	</script>
@endpush