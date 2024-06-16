@extends('administration::layouts.default')

@section('title', 'Postingan')

@php($url = url()->current())
@php($is_admin = auth()->user()->isManagerCenters())

@section('content')
<div class="mb-4">
	<h5 class="mb-0">
		<strong><i class="fas fa-sm fa-newspaper"></i> Postingan</strong>
	</h5>
</div>
<div class="mb-4">
	<a class="btn btn-danger" href="{{ route('administration::blog.posts.create', ['next' => $url]) }}"><i class="fas fa-sm fa-plus-circle"></i> Buat postingan baru</a>
</div>
<div class="row">
	<div class="col-lg-8">
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-list"></i> Daftar postingan
			</div>
			<div class="card-body">
				<form class="form-block" action="{{ route('administration::blog.posts.index') }}" method="GET">
					<input type="hidden" name="category" value="{{ request('category') }}">
					<input type="hidden" name="trashed" value="{{ request('trashed') }}">
					<div class="input-group">
						<input class="form-control" type="search" name="search" placeholder="Cari judul disini..." value="{{ request('search') }}">
						<div class="input-group-append">
							<a class="btn btn-light border" href="{{ route('administration::blog.posts.index') }}"><i class="fas fa-sm fa-sync" style="font-size: 10pt;"></i></a>
							<button class="btn btn-dark"><i class="fas fa-sm fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover mb-0">
					<thead class="thead-dark">
						<tr>
							<th>No</th>
							<th>Judul</th>
							<th>Kategori</th>
							<th>Dipublikasi</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse($posts as $post)
							<tr>
								<td class="align-middle">{{ $posts->firstItem() + $loop->iteration - 1 }}</td>
								<td style="min-width: 300px;">
									<strong>{{ $post->title }}</strong>
									@if($post->unpublished_comments_count)
										<a href="{{ route('administration::blog.posts.show', ['post' => $post->id, 'next' => url()->current()]) }}">
											<span class="badge badge-pill badge-danger"><i class="fas fa-sm fa-comments"></i> {{ $post->unpublished_comments_count }}</span>
										</a>
									@endif
									<br>
									@if($post->trashed())
										@if($is_admin)
											<form class="d-inline form-confirm form-block" action="{{ route('administration::blog.posts.restore', ['post' => $post->id]) }}" method="POST"> @csrf @method('PUT')
												<button class="btn btn-link align-baseline text-danger p-0 mr-2">Pulihkan</button>
											</form>
											<form class="d-inline form-confirm form-block" action="{{ route('administration::blog.posts.kill', ['post' => $post->id]) }}" method="POST"> @csrf @method('DELETE')
												<button class="btn btn-link align-baseline text-danger p-0 mr-2">Hapus permanen</button>
											</form>
										@endif
									@else
										@if($is_admin || auth()->id() == $post->author_id)
											@if($is_admin)
												<form class="d-inline form-confirm form-block" action="{{ route('administration::blog.posts.approval', ['post' => $post->id]) }}" method="POST"> @csrf @method('PUT')
													<button class="btn btn-link align-baseline text-{{ $post->approved ? 'danger' : 'success' }} p-0 mr-2">{{ $post->approved ? 'Unapprove' : 'Approve' }}</button>
												</form>
											@endif
											<a class="mr-2 text-warning" href="{{ route('administration::blog.posts.edit', ['post' => $post->id, 'next' => url()->current()]) }}">Edit</a>
											<form class="d-inline form-confirm form-block" action="{{ route('administration::blog.posts.destroy', ['post' => $post->id]) }}" method="POST"> @csrf @method('DELETE')
												<button class="btn btn-link align-baseline text-danger p-0 mr-2">Buang</button>
											</form>
										@endif
										<a class="text-primary" href="{{ route('web::read', ['category' => $post->category()->slug, 'slug' => $post->slug, 'next' => $url]) }}" target="_blank">Lihat</a>
									@endif
								</td>
								<td class="align-middle" style="max-width: 200px;">
									<div>
										@forelse($post->categories->take(3) as $category)
											<span class="badge badge-pill badge-dark">{{ $category->name }}</span>
										@empty
											<span class="badge badge-pill badge-secondary">Uncategorized</span>
										@endforelse
									</div>
								</td>
								<td class="align-middle">
									<small>{{ $post->published_at ? $post->published_at->ISOFormat('L') : '-' }}</small><br>
									<i class="fas fa-sm fa-eye"></i> <small>{{ $post->views_count }}</small>
									<i class="fas fa-sm fa-comment"></i> <small>{{ $post->comments_count }}</small>
								</td>
								<td class="align-middle">
									@if(!$post->trashed())
										<a class="btn btn-danger btn-sm rounded-pill text-nowrap" href="{{ route('administration::blog.posts.show', ['post' => $post->id, 'next' => url()->current()]) }}"><i class="far fa-eye"></i> Detail</a>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td class="text-center" colspan="5">Tidak ada data</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			<div class="card-body">
				{{ $posts->appends(request()->all())->links() }}
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-filter"></i> Filter
			</div>
			<div class="card-body">
				<form class="form-block" action="{{ route('administration::blog.posts.index') }}" method="get">
					<div class="form-group">
						<select type="text" class="form-control" name="category">
							<option value="">Semua kategori</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group mb-0">
						<button type="submit" class="btn btn-dark">Tetapkan</button>
					</div>
				</form>
			</div>
		</div>
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-comments"></i> Komentar terakhir
			</div>
			@include('web::includes.comment-widgets-1', ['comments' => $latest_comments])
		</div>
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-cogs"></i> Lanjutan
			</div>
			<div class="list-group list-group-flush">
				<a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::blog.posts.index', ['category' => request('category'), 'trashed' => request('trashed') ? 0 : 1 ]) }}">
					<i class="fas fa-sm fa-trash"></i> Tampilkan postingan yang {{ request('trashed') ? 'tidak' : '' }} dihapus
				</a>
			</div>
		</div>
	</div>
</div>
@endsection