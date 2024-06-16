@extends('administration::layouts.default')

@section('title', 'Buka Pendaftaran - ')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h2>
			<a class="text-decoration-none small" href="{{ route('administration::managements.regencies.index') }}"><i class="mdi mdi-arrow-left-circle-outline"></i></a>
			Organisasi Anda
		</h2>
		<hr>
		<p class="text-secondary">Perubahan informasi dibawah akan diterapkan di {{ config('app.name') }} Anda</p>
		<div class="card mb-4 border-left-danger border-0">
			<div class="card-body">
				<form class="form-block" action="{{ route('administration::managements.regencies.updateregisters',['next' => request('next', route('administration::managements.regencies.index'))]) }}" method="POST">
					@csrf @method('PUT')
					<fieldset>
						<div class="row">
							<div class="col-md-7 offset-md-4 offset-lg-3">
								<h5 class="text-muted font-weight-normal mb-3">Pendaftaran organisasi</h5>
							</div>
						</div>

						<div class="form-group required row">
							<label class="col-md-4 col-lg-3 col-form-label">Sebagai</label>
							<div class="col-md-4">
								<select name="as" class="form-control selectpicker @error('as') is-invalid @enderror" data-live-search="true">
									<option value="">-- Pilih Pendaftaran --</option>
									<option value="1"> Siswa </option>
									<option value="2"> Anggota </option>
								</select>
								@error('as')
									<small class="text-danger"> {{ $message }} </small>
								@enderror
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4 col-lg-3 col-form-label">Pimda</label>
							<div class="col-md-4">
								<select name="regency_id" class="form-control selectpicker @error('regency_id') is-invalid @enderror" data-live-search="true">
									<option value="">-- Pilih pimda --</option>
									@foreach ($pd as $v)
										<option value="{{ $v['id'] }}")>{{ $v['name'] }}</option>
									@endforeach
								</select>
								@error('regency_id')
								<span class="invalid-feedback"> {{ $message }} </span>
								@enderror
							</div>
						</div>
					</fieldset>
					<hr>
					<div class="form-group row mb-0">
						<div class="col-md-7 offset-md-4 offset-lg-3">
							<button class="btn btn-danger" type="submit">Simpan</button>
							<a class="btn btn-secondary" href="{{ route('administration::managements.regencies.index') }}">Kembali</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<h2>Daftar Pendaftaran</h2>
		<hr>
		<p class="text-secondary">Daftar Pimda {{ config('app.name') }} yang membuka pendaftaran.</p>
		<div class="card mb-4 border-left-danger border-0 shadow">
			<div class="card-body box-profile">
				<div class="text-center mb-4">
					<img class="profile-user-img img-fluid img-circle" src="http://admin.tapaksuciapp.test/img/logo/tapak-suci-png-5.png" alt="" style="width: 128px;">
				</div>
			</div>
			<div class="list-group list-group-flush">
				@forelse($opened as $k => $v)
                <a class="list-group-item list-group-item-action text-danger" style="cursor: pointer;"></i>
                	<div class="row">
                		<div class="col-md-8"><strong>{{ $v->name }}</strong></div>
                		<div class="col-md-4 float-right">
                			<form method="POST" action="{{ route('administration::managements.regencies.resetregisters',['regency' => $v->id]) }}">@csrf @method('PUT')
                				<button class="btn btn-danger btn-sm">STOP</button>
                			</form>
                		</div>
                	</div>
                </a>
            	@empty
            	<p>Belum ada pendaftaran</p>
            	@endforelse
            </div>
		</div>
	</div>
</div>
@endsection

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
@endpush