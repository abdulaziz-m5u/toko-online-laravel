@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Order</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-striped">
                            <thead>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Total Qty</th>
                                <th>Total Weight (gram)</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($shipments as $shipment)
                                    <tr>    
                                        <td>
                                            {{ $shipment->order->code }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $shipment->order->order_date }}</span>
                                        </td>
                                        <td>{{ $shipment->order->customer_full_name }}</td>
                                        <td>
                                            {{ $shipment->status }}
                                            <br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $shipment->shipped_at }}</span>
                                        </td>
                                        <td>{{ $shipment->total_qty }}</td>
                                        <td>{{ $shipment->total_weight }}</td>
                                        <td>
                                            <a href="{{ url('admin/orders/'. $shipment->order->id) }}" class="btn btn-info btn-sm">show</a>      
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
