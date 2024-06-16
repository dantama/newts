@extends('administration::layouts.default')

@section('title', 'Edit siswa')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.students.show',['student' => $students[0]['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Profil siswa
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.students.organization-update',['student' => $students[0]['user']['id']], ['next' => request('next', route('administration::members.students.index'))]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Pimwil</label>
							<select id="pimwil" name="mgmt_province_id" class="form-control selectpicker" data-live-search="true" required>
								<option selected>Choose...</option>
								@foreach($managements as $management)
								<option value="{{ $management->id }}" @if(request('mgmt', $managements->first()->id ?? null) == $management->id) selected @endif>{{ $management->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Pimda</label>
							<select id="pimda" name="mgmt_province_regencies_id" class="form-control selectpicker" data-live-search="true" required>
								<option selected>Choose...</option>
								@foreach($managementRegencys as $managementRegency)
								<option value="{{ $managementRegency->id }}" @if(request('mgmt', $managementRegency->first()->id ?? null) == $management->id) selected @endif>{{ $managementRegency->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Bergabung Tahun</label>
							<input type="text" name="joined_at" id="joined_at" class="form-control @error('joined_at') is-invalid @enderror">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">NBTS</label>
							<input type="text" name="nbts" id="nbts" class="form-control @error('nbts') is-invalid @enderror">
						</div>
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