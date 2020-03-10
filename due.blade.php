@extends('layouts.app')

@section('content')
{{-- Due Account create --}}
	<form class="form-inline cusTopMargin" action="{{ route('add.due.acc') }}" method="post" id="due_add_form">
		{{csrf_field()}}
		<div class="form-group mb-2">
			<label for="due_name" class="sr-only">Name</label>
			<input type="text" class="form-control" id="due_name" name="due_name" placeholder="Raihan@hink" required>
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<label for="due_num" class="sr-only">Phone</label>
			<input type="text" class="form-control" id="due_num" name="due_num" placeholder="01xxxxxxxx" required>
		</div>
		<button type="submit" class="btn btn-primary mb-2">Create New Due Account</button>
	</form>
{{-- Due acc from end --}}
@if(Session::has('cart'))
<div class="card-body">
	<form class="well form-horizontal" action="{{ route('submit.due.checkout') }}" method="post"  id="due_form">
		{{csrf_field()}}
		<fieldset>
			<div class="form-group"> 
				<label class="col-md-4 control-label">Account Name</label>
				<div class="col-md-4 selectContainer">
					<div class="input-group">
						<select name="due_name" class="form-control selectpicker">
							<option value="Account Name">Select Account Name</option>
							@foreach ($d_info as $due_name)
								<option>{{$due_name->d_ac_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<!-- Text input-->

			<div class="form-group">
				<label class="col-md-4 control-label">Date</label>  
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						{{-- <p id="demo"></p> --}}
						<input id="date_time"  name="date_time" placeholder="Date" class="form-control"  type="text" placeholder="date" readonly>
					</div>
				</div>
			</div>
			<!-- Text input-->

			<div class="form-group">
				<label class="col-md-4 control-label">Total</label>  
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<input  name="total_amount" placeholder="Total Amount" class="form-control"  type="text" value="{{ $totalPrice }}" readonly>
					</div>
				</div>
			</div>
			<!-- Text input-->

			<div class="form-group">
				<label class="col-md-4 control-label">Paid</label>  
				<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<input  name="money_paid" placeholder="paid amount" class="form-control"  type="number">
					</div>
				</div>
			</div>
			{{-- button --}}
			<div class="form-group">
				<label class="col-md-4 control-label"></label>
				<div class="col-md-4"><br>
					<button onclick="dateFunction()" type="submit" class="btn btn-warning" >Submit</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>
<hr>
@endif


<!-- Modal -->
<div class="modal fade" id="dueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Due Pay</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form action="/submit_due_paid" method="post" id="dueForm">
			{{csrf_field()}}
			<fieldset>
        	<div>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Paid Due</button>

			        <label class="col-md-4 control-label">Pay Now 
			        	<input id="payNow" type="number" class="form-control form-control-sm" placeholder="Pay Now" name="payNow"></label>
					

					<p id="name" class="col-md-4"><b>Name</b></p>
					<p id="mobile" class="col-md-4">Mobile</p>
					
					<div class="form-group">
						<label class="col-md-4 control-label">Total Due</label>
						<input id="total_due" type="number" class="form-control form-control-sm" placeholder="Total Due" name="total_due" readonly>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Last Paid</label>
						<input id="last_paid" type="number" class="form-control form-control-sm" placeholder="Last Paid" name="last_paid" readonly>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Last Due</label>
						<input id="last_due" type="number" class="form-control form-control-sm" placeholder="Last Due" name="last_due" readonly>
					</div>
				
				</div>
				<div class="modal-footer">
			        
			    </div>
				</fieldset>
		</form>
		
      </div>
      
    </div>
  </div>
</div>

{{-- model end --}}

<table id="table_id" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Mobile</th>
			<th>Due</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($d_info as $dues)
			<tr>
				<td>{{$dues->d_ac_name}}</td>
				<td>{{$dues->d_ac_mobile}}</td>
				<td>{{$dues->d_total_amo}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<script>
	function dateFunction() {
		var dt = new Date();
		document.getElementById("date_time").value = dt;
	}
</script>
{{-- <script type="text/javascript">
	$(document).ready(function(){
		var table = $('#datatable').DataTable();

		//start edit record
		table.on('click', '.edit', function() {
			$tr = $(this).closest('tr');
			if($($tr).hasClass('child')){
				$tr = $tr.prev('.parent');
			}

			var data = table.row($tr).data();
			console.log(data);

			$('#name').val(data[1]);
			$('#mobile').val(data[2]);
			$('#total_due').val(data[3]);
			

			$('#dueForm').attr('action', '/due_pay/'+data[0]);
			$('#dueModal').modal('show');
		})
		//end edit record
	})
</script> --}}

<script type="text/javascript">
	$(document).ready( function () {
	    var table = $('#table_id').DataTable();

	    $('#table_id tbody').on('click', 'tr', function () {
	        var data = table.row( this ).data();
	        // alert( 'You clicked on '+data[0]+'\'s row' );

	        console.log(data);
	        document.getElementById("name").innerHTML = data[0];
	        document.getElementById("mobile").innerHTML = data[1];
	        $('#total_due').val(data[2]);

	        var array = @json($d_info);
	        array.forEach(arrFunction);
	        function arrFunction(value){
	        	if(value["d_ac_name"]==data[0]){
	        		$('#last_paid').val(value["d_last_paid_amo"]);
	        		$('#last_due').val(value["d_last_due_amo"]);
	        	}
	        }
	        
	        $('#dueModal').modal('show');
	        
	        $('#dueForm').attr('action', '/submit_due_paid/'+data[0]);
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

