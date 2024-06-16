@extends('administration::layouts.default')

@section('title', 'Edit Pendekar')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.warriors.show',['warrior' => $warriors[0]['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Profil Pendekar
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.warriors.profile-update',['warrior' => $warriors[0]['user']['id']], ['next' => request('next', route('administration::members.warriors.index'))]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-group">
						<label for="inputAddress">Full Name</label>
						<input type="text" name="name" class="form-control col-md-12 @error('name') is-invalid @enderror" id="fullname" placeholder="Nama Lengkap" value="{{ $warriors[0]['user']['profile']['name'] }}" required>
						@error('name')
						<small class="invalid-feedback"> {{ $message }} </small>
						@enderror
					</div>
					<div class="form-group">
						<label for="inputAddress">NIK</label>
						<input type="text" name="nik" class="form-control col-md-12" id="nik" placeholder="NIK" value="{{ $warriors[0]['user']['profile']['nik'] }}" required>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputEmail4">Jenis Kelamin</label>
							<select id="sex" name="sex" class="form-control @error('sex') is-invalid @enderror" required>
								<option value="">Choose...</option>
								<option value="0" {{ $warriors[0]['user']['profile']['sex'] == 0 ? 'selected' : '' }}>Laki-laki</option>
								<option value="1" {{ $warriors[0]['user']['profile']['sex'] == 1 ? 'selected' : '' }}>Perempuan</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="inputEmail4">Tanggal Lahir</label>
							<input type="date" class="form-control" id="dob" name="dob" value="{{ $warriors[0]['user']['profile']['dob'] }}" required>
						</div>
						<div class="form-group col-md-4">
							<label for="inputEmail4">Tempat Lahir</label>
							<input type="text" class="form-control" id="pob" name="pob" value="{{ $warriors[0]['user']['profile']['pob'] }}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Gelar Depan</label>
						<input type="text" name="prefix" class="form-control col-md-12" value="{{ $warriors[0]['user']['profile']['prefix'] }}" id="prefix">
					</div>
					<div class="form-group">
						<label for="inputAddress">Gelar Belakang</label>
						<input type="text" name="suffix" class="form-control col-md-12" value="{{ $warriors[0]['user']['profile']['suffix'] }}" id="suffix">
					</div>
					<div class="form-group">
						<label for="inputAddress">Golongan Darah</label>
						<select id="blood" name="blood" class="form-control @error('blood') is-invalid @enderror" required>
							<option value="" selected>Choose...</option>
							<option value="0">Gol Darah A</option>
							<option value="2">Gol Darah B</option>
							<option value="3">Gol Darah AB</option>
							<option value="4">Gol Darah O</option>
						</select>
					</div>
					<div class="form-group">
						<label for="inputAddress">Pendidikan</label>
						<select name="grade_id" id="grade_id" class="form-control">
							<option value="" selected>Choose..</option>
							@foreach($grades as $grade)
							<option value="{{ $grade->id }}">{{ $grade->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="inputAddress">Pekerjaan</label>
						<select name="employment_id" id="employment_id" class="form-control">
							<option value="" selected>Choose..</option>
							@foreach($employments as $employment)
							<option value="{{ $employment->id }}">{{ $employment->name }}</option>
							@endforeach
						</select>
					</div>
					<button type="submit" class="btn btn-primary btn-sm">Perbarui Profil</button>
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
</script>
@endpush