@extends('layouts.app')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Payment Report</h2>
					</div>
					<div class="card-body">
						@include('admin.reports.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>Order ID</th>
								<th>Date</th>
								<th>Status</th>
								<th>Amount</th>
								<th>Gateway</th>
								<th>Payment Type</th>
								<th>Ref</th>
							</thead>
							<tbody>
								@forelse ($payments as $payment)
									<tr>    
										<td>{{ $payment->code }}</td>
										<td>{{ date('d M Y H:i:s', strtotime($payment->created_at)) }}</td>
										<td>{{ $payment->status }}</td>
										<td>Rp{{ number_format($payment->amount, 0, ",", ".") }}</td>
										<td>{{ $payment->method }}</td>
										<td>{{ $payment->payment_type }}</td>
										<td>{{ $payment->token }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="8">No records found</td>
									</tr>
								@endforelse
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