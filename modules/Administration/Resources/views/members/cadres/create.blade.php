@extends('administration::layouts.default')

@section('title', 'Tambah kader')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.cadres.index') }}"> <i class="fa fa-arrow-circle-left"></i></a> Tambah kader
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.cadres.store', ['next' => request('next', route('administration::members.cadres.index'))]) }}" method="POST"> @csrf
					<div class="form-group">
						<label for="inputAddress">Full Name</label>
						<input type="text" name="name" class="form-control col-md-12 @error('name') is-invalid @enderror" id="fullname" placeholder="Nama Lengkap">
						@error('name')
						<small class="invalid-feedback"> {{ $message }} </small>
						@enderror
					</div>
					<div class="form-group">
						<label for="inputAddress">NIK</label>
						<input type="text" name="nik" class="form-control col-md-12 @error('nik') is-invalid @enderror" id="nik" placeholder="NIK">
						@error('nik')
						<small class="invalid-feedback"> {{ $message }} </small>
						@enderror
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputEmail4">Jenis Kelamin</label>
							<select id="sex" name="sex" class="form-control selectpicker @error('sex') is-invalid @enderror">
								<option selected>Choose...</option>
								<option value="0">Laki-laki</option>
								<option value="1">Perempuan</option>
							</select>
							@error('sex')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
						<div class="form-group col-md-4">
							<label for="inputEmail4">Tanggal Lahir</label>
							<input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" placeholder="Tanggal Lahir">
							@error('dob')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
						<div class="form-group col-md-4">
							<label for="inputEmail4">Tempat Lahir</label>
							<input type="text" class="form-control @error('pob') is-invalid @enderror" id="pob" name="pob" placeholder="Tempat Lahir">
							@error('pob')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
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
								<input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
								@error('email')
								<small class="invalid-feedback"> {{ $message }} </small>
								@enderror 
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
								<input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" id="username" name="username">
								@error('username')
								<small class="invalid-feedback"> {{ $message }} </small>
								@enderror
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
								<input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask="" im-insert="true">
								@error('phone')
								<small class="invalid-feedback"> {{ $message }} </small>
								@enderror
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
						<input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="1234 Main St">
						@error('address')
						<small class="invalid-feedback"> {{ $message }} </small>
						@enderror
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
							<label for="inputState">Kecamatan</label>
							<select id="district_id" name="district_id" class="form-control @error('district_id') is-invalid @enderror">
								<option selected>Choose...</option>
							</select>
							@error('district_id')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
						<div class="form-group col-md-4">
							<label for="inputCity">Kelurahan</label>
							<input type="text" class="form-control" id="village" name="village">
						</div>
						<div class="form-group col-md-2">
							<label for="inputZip">Zip</label>
							<input type="text" class="form-control" id="postal" name="postal">
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Tingkat</label>
							<select id="grade_id" name="level_id" class="form-control selectpicker @error('level_id') is-invalid @enderror" data-live-search="true">
								<option selected>Choose...</option>
								@foreach($levels as $level)
								<option value="{{ $level->id }}">{{ $level->name }}</option>
								@endforeach
							</select>
							@error('level_id')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail4">Tahun Masuk</label>
							<input type="text" class="form-control @error('joined_at') is-invalid @enderror" id="joined_at" name="joined_at"> 
							@error('joined_at')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Pekerjaan</label>
							<select id="pimda" name="employment_id" class="form-control selectpicker" data-live-search="true">
								<option selected>Choose...</option>
								@foreach($employs as $employ)
								<option value="{{ $employ->id }}">{{ $employ->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Pimwil</label>
							<select id="pimwil" name="mgmt_province_id" class="form-control selectpicker @error('mgmt_province_id') is-invalid @enderror" data-live-search="true">
								<option selected>Choose...</option>
								@foreach($managements as $management)
								<option value="{{ $management->id }}" @if(request('mgmt', $managements->first()->id ?? null) == $management->id) selected @endif>{{ $management->name }}</option>
								@endforeach
							</select>
							@error('mgmt_province_id')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputState">Pimda</label>
							<select id="pimda" name="mgmt_province_regencies_id" class="form-control selectpicker @error('mgmt_province_regencies_id') is-invalid @enderror" data-live-search="true">
								<option selected>Choose...</option>
								@foreach($managementRegencys as $managementRegency)
								<option value="{{ $managementRegency->id }}" @if(request('mgmt', $managementRegency->first()->id ?? null) == $management->id) selected @endif>{{ $managementRegency->name }}</option>
								@endforeach
							</select>
							@error('mgmt_province_regencies_id')
							<small class="invalid-feedback"> {{ $message }} </small>
							@enderror
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="gridCheck">
							<label class="form-check-label" for="gridCheck">
								Data sudah benar
							</label>
						</div>
					</div>
					<button type="submit" class="btn btn-danger btn-sm">Register</button>
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