@extends('administration::layouts.default')

@section('title', 'Pengurus ')
@section('navtitle', 'Pengurus')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-format-list-bulleted"></i> Daftar pengurus
                </div>
                <div class="card-body border-top border-light">
                    <form class="form-block row g-2" action="{{ route('administration::managers.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="flex-grow-1 col-auto">
                            <input class="form-control" name="search" placeholder="Cari nama ..." value="{{ request('search') }}" />
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-light" href="{{ route('administration::managers.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> <span class="d-sm-none">Reset</span></a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Cari</button>
                        </div>
                    </form>
                </div>
                <div class="d-block">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Unit</th>
                                    <th>Jabatan</th>
                                    <th>Departemen</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($managers as $manager)
                                    <tr @if ($manager->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $managers->firstItem() - 1 }}</td>
                                        <td>
                                            <strong>{{ $manager->member->user->name }}</strong>
                                        </td>
                                        <td>
                                            {{ $manager->unit_departement->unit->name }}
                                        </td>
                                        <td>
                                            {{ ucwords(Str::lower($manager->contract ? $manager->contract->unit_position->position->name : '')) }}
                                        </td>
                                        <td>
                                            {{ $manager->unit_departement->departement->name }}
                                        </td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($manager->trashed())
                                                @can('restore', $manager)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('administration::managers.restore', ['manager' => $manager->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                <span data-bs-toggle="collapse" data-bs-target="#collapse-{{ $manager->id }}">
                                                    <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Lihat daftar"><i class="mdi mdi-file-tree-outline"></i></button>
                                                </span>
                                                @can('update', $manager)
                                                    <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('administration::managers.show', ['manager' => $manager->id, 'next' => url()->current()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                                @endcan
                                                @can('kill', $manager)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('administration::managers.destroy', ['manager' => $manager->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 p-0" colspan="100%">
                                            <div class="collapse" id="collapse-{{ $manager->id }}">
                                                <table class="table-borderless table-hover table-sm mb-0 table align-middle">
                                                    <thead>
                                                        <tr class="text-muted small bg-light">
                                                            <th class="border-bottom fw-normal"></th>
                                                            <th class="border-bottom fw-normal">Tingkat</th>
                                                            <th class="border-bottom fw-normal">NBTS</th>
                                                            <th class="border-bottom fw-normal">No Telepon</th>
                                                            <th class="border-bottom fw-normal">Email</th>
                                                            <th class="border-bottom fw-normal"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <th class="border-bottom fw-normal"></th>
                                                        <th class="border-bottom fw-normal">{{ $manager->member->level->level->name }}</th>
                                                        <th class="border-bottom fw-normal">{{ $manager->member->nbts }}</th>
                                                        <th class="border-bottom fw-normal">{{ $manager->member->user->getMeta('profile_phone') }}</th>
                                                        <th class="border-bottom fw-normal">{{ $manager->member->user->email_address }}</th>
                                                        <th class="border-bottom fw-normal"></th>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            @include('components.notfound')
                                            @if (!request('trash'))
                                                @can('store', Modules\Core\Models\Manager::class)
                                                    <div class="mb-lg-5 mb-4 text-center">
                                                        <a class="btn btn-soft-danger" href="{{ route('administration::managers.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Tambah pengurus baru</a>
                                                    </div>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    {{ $managers->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $manager_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah unit</div>
                </div>
                <div><i class="mdi mdi-file-tree-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top border-light">
                    @can('store', Modules\Core\Models\Manager::class)
                        <a class="list-group-item list-group-item-action" href="{{ route('administration::managers.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus-circle-outline"></i> Tambah pengurus baru</a>
                    @endcan
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::managers.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat pengurus yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
