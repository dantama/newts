@extends('blog::layouts.default')

@section('title', $post->title . ' - ')
@section('meta_title', Str::words(strip_tags($post->getMeta('title')), 50))
@section('meta_description', Str::words(strip_tags($post->getMeta('description')), 150))
@section('meta_image', $post->cover)

@section('content')
    <div class="container rounded py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-body">
                    @if ($post->cover)
                        <div class="mb-4">
                            <img src="{{ $post->cover }}" class="card-img-top rounded" alt="">
                        </div>
                    @endif
                    <div>
                        @forelse($post->categories as $category)
                            <span class="badge badge-pill badge-dark">{{ $category->name }}</span>
                        @empty
                            <span class="badge badge-pill badge-secondary">Tidak ada kategori</span>
                        @endforelse
                    </div>
                    <h2 class="mb-2"><strong>{{ $post->title }}</strong></h2>
                    <div class="d-flex align-items-center flex-row">
                        <img class="rounded-circle me-3" src="{{ $post->author_avatar }}" alt="" style="width: 32px">
                        <div>
                            <div class="font-weight-bold">{{ $post->author->name ?? 'Penulis' }}</div>
                        </div>
                    </div>
                    <div class="my-4">
                        {!! $post->content !!}
                    </div>
                    @if ($post->commentable)
                        <div class="mb-4">
                            <p><strong>Komentar</strong> ({{ $post->comments->count() }})</p>
                            @forelse($post->comments as $comment)
                                <section class="d-flex w-100 flex-row">
                                    <div>
                                        <img class="rounded-circle me-3" src="{{ $comment->commentator->profile->avatar_path }}" alt="" style="width: 46px;">
                                    </div>
                                    <div class="flex-grow-1 bg-light rounded p-3">
                                        <div class="font-weight-bold">{{ $comment->commentator->profile->full_name }}</div>
                                        <article class="comments-readmore overflow-hidden">{{ $comment->content }}</article>
                                        <small class="text-muted"><i class="fa fa-calendar-outline"></i> {{ $comment->created_at->ISOFormat('llll') }}</small>
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
                                        <img class="rounded-circle me-3" src="{{ $user->getMeta('profile_avatar') }}" alt="" style="width: 46px;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <form class="form-block form-confirm" action="{{ route('training::comment', ['post' => $post->id]) }}" method="post"> @csrf
                                            <div class="form-group">
                                                <textarea class="form-control" name="content" placeholder="Tulis komentar Anda disini ..." required></textarea>
                                                <small>Anda berkomentar sebagai <strong>{{ $user->name }}</strong></small>
                                            </div>
                                            <button class="btn btn-dark"><i class="fa fa-send-outline fa-rotate-315"></i> Kirim</button>
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
                </div>
            </div>
        </div>
    </div>
@endsection
