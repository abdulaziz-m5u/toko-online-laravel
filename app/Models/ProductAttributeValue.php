<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function getAttributeOptions($product, $attributeCode)
    {
        $productVariantIDs = $product->variants->pluck('id');
        $attribute = Attribute::where('code', $attributeCode)->first();

        $attributeOptions = ProductAttributeValue::where('attribute_id', $attribute->id)
                            ->whereIn('product_id', $productVariantIDs)
                            ->get();

        return $attributeOptions;
    }
}
