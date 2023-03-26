<!DOCTYPE html>
<html>
  	<head>
		<meta charset="utf-8">
		<title>Revenue Reprot</title>
		<style type="text/css">
			table {
				width: 100%;
			}
			table tr td,
			table tr th {
				font-size: 10pt;
				text-align: left;
			}
			table tr:nth-child(even) {
				background-color: #f2f2f2;
			}
			table th, td {
  				border-bottom: 1px solid #ddd;
			}
			table th {
				border-top: 1px solid #ddd;
				height: 40px;
			}
			table td {
				height: 25px;
			}
		</style>
	</head>
  	<body>
		<h2>Revenue Report</h2>
		<hr>
		<p>Period : {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>
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
						<td>{{ number_format($revenue->gross_revenue, 0, ",", ".") }}</td>
						<td>{{ number_format($revenue->taxes_amount, 0, ",", ".") }}</td>
						<td>{{ number_format($revenue->shipping_amount, 0, ",", ".") }}</td>
						<td>{{ number_format($revenue->net_revenue, 0, ",", ".") }}</td>
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
					<td><strong>{{ $totalOrders }}</strong></td>
					<td><strong>{{ number_format($totalGrossRevenue, 0, ",", ".") }}</strong></td>
					<td><strong>{{ number_format($totalTaxesAmount, 0, ",", ".") }}</strong></td>
					<td><strong>{{ number_format($totalShippingAmount, 0, ",", ".") }}</strong></td>
					<td><strong>{{ number_format($totalNetRevenue, 0, ",", ".") }}</strong></td>
				</tr>
			</tbody>
		</table>
 	</body>
</html>