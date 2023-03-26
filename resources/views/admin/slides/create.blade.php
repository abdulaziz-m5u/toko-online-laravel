@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tambah Slide</h3>
                <a href="{{ route('admin.slides.index')}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('admin.slides.store') }}" enctype="multipart/form-data">
                    @csrf 
                    <div class="form-group row border-bottom pb-4">
                        <label for="title" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="title" value="{{ old('title') }}" id="title">
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="url" class="col-sm-2 col-form-label">Url</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="url" value="{{ old('url') }}" id="url">
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="path" class="col-sm-2 col-form-label">Gambar</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" name="path" value="{{ old('path') }}" id="path">
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="body" class="col-sm-2 col-form-label">Body</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="body" id="body" cols="30" rows=8>{{ old('body') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                              <select class="form-control" name="status" id="status">
                                @foreach($statuses as $value => $status)
                                  <option {{ old('status') == $value ? 'selected' : null }} value="{{ $value }}"> {{ $status }}</option>
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