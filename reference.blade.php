@extends('layouts.app')

@section('content')

<div class="container cusTopMargin">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Reference Code</div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif
					<p>Hi {{$bill_info->bi_ac_name}}</p>
					<h3>Welcome to Percher.com</h3>
					<p>Referance Code: <b>{{$bill_info->bi_ref_code}}</b></p>
					{{-- Reference Submit --}}
					<div>
						<form class="well form-horizontal" action="{{ route('reference.submit', ['myRefCode' => $bill_info->bi_ref_code]) }}" method="post">
							{{csrf_field()}}
							<fieldset>

								<div class="form-group row">
									<label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Put Your Friends Reference code if you have.') }}</label>

									<div class="col-md-6">
										<input type="text" class="form-control" name="reference_code" autofocus>
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
					<div class="add_button">
						<a href="{{ route('home') }}" type="button" class="btn btn-info" role="button">Skip>></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection