@extends('core::layouts.default')

@section('title', 'Posisi ')
@section('navtitle', 'Posisi')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-format-list-bulleted"></i> Daftar jabatan
                </div>
                <div class="card-body border-top border-light">
                    <form class="form-block row g-2" action="{{ route('core::administration.unit-positions.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="flex-grow-1 col-auto">
                            <input class="form-control" name="search" placeholder="Cari nama ..." value="{{ request('search') }}" />
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-light" href="{{ route('core::administration.unit-positions.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> <span class="d-sm-none">Reset</span></a>
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
                                    <th>Unit</th>
                                    <th class="text-center">Kode</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unitPoss as $unit)
                                    <tr @if ($unit->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $unitPoss->firstItem() - 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $unit->name }}</div>
                                            <div class="text-muted">{{ $unit->getMeta('org_address') }}</div>
                                            <div class="badge small {{ $unit->type->color() }}">{{ $unit->type->prefix() }}</div>
                                        </td>
                                        <td class="text-center">
                                            {{ $unit->getMeta('org_code') }}
                                        </td>
                                        <td class="py-2 text-end" nowrap>
                                            @if (!$unit->trashed())
                                                <span data-bs-toggle="collapse" data-bs-target="#collapse-{{ $unit->id }}">
                                                    <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Lihat daftar"><i class="mdi mdi-file-tree-outline"></i></button>
                                                </span>
                                                <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('core::administration.unit-positions.create', ['unit' => $unit->id, 'next' => url()->current()]) }}" data-bs-toggle="tooltip" title="Tambah komponen"><i class="mdi mdi-plus-circle-outline"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 p-0" colspan="100%">
                                            <div class="collapse" id="collapse-{{ $unit->id }}">
                                                <table class="table-borderless table-hover table-sm mb-0 table align-middle">
                                                    <thead>
                                                        <tr class="text-muted small bg-light">
                                                            <th class="border-bottom fw-normal"></th>
                                                            <th class="border-bottom fw-normal">Jabatan</th>
                                                            <th class="border-bottom fw-normal">Status</th>
                                                            <th class="border-bottom fw-normal"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($unit->unit_positions as $key => $poss)
                                                            <tr class="small">
                                                                <td></td>
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
                                                                                <form class="form-block form-confirm d-inline" action="{{ route('core::administration.unit-positions.restore', ['unit' => $unit->id, 'unit_position' => $poss->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                                                    <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                                                </form>
                                                                            @endcan
                                                                        @else
                                                                            @can('update', $poss)
                                                                                <a class="btn btn-sm btn-soft-warning rounded px-2 py-1" href="{{ route('core::administration.unit-positions.show', ['unit' => $unit->id, 'unit_position' => $poss->id, 'next' => url()->current()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                                                            @endcan
                                                                            @can('kill', $poss)
                                                                                <form class="form-block form-confirm d-inline" action="{{ route('core::administration.unit-positions.destroy', ['unit' => $unit->id, 'unit_position' => $poss->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            @include('components.notfound')
                                        </td>
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
                    <div class="display-4">{{ $unit_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah unit</div>
                </div>
                <div><i class="mdi mdi-file-tree-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top border-light">
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('core::administration.unit-positions.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat unit departemen yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
