@extends('blog::layouts.default')

@section('title', 'Artikel')
@section('navtitle', 'Artikel')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <section>
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-format-list-bulleted"></i> Daftar Artikel
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Dibuat pada</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr @if ($post->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $posts->firstItem() - 1 }}</td>
                                        <td class="fw-bold">
                                            <div class="fw-bold">{{ $post->title }}</div>
                                            <span class="text-muted">Jumlah like: {{ $post->likes->count() }}</span>
                                            <span class="text-muted">Jumlah comment: {{ $post->comments->count() }}</span>
                                        </td>
                                        <td>{{ Str::limit(strip_tags($post->content), 50) }}</td>
                                        <td>{{ $post->created_at->isoFormat('LL') }}</td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($post->trashed())
                                                @can('restore', $post)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('blog::article.posts.restore', ['post' => $post->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                    <form class="form-block form-confirm d-inline" action="{{ route('blog::article.posts.kill', ['post' => $post->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus permanen"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                @can('update', $post)
                                                    <a class="btn btn-soft-primary rounded px-2 py-1" href="{{ route('blog::article.posts.show', ['post' => $post->id, 'next' => url()->current()]) }}" data-bs-toggle="tooltip" title="Lihat detail"><i class="mdi mdi-eye-outline"></i></a>
                                                    <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('blog::article.posts.edit', ['post' => $post->id, 'next' => url()->current()]) }}" data-bs-toggle="tooltip" title="Lihat detail"><i class="mdi mdi-pencil"></i></a>
                                                @endcan
                                                @can('destroy', $post)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('blog::article.posts.destroy', ['post' => $post->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            @include('components.notfound')
                                            @if (!request('trash'))
                                                @can('store', Modules\Blog\Models\BlogPost::class)
                                                    <div class="mb-lg-5 mb-4 text-center">
                                                        <a class="btn btn-soft-danger" href="{{ route('blog::article.posts.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat artikel baru</a>
                                                    </div>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        {{ $posts->appends(request()->all())->links() }}
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $post_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah post</div>
                </div>
                <div><i class="mdi mdi-account-group-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body"><i class="mdi mdi-filter-outline"></i> Filter</div>
                <div class="card-body border-top">
                    <form class="form-block row gy-2 gx-2" action="{{ route('blog::article.posts.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="mb-3">
                            <label class="form-label" for="">Pencarian</label>
                            <input class="form-control" name="search" placeholder="Cari nama di sini ..." value="{{ request('search') }}" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Terapkan</button>
                            <a class="btn btn-light" href="{{ route('blog::article.posts.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top">
                    @can('store', Modules\Blog\Models\BlogPost::class)
                        <a class="list-group-item list-group-item-action" href="{{ route('blog::article.posts.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat artikel baru</a>
                    @endcan
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('blog::article.posts.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat artikel yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
