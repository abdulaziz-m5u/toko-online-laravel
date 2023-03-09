<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\ProductImageRequest;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return view('admin.product_images.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('admin.product_images.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductImageRequest $request, Product $product)
    {
        if($request->validated()) {
            $path = $request->file('path')->store(
                'product/images', 'public'
            );
            ProductImage::create(['path' => $path, 'product_id' => $product->id]);
        }

        return redirect()->route('admin.products.product_images.index', $product)->with([
            'message' => 'Berhasil di upload !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductImage $product_image)
    {
        File::delete('storage/'. $product_image->path);
        $product_image->delete();

        return redirect()->back()->with([
            'message' => 'Berhasil di hapus !',
            'alert-type' => 'danger'
        ]);
    }
}
