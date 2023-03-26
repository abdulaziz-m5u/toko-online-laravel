<table>
	<thead>
		<tr>
			<th>Date</th>
			<th>Orders</th>
			<th>Gross Revenue</th>
			<th>Taxes</th>
			<th>Shipping</th>
			<th>Net Revenue</th>
		</tr>
	</thead>
	<tbody>
		@php
			$totalOrders = 0;
			$totalGrossRevenue = 0;
			$totalTaxesAmount = 0;
			$totalShippingAmount = 0;
			$totalNetRevenue = 0;
		@endphp
		@foreach ($revenues as $revenue)
			<tr>    
				<td>{{ date('d M Y', strtotime($revenue->date)) }}</td>
				<td>{{ $revenue->num_of_orders }}</td>
				<td>{{ $revenue->gross_revenue }}</td>
				<td>{{ $revenue->taxes_amount }}</td>
				<td>{{ $revenue->shipping_amount }}</td>
				<td>{{ $revenue->net_revenue }}</td>
			</tr>

			@php
				$totalOrders += $revenue->num_of_orders;
				$totalGrossRevenue += $revenue->gross_revenue;
				$totalTaxesAmount += $revenue->taxes_amount;
				$totalShippingAmount += $revenue->shipping_amount;
				$totalNetRevenue += $revenue->net_revenue;
			@endphp
		@endforeach
		<tr>
			<td>Total</td>
			<td>{{ $totalOrders }}</td>
			<td>{{ $totalGrossRevenue }}</td>
			<td>{{ $totalTaxesAmount }}</td>
			<td>{{ $totalShippingAmount }}</td>
			<td>{{ $totalNetRevenue }}</td>
		</tr>
	</tbody>
</table>