@extends('layouts.app')

@section('content')
<div class="container cusTopMargin">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billng</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <p>Your Reference code: <b>{{$bill_info->bi_ref_code}}</b></p>
                    <p>Payment Bkash Number: <b>01849609902</b></p>
                    <p>Monthly Fee: <b>{{$bill_info->bi_monthly_fee}} tk</b></p>

                    @switch($bill_info->bi_status_flag)
                    @case('paid')
                    <p style="color:green;">Payment Status: <b>{{$bill_info->bi_status_flag}}</b></p>
                    @break
                    @case('notPaid')
                    <p style="color:#88e22b;">Payment Status: <b>{{$bill_info->bi_status_flag}}</b></p>
                    <p>Warning: Please pay your pending monthly fee <b>{{$due_fee}} tk</b></p>
                    @break
                    @case('disable')
                    <p style="color:red;">Payment Status: <b>{{$bill_info->bi_status_flag}}</b></p>
                    <p>Your Account Is Disable, To active your account please contact with 01849609902 or text mail to raihansarkar567@gmail.com</p>
                    @break
                    
                    @default
                    <p style="color:#e32472;">Payment Status: <b>{{$bill_info->bi_status_flag}}</b></p>
                    @endswitch
                    
                    {{-- Priority Update --}}
                    @if ($bill_info->bi_status_flag != 'disable')
                    <div>
                        <form class="well form-horizontal" action="{{ route('payment.trxid.submit') }}" method="post">
                            {{csrf_field()}}
                            <fieldset>

                                <div class="form-group row">
                                    <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('After Send Money, submit the bkash TrxID code within 24hr') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="trxid" placeholder="Put the TrxID" autofocus required>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection