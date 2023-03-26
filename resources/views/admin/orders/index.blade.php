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
                <a href="{{ route('admin.orders.trashed')}}" class="btn btn-danger shadow-sm float-right"> <i class="fa fa-trash"></i> Trash </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="" class="input-daterange form-inline mb-4">
                <div class="form-group mb-2">
                  <input type="text" class="form-control input-block" name="q" value="{{ !empty(request()->input('q')) ? request()->input('q') : '' }}" placeholder="Type code or name"> 
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}" name="start" placeholder="from">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}" name="end" placeholder="to">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <select class="form-control input-block" name="status" id="status">
                    @foreach($statuses as $value => $status)
                      <option value="{{ $value }}">{{ $status }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <button type="submit" class="btn btn-success shadow-sm float-right">Cari</button>
                </div>
                </form>
                <div class="table-responsive">
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
                                    <td>Rp{{ number_format($order->grand_total,0,",", ".") }}</td>
                                    <td>
                                        {{ $order->customer_full_name }}<br>
                                        <span style="font-size: 12px; font-weight: normal"> {{ $order->customer_email }}</span>
                                    </td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a>
                                        <form onclick="return confirm('are you sure !')" action="{{ route('admin.orders.destroy', $order) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
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
    <script>
    $("#data-table").DataTable();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
		$(".delete").on("submit", function () {
			return confirm("Do you want to remove this?");
		});
		$("a.delete").on("click", function () {
			event.preventDefault();
			var orderId = $(this).attr('order-id');
			if (confirm("Do you want to remove this?")) {
				document.getElementById('delete-form-' + orderId ).submit();
			}
		});
		$(".restore").on("click", function () {
			return confirm("Do you want to restore this?");
		});
	</script>
@endpush
