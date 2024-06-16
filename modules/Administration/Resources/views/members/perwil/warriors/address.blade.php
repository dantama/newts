@extends('administration::layouts.default')

@section('title', 'Edit pendekar')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.perwil-warriors.show',['perwil_warrior' => $members['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Warrior Profile
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.perwil-warriors.address-update', ['perwil_warrior' => $members['user']['id']]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" class="form-control col-md-12 @error('address') is-invalid @enderror" id="address" name="address" placeholder="Ex: Jl Kaliurang" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail4">Neighbourhood</label>
							<input type="text" class="form-control" id="rt" name="rt" placeholder="Neighbourhood">
						</div>
						<div class="form-group col-md-6">
							<label for="inputPassword4">Hamlet</label>
							<input type="text" class="form-control" id="rw" name="rw" placeholder="Hamlet">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="inputCity">Village</label>
							<input type="text" class="form-control" id="village" name="village" required>
						</div>
						{{-- <div class="form-group col-md-4">
							<label for="inputState">Sub-district</label>
							<select id="district_id" name="district_id" class="form-control selectpicker" data-live-search="true" required>
								<option value="" selected>Choose...</option>
							</select>
						</div> --}}
						<div class="form-group col-md-4">
							<label for="inputZip">Zip</label>
							<input type="text" class="form-control" id="postal" name="postal" required>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Update address</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@push('style')
<link href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet">
<style type="text/css">
	.bootstrap-select .btn {
		background-color: #fff;
		border-style: solid;
		border: 1px solid #ced4da;
	}  
</style>
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script>
    $('[name="district_id"]').select2({
        minimumInputLength: 3,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ route('api.getDistricts') }}',
            dataType: 'json',
            delay: 500,
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });
</script>
@endpush