@extends('core::layouts.default')

@section('title', 'Unit ')
@section('navtitle', 'Unit')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-format-list-bulleted"></i> Daftar organisasi
                </div>
                <div class="card-body border-top border-light">
                    <form class="form-block row g-2" action="{{ route('core::administration.units.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="flex-grow-1 col-auto">
                            <input class="form-control" name="search" placeholder="Cari nama ..." value="{{ request('search') }}" />
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-light" href="{{ route('core::administration.units.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> <span class="d-sm-none">Reset</span></a>
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
                                    <th>Pimwil</th>
                                    <th class="text-center">Kode</th>
                                    <th nowrap>No. Telepon</th>
                                    <th nowrap>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($regions as $region)
                                    <tr @if ($region->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $regions->firstItem() - 1 }}</td>
                                        <td width="20%">
                                            <strong>{{ $region->name }}</strong>
                                        </td>
                                        <td class="text-center">
                                            {{ $region->getMeta('org_code') }}
                                        </td>
                                        <td width="20%">
                                            @if (!empty($region->getMeta('org_phone')))
                                                <div class="py-1">
                                                    <a href="javascript:;" class="text-dark"> {{ $region->getMeta('org_phone') }}</a>
                                                </div>
                                            @endif
                                        </td>
                                        <td width="35%">
                                            @if (!empty($region->getMeta('org_email')))
                                                <div class="py-1">
                                                    <a href="mailto:{{ $region->getMeta('org_email') }}" class="text-dark"> {{ $region->getMeta('org_email') }}</a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($region->trashed())
                                                @can('restore', $region)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('core::administration.units.restore', ['unit' => $region->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                <span data-bs-toggle="collapse" data-bs-target="#collapse-{{ $region->id }}">
                                                    <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Lihat daftar"><i class="mdi mdi-file-tree-outline"></i></button>
                                                </span>
                                                @can('update', $region)
                                                    <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('core::administration.units.show', ['unit' => $region->id, 'next' => url()->current()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                                @endcan
                                                @can('kill', $region)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('core::administration.units.destroy', ['unit' => $region->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 p-0" colspan="100%">
                                            <div class="collapse" id="collapse-{{ $region->id }}">
                                                <table class="table-borderless table-hover table-sm mb-0 table align-middle">
                                                    <thead>
                                                        <tr class="text-muted small bg-light">
                                                            <th class="border-bottom fw-normal"></th>
                                                            <th class="border-bottom fw-normal">Pimda</th>
                                                            <th class="border-bottom fw-normal">Kode</th>
                                                            <th class="border-bottom fw-normal">No Telepon</th>
                                                            <th class="border-bottom fw-normal">Email</th>
                                                            <th class="border-bottom fw-normal"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($region->children as $key => $area)
                                                            <tr class="small">
                                                                <td></td>
                                                                <td class="text-dark" width="25%">{{ $area->name }}</td>
                                                                <td class="text-center">{{ $area->getMeta('org_code') }}</td>
                                                                <td width="15%">
                                                                    @if (!empty($area->getMeta('org_phone')))
                                                                        <a href="javascript:;" class="text-dark"> {{ $area->getMeta('org_phone') }}</a>
                                                                    @endif
                                                                </td>
                                                                <td width="35%">
                                                                    @if (!empty($area->getMeta('org_email')))
                                                                        <a href="mailto:{{ $area->getMeta('org_email') }}" class="text-dark"> {{ $area->getMeta('org_email') }}</a>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end">
                                                                    <div class="me-1">
                                                                        @if ($area->trashed())
                                                                            @can('restore', $area)
                                                                                <form class="form-block form-confirm d-inline" action="{{ route('core::administration.units.restore', ['unit' => $area->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                                                    <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                                                </form>
                                                                            @endcan
                                                                        @else
                                                                            @can('update', $area)
                                                                                <a class="btn btn-sm btn-soft-warning rounded px-2 py-1" href="{{ route('core::administration.units.show', ['unit' => $area->id, 'next' => url()->current()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                                                            @endcan
                                                                            @can('kill', $area)
                                                                                <form class="form-block form-confirm d-inline" action="{{ route('core::administration.units.destroy', ['unit' => $area->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
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
                                            @if (!request('trash'))
                                                @can('store', Modules\Core\Models\Unit::class)
                                                    <div class="mb-lg-5 mb-4 text-center">
                                                        <a class="btn btn-soft-danger" href="{{ route('core::administration.units.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat unit baru</a>
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
                    {{ $regions->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $region_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah unit</div>
                </div>
                <div><i class="mdi mdi-file-tree-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top border-light">
                    @can('store', Modules\Core\Models\Unit::class)
                        <a class="list-group-item list-group-item-action" href="{{ route('core::administration.units.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus-circle-outline"></i> Buat unit baru</a>
                    @endcan
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('core::administration.units.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat unit yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
