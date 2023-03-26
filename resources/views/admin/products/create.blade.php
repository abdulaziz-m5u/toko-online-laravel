@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Buat Produk</h3>
                <a href="{{ route('admin.products.index')}}" class="btn btn-success shadow-sm float-right"> <i class="fa fa-arrow-left"></i> Kembali</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form method="post" action="{{ route('admin.products.store') }}">
                    @csrf 
                    <div class="form-group row border-bottom pb-4">
                        <label for="type" class="col-sm-2 col-form-label">Tipe Kategori</label>
                        <div class="col-sm-10">
                          <select class="form-control product-type" name="type" id="type">
                            @foreach($types as $value => $type)
                              <option {{ old('type') == $value ? 'selected' : null }} value="{{ $value }}"> {{ $type }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="sku" class="col-sm-2 col-form-label">SKU</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="sku" value="{{ old('sku') }}" id="sku">
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="name" class="col-sm-2 col-form-label">Nama Produk</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name">
                        </div>
                    </div>
                    <div class="form-group row border-bottom pb-4">
                        <label for="category_id" class="col-sm-2 col-form-label">Kategori Produk</label>
                        <div class="col-sm-10">
                        <!-- sampai sini -->
                          <select class="form-control select-multiple"  multiple="multiple" name="category_id[]" id="category_id">
                            @foreach($categories as $category)
                              <option {{ old('category_id') == $category->id ? 'selected' : null }} value="{{ $category->id }}"> {{ $category->name }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="configurable-attributes">
                      @if(count($configurable_attributes) > 0)
                        <p class="text-primary mt-4">Konfigurasi Attribute Produk</p>
                        <hr/>
                        @foreach($configurable_attributes as $configurable_attribute)
                          <div class="form-group row border-bottom pb-4">
                              <label for="{{ $configurable_attribute->code }}" class="col-sm-2 col-form-label">{{ $configurable_attribute->code }}</label>
                              <div class="col-sm-10">
                              <!-- sampai sini -->
                                <select class="form-control select-multiple"  multiple="multiple" name="{{ $configurable_attribute->code }}[]" id="{{ $configurable_attribute->code }}">
                                  @foreach($configurable_attribute->attribute_options as $attribute_option)
                                    <option value="{{ $attribute_option->id }}"> {{ $attribute_option->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                          </div>
                        @endforeach
                      @endif   
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

@push('style-alt')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script-alt')
<script
        src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
        crossorigin="anonymous"
    >
    </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
      $('.select-multiple').select2();
      function showHideConfigurableAttributes() {
			var productType = $(".product-type").val();
				
			if (productType == 'configurable') {
				$(".configurable-attributes").show();
			} else {
				$(".configurable-attributes").hide();
			}
		}
		$(function(){
			showHideConfigurableAttributes();
			$(".product-type").change(function() {
				showHideConfigurableAttributes();
			});
		});
</script>
@endpush