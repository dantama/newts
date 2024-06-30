@extends('blog::layouts.default')

@section('title', 'Testimonial')
@section('navtitle', 'Testimonial')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <section>
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-format-list-bulleted"></i> Daftar testimonial
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Testimoni</th>
                                    <th>Dibuat pada</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($testimonies as $testimony)
                                    <tr @if ($testimony->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $testimonies->firstItem() - 1 }}</td>
                                        <td width="10">
                                            <div class="rounded-circle" style="background: url('{{ json_decode($testimony->meta?->avatar)->path }}') center center no-repeat; background-size: cover; width: 32px; height: 32px;"></div>
                                        </td>
                                        <td class="fw-bold" nowrap>
                                            <div class="fw-bold">{{ $testimony->name }}</div>
                                        </td>
                                        <td>{!! $testimony->content !!}</td>
                                        <td>{{ $testimony->created_at->isoFormat('LLL') }}</td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($testimony->trashed())
                                                @can('restore', $testimony)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('blog::testimonies.restore', ['testimony' => $testimony->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                    <form class="form-block form-confirm d-inline" action="{{ route('blog::testimonies.kill', ['testimony' => $testimony->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus permanen"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                @can('update', $testimony)
                                                    <a class="btn btn-soft-primary rounded px-2 py-1" href="{{ route('blog::testimonies.show', ['testimony' => $testimony->id, 'next' => url()->current()]) }}" data-bs-toggle="tooltip" title="Lihat detail"><i class="mdi mdi-eye-outline"></i></a>
                                                @endcan
                                                @can('destroy', $testimony)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('blog::testimonies.destroy', ['testimony' => $testimony->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
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
                                                @can('store', Modules\Blog\Models\Testimony::class)
                                                    <div class="mb-lg-5 mb-4 text-center">
                                                        <a class="btn btn-soft-danger" href="{{ route('blog::testimonies.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat testimoni baru</a>
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
                        {{ $testimonies->appends(request()->all())->links() }}
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $testimony_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah testimoni</div>
                </div>
                <div><i class="mdi mdi-account-group-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body"><i class="mdi mdi-filter-outline"></i> Filter</div>
                <div class="card-body border-top">
                    <form class="form-block row gy-2 gx-2" action="{{ route('blog::testimonies.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="mb-3">
                            <label class="form-label" for="">Pencarian</label>
                            <input class="form-control" name="search" placeholder="Cari nama di sini ..." value="{{ request('search') }}" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Terapkan</button>
                            <a class="btn btn-light" href="{{ route('blog::testimonies.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top">
                    {{-- @can('store', Modules\Blog\Models\Testimony::class) --}}
                    <a class="list-group-item list-group-item-action" href="{{ route('blog::testimonies.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus-circle-outline"></i> Buat testimoni baru</a>
                    {{-- @endcan --}}
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('blog::testimonies.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat testimoni yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
