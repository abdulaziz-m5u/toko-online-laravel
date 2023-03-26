<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
		// Cart::destroy();
		$items = Cart::content();
		
		return view('frontend.carts.index', compact('items'));
    }

    private function _getItemQuantity($itemQty)
	{
		$items = Cart::content();
		$itemQuantity = $itemQty;
		if ($items) {
			foreach ($items as $item) {
				$itemQuantity += $item->qty;
			}
		}
		return $itemQuantity;
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');
		
		$product = Product::findOrFail($params['product_id']);
        $slug = $product->slug;

		$attributes = [];
		if ($product->configurable()) {
			$product = Product::from('products as p')
				->whereRaw(
					"p.parent_id = :parent_product_id
				and (select pav.text_value 
						from product_attribute_values pav
						join attributes a on a.id = pav.attribute_id
						where a.code = :size_code
						and pav.product_id = p.id
						limit 1
					) = :size_value
				and (select pav.text_value 
						from product_attribute_values pav
						join attributes a on a.id = pav.attribute_id
						where a.code = :color_code
						and pav.product_id = p.id
						limit 1
					) = :color_value
					",
					[
						'parent_product_id' => $product->id,
						'size_code' => 'size',
						'size_value' => $params['size'],
						'color_code' => 'color',
						'color_value' => $params['color'],
					]
				)->firstOrFail();

			$attributes['size'] = $params['size'];
			$attributes['color'] = $params['color'];
		}

		$itemQuantity =  $this->_getItemQuantity($params['qty']);

		try {
			if ($product->productInventory->qty < $itemQuantity) {
				throw new \App\Exceptions\OutOfStockException('The product '. $product->sku .' is out of stock');
			}	
		} catch (\Throwable $th) {
			return redirect()->back()->with([
				'message' => $th->getMessage(),
				'alert-type' => 'danger'
			]);
		}

		Cart::add(
			$product->id,
			$product->name,
			(int)$params['qty'],
			(float)$product->price,
			['options' => $attributes]
		)->associate('App\Models\Product');

		return redirect()->route('carts.index')->with([
			'message' => 'Produk berhasil di tambahkan !',
			'alert-type' => 'success'
		]);
	}

	public function update(Request $request)
	{
		$params = $request->except('_token');
		
		Cart::update($request->productId, $request->qty);

		\Session::flash('success', 'The cart has been updated');
		return redirect('carts');
	}
	
	public function destroy($id)
	{
		Cart::remove($id);

		return redirect()->back()->with([
			'message' => 'Produk berhasil di hapus !',
			'alert-type' => 'danger'
		]);
	}
}
