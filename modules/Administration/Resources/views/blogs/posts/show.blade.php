@extends('administration::layouts.default')

@section('title', 'Detail postingan')

@php($url = url()->current())
@php($is_admin = auth()->user()->isManagerCenters() || auth()->id() == $post->author_id)

@section('content')
<div class="mb-4">
	<h5 class="mb-0">
		<a href="{{ request('next', route('administration::blog.posts.index')) }}"><i class="fas fa-sm fa-arrow-circle-left"></i></a>
		<strong>Detail postingan</strong>
	</h5>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="row mb-4 d-flex align-items-center">
			<div class="col-lg-4">
				<div class="rounded mb-4 mb-lg-0" style="background: url({{ Storage::exists($post->img) ? Storage::url($post->img) : asset('img/no-image.png') }}) center center no-repeat; background-size: cover; height: 200px;"></div>
			</div>
			<div class="col-lg-8">
				<div class="bg-white rounded p-4">
					<div class="mb-2">
						@forelse($post->categories->take(3) as $category)
							<span class="badge badge-pill badge-dark">{{ $category->name }}</span>
						@empty
							<span class="badge badge-pill badge-secondary">Uncategorized</span>
						@endforelse
					</div>
					<h5><strong>{{ $post->title }}</strong></h5>
					<div class="text-muted">
						<i class="fas fa-sm fa-eye"></i> <small>{{ $post->views_count }}</small>
						{{-- <i class="mdi mdi-heart"></i> <small>{{ $post->likes_count }}</small> --}}
						<i class="fas fa-sm fa-comment"></i> <small>{{ $post->comments_count }}</small>
						<i class="fas fa-sm fa-calendar"></i> <small>{{ $post->created_at ? $post->created_at->ISOFormat('L') : '-' }}</small>
					</div>
					<div class="text-muted mb-2">{{ \Str::words(strip_tags($post->content), 20) }}</div>
					<div>
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
					</div>
				</div>
			</div>
		</div>
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-comments"></i> Komentar
			</div>
			<div class="list-group list-group-flush">
				@forelse($post->comments as $comment)
					<div class="list-group-item">
						<section class="d-flex flex-row w-100">
							<div>
								<img class="rounded-circle mr-3" src="{{ $comment->commentator->profile->avatar_path }}" alt="" style="width: 46px;">
							</div>
							<div class="flex-grow-1 bg-light rounded p-3">
								<div class="font-weight-bold">{{ $comment->commentator->profile->full_name }}</div>
								<article class="comments-readmore overflow-hidden">{{ $comment->content }}</article>
								<small class="text-muted"><i class="fas fa-sm fa-calendar"></i> {{ $comment->created_at->ISOFormat('llll') }}</small>
								<div class="mt-2">
									<form class="d-inline form-block form-confirm" action="{{ route('administration::blog.comments.approve', ['comment' => $comment->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('PUT')
										<button class="btn btn-{{ $comment->published_at ? 'warning' : 'success' }} btn-sm"><i class="fas fa-sm fa-{{ $comment->published_at ? 'times' : 'check' }}-circle-outline"></i> {{ $comment->published_at ? 'Reject' : 'Approve' }}</button>
									</form>
									<form class="d-inline form-block form-confirm" action="{{ route('administration::blog.comments.destroy', ['comment' => $comment->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('DELETE')
										<button class="btn btn-danger btn-sm"><i class="fas fa-sm fa-trash"></i> Hapus <span class="d-none d-sm-inline">komentar</span></button>
									</form>
								</div>
							</div>
						</section>
					</div>
				@empty
					<div class="list-group-item">Tidak ada komentar</div>
				@endforelse
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card border-0 mb-4">
			<div class="card-header bg-gray-200">
				<i class="fas fa-sm fa-newspaper"></i> Detail postingan
			</div>
			<div class="list-group list-group-flush">
				@foreach([
						'Author'	=> $post->author->profile->full_name ?? null,
						'Waktu publish'	=> $post->published_at ? $post->published_at->ISOFormat('LL') : null,
						'Dibuat pada'	=> $post->created_at,
						'Terakhir diperbarui'	=> $post->updated_at,
					] as $k => $v)
					<div class="list-group-item">
						<small>{{ $k }} </small><br> <strong>{!! $v ?? '-' !!}</strong>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/readmore.min.js') }}"></script>
<script>
	$(() => {
		$('.comments-readmore').readmore({collapsedHeight:70});
	})
</script>
@endpush