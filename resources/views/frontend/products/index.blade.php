@extends('frontend.layout')

@section('content')
	<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container-fluid">
			<div class="breadcrumb-content text-center">
				<h2>shop grid 3 column</h2>
				<ul>
					<li><a href="#">home</a></li>
					<li>shop grid 3 column</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="shop-page-wrapper shop-page-padding ptb-100">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3">
					<!-- sidebar -->
                    <div class="shop-sidebar mr-50">
                        <form method="GET" action="{{ url('products')}}">
                            <div class="sidebar-widget mb-40">
                                <h3 class="sidebar-title">Filter by Price</h3>
                                <div class="price_filter">
                                    <div id="slider-range"></div>
                                    <div class="price_slider_amount">
                                        <div class="label-input">
                                            <label>price : </label>
                                            <input type="text" id="amount" name="price"  placeholder="Add Your Price" style="width:170px" />
                                            <input type="hidden" id="productMinPrice" value="{{ $minPrice }}"/>
                                            <input type="hidden" id="productMaxPrice" value="{{ $maxPrice }}"/>
                                        </div>
                                        <button type="submit">Filter</button> 
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if ($categories)
                            <div class="sidebar-widget mb-45">
                                <h3 class="sidebar-title">Categories</h3>
                                <div class="sidebar-categories">
                                    <ul>
                                        @foreach ($categories as $category)
                                                <li><a href="{{ url('products?category='. $category->slug) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        
                        @if ($colors)
                            <div class="sidebar-widget sidebar-overflow mb-45">
                                <h3 class="sidebar-title">color</h3>
                                <div class="sidebar-categories">
                                    <ul>
                                        @foreach ($colors as $color)
                                            <li><a href="{{ url('products?option='. $color->id) }}">{{ $color->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if ($sizes)
                            <div class="sidebar-widget mb-40">
                                <h3 class="sidebar-title">size</h3>
                                <div class="product-size">
                                    <ul>
                                        @foreach ($sizes as $size)
                                            <li><a href="{{ url('products?option='. $size->id) }}">{{ $size->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- end -->
				</div>
				<div class="col-lg-9">
					<div class="shop-product-wrapper res-xl">
						<div class="shop-bar-area">
							<div class="shop-bar pb-60">
								<div class="shop-found-selector">
									<div class="shop-found">
										<p><span>{{ count($products) }}</span> Product Found of <span>{{ $products->total() }}</span></p>
									</div>
									<div class="shop-selector">
										<label>Sort By : </label>
                                        <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value)" name="sort" id="">
                                            @foreach($sorts as $url => $sort)
                                                <option {{ $selectedSort == $url ? 'selected' : null }} value="{{ $url }}">{{ $sort }}</option>
                                            @endforeach
                                        </select>
									</div>
								</div>
								<div class="shop-filter-tab">
									<div class="shop-tab nav" role=tablist>
										<a class="active" href="#grid-sidebar3" data-toggle="tab" role="tab" aria-selected="false">
											<i class="ti-layout-grid4-alt"></i>
										</a>
										<a href="#grid-sidebar4" data-toggle="tab" role="tab" aria-selected="true">
											<i class="ti-menu"></i>
										</a>
									</div>
								</div>
							</div>
							<div class="shop-product-content tab-content">
								<div id="grid-sidebar3" class="tab-pane fade active show">
                                <!-- grid view -->
                                    <div class="row">
                                        @forelse ($products as $product)
                                            <!-- grid box -->
                                            <div class="col-md-6 col-xl-4">
                                                <div class="product-wrapper mb-30">
                                                    <div class="product-img">
                                                        <a href="{{ url('product/'. $product->slug) }}">
                                                            @if ($product->productImages->first())
                                                                <img src="{{ asset('storage/'.$product->productImages->first()->path) }}" alt="{{ $product->name }}">
                                                            @else
                                                                <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
                                                            @endif
                                                        </a>
                                                        <span>hot</span>
                                                        <div class="product-action">
                                                            <a class="animate-left add-to-fav" title="Favorite"  product-slug="{{ $product->slug }}" href="">
                                                                <i class="pe-7s-like"></i>
                                                            </a>
                                                            <a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $product->id }}" product-type="{{ $product->type }}" product-slug="{{ $product->slug }}">
                                                                <i class="pe-7s-cart"></i>
                                                            </a>
                                                            <a class="animate-right quick-view" data-toggle="modal" data-target="#exampleModal" title="Quick View" product-slug="{{ $product->slug }}" href="">
                                                                <i class="pe-7s-look"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <h4><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></h4>
                                                        <span>{{ number_format($product->priceLabel()) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end -->
                                        @empty
                                            No product found!
                                        @endforelse
                                    </div>
                                <!-- end -->
								</div>
								<div id="grid-sidebar4" class="tab-pane fade">
                                    <!-- list view -->
                                    <div class="row">
                                        @forelse ($products as $product)
                                        <div class="col-lg-12">
                                            <div class="product-wrapper mb-30 single-product-list product-list-right-pr mb-60">
                                                <div class="product-img list-img-width">
                                                    <a href="{{ url('product/'. $product->slug) }}">
                                                        @if ($product->productImages->first())
                                                            <img src="{{ asset('storage/'.$product->productImages->first()->path) }}" alt="{{ $product->name }}">
                                                        @else
                                                            <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
                                                        @endif
                                                    </a>
                                                    <span>hot</span>
                                                    <div class="product-action-list-style">
                                                        <a class="animate-right" title="Quick View" data-toggle="modal" data-target="#exampleModal" href="#">
                                                            <i class="pe-7s-look"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-content-list">
                                                    <div class="product-list-info">
                                                        <h4><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></h4>
                                                        <span>{{ number_format($product->priceLabel()) }}</span>
                                                        <p>{!! $product->short_description !!}</p>
                                                    </div>
                                                    <div class="product-list-cart-wishlist">
                                                        <div class="product-list-cart">
                                                            <a class="btn-hover list-btn-style add-to-card" href=""  product-id="{{ $product->id }}" product-type="{{ $product->type }}" product-slug="{{ $product->slug }}">add to cart</a>
                                                        </div>
                                                        <div class="product-list-wishlist">
                                                            <a class="btn-hover list-btn-wishlist add-to-fav" title="Favorite"  product-slug="{{ $product->slug }}" href="">
                                                                <i class="pe-7s-like"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            No product found!
                                        @endforelse
                                    </div>
                                    <!-- end -->
								</div>
							</div>
						</div>
					</div>
					<div class="mt-50 text-center">
						{{ $products->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
