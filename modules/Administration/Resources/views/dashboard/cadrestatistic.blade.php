@extends('administration::layouts.default')

@section('title', 'Statistik')

@section('content')
<div class="row justify-content-center">	
	<div class="col-md-12">
		<h4><strong>KADER TAPAKSUCI</strong></h4>
	</div>	
	<div class="col-md-9">	
		<div class="card border-left-danger border-0 shadow" style="margin-bottom: 10px;">
			<div class="card-header text-lg-left"><strong> Kader</strong></div>
			<div class="card-body">
				<table class="table table-striped" id="cdstat">
					<thead class="bg-dark text-light">
						<tr>
							<th>PIMDA</th>
							<th>Dasar</th>
							<th>Muda</th>
							<th>Madya</th>
							<th>Kepala</th>
							<th>Utama</th>
						</tr>
					</thead>	
					@foreach($all_count as $all)
					<tr>
						<td>{{ $all['name'] }}</td>
						<td>{{ $all['levels']['Kader Dasar'] ?? '0' }}</td>
						<td>{{ $all['levels']['Kader Muda'] ?? '0' }}</td>
						<td>{{ $all['levels']['Kader Madya'] ?? '0' }}</td>
						<td>{{ $all['levels']['Kader Kepala'] ?? '0' }}</td>
						<td>{{ $all['levels']['Kader Utama'] ?? '0' }}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card border-left-danger border-0 shadow">
			<div class="card-header">Opsi</div>			
			<div class="list-group list-group-flush">
				<a class="list-group-item list-group-item-action text-danger content-block" href="{{ route('administration::cadre-statistic-province') }}"><i class="fa fa-plus-circle"></i> Tampilkan per wilayah</a>
			</div>			
		</div>
	</div>
</div>
@stop

@push('style')
	<link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('script')
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function(){
        $('#cdstat').DataTable();       
    });
</script>
@endpush