@extends('administration::layouts.default')

@section('title', 'Daftar Pelatih Nasional')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Detail Pelatih</h4>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="jumbotron bg-light py-4 mb-4 border-dark">
			<span class="float-right text-muted font-weight-bold"><i class="far fa-user"></i> Pelatih Nasional</span>
			<h2>{{ $coachs[0]['user']['profile']['name'] }}</h2>
			<hr>
		</div>
		<div class="card-columns mb-4">
			@foreach($coachLevels as $coachLevel)
			<div class="card text-center">
				<div class="card-header bg-light">
					<strong><h4>{{ $coachLevel->detail->name }}</h4></strong>
				</div>
				<div class="card-body">
					<div class="mb-2">
						<p>Tingkat : {{ $coachLevel->detail->name }}</p>
						<p>Mulai : {{ date_format(new DateTime($coachLevel->start),'d-M-Y') }}</p>
						@if(auth()->user()->isManagerCenters())
							@if($coachLevel->accepted == 1)
								<form class="d-inline form-block form-confirm" action="#" method="POST">
                                    <button class="btn btn-success btn-sm" data-toggle="tooltip" title="Non Aktif">Verified</button>
                                </form>
							@else
								<form class="d-inline form-block form-confirm" action="#" method="POST">
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Aktif">Not Verified</button>
                                </form>
							@endif
						@else
							@if($coachLevel->accepted == 1)
								<span class="badge badge-success">verified</span>
							@else
								<span class="badge badge-danger">not verified</span>
							@endif
						@endif
						<hr>
						@if(!empty($coachLevel->file))
							<a href="{{ url('storage/'.$coachLevel->file) }}"><span class="badge badge-success">Certified</span></a>
						@else
							<span class="badge badge-danger">Not Certified</span>
						@endif
					</div>
				</div>
			</div>
			@endforeach
		</div> 
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header bg-light">Lanjutan</div>
			<div class="card-body">
				<form method="POST" enctype="multipart/form-data" action="{{ route('administration::technical.center-coachs.store-level', ['coach' => $coachs[0]['id']]) }}">@csrf
				  <div class="form-group">
				    <label for="inputAddress">Nama</label>
				    <input type="text" class="form-control" id="inputAddress" value="{{ $coachs[0]['user']['profile']['name'] }}">
				  </div>
				  <div class="form-group">
				    <label for="inputAddress2">Tingkat</label>
				    <select name="type_id" class="form-control">
				    	<option value="">Pilih Tingkat</option>
				    	@foreach($coachtypes as $coachtype)
				    	<option value="{{ $coachtype->id }}">{{ $coachtype->name }}</option>
				    	@endforeach
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="inputAddress2">Berlaku mulai</label>
				    <input type="date" class="form-control" id="date" name="start">
				  </div>
				  <div class="form-group">
				    <label for="inputAddress2">Event</label>
				    <select name="event_id" class="form-control">
				    	<option value="">Pilih Event</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="inputAddress2">Lampiran</label>
				    <input type="file" class="form-control" id="file" name="file">
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
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#kader').DataTable();
    });
</script>
@endpush
					