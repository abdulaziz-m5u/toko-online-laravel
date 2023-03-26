@extends('frontend.layout')

@section('content')
<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
	<div class="container-fluid">
		<div class="breadcrumb-content text-center">
			<h2>Forgot Password</h2>
			<ul>
				<li><a href="#">home</a></li>
				<li>Forgot Password</li>
			</ul>
		</div>
	</div>
</div>
<!-- register-area start -->
<div class="register-area ptb-100">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-12 col-lg-12 col-xl-6 ml-auto mr-auto">
				<div class="login">
					<div class="login-form-container">
						<div class="login-form">
							@if (session('status'))
								<div class="alert alert-success" role="alert">
									{{ session('status') }}
								</div>
							@endif

							<form method="POST" action="{{ route('password.email') }}">
								@csrf
								<div class="form-group row">
									<div class="col-md-12">
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">

										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>
								<div class="form-group row mb-0">
									<div class="col-md-12">
										<div class="button-box">
											<button type="submit" class="default-btn floatright">{{ __('Send Password Reset Link') }}</button>
										</div>
									</div>
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