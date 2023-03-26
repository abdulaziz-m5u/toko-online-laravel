<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Slide;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function index()
    {
        $products = Product::active()->get();
        $slides = Slide::active()->orderBy('position', 'ASC')->get();;
        
        return view('frontend.homepage', compact('products', 'slides'));
    }
}
