@extends('layouts.app')

@section('content')

@if(Session::has('cart'))
<div class="row cusTopMargin">
	<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
		<ul class="list-group">
			@foreach($products as $product)
				<li class="list-group-item">
					<span> Quantity: {{$product['qty']}}</span>
					<strong> {{$product['item'] -> product_name}} </strong>
					<span> Price <label class="label-success">{{$product['price']}}</label></span>
					<div class="button-group">
						<button type="button" class="btn btn-primary btn-xs dropdown-toogle" data-toggle="dropdown" >Action <span class="caret"></span></button>
						<ul class="dropdown-menu">
							li><a href="#">Reduce by 1</a>
							li><a href="#">Reduce all</a>
						</ul>
					</div>
				</li>
			@endforeach
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
		<strong>Total Price {{ $totalPrice }}</strong>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
		<a href="{{URL::to('/checkout')}}" type="button" class="btn btn-info" role="button">Checkout</a>

		<a href="{{ route('due.checkout') }}" type="button" class="btn btn-info" role="button">Due Checkout</a>
	</div>
</div>
@else
<div class="row">
	<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
		<h1>No Item In Cart!</h1>
	</div>
</div>
@endif


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