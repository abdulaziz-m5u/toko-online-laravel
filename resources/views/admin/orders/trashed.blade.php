@extends('layouts.app')

@section('content')
    <div class="content pt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Trashed Orders</h2>
                        <a href="{{ route('admin.orders.index')}}" class="btn btn-success shadow-sm float-right"> Kembali </a>
                    </div>
                    <div class="card-body">
                        <table id="data-table" class="table table-bordered table-striped">
                            <thead>
                                <th>Order ID</th>
                                <th>Grand Total</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>    
                                        <td>
                                            {{ $order->code }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $order->order_date }}</span>
                                        </td>
                                        <td>{{ $order->grand_total }}</td>
                                        <td>
                                            {{ $order->customer_full_name }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $order->customer_email }}</span>
                                        </td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show',$order) }}" class="btn btn-info btn-sm">show</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No records found</td>
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