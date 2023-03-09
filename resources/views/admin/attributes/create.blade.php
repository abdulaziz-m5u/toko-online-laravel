@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Buat Attribute</h3>
                <a href="{{ route('admin.attributes.index')}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('admin.attributes.store') }}">
                    @csrf
                    <fieldset class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <legend class="col-form-label pt-0 text-green">General</legend>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="code" class="col-sm-2 col-form-label">Code</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="code" value="{{ old('code') }}" id="code">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="type" class="col-sm-2 col-form-label">type</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="type" id="type">
                                          @foreach($types as $type)
                                            <option {{ old('type') == $type ? 'selected' : null }} value="{{ $type }}">{{ $type }}</option>
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
                                            <option {{ old('is_required') == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="is_unique" class="col-sm-2 col-form-label">Harus Unik ?</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="is_unique" id="is_unique">
                                          @foreach($booleanOptions as $no => $booleanOption)
                                            <option {{ old('is_unique') == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="validation" class="col-sm-2 col-form-label">Validasi</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="validation" id="validation">
                                          @foreach($validations as $validation)
                                            <option {{ old('validation') == $validation ? 'selected' : null}} value="{{ $validation }}">{{ $validation }}</option>
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
                                            <option {{ old('is_configurable') == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom pb-4">
                                    <label for="is_filterable" class="col-sm-2 col-form-label">Filter Produk ?</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" name="is_filterable" id="is_filterable">
                                          @foreach($booleanOptions as $no => $booleanOption)
                                            <option {{ old('is_filterable') == $no ? 'selected' : null }} value="{{ $no }}">{{ $booleanOption }}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-success">Simpan</button>
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