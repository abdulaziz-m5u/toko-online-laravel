@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Attribute Option</h3>
                <a href="{{ route('admin.attributes.attribute_options.create', $attribute) }}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-plus"></i> Tambah</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($attribute->attribute_options as $attribute_option)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attribute_option->name }}</td>
                                <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.attributes.attribute_options.edit', [$attribute, $attribute_option]) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form onclick="return confirm('are you sure !')" action="{{ route('admin.attributes.attribute_options.destroy', [$attribute,$attribute_option]) }}"
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
                                <td colspan="4" class="text-center">Data Kosong !</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Attribute</h3>
                <a href="{{ route('admin.attributes.index')}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('admin.attributes.update', $attribute) }}">
                    @csrf 
                    @method('put')
                    <fieldset class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <legend class="col-form-label pt-0 text-green">General</legend>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="code" class="col-sm-2 col-form-label">Code</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="code" value="{{ old('code', $attribute->code) }}" id="code">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="name" value="{{ old('name', $attribute->name) }}" id="name">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="type" class="col-sm-2 col-form-label">type</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="type" id="type">
                                          @foreach($types as $type)
                                            <option {{ old('type',$attribute->type) == $type ? 'selected' : null }} value="{{ $type }}">{{ $type }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <legend class="col-form-label pt-0 text-green">Validasi</legend>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="is_required" class="col-sm-2 col-form-label">Harus Di isi ?</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="is_required" id="is_required">
                                          @foreach($booleanOptions as $no => $booleanOption)
                                            <option {{ old('is_required',$attribute->is_required) == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="is_unique" class="col-sm-2 col-form-label">Harus Unik ?</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="is_unique" id="is_unique">
                                          @foreach($booleanOptions as $no => $booleanOption)
                                            <option {{ old('is_unique',$attribute->is_unique) == $no ? 'selected' : null}} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="validation" class="col-sm-2 col-form-label">Validasi</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="validation" id="validation">
                                          @foreach($validations as $validation)
                                            <option {{ old('validation', $attribute->validation) == $validation ? 'selected' : null }} value="{{ $validation }}">{{ $validation }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <legend class="col-form-label pt-0 text-green">Konfigurasi</legend>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="is_configurable" class="col-sm-2 col-form-label">Konfigurasi Produk ?</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="is_configurable" id="is_configurable">
                                          @foreach($booleanOptions as $no => $booleanOption)
                                            <option {{ old('is_configurable', $attribute->is_configurable) == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="is_filterable" class="col-sm-2 col-form-label">Filter Produk ?</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="is_filterable" id="is_filterable">
                                          @foreach($booleanOptions as $no => $booleanOption)
                                            <option {{ old('is_configurable', $attribute->is_filterable) == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
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