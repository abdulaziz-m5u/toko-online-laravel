@extends('frontend.layout')

@section('content')
	<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container-fluid">
			<div class="breadcrumb-content text-center">
				<h2>Register</h2>
				<ul>
					<li><a href="#">home</a></li>
					<li>register</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="shop-page-wrapper shop-page-padding ptb-100">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3">
					@include('frontend.partials.user_menu')
				</div>
				<div class="col-lg-9">
                    @if(session()->has('message'))
                        <div class="content-header mb-3 pb-0">
                            <div class="container-fluid">
                                <div class="mb-0 alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show" role="alert">
                                    <strong>{{ session()->get('message') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> 
                            </div><!-- /.container-fluid -->
                        </div>
                    @endif
					<div class="login">
						<div class="login-form-container">
							<div class="login-form">
                                    <form action="{{ url('profile') }}" method="post">
									@csrf
                                    @method('put')
									<div class="form-group row">
										<div class="col-md-6">
                                            <div class="checkout-form-list">
                                                <label>Nama Pertama <span class="required">*</span></label>										
                                                <input type="text" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}">
                                            </div>
											@error('first_name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="col-md-6">
                                            <div class="checkout-form-list">
                                                <label>Nama Akhir <span class="required">*</span></label>										
                                                <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}">
                                            </div>
                                            @error('last_name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-12">
                                            <div class="checkout-form-list">
                                                <label>Address <span class="required">*</span></label>
                                                <input type="text" name="address1" value="{{ old('address1') }}">
                                            </div>
                                            @error('address1')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-12">
                                            <div class="checkout-form-list">
                                                <input type="text" name="address2" value="{{ old('address2', auth()->user()->address2) }}">
                                            </div>
                                            @error('address2')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-6">
                                            <label>Provinsi<span class="required">*</span></label>
                                            <select name="province_id" id="shipping-province">
                                                @foreach($provinces as $id => $province)
                                                    <option value="{{ $id }}">{{ $province }}</option>
                                                @endforeach
                                            </select>
                                            @error('province_id')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="col-md-6">
                                            <label>City<span class="required">*</span></label>
                                            <select name="city_id" id="city_id">
                                                @foreach($cities as $id => $city)
                                                    <option value="{{ $id }}">{{ $city }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-6">
                                            <div class="checkout-form-list">
                                                <label>Postcode / Zip <span class="required">*</span></label>										
                                                <input type="text" name="postcode" value="{{ old('postcode', auth()->user()->postcode) }}">
                                            </div>
                                            @error('postcode')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
										<div class="col-md-6">
                                            <div class="checkout-form-list">
                                                <label>Phone  <span class="required">*</span></label>										
                                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                            </div>
											@error('phone')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-12">
                                            <input type="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" placeholder="Email">
											@error('email')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="button-box">
										<button type="submit" class="default-btn floatright">Update Profile</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- register-area end -->
@endsection