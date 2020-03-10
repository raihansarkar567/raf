<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="_token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet"> {{-- custom css file --}}

	{{-- script files --}}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> {{-- for dropdown menue --}}
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


</head>
<body>
	<div id="app">
		<nav class="navbar fixed-top navbar-expand-md navbar-light bg-white shadow-sm">
			<div class="container">
				<a class="navbar-brand" href="{{ url('/admin') }}">
					{{ config('app.name', 'Laravel') }}
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto">

					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Authentication Links -->
						@guest
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.login') }}">{{ __('Admin Login') }}</a>
						</li>
						@if (Route::has('admin.register'))
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.register') }}">{{ __('Admin Register') }}</a>
						</li>
						@endif
						@else
						{{-- nav menu- --}}
						<li>
							<div class="add_button">
								<a href="{{route('home')}}" type="button" class="btn btn-see" role="button">Home</a>
								<a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-see" role="button">Deshboard</a>
								<a href="{{route('admin.all.product')}}" type="button" class="btn btn-see" role="button">All Product</a>
								<span>
									<a type="button" class="btn btn-danger" role="button" id="removeAccount">Account Remove</a>

									<script type="text/javascript">
										$(document).ready( function () {

											$( "#removeAccount" ).click(function() {
												var c = confirm( "Are you Sure???" );
												if(c==true){
													var d = confirm( "Your all data and account will be deleted Permenently!!!" );
													if(d==true){
														var id={{Auth::guard('admin')->user()->business_id}}
														$('#removeAccount').attr('href', '/admin/delete_account/'+id);
													}
												}

											});
										});
									</script>
								</span>


							</div>
						</li>
						{{-- nav menu end --}}
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								{{ Auth::user()->name }} Admin<span class="caret"></span>
							</a>

							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
                            {{-- <div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('logout') }}">{{ __('Logout') }}</a>
                              </div>
                          </div> --}}
                      </li>
                      @endguest
                  </ul>
              </div>
          </div>
      </nav>

      <main class="py-4">
      	@yield('content')
      </main>
  </div>
</body>
</html>
