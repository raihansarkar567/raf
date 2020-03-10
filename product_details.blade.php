@extends('layouts.app')

@section('content')

{{-- <p>{{$product->product_id}}</p> --}}

<div class="cusTopMargin">
	<img class="card-img-top" src="img/raihan.jpeg" alt="Card image">
	<div>
		<span><b>{{$product -> product_name}}</b></span><br>
		<span>Quantity: </span><span>{{$product -> product_quantity}}</span><span> {{$product -> product_unit}}</span><br>
		<span>Price: </span><span>{{$product -> product_rate}}</span><span> tk</span><br>
		<span>Discount: </span><span>{{$product -> product_discount}}</span><span>%</span><br>
		<span>Total Cost: </span><span>{{$product -> product_discount}}</span><span> tk</span><br>
		<span>Per Cost: </span><span>{{$perCost}}</span><span> tk</span><br>
		<span>Profit: </span><span>{{$product -> product_discount}}</span><span> tk</span><br>
		<span>Details: </span><span>{{$product -> product_details}}</span><br>
		<span>Priority: </span><span>{{$product -> priority}}</span><br>
	</div>

</div>
<div>
	<form class="well form-horizontal" action="{{url('/add_more_product',['id'=>$product->product_id])}}" method="post"  id="product_form">
		{{csrf_field()}}
		<fieldset>

			<!-- Form Name -->
			<legend><center><h2><b>{{ __('Add Product') }}</b></h2></center></legend><br>
			<!-- Text input-->

			<div class="form-group row">
				<label for="qty" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

				<div class="col-md-6">
					<input id="qty" type="number" step="any" class="form-control @error('number') is-invalid @enderror" name="qty" value="{{ old('qty') }}" required autocomplete="number" autofocus>

					@error('qty')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<!-- Text input-->

			<div class="form-group row">
				<label for="cost" class="col-md-4 col-form-label text-md-right">{{ __('Cost') }}</label>

				<div class="col-md-6">
					<input id="cost" type="number" step="any" class="form-control @error('number') is-invalid @enderror" name="cost" value="{{ old('cost') }}" required autocomplete="number" autofocus>

					@error('cost')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>
			<!-- Text input-->

			<div class="form-group row">
				<label for="rate" class="col-md-4 col-form-label text-md-right">{{ __('Rate') }}</label>

				<div class="col-md-6">
					<input id="rate" type="number" step="any" class="form-control @error('number') is-invalid @enderror" name="rate" value="{{$product -> product_rate}}" required autocomplete="number" autofocus>

					@error('rate')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<!-- Button -->
			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="submit" class="btn btn-primary">
						{{ __('Add') }}
					</button>
				</div>
			</div>

		</fieldset>
	</form>
</div>

{{-- Priority Update --}}
<div>
	<form class="well form-horizontal" action="{{url('/priority_update',['id'=>$product->product_id])}}" method="post"  id="product_form">
		{{csrf_field()}}
		<fieldset>

			<!-- Form Name -->
			<legend><center><h2><b>{{ __('Priority Update') }}</b></h2></center></legend><br>
			<!-- Text input-->

			<div class="form-group row">
				<label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Priority') }}</label>

				<div class="col-md-6">
					<input id="priority" type="number" step="any" class="form-control @error('number') is-invalid @enderror" name="priority" value="{{$product -> priority}}" autofocus>

					@error('priority')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<!-- Button -->
			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="submit" class="btn btn-primary">
						{{ __('Set Priority') }}
					</button>
				</div>
			</div>

		</fieldset>
	</form>
</div>

{{-- Return Product --}}
<div>
	<form class="well form-horizontal" action="{{url('/return_product',['id'=>$product->product_id])}}" method="post"  id="product_form">
		{{csrf_field()}}
		<fieldset>

			<!-- Form Name -->
			<legend><center><h2><b>{{ __('Return Product') }}</b></h2></center></legend><br>
			<!-- Text input-->

			<div class="form-group row">
				<label for="return_qty" class="col-md-4 col-form-label text-md-right">{{ __('Return Quantity') }}</label>

				<div class="col-md-6">
					<input id="return_qty" type="number" step="any" class="form-control @error('number') is-invalid @enderror" name="return_qty" value="{{ old('return_qty') }}" autofocus required>

					@error('number')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>
			<!-- Text input-->

			<div class="form-group row">
				<label for="return_price" class="col-md-4 col-form-label text-md-right">{{ __('Return Price') }}</label>

				<div class="col-md-6">
					<input id="return_price" type="number" step="any" class="form-control @error('number') is-invalid @enderror" name="return_price" value="{{ old('return_price') }}" autofocus required>

					@error('return_price')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>

			<!-- Button -->
			<div class="form-group row mb-0">
				<div class="col-md-6 offset-md-4">
					<button type="submit" class="btn btn-primary">
						{{ __('Return Product') }}
					</button>
				</div>
			</div>

		</fieldset>
	</form>
</div>



{{-- scroll top --}}
<button onclick="topFunction()" id="scrollTop" title="Go to top">Top</button>
<script type="text/javascript">
//Get the button
var mybutton = document.getElementById("scrollTop");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
{{-- scroll top end --}}
@endsection