@extends('administration::layouts.default')

@section('title', 'Dasbor')

@section('content')
<div class="card border-0 shadow mb-4">
	<div class="card-body">
		<h4>Selamat datang <strong> {{ $user->profile->full_name }} </strong></h4>
		<h6>	
			<strong>
				{{ auth()->user()->isManagerCenters() ? 'ADMIN PUSAT ' 
					: (auth()->user()->isManagerProvinces() ? 'ADMIN WILAYAH '
					: (auth()->user()->isManagerRegencies() ? 'ADMIN DAERAH ' : 'ADMIN CABANG')). ' - '
					.$user->flattenManagerials()->first()->name }}
			</strong>
		</h6>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-lg mb-4">
		<div class="card border-left-primary border-0 shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pendekar</div>
						<h1 class="mb-0 font-weight-bold text-gray-800">{{ $warrior_count }}</h1>
					</div>
					<div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg mb-4">
		<div class="card border-left-success border-0 shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kader</div>
						<h1 class="mb-0 font-weight-bold text-gray-800">{{ $cadre_count }}</h1>
					</div>
					<div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg mb-4">
		<div class="card border-left-info border-0 shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Siswa</div>
						<h1 class="mb-0 font-weight-bold text-gray-800">{{ $students_count }}</h1>
					</div>
					<div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg mb-4">
		<div class="card border-left-warning border-0 shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">User</div>
						<h1 class="mb-0 font-weight-bold text-gray-800">{{ $users_count }}</h1>
					</div>
					<div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-8">
		@if(auth()->user()->isManagerCenters())
		<h4><strong>TOP 4 PIMDA</strong></h4>
		<div class="card-columns" style="column-count: 2;">	
			@foreach($all_count as $all)
				<div class="card text-center border-left-danger border-0 mb-4" style="margin-bottom: 10px;">
					<div class="card-header">
						<h5> {{ $all['name'] }} </h5>
					</div>
					<h7>Pendekar</h7>
					<table class="table table-striped mb-4 table-sm" style="table-layout : fixed; font-size: 0.7rem;">
						<tr>
							<td>Muda</td>
							<td>Madya</td>
							<td>Kepala</td>
							<td>Utama</td>
							<td>Besar</td>
						</tr>
						<tr>
							<td>{{ $all['levels']['Pendekar Muda'] ?? '0' }}</td>
							<td>{{ $all['levels']['Pendekar Madya'] ?? '0' }}</td>
							<td>{{ $all['levels']['Pendekar Kepala'] ?? '0' }}</td>
							<td>{{ $all['levels']['Pendekar Utama'] ?? '0' }}</td>
							<td>{{ $all['levels']['Pendekar Besar'] ?? '0' }}</td>
						</tr>
					</table>
					<br>
					<h7>Kader</h7>
					<table class="table table-striped mb-4 table-sm" style="table-layout : fixed; font-size: 0.7rem;">
						<tr>
							<td>Dasar</td>
							<td>Muda</td>
							<td>Madya</td>
							<td>Kepala</td>
							<td>Utama</td>
						</tr>
						<tr>
							<td>{{ $all['levels']['Kader Dasar'] ?? '0' }}</td>
							<td>{{ $all['levels']['Kader Muda'] ?? '0' }}</td>
							<td>{{ $all['levels']['Kader Madya'] ?? '0' }}</td>
							<td>{{ $all['levels']['Kader Kepala'] ?? '0' }}</td>
							<td>{{ $all['levels']['Kader Utama'] ?? '0' }}</td>
						</tr>
					</table>
				</div>
			@endforeach
		</div>
		@endif
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-newspaper"></i> Postingan terbaru
			</div>
			@include('web::includes.post-widgets-6', ['post' => $recent_posts])
		</div>
		<div class="row mb-4">
			@foreach($categories as $category)
				<div class="col-md-3">
					<div class="card border-0 border-left-dark mb-4">
						<div class="card-body">
							<h3><strong>{{ $category->posts_count }}</strong></h3>
							<small class="text-muted">Berita {{ $category->name }} <br></small>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-eye"></i> Postingan paling banyak dilihat
			</div>
			@include('web::includes.post-widgets-6', ['post' => $most_viewed_posts])
		</div>
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-user"></i> Akun Anda
			</div>
			<div class="list-group list-group-flush">
				<div class="list-group-item">
					Nama <br>
					<strong>{{ $user->profile->name }}</strong>
				</div>
				<div class="list-group-item">
					Username <br>
					<strong>{{ $user->username }}</strong>
				</div>
				<a class="list-group-item list-group-item-action text-danger" href="{{ route('account::index', ['next' => url()->current()]) }}">Selengkapnya &raquo;</a>
			</div>
		</div>
	</div>
</div>

@stop