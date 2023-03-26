@extends('layouts.app')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Inventory Report</h2>
					</div>
					<div class="card-body">
                        <form action="{{ url()->current() }}" method="get" class="form-inline">
						<div class="form-group mb-2">
                            <select name="export" id="export" class="form-control input-block">
                                @foreach($exports as $value => $export)
                                    <option value="{{ $value }}">{{ $export }}</option>
                                @endforeach
                            </select>
                        </div>
                        
							<div class="form-group mx-sm-3 mb-2">
								<button type="submit" class="btn btn-success">Go</button>
							</div>
                        </form>
						<table id="data-table" class="table table-bordered table-striped">
							<thead>
								<th>Name</th>
								<th>SKU</th>
								<th>Stock</th>
							</thead>
							<tbody>
								@forelse ($products as $product)
									<tr>    
										<td>{{ $product->name }}</td>
										<td>{{ $product->sku }}</td>
										<td>{{ $product->stock }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="3">No records found</td>
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