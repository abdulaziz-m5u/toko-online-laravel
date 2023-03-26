<table>
	<thead>
		<tr>
			<th>Order ID</th>
			<th>Date</th>
			<th>Status</th>
			<th>Amount</th>
			<th>Gateway</th>
			<th>Payment Type</th>
			<th>Ref token</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($payments as $payment)
			<tr>    
				<td>{{ $payment->code }}</td>
				<td>{{ $payment->created_at }}</td>
				<td>{{ $payment->status }}</td>
				<td>{{ $payment->amount }}</td>
				<td>{{ $payment->method }}</td>
				<td>{{ $payment->payment_type }}</td>
				<td>{{ $payment->token }}</td>
			</tr>
		@endforeach
	</tbody>
</table>