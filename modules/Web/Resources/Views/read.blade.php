@extends('web::layouts.default')
@section('title', $post->title . ' - ')
@section('meta_title', $post->title . ' - ')
@section('meta_description', Str::words(strip_tags($post->content), 15))
@section('meta_image', $post->img ? Storage::url($post->img) : null)
@php($user = auth()->user())

@section('content')
    <div class="container rounded bg-white py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4 border-0">
                    @if ($post->img)
                        @if (Storage::exists($post->img))
                            <img src="{{ Storage::url($post->img) }}" class="card-img-top rounded" alt="">
                        @else
                            <div class="rounded bg-gray-900" style="height: 150px;"></div>
                        @endif
                    @else
                        <div class="card-body bg-light rounded" style="height: 18vh;"></div>
                    @endif
                    <div class="card-body p-sm-4 p-2">
                        <div class="rounded bg-white p-4 shadow" style="margin-top: -18%;">
                            <p>
                                @forelse($post->categories as $category)
                                    <span class="badge badge-pill badge-dark">{{ $category->name }}</span>
                                @empty
                                    <span class="badge badge-pill badge-secondary">Uncategorized</span>
                                @endforelse
                            </p>
                            <h2 class="mb-2"><strong>{{ $post->title }}</strong></h2>
                            <div class="text-muted mb-4">
                                <i class="mdi mdi-eye"></i> <small class="me-2">{{ $post->views_count }}</small>
                                <i class="mdi {{ $post->commentable ? 'mdi-comment' : 'mdi-comment-remove' }}"></i> <small class="me-2">{{ $post->comments_count }}</small>
                                <i class="mdi mdi-calendar"></i> <small class="me-2">{{ $post->created_at ? $post->created_at->ISOFormat('L') : '-' }}</small>
                            </div>
                            <div class="d-flex align-items-center flex-row">
                                <img class="rounded-circle mr-3" src="{{ $post->author ? $post->author->profile->avatar_path : asset('img/default-avatar.svg') }}" alt="" style="width: 46px">
                                <div>
                                    <div class="font-weight-bold">{{ $post->author->profile->name ?? 'Penulis' }}</div>
                                    <i>{{ $post->author->profile->bio ?? 'Tidak ada bio' }}</i>
                                </div>
                            </div>
                            <article class="my-4">
                                {!! $post->content !!}
                            </article>
                            @if ($post->commentable)
                                <div class="mb-4">
                                    <p><strong>Komentar</strong> ({{ $post->comments->count() }})</p>
                                    @forelse($post->comments as $comment)
                                        <section class="d-flex w-100 flex-row">
                                            <div>
                                                <img class="rounded-circle mr-3" src="{{ $comment->commentator->profile->avatar_path }}" alt="" style="width: 46px;">
                                            </div>
                                            <div class="flex-grow-1 bg-light rounded p-3">
                                                <div class="font-weight-bold">{{ $comment->commentator->profile->full_name }}</div>
                                                <article class="comments-readmore overflow-hidden">{{ $comment->content }}</article>
                                                <small class="text-muted"><i class="mdi mdi-calendar-outline"></i> {{ $comment->created_at->ISOFormat('llll') }}</small>
                                            </div>
                                        </section>
                                    @empty
                                        Tidak ada komentar
                                    @endforelse
                                </div>
                                <div>
                                    <hr>
                                    @auth
                                        <div class="d-flex w-100 flex-row">
                                            <div>
                                                <img class="rounded-circle mr-3" src="{{ $user->profile->avatar_path }}" alt="" style="width: 46px;">
                                            </div>
                                            <div class="flex-grow-1">
                                                <form class="form-block form-confirm" action="{{ route('web::comment', ['post' => $post->id]) }}" method="post"> @csrf
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="content" placeholder="Tulis komentar Anda disini ..." required></textarea>
                                                        <small>Anda berkomentar sebagai <strong>{{ $user->profile->name }}</strong></small>
                                                    </div>
                                                    <button class="btn btn-dark"><i class="mdi mdi-send-outline mdi-rotate-315"></i> Kirim</button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <a class="btn btn-dark btn-sm" href="{{ route('account::auth.login', ['next' => url()->current()]) }}">Login untuk berkomentar &raquo;</a>
                                    @endauth
                                </div>
                            @else
                                <hr>
                                <div class="text-muted">Komentar untuk postingan ini telah dinonaktifkan</div>
                            @endif
                            <div class="addthis_inline_share_toolbox"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3"><strong>Postingan terkait</strong></h5>
                @include('web::layouts.components.widgets.widget-1', ['posts' => $related_posts])
                <hr class="my-4">
                <h5 class="mb-3"><strong>Postingan terbaru</strong></h5>
                @include('web::layouts.components.widgets.widget-2', ['posts' => $latest_posts])
                <hr class="my-4">
                <h5 class="mb-3"><strong>Populer</strong></h5>
                @include('web::layouts.components.widgets.widget-3', ['posts' => $popular_posts])
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- <script src="{{ asset('js/readmore.min.js') }}"></script> --}}
    {{-- <script>
	$(() => {
		$('.comments-readmore').readmore({collapsedHeight:70});
	})
</script> --}}
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6021f7699bc4c253"></script>
@endpush
