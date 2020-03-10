@extends('layouts.master_admin_layout')

@section('content')
    <div class="row justify-content-center cusTopMargin">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Master Admin Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="add_button">
                        <a href="{{ route('master.admin.paymentRequest') }}" type="button" class="btn btn-info" role="button">Payment Request</a>

                        <a href="{{ route('disable.list') }}" type="button" class="btn btn-info" role="button">Disable List</a>

                        <a href="{{ route('all.user') }}" type="button" class="btn btn-info" role="button">All User</a>

                        <span class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Send Payment Notice
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('payment.notice',['flag'=>'paidUser'])}}">Only for Paid User</a>
                            <a class="dropdown-item" href="{{route('payment.notice',['flag'=>'trialUser'])}}">Only for Trial User</a>
                          </div>
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6>Paid User</h6>
                            <table id="paidTbl_id" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Name</th>
                                       <th>Ref</th>
                                       <th>id</th>
                                   </tr>
                               </thead>
                               <tbody>
                                @foreach ($bill_info as $bill_data)
                                    @if ($bill_data->bi_status_flag == 'paid')
                                        <tr>
                                            <td>{{$bill_data -> bi_ac_name}}</td>
                                            <td>{{$bill_data -> bi_ref_code}}</td>
                                            <td>{{$bill_data -> bus_id}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                           </table>
                        </div>
                        <div class="col-sm-6">
                            <h6>Bill Pending User</h6>
                            <table id="notPaidTbl_id" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Name</th>
                                       <th>Ref</th>
                                       <th>id</th>
                                       <th>Due</th>
                                   </tr>
                               </thead>
                               <tbody>
                                @foreach ($bill_info as $bill_data)
                                    @if ($bill_data->bi_status_flag == 'notPaid')
                                        <tr>
                                            <td>{{$bill_data -> bi_ac_name}}</td>
                                            <td>{{$bill_data -> bi_ref_code}}</td>
                                            <td>{{$bill_data -> bus_id}}</td>
                                            <td>{{$bill_data -> bi_warning_count * $bill_data -> bi_monthly_fee}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                           </table>
                        </div>
                        <div class="col-sm-3">
                            <h6>Trial User</h6>
                            <table id="trialTbl_id" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Name</th>
                                       <th>Ref</th>
                                       <th>id</th>
                                   </tr>
                               </thead>
                               <tbody>
                                    @foreach ($bill_info as $bill_data)
                                    @if ($bill_data->bi_status_flag == 'trial')
                                        <tr>
                                            <td>{{$bill_data -> bi_ac_name}}</td>
                                            <td>{{$bill_data -> bi_ref_code}}</td>
                                            <td>{{$bill_data -> bus_id}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                           </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#paidTbl_id').DataTable({
                        retrieve: true,
                        paging: false
                    });
            $('#notPaidTbl_id').DataTable({
                        retrieve: true,
                        paging: false
                    });
            $('#trialTbl_id').DataTable({
                        retrieve: true,
                        paging: false
                    });
        } );
    </script>
@endsection