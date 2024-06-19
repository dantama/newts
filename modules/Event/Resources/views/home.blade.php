@extends('event::layouts.default')

@section('title', 'Event')

@section('content')
<div class="row">
	<div class="col-md-9">
		<div class="card mb-4 border-0 shadow">
			<div class="card-header">
				<div><i class="fas fa-newspaper"></i> Event sedang berlangsung</div>
			</div>
			<div class="list-group list-group-flush">
				@forelse($active_events as $event)
					<div class="list-group-item">
						<div class="d-md-flex flex-row justify-content-between align-items-center">
							<div>
								<strong>{{ $event->name }}</strong> <br>
								{{ Str::words($event->content, 10) }} - <strong>{{ $event->mgmt_name }}</strong>
							</div>
							<div class="mt-3 mt-sm-0 px-sm-3 text-nowrap">
								{{ $event->timeRange() ?? 'Tidak ditentukan' }} <br>
								@if($event->type)
									<span class="badge badge-pill badge-dark">{{ $event->type->name }}</span>
								@else
									<span class="badge badge-pill badge-secondary">Umum</span>
								@endif
								@if($event->registrable && $event->price)
									<small> - Rp {{ number_format($event->price, 0, ',', '.') }}</small>
								@endif
							</div>
							<div class="mt-3 mt-sm-0 px-sm-3 text-nowrap">
								@if(!auth()->user()->isManagerCenters())
									<a class="btn btn-danger btn-sm rounded-pill" href="{{ route('event::register.index', ['event' => $event->id, 'state' => $state, 'next' => url()->current()]) }}">
										<i class="fas fa-chevron-circle-right"></i> Daftar
									</a>
								@endif
							</div>
						</div>
					</div>
				@empty
					<div class="list-group-item text-muted font-italic">
						Tidak ada event berlangsung
					</div>
				@endforelse
			</div>
		</div>
		<div class="card mb-4 border-0 shadow">
			<div class="card-header">
				<div><i class="fas fa-calendar-alt"></i> Event yang akan datang</div>
			</div>
			<div class="list-group list-group-flush">
				@forelse($upcoming_events as $event)
					<div class="list-group-item">
						<div class="d-md-flex flex-row justify-content-between align-items-center">
							<div>
								<strong>{{ $event->name }}</strong> <br>
								{{ Str::words($event->content, 15) }} - <strong>{{ $event->mgmt_name }}</strong>
							</div>
							<div class="mt-3 mt-sm-0 px-sm-3 text-nowrap">
								{{ $event->timeRange() ?? 'Tidak ditentukan' }} <br>
								<small>{{ $event->start_at->diffForHumans() }}</small> <br>
								@if($event->type)
									<span class="badge badge-pill badge-dark">{{ $event->type->name }}</span>
								@else
									<span class="badge badge-pill badge-secondary">Umum</span>
								@endif
								@if($event->registrable && $event->price)
									<small> - Rp {{ number_format($event->price, 0, ',', '.') }}</small>
								@endif
							</div>
						</div>
					</div>
				@empty
					<div class="list-group-item text-muted font-italic">
						Tidak ada event yang akan datang
					</div>
				@endforelse
			</div>
		</div>
		@if(auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
			<div class="card mb-4 border-0 shadow">
				<div class="card-header">
					<div><i class="fas fa-paper-plane"></i> Ajukan event baru</div>
				</div>
				<div class="card-body">
					@include('event::submissions.includes.create-form')
				</div>
			</div>
		@endif
	</div>
	<div class="col-md-3">
		@foreach($stats as $title => $stat)
			<div class="card mb-4 border-left-{{ $stat[1] }} border-0 shadow">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-{{ $stat[1] }} text-uppercase mb-1">{{ $title }}</div>
							<h1 class="mb-0 font-weight-bold text-gray-800">{{ $stat[0] ?? 0 }}</h1>
						</div>
						<div class="col-auto"> <i class="fas fa-newspaper fa-3x text-gray-300"></i> </div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>
@stop