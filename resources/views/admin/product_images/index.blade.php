@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Gambar Produk</h3>
                <a href="{{ route('admin.products.edit', $product)}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali </a>
                <a href="{{ route('admin.products.product_images.create', $product)}}" class="btn btn-success shadow-sm float-right mr-2"> <i class="fa fa-upload"></i> Upload </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($product->productImages as $productImage)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                  <a href="{{ Storage::url($productImage->path) }}" target="_blank">
                                    <img width="100" src="{{ Storage::url($productImage->path) }}" alt="">
                                  </a>
                                </td>
                                <td>
                                <div class="btn-group btn-group-sm">
                                    <form onclick="return confirm('are you sure !')" action="{{ route('admin.products.product_images.destroy', [$product, $productImage]) }}"
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
                                <td colspan="7" class="text-center">Data Kosong !</td>
                            </tr>
                        @endforelse
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