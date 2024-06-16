@extends('administration::layouts.default')

@section('title', 'Edit NBTS')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.perwil-cadres.show',['perwil_cadre' => $members['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Cadre Profile
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.perwil-cadres.nbts-update',['perwil_cadre' => $members['user']['id']], ['next' => request('next', route('administration::members.perwil-cadres.index'))]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">NBTS</label>
							<input type="text" name="nbts" id="nbts" class="form-control @error('nbts') is-invalid @enderror" value="{{ !is_null($members['nbts']) ? $members['nbts'] : ($members['joined_at'] ?? 'YYYY') .'-PERWIL-'. $members['perwildata']['perwil_code'].'-' }}">
						</div>
					</div>
					@error('nbts')
					<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Update NBTS</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<h4 class="font-weight-bold mb-4">
			QR
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body text-center">
				@if(!empty($members['qr']))
					<img src={{ Storage::url($members['qr']) }} alt="User Qr" width="128">
				@else
					<img src="{{ asset('img/no-image.png') }}" alt="" width="128">
				@endif
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