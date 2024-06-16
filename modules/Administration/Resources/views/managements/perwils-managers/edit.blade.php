@extends('administration::layouts.default')

@section('title', 'Edit Perwil')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::managements.perwil-managers.index') }}"> <i class="fa fa-arrow-circle-left"></i></a> Perwakilan Wilayah
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::managements.perwil-managers.update', ['perwil_manager' => $managers['id']]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Nama</label>
							<div class="input-group">
								<input type="text" value="{{ $managers['user']['profile']['display_name'] }}" class="form-control" disabled="">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Jabatan</label>
							<div class="input-group">
								<select name="position_id" id="position_id" class="form-control">
									<option value="">Pilih Jabatan</option>
									@foreach($positions as $position)
										<option value="{{ $position->id }}">{{ $position->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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
@endpush