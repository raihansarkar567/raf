@extends('layouts.master_admin_layout')

@section('content')
<div class="row justify-content-center cusTopMargin">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Disable List</div>

      <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
        @endif
        <table id="disableTbl_id" class="table table-striped table-bordered">
         <thead>
          <tr>
           <th>Name</th>
           <th>Mobile</th>
           <th>Ref</th>
           <th>Status</th>
           <th>Fnf Ref</th>
           <th>Ref Amount</th>
           <th>id</th>
           <th>Button</th>
         </tr>
       </thead>
       <tbody>
        @foreach ($bill_info as $bill_data)
        <tr>
          <td>{{$bill_data -> bi_ac_name}}</td>
          <td>{{$bill_data -> bi_ac_mobile}}</td>
          <td>{{$bill_data -> bi_ref_code}}</td>
          <td>{{$bill_data -> bi_status_flag}}</td>
          <td>{{$bill_data -> bi_fnf_ref}}</td>
          <td>{{$bill_data -> bi_ref_amo}}</td>
          <td>{{$bill_data -> bus_id}}</td>
          <td>
            <a href="{{route('payment.enable',['bus_id'=>$bill_data->bus_id])}}" type="button" class="btn btn-success" role="button">Enable</a>
        </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready( function () {
    $('#disableTbl_id').DataTable({
      retrieve: true,
      paging: false
    });
  } );
</script>
@endsection