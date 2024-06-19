@extends('event::layouts.default')

@section('title', 'Pengajuan event')

@section('content')
<div class="row">
	<div class="col-md-9">
		<div class="card mb-4 border-0 shadow">
			<div class="card-header">
				<div>Ajukan event baru</div>
			</div>
			<div class="card-body">
				@include('event::submissions.includes.create-form')
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card mb-4 border-0 shadow">
			<div class="card-header">
				<div>Daftar pengajuan Anda</div>
			</div>
			<div class="list-group list-group-flush">
				@forelse($events as $event)
					<div class="list-group-item">
						<div class="d-flex">
							
						</div>
						@if(!$event->approved)
							<form class="form-inline form-block float-right" action="{{ route("event::submissions.delete", ['event' => $event->id]) }}" method="POST"> @csrf @method('DELETE')
								<button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
							</form>
						@endif
						<div class="mb-1">
							@if($event->type)
								<span class="badge badge-pill badge-dark">{{ $event->type->name }}</span>
							@else
								<span class="badge badge-pill badge-secondary">Umum</span>
							@endif
						</div>
						<div>
							<strong>{{ $event->name }}</strong>
						</div>
						@if($event->registrable && $event->price)
							<div>
								<small>Rp {{ number_format($event->price, 0, ',', '.') }}</small>
							</div>
						@endif
						<div class="mt-4">
							{{ $event->timeRange() ?? 'Belum ditentukan' }} <br>
							@if($event->approved)
								<span class="badge badge-pill badge-success"><i class="fas fa-check"></i> Disetujui</span>
							@else
								<span class="badge badge-pill badge-danger"><i class="fas fa-times"></i> Belum disetujui</span>
							@endif
						</div>
					</div>
				@empty
					<div class="list-group-item">
						<i>Tidak ada event</i>
					</div>
				@endforelse
			</div>
		</div>
		<div class="card mb-4 border-0 shadow">
			<div class="card-header">
				<div>Organisasi Anda</div>
			</div>
			<div class="list-group list-group-flush">
				@foreach([
						'Pimpinan'	=> $managerial->name,
						'Alamat e-mail'	=> $managerial->email,
					] as $k => $v)
					<div class="list-group-item">
						<div>{{ $k }}</div>
						<strong>{{ $v ?? '-' }}</strong>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@stop