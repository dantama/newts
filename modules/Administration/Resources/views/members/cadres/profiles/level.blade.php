@extends('administration::layouts.default')

@section('title', 'Edit Tingkat Kader')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.cadres.show',['cadre' => $members[0]['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Profil Kader
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-header">
				<h6>History tingkat <strong>{{ $members[0]['user']['profile']['display_name'] }}</strong></h6>
			</div>	
			<table class="table table-hover mb-0 border-bottom">
				<thead class="bg-dark text-light">
					<tr>
						<th>No</th>
						<th>Tingkat</th>
						<th>Tahun</th>
						<th style="width: 120px;"></th>
					</tr>
				<tbody>
					@foreach($members[0]['levels'] as $member)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $member->detail->name }}</td>
						<td>{{ $member->year }}</td>
						<td>
							<a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
						</td>
					</tr>	
					@endforeach
				</tbody>		
				</thead>
			</table>	
		</div>
	</div>
	<div class="col-md-4">	
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.cadres.level-update', ['cadre' => $members[0]['id']]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Nama</label>
							<input type="text" class="form-control" value="{{ $members[0]['user']['profile']['display_name'] }}" disabled="">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Tingkat</label>
							@foreach($members[0]['levels'] as $mylevel)
								@if($loop->last)
									<input type="text" class="form-control" value="{{ $mylevel->detail->name }}" disabled="">
								@endif
							@endforeach
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Tahun</label>
							<input type="number" name="tahun" class="form-control">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">Tingkat</label>
							<select id="grade_id" name="level_id" class="form-control selectpicker" data-live-search="true" required>
								<option selected>Choose...</option>
								@foreach($levels as $level)
								<option value="{{ $level->id }}" {{ $level->id == $last->level_id ? 'selected' : '' }}>{{ $level->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-sm">Perbarui Tingkat</button>
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