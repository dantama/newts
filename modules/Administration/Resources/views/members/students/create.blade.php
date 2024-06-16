@extends('administration::layouts.default')

@section('title', 'Tambah siswa')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.students.index') }}"> <i class="fa fa-arrow-circle-left"></i></a> Tambah siswa
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.students.store', ['next' => request('next', route('administration::members.students.index'))]) }}" method="POST"> @csrf
					<div class="form-group">
						<label for="inputAddress">Full Name</label>
						<input type="text" name="name" class="form-control col-md-12 @error('name') is-invalid @enderror" id="fullname" placeholder="Nama Lengkap" required>
						@error('name')
						<small class="invalid-feedback"> {{ $message }} </small>
						@enderror
					</div>
					<div class="form-group">
						<label for="inputAddress">NIK</label>
						<input type="text" name="nik" class="form-control col-md-12" id="nik" placeholder="NIK" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputEmail4">Jenis Kelamin</label>
							<select id="sex" name="sex" class="form-control @error('sex') is-invalid @enderror" required>
								<option value="" selected>Choose...</option>
								<option value="0">Laki-laki</option>
								<option value="1">Perempuan</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputEmail4">Tanggal Lahir</label>
							<input type="date" class="form-control" id="dob" name="dob" placeholder="Tanggal" required>
						</div>
						<div class="form-group col-md-4">
							<label for="inputEmail4">Tempat Lahir</label>
							<input type="text" class="form-control" id="pob" name="pob" placeholder="Tempat" required>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Email</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
							</div> 
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Username</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">@</span>
								</div>
								<input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
							</div> 
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">No Telpon</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="text" name="phone" class="form-control" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask="" im-insert="true" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="wa" name="wa" value="1">
							<label class="form-check-label" for="gridCheck">
								Whatsapp
							</label>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="inputAddress">Alamat</label>
						<input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail4">RT</label>
							<input type="text" class="form-control" id="rt" name="rt" placeholder="RT">
						</div>
						<div class="form-group col-md-6">
							<label for="inputPassword4">RW</label>
							<input type="text" class="form-control" id="rw" name="rw" placeholder="RW">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">Kelurahan</label>
							<input type="text" class="form-control" id="village" name="village" required>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">Kabupaten</label>
							<select id="regency_id" name="regency_id" class="form-control selectpicker" data-live-search="true" required>
								<option value="" selected>Choose...</option>
								@foreach($regencies as $regency)
									<option value="{{ $regency->id }}" @if(request('regency_id', null) == $regency->id) selected @endif>{{ $regency->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="inputZip">Zip</label>
							<input type="text" class="form-control" id="postal" name="postal" required>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Tingkat</label>
							<select id="grade_id" name="level_id" class="form-control selectpicker" data-live-search="true" required>
								<option selected>Choose...</option>
								@foreach($levels as $level)
								<option value="{{ $level->id }}">{{ $level->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Pimda</label>
							<select id="pimda" name="mgmt_province_regencies_id" class="form-control selectpicker" data-live-search="true" required>
								<option selected>Choose...</option>
								@foreach($managementRegencies as $managementRegency)
								<option value="{{ $managementRegency->id }}" @if(request('mgmt', null) == $managementRegency->id) selected @endif>{{ $managementRegency->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Cabang</label>
							<select id="cabang" name="district_id" class="form-control selectpicker" data-live-search="true" required>
								<option selected>Choose...</option>
								@foreach($managementDistricts as $managementDistrict)
								<option value="{{ $managementDistrict->id }}" @if(request('mgmt', null) == $managementDistrict->id) selected @endif>{{ $managementDistrict->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="gridCheck">
							<label class="form-check-label" for="gridCheck">
								Check me out
							</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-sm">Register</button>
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
    $('[name="regency_id"]').select2({
        minimumInputLength: 3,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ route('api.getRegencies') }}',
            dataType: 'json',
            delay: 500,
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });

    $('[name="mgmt_province_regencies_id"]').select2({
        minimumInputLength: 3,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ route('api.getMgmtRegencies') }}',
            dataType: 'json',
            delay: 500,
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });

    $('[name="district_id"]').select2({
        minimumInputLength: 3,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ route('api.getMgmtDistricts') }}',
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