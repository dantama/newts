@extends('administration::layouts.default')

@section('title', 'Pimpinan Pusat')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h4 class="font-weight-bold mb-0 text-gray-800">Pimpinan pusat</h4>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-3">
		<div class="card mb-4 border-left-danger border-0 shadow">
			<div class="card-body box-profile">
				<div class="text-center mb-4">
					<img class="profile-user-img img-fluid img-circle" src="{{ asset('img/logo/tapak-suci-png-5.png') }}" alt="" style="width: 128px;">
				</div>

				<h4 class="font-weight-bold text-center">Pimpinan Pusat</h4>

				<ul class="list-group list-group-unbordered mb-0">
					<li class="list-group-item">
						<b>Pendekar</b> <a class="float-right">{{ $warriors_count }}</a>
					</li>
					<li class="list-group-item">
						<b>Kader</b> <a class="float-right">{{ $cadres_count }}</a>
					</li>
					<li class="list-group-item">
						<b>Siswa</b> <a class="float-right">{{ $students_count }}</a>
					</li>
				</ul>
			</div>
		</div>		
		<div class="card mb-4 border-left-danger border-0 shadow">
			<div class="card-header">About Me</div>
			<div class="card-body">
				@foreach($pp as $pp)
					<strong><i class="fas fa-book mr-1"></i> Nama</strong>
					<p class="text-muted">{{ $pp['name'] }}</p>
					<hr>
					<strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
					<p class="text-muted">{{ $pp['address'] }}</p>
					<hr>
					<strong><i class="fas fa-pencil-alt mr-1"></i> Email</strong>
					<p class="text-muted">{{ $pp['email'] }}</p>
					<hr>
					<strong><i class="far fa-file-alt mr-1"></i> Telp</strong>
					<p class="text-muted mb-0">{{ $pp['phone'] }}</p>
				@endforeach    
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="card border-0 shadow">
			<div class="card-header">Posting populer</div>
			<div class="list-group list-group-flush">
				@forelse($most_viewed_posts as $post)
				<a class="list-group-item list-group-item-action" href="{{ route('web::read', ['category' => $post->category()->slug, 'slug' => $post->slug]) }}" target="_blank">
					<div class="d-flex flex-row align-items-center justify-content-between">
						<div class="rounded mr-2" style="background: url({{ Storage::exists($post->img) ? Storage::url($post->img) : asset('img/no-image.png') }}) center center no-repeat; background-size: cover; min-width: 60px; height: 60px;"></div>
						<div class="flex-grow-1">
							<strong>{{ Str::limit($post->title, 50) }}</strong> <br>
							<i class="fas fa-sm fa-eye"></i> <small>{{ $post->views_count }}</small>
							<i class="fas fa-sm fa-comments"></i> <small>{{ $post->comments_count }}</small>
							<i class="fas fa-sm fa-calendar"></i> <small>{{ $post->created_at ? $post->created_at->ISOFormat('L') : '-' }}</small>
						</div>
						<i class="fas fa-sm fa-external-link-alt"></i>
					</div>
				</a>
				@empty
				<div class="list-group-item">
					Tidak ada postingan
				</div>
				@endforelse
			</div>
		</div>
	</div>
</div>
@stop