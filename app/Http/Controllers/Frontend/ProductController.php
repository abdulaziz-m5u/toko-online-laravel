<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttributeOption;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeValue;

class ProductController extends Controller
{
    private $selectedSort = null;

    public function index(Request $request)
    {
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $products = Product::active();
        $colors = AttributeOption::whereHas(
			'attribute',
			function ($query) {
					$query->where('code', 'color')
						->where('is_filterable', 1);
			}
		)
        ->orderBy('name', 'asc')->get();
        $sizes = AttributeOption::whereHas(
			'attribute',
			function ($query) {
				$query->where('code', 'size')
					->where('is_filterable', 1);
			}
        )->orderBy('name', 'asc')->get();
        $categories = Category::parentCategories()
			->orderBy('name', 'asc')
            ->get();

        $selectedSort = url('products');
        $sorts = [
            url('products') => 'Default',
            url('products?sort=price-asc') => 'Price - Low to High',
            url('products?sort=price-desc') => 'Price - High to Low',
            url('products?sort=created_at-desc') => 'Newest to Oldest',
            url('products?sort=created_at-asc') => 'Oldest to Newest',
        ];

        $products = $this->_searchProducts($products, $request);
        $products = $this->_filterProductsByPriceRange($products, $request);
        $products = $this->_filterProductsByAttribute($products, $request);
        $products = $this->_sortProducts($products, $request);
        $selectedSort = $this->selectedSort;
        $products = $products->paginate(10);
        
        return view('frontend.products.index', compact('products','colors','sizes','minPrice','maxPrice','categories', 'sorts','selectedSort'));
    }

    private function _filterProductsByPriceRange($products, $request)
	{
		$lowPrice = null;
		$highPrice = null;

		if ($priceSlider = $request->query('price')) {
            $prices = explode('-', $priceSlider);

			$lowPrice = (float)$prices[0];
			$highPrice = (float)$prices[1];

			if ($lowPrice && $highPrice) {
				$products = $products->where('price', '>=', $lowPrice)
					->where('price', '<=', $highPrice)
					->orWhereHas(
						'variants',
						function ($query) use ($lowPrice, $highPrice) {
							$query->where('price', '>=', $lowPrice)
								->where('price', '<=', $highPrice);
						}
					);
			}
		}

		return $products;
	}

    private function _searchProducts($products, $request)
	{
		if ($q = $request->query('q')) {
			$q = str_replace('-', ' ', Str::slug($q));
			
			$products = $products->whereRaw('MATCH(name, slug, short_description, description) AGAINST (? IN NATURAL LANGUAGE MODE)', [$q]);

			$this->data['q'] = $q;
		}

		if ($categorySlug = $request->query('category')) {
			$category = Category::where('slug', $categorySlug)->firstOrFail();

			$childIds = Category::childIds($category->id);
			$categoryIds = array_merge([$category->id], $childIds);

			$products = $products->whereHas(
				'categories',
				function ($query) use ($categoryIds) {
					$query->whereIn('categories.id', $categoryIds);
				}
			);
		}

		return $products;
    }
    
    private function _filterProductsByAttribute($products, $request)
	{
		if ($attributeOptionID = $request->query('option')) {
			$attributeOption = AttributeOption::findOrFail($attributeOptionID);

			$products = $products->whereHas(
				'ProductAttributeValues',
				function ($query) use ($attributeOption) {
					$query->where('attribute_id', $attributeOption->attribute_id)
						->where('text_value', $attributeOption->name);
				}
			);
		}

		return $products;
    }
    
    private function _sortProducts($products, $request)
	{
		if ($sort = preg_replace('/\s+/', '', $request->query('sort'))) {
			$availableSorts = ['price', 'created_at'];
			$availableOrder = ['asc', 'desc'];
			$sortAndOrder = explode('-', $sort);

			$sortBy = strtolower($sortAndOrder[0]);
			$orderBy = strtolower($sortAndOrder[1]);

			if (in_array($sortBy, $availableSorts) && in_array($orderBy, $availableOrder)) {
				$products = $products->orderBy($sortBy, $orderBy);
			}

            $this->selectedSort = url('products?sort='. $sort);
		}
		
		return $products;
	}

    public function show(Product $product)
    {
        if (!$product->configurable()) {
            return view('frontend.products.show', compact('product'));
        }

        $colors = ProductAttributeValue::getAttributeOptions($product, 'color')->pluck('text_value', 'text_value');
        $sizes = ProductAttributeValue::getAttributeOptions($product, 'size')->pluck('text_value', 'text_value');
        return view('frontend.products.show', compact('product', 'sizes', 'colors'));
    }

    public function quickView(Product $product)
	{
		if (!$product->configurable()) {
            return view('frontend.products.quick_view', compact('product'));
        }

        $colors = ProductAttributeValue::getAttributeOptions($product, 'color')->pluck('text_value', 'text_value');
        $sizes = ProductAttributeValue::getAttributeOptions($product, 'size')->pluck('text_value', 'text_value');
        return view('frontend.products.quick_view', compact('product', 'sizes', 'colors'));
	}
}
