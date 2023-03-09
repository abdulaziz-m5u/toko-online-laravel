<p class="text-primary mt-4">Product Variants</p>
<hr/>
 @foreach ($product->variants as $variant)
    <div class="row">
    <input type="hidden" value="{{ $variant->id }}" name="variants[{{ $variant->id }}][id]">
        <div class="col-md-2">
            <div class="form-group border-bottom pb-4">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" name="variants[{{ $variant->id }}][sku]" value="{{ old('sku', $variant->sku) }}" id="sku">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group border-bottom pb-4">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="variants[{{ $variant->id }}][name]" value="{{ old('name', $variant->name) }}" id="name">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group border-bottom pb-4">
                <label for="price" class="form-label">Harga Produk</label>
                <input type="number" class="form-control" name="variants[{{ $variant->id }}][price]" value="{{ old('price', $variant->price) }}" id="price">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group border-bottom pb-4">
                <label for="qty" class="form-label">Jumlah Produk</label>
                <input type="number" class="form-control" name="variants[{{ $variant->id }}][qty]" value="{{ old('qty', ($variant->productInventory) ? $variant->productInventory->qty : null) }}" id="qty">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group border-bottom pb-4">
                <label for="weight" class="form-label">Berat Produk</label>
                <input type="number" class="form-control" name="variants[{{ $variant->id }}][weight]" value="{{ old('weight', $variant->weight) }}" id="weight">
            </div>
        </div>
    </div>
@endforeach
<hr/>