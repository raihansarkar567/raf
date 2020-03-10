@extends('layouts.app')

@section('content')
<div class="container cusTopMargin">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Product</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{-- Session Massege section --}}
            
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }} {{ Session::get('product_name') }}</strong>
                    </div>
                    @endif

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Session Massege section End --}}

                    {{-- form start --}}

                    <form class="well form-horizontal" action="{{url('/save_product')}}" method="post"  id="product_form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <fieldset>

                            <!-- Form Name -->
                            <legend><center><h2><b>Add Product</b></h2></center></legend><br>

                            <!-- Text input-->

                            <div class="form-group">
                              <label class="col-md-4 control-label">Business ID</label>  
                              <div class="col-md-4 inputGroupContainer">
                                <div class="input-group">
                                  <input  name="business_id" placeholder="business_id" class="form-control"  type="text" value="{{Auth::user()->id}}" readonly>
                              </div>
                          </div>
                      </div>

                      <!-- Text input-->

                      <div class="form-group">
                          <label class="col-md-4 control-label">Product Name</label>  
                          <div class="col-md-4 inputGroupContainer">
                            <div class="input-group">
                              <input  name="product_name" placeholder="product Name" class="form-control"  type="text">
                          </div>
                      </div>
                  </div>

                  
                  <!-- Text input-->

                  <div class="form-group">
                      <label class="col-md-4 control-label">Quantity</label>  
                      <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                          <input  name="product_quantity" placeholder="Quantity" class="form-control"  type="number">
                      </div>
                  </div>
              </div>

              <!-- Text input-->

              <div class="form-group">
                  <label class="col-md-4 control-label" >Cost</label> 
                  <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                      <input name="product_cost" placeholder="Cost" class="form-control"  type="number">
                  </div>
              </div>
          </div>

          <!-- Text input-->

          <div class="form-group">
              <label class="col-md-4 control-label" >Rate</label> 
              <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                  <input name="product_rate" placeholder="Rate" class="form-control"  type="number">
              </div>
          </div>
      </div>

      <!-- Text input-->
      <div class="form-group">
          <label class="col-md-4 control-label">Discount</label>  
          <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
              <input name="product_discount" placeholder="Discount" class="form-control"  type="number">
          </div>
      </div>
  </div>
  <div class="form-group"> 
      <label class="col-md-4 control-label">Unit</label>
      <div class="col-md-4 selectContainer">
        <div class="input-group">
          <select name="product_unit" class="form-control selectpicker">
            <option value="unit">Select your Unit</option>
            <option>tk</option>
            <option>USD</option>
            <option>Litter</option>
            <option>kg</option>
            <option>Inch</option>
            <option>cm</option>
            <option>meter</option>
            <option>pice</option>
            <option>unit</option>
            
        </select>
    </div>
</div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">Group/Company Details</label>  
  <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
      <input name="product_details" placeholder="Group/Company" class="form-control" type="text">
  </div>
</div>
</div>

{{-- file inpute --}}
<div class="form-group">
    <label for="image" class="col-md-4 control-label">Image Input</label>
    <input type="file" class="form-control-file" name="image" id="image">
</div>


<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4"><br>
    <button type="submit" class="btn btn-warning" >Submit</button>
</div>
</div>

</fieldset>
</form>

{{-- form end --}}

</div>
</div>
</div>
</div>
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
