@extends('frontend.layout')

@section('content')
    <!-- slider -->
        <div class="slider-area">
            <div class="slider-active owl-carousel">
                <div class="single-slider-4 slider-height-6 bg-img" style="background-image: url('test.jpg')">
                    <div class="container">
                        <div class="row">
                            <div class="ml-auto col-lg-6">
                                <div class="furniture-content fadeinup-animated">
                                    <h2 class="animated">Title</h2>
                                    <p class="animated">body</p>
                                    <a class="furniture-slider-btn btn-hover animated" href="#">Go</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider-4 slider-height-6 bg-img" style="background-image: url({{ asset('themes/ezone/assets/img/slider/9.jpg') }})">
                    <div class="container">
                        <div class="row">
                            <div class="ml-auto col-lg-6">
                                <div class="furniture-content fadeinup-animated">
                                    <h2 class="animated">Comfort  <br>Collection.</h2>
                                    <p class="animated">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <a class="furniture-slider-btn btn-hover animated" href="product-details.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider-4 slider-height-6 bg-img" style="background-image: url({{ asset('themes/ezone/assets/img/slider/19.jpg') }})">
                    <div class="container">
                        <div class="row">
                            <div class="ml-auto col-lg-6">
                                <div class="furniture-content fadeinup-animated">
                                    <h2 class="animated">Comfort  <br>Collection.</h2>
                                    <p class="animated">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <a class="furniture-slider-btn btn-hover animated" href="product-details.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- end -->
    <!-- products -->
    <div class="popular-product-area wrapper-padding-3 pt-115 pb-115">
        <div class="container-fluid">
            <div class="section-title-6 text-center mb-50">
                <h2>Popular Product</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
            </div>
            <div class="product-style">
                <div class="popular-product-active owl-carousel">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="#">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left add-to-fav" title="Wishlist"  product-slug="#" href="">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top add-to-card" title="Add To Cart" href="" product-id="#" product-type="#" product-slug="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right quick-view" title="Quick View" product-slug="#" href="">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="#">Name</a></h4>
                                <span>test</span>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
@endsection