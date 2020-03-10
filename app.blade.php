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
                <a class="navbar-brand" href="{{ url('/home') }}">
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
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        {{-- nav menu- --}}
                        <li>
                            <div class="add_button">
                              <a href="{{URL::to('/add_product')}}" type="button" class="btn btn-see" role="button"><b>Add</b></a>
                              <a href="{{URL::to('/shopping_cart')}}" type="button" class="btn btn-see" role="button"><b>Shop</b>
                                <span class="badge" id="badge">{{Session::has('cart') ? Session::get('cart') -> totalQty : ''}}</span>
                            </a>
                            <a href="{{ route('due') }}" type="button" class="btn btn-see" role="button"><b>Due</b></a>
                            <a href="{{URL::to('/reset_product')}}" type="button" class="btn btn-see" role="button"><b>Reset</b></a>
                            <a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-see" role="button"><b>Deshboard</b></a>
                            <a href="{{ route('bill.pay') }}" type="button" class="btn btn-see" role="button"><b>Bill Pay</b></a>
                            {{--  --}}
                            <span class="dropdown" href="#">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    My Account
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" id="editProfile">Edit Profile</a>
                                    <a class="dropdown-item" href="#" id="userSetting">Settings</a>
                                    <a class="dropdown-item" href="#">Privecy</a>
                                </div>
                                {{-- js function for Edit Profile Btn --}}
                                <script type="text/javascript">
                                  $(document).ready( function () {

                                      $( "#editProfile" ).click(function() {


                                          console.log("userClick");
                                          $('#user_name').val('{{Auth::user()->name}}');
                                          $('#business_name').val('{{Auth::user()->business_name}}');
                                          $('#address').val('{{Auth::user()->address}}');
                                          $('#mobile').val('{{Auth::user()->mobile}}');
                                          $('#catagories').val('{{Auth::user()->catagories}}');
                                          
                                          $('#updateModal').modal('show');
                                          var id="{{Auth::user()->id}}"
                                          $('#updateForm').attr('action', '/edit_profile/'+id);
                                      } );
                                  });
                              </script>
                          </span>
                          {{--  --}}
                      </div>
                  </li>
                  {{-- nav menu end --}}
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
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











<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <form action="/edit_profile" method="post" id="updateForm">
      {{csrf_field()}}
      <fieldset>
          <div>
              <div class="form-group">
                <label class="col-md-4 control-label">User Name</label>
                <input id="user_name" type="text" class="form-control form-control-sm" placeholder="User Name" name="user_name" required>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Business Name</label>
                <input id="business_name" type="text" class="form-control form-control-sm" placeholder="Business Name" name="business_name" required>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Business Address</label>
                <input id="address" type="text" class="form-control form-control-sm" placeholder="Business Area" name="address" required>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Mobile No</label>
                <input id="mobile" type="text" class="form-control form-control-sm" placeholder="Mobile No..." name="mobile" required>
            </div>
            <div class="form-group row">
                <label for="catagories" class="col-md-4 col-form-label text-md-right">{{ __('Catagorys') }}</label>

                <div class="col-md-6">
                    <select name="catagories" class="form-control selectpicker">
                        <option id="catagories" value="{{ old('catagories') }}" class="form-control" autofocus required>Select your Catagory</option>
                        <option>Food</option>
                        <option>Clothes</option>
                        <option>Fashion</option>
                        <option>Grocery</option>
                        <option>Medicine</option>
                        <option>Corner Shop</option>
                        <option>Electronics & Hardware</option>
                        <option>Technology</option>
                        <option>Vehicle</option>
                        <option>Sports</option>
                        <option>Music</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>
            
            
        </div>
        
    </fieldset>
    
    <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       <button type="submit" class="btn btn-primary">Update</button>
   </div>
</form>
</div>

</div>
</div>
</div>

{{-- model end --}}

</body>
</html>
