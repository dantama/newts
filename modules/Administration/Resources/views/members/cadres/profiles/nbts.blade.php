@extends('administration::layouts.default')

@section('title', 'Edit NBTS')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.cadres.show',['cadre' => $members[0]['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Profil Kader
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.cadres.nbts-update',['cadre' => $members[0]['user']['id']], ['next' => request('next', route('administration::members.cadres.index'))]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">NBTS</label>
							<input type="text" name="nbts" id="nbts" class="form-control @error('nbts') is-invalid @enderror" value="{{ $members[0]['joined_at'] ?? 'yyyy' }}-{{ $members[0]['regency']['management']['pimwil_code'] }}-{{ str_pad($members[0]['regency']['pimda_code'], 3, '0', STR_PAD_LEFT) }}-">
						</div>
					</div>
					@error('nbts')
					<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					<button type="submit" class="btn btn-primary btn-sm">Perbarui Profil</button>
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
				@if(!empty($members[0]['qr']))
					<img src={{ Storage::url($members[0]['qr']) }} alt="User Qr" width="128">
				@else
					<img src="{{ asset('img/default-avatar.svg') }}" alt="" width="128">
				@endif
				<p>NBTS : {{ $members[0]['nbts'] }}</p>
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