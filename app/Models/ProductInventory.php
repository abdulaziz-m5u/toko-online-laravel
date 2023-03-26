<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function reduceStock($productId, $qty)
	{
		$inventory = self::where('product_id', $productId)->firstOrFail();

		if ($inventory->qty < $qty) {
			$product = Product::findOrFail($productId);
			throw new \App\Exceptions\OutOfStockException('The product '. $product->sku .' is out of stock');
		}

		$inventory->qty = $inventory->qty - $qty;
		$inventory->save();
	}

	public static function increaseStock($productId, $qty)
	{
		$inventory = self::where('product_id', $productId)->firstOrFail();
		$inventory->qty = $inventory->qty + $qty;
		$inventory->save();
	}
}
