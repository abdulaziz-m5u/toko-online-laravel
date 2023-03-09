@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Buat Kategori</h3>
                <a href="{{ route('admin.categories.index')}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('admin.categories.store') }}">
                    @csrf 
                    <div class="form-group row border-bottom pb-4">
                        <label for="name" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name">
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="parent_id" class="col-sm-2 col-form-label">Kategori Utama</label>
                        <div class="col-sm-10">
                          <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">Atur sebagai Kategori Utama</option>
                            @foreach($main_categories as $main_category)
                              <option {{ old('parent_id') == $main_category->id ? 'selected' : null }} value="{{ $main_category->id }}"> {{ $main_category->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
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