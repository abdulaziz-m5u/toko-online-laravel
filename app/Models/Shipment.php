<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const PENDING = 'pending';
    public const SHIPPED = 'shipped';
    
    public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
