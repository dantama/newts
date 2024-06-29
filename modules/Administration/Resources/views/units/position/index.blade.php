@extends('administration::layouts.default')

@section('title', 'Jabatan ')
@section('navtitle', 'Jabatan')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-format-list-bulleted"></i> Daftar jabatan
                </div>
                <div class="card-body border-top border-light">
                    <form class="form-block row g-2" action="{{ route('administration::units.positions.index', ['unit' => $currentUnit->kd, 'trashed' => request('trashed'), 'closed' => request('closed')]) }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="flex-grow-1 col-auto">
                            <input class="form-control" name="search" placeholder="Cari nama ..." value="{{ request('search') }}" />
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-light" href="{{ route('administration::units.positions.index', ['unit' => $currentUnit->kd, 'trashed' => request('trashed'), 'closed' => request('closed')]) }}"><i class="mdi mdi-refresh"></i> <span class="d-sm-none">Reset</span></a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Cari</button>
                        </div>
                    </form>
                </div>
                <div class="d-block">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th class="border-bottom text-center">#</th>
                                    <th class="border-bottom">Jabatan</th>
                                    <th class="border-bottom">Status</th>
                                    <th class="border-bottom"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unitPoss as $key => $poss)
                                    <tr @if ($poss->trashed()) class="table-light text-muted" @endif>
                                        <td class="text-center">{{ $loop->iteration + $unitPoss->firstItem() - 1 }}</td>
                                        <td class="text-dark">{{ $poss->position->name }}</td>
                                        <td>
                                            @if ($poss->position->is_visible)
                                                <a href="javascript:;" class="text-success"><i class="mdi mdi-check"></i> Aktif</a>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="me-1">
                                                @if ($poss->trashed())
                                                    @can('restore', $poss)
                                                        <form class="form-block form-confirm d-inline" action="{{ route('administration::units.positions.restore', ['position' => $poss->id, 'unit' => $currentUnit->kd, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                            <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                        </form>
                                                    @endcan
                                                @else
                                                    @can('update', $poss)
                                                        <a class="btn btn-sm btn-soft-warning rounded px-2 py-1" href="{{ route('administration::units.positions.show', ['position' => $poss->id, 'unit' => $currentUnit->kd, 'next' => url()->current()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                                    @endcan
                                                    @can('kill', $poss)
                                                        <form class="form-block form-confirm d-inline" action="{{ route('administration::units.positions.destroy', ['position' => $poss->id, 'unit' => $currentUnit->kd, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                            <button class="btn btn-sm btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    {{ $unitPoss->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $unit_poss_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah jabatan</div>
                </div>
                <div><i class="mdi mdi-file-tree-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top border-light">
                    <a class="list-group-item list-group-item-action text-dark" href="{{ route('administration::units.positions.create', ['unit' => $currentUnit->kd]) }}"><i class="mdi mdi-plus-circle-outline"></i> Tambah jabatan</a>
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::units.positions.index', ['unit' => $currentUnit->kd, 'trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat jabatan yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
