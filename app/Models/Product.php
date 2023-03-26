<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public const DRAFT = 0;
	public const ACTIVE = 1;
	public const INACTIVE = 2;

	public const STATUSES = [
		self::DRAFT => 'draft',
		self::ACTIVE => 'active',
		self::INACTIVE => 'inactive',
	];

	public const SIMPLE = 'simple';
	public const CONFIGURABLE = 'configurable';
	public const TYPES = [
		self::SIMPLE => 'Simple',
		self::CONFIGURABLE => 'Configurable',
	];
	
	/**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
    
    public static function statuses()
	{
		return self::STATUSES;
	}
	
	public function statusLabel()
	{
		$statuses = $this->statuses();
		
		return isset($this->status) ? $statuses[$this->status] : null;
	}
    
    public static function types()
	{
		return self::TYPES;
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'product_categories');
	}

	public function variants()
	{
		return $this->hasMany(Product::class, 'parent_id')->orderBy('price', 'ASC');
	}

	public function productInventory()
	{
		return $this->hasOne(productInventory::class);
	}

	public function productImages()
	{
		return $this->hasMany(ProductImage::class)->orderBy('id', 'DESC');
	}

	public function scopeActive($query)
	{
		return $query->where('status', 1)
			->where('parent_id', null);
	}

	public function scopePopular($query, $limit = 10)
	{
		$month = now()->format('m');

		return $query->selectRaw('products.*, COUNT(order_items.id) as total_sold')
			->join('order_items', 'order_items.product_id', '=', 'products.id')
			->join('orders', 'order_items.order_id', '=', 'orders.id')
			->whereRaw(
				'orders.status = :order_satus AND MONTH(orders.order_date) = :month',
				[
					'order_status' => Order::COMPLETED,
					'month' => $month
				]
			)
			->groupBy('products.id')
			->orderByRaw('total_sold DESC')
			->limit($limit);
	}

	public function priceLabel()
	{
		return ($this->variants->count() > 0) ? $this->variants->first()->price : $this->price;
	}

	public function configurable()
	{
		return $this->type == 'configurable';
	}

	public function parent()
	{
		return $this->belongsTo(Product::class, 'parent_id');
	}

	public function productAttributeValues()
	{
		return $this->hasMany(ProductAttributeValue::class, 'parent_product_id');
	}
}
