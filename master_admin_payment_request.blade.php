@extends('layouts.master_admin_layout')

@section('content')
<div class="row justify-content-center cusTopMargin">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Payment Request</div>

      <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
        @endif


        <table id="table_id" class="table table-striped table-bordered">
         <thead>
          <tr>
           <th>Name</th>
           <th>Mobile</th>
           <th>Ref</th>
           <th>TrxID</th>
           <th>Fnf Ref</th>
           <th>Due Count</th>
           <th>id</th>
           <th>Button</th>
         </tr>
       </thead>
       <tbody>
        @foreach ($payment_req as $pay_req)
        <tr id="rowHide{{$pay_req -> payment_rq_id}}">
          <td>{{$pay_req -> bi_ac_name}}</td>
          <td>{{$pay_req -> bi_ac_mobile}}</td>
          <td>{{$pay_req -> bi_ref_code}}</td>
          <td>{{$pay_req -> bi_trx_id}}</td>
          <td>{{$pay_req -> bi_fnf_ref}}</td>
          <td>{{$pay_req -> bi_warning_count}}</td>
          <td>{{$pay_req -> bus_id}}</td>
          <td>
              <a href="{{route('payment.request.accept',['bus_id'=>$pay_req->bus_id, 'flag'=>'delete'])}}" type="button" class="btn btn-danger" role="button">Delete</a>
            <a id="acceptBtn{{$pay_req -> payment_rq_id}}" type="button" class="btn btn-success" role="button">Accept</a>
        </td>
        </tr>
        <script>
            $(function(){
               // -----------------
               $('#acceptBtn{{$pay_req -> payment_rq_id}}').click(function() {
                let amount = prompt("Input paid amount");
                if(amount!=null && amount>0){
                  var warningData = '{{$pay_req -> bi_warning_count}}';
                  var fnf_ref='{{$pay_req -> bi_fnf_ref}}';
                  var monthly_fee='{{$pay_req -> bi_monthly_fee}}';

                      $.ajax({
                      url: '{{route('payment.request.accept',['bus_id'=>$pay_req->bus_id, 'flag'=>'accept'])}}',
                      type: 'GET',
                      data: { 'fnf_ref': fnf_ref,
                      'warning_count': warningData,
                      'paidAmount': amount,
                      'monthly_fee': monthly_fee },
                      success: function(response)
                      {
                          $('#rowHide{{$pay_req -> payment_rq_id}}').hide();
                          
                          console.log(response);
                      },
                      error: function() {
                          alert('error');
                      }
                  });
                  
                }
                
                
                
            });
               //-----------------
           });    
        </script>
        @endforeach
      </tbody>
    </table>

  </div>
</div>
</div>
</div>



<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable({
      retrieve: true,
      paging: false
    });
  } );
</script>
@endsection