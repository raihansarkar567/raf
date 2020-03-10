@extends('layouts.admin_layout')

@section('content')
<div class="row justify-content-center cusTopMargin">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">All Products</div>

      <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
        @endif
        <table id="allTbl_id" class="table table-striped table-bordered">
         <thead>
          <tr>
           <th>Image</th>
           <th>Name</th>
           <th>id</th>
           <th>Qty</th>
           <th>Discount</th>
           <th>Details</th>
           <th>Button</th>
         </tr>
       </thead>
       <tbody>
        @foreach ($all_products as $all_product)
        <tr>
          <td style="width: 100px; height: 100px;"><img class="card-img-top" src="{{ URL::to('upload/product/'.$all_product -> image_txt)}}" alt="Product Image"></td>
          <td>{{$all_product -> product_name}}</td>
          <td>{{$all_product -> product_id}}</td>
          <td>{{$all_product -> product_quantity}}</td>
          <td>{{$all_product -> product_discount}}</td>
          <td>{{$all_product -> product_details}}</td>
          <td>
            <a href="#" type="button" class="btn btn-primary" role="button">Update</a>
            <a href="#" type="button" class="btn btn-danger" role="button">Delete</a>
        </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/update_product" method="post" id="updateForm" enctype="multipart/form-data">
      {{csrf_field()}}
      <fieldset>
          <div>
          <div class="form-group">
            <div id="product_img" class="col-md-4 control-label"></div>
            <input type="file" class="form-control-file" name="image" id="image">
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label">Product Name</label>
            <input id="product_name" type="text" class="form-control form-control-sm" placeholder="Product Name" name="product_name">
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label">Discount</label>
            <input id="discount" type="number" class="form-control form-control-sm" placeholder="Discount" name="discount">
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label">Details</label>
            <input id="details" type="text" class="form-control form-control-sm" placeholder="Details" name="details">
          </div>
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update</button>
              
        </div>
        
        </fieldset>
    </form>
      <div class="modal-footer">
        <form action="/admin/backpage" method="post" id="deleteForm">
          {{csrf_field()}}
          <fieldset>
            <div>
                  <button type="submit" class="btn btn-danger" id="deleteId">Delete</button>
            </div>
          </fieldset>
        </form>     
      </div>
      </div>
      
    </div>
  </div>
</div>

{{-- model end --}}

<script type="text/javascript">
  $(document).ready( function () {
      var table =$('#allTbl_id').DataTable({
                            retrieve: true,
                            paging: false
                          });

      $('#allTbl_id tbody').on('click', 'tr', function () {
          var data = table.row( this ).data();
          // alert( 'You clicked on '+data[0]+'\'s row' );

          console.log(data);
          $('#product_img').html(data[0]);
          $('#product_name').val(data[1]);
          $('#discount').val(data[4]);
          $('#details').val(data[5]);
          
          $('#updateModal').modal('show');
          
          $('#updateForm').attr('action', '/admin/update_product/'+data[2]);
          $( "#deleteId" ).click(function() {
            var c = confirm( "Are you delete this Product data Permenently" );
            if(c==true){
              $('#deleteForm').attr('action', '/admin/delete_product/'+data[2]);
            }
            
          });
      } );
  });
</script>


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