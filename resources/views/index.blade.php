<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
	<style>
		.login{
			background-color: #4043bc
		}
		.login:hover{
			#D37194
		}
	</style>
<link rel="stylesheet" href="{{asset('assets/css/argon-dashboard.css')}}">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
                    <img src="assets/img/hero/DOC4.jpg" alt="">
                {{-- <p class="d-flex align-items-center mt-3" data-animation="fadeInLeft" data-delay=".6s">Vendor Invoicing System is a website created to make it easier for MIP/MKP/MHA parties to receive invoices from vendors, where the process is done online entry.</p> --}}
				</div>

				<form method="POST" action="{{ route('loginpost') }}">
					@csrf
                    <div class="page-title">
                    <h1 class="mb-3" style="text-align: center;"><strong>Login e-Spice </strong></h1>
                    </div>
					@if($message = Session::get('destroy'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>Sorry!</strong> {{$message}}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                @elseif($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  <strong>Success!</strong> {{$message}}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                @elseif($message = Session::get('warning'))
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                  <strong>Success!</strong> {{$message}}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                              @endif
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz" required>
						<input class="input100"  @error('email[]') is-invalid @enderror type="email" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
						@error('email[]')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
					</div>
					
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password"  @error('email[]') is-invalid @enderror name="password" placeholder="Password" id="myInput" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
						@error('email[]')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
					</div>
					&nbsp;&nbsp;&nbsp;<input type="checkbox" onclick="myFunction()" class="mt-2"> Show Password

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn login">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<!-- <span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a> -->
						{{-- <a class="txt2" href="{{url('daftar-login')}}">
							REGISTER NOW
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a> --}}
					</div>

					<div class="text-center p-t-150">
					
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{asset('login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('login/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('login/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
			function myFunction() {
			var x = document.getElementById("myInput");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
			}

		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{asset('login/js/main.js')}}"></script>

</body>
</html>