@extends('core::layouts.default')

@section('title', 'Anggota ')
@section('navtitle', 'Anggota')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-format-list-bulleted"></i> Daftar anggota
                </div>
                <div class="card-body border-top border-light">
                    <form class="form-block row g-2" action="{{ route('core::membership.members.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="flex-grow-1 col-auto">
                            <input class="form-control" name="search" placeholder="Cari nama ..." value="{{ request('search') }}" />
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-light" href="{{ route('core::membership.members.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> <span class="d-sm-none">Reset</span></a>
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
                                    <th>NBTS</th>
                                    <th nowrap>Organisasi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $member)
                                    <tr @if ($member->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $members->firstItem() - 1 }}</td>
                                        <td width="30%">
                                            <strong>{{ $member->user->name }}</strong>
                                        </td>
                                        <td class="text-start">
                                            {{ $member->nbts }}
                                        </td>
                                        <td>
                                            {{ $member->unit->name }}
                                        </td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($member->trashed())
                                                @can('restore', $member)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('core::membership.members.restore', ['member' => $member->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                <span data-bs-toggle="collapse" data-bs-target="#collapse-{{ $member->id }}">
                                                    <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Lihat daftar"><i class="mdi mdi-file-tree-outline"></i></button>
                                                </span>
                                                @can('update', $member)
                                                    <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('core::membership.members.show', ['member' => $member->id, 'next' => url()->current()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                                @endcan
                                                @can('kill', $member)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('core::membership.members.destroy', ['member' => $member->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 p-0" colspan="100%">
                                            <div class="collapse" id="collapse-{{ $member->id }}">
                                                <table class="table-borderless table-hover table-sm mb-0 table align-middle">
                                                    <thead>
                                                        <tr class="text-muted small bg-light">
                                                            <th class="border-bottom fw-normal"></th>
                                                            <th class="border-bottom fw-normal">Tingkat</th>
                                                            <th class="border-bottom fw-normal text-center">Periode</th>
                                                            <th class="border-bottom fw-normal">Sertifikat</th>
                                                            <th class="border-bottom fw-normal"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($member->levels as $key => $level)
                                                            <tr class="small">
                                                                <td></td>
                                                                <td class="text-dark" width="25%">{{ $level->level->name }}</td>
                                                                <td nowrap class="text-center">
                                                                    <div class="justify-content-center align-items-center d-flex">
                                                                        @if ($level->start_at)
                                                                            <div class="">
                                                                                <h6 class="mb-0">{{ $level->start_at->format('d-M') }}</h6> <small class="text-muted">{{ $level->start_at->format('Y') }}</small>
                                                                            </div>
                                                                        @endif
                                                                        <div class="text-muted small mx-2">&mdash; s.d. &mdash;</div>
                                                                        @if ($level->end_at)
                                                                            <div class="">
                                                                                <h6 class="mb-0">{{ $level->end_at->format('d-M') }}</h6> <small class="text-muted">{{ $level->end_at->format('Y') }}</small>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td width="35%">
                                                                    @if (!empty($level->meta?->certified))
                                                                        <a href="javascript:;" class="text-dark"> <i class="mdi mdi-cloud-download-outline"></i> Unduh</a>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end">
                                                                    <div class="me-1">

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
                                                        <a class="btn btn-soft-danger" href="{{ route('core::membership.members.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat unit baru</a>
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
                    {{ $members->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $member_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah anggota</div>
                </div>
                <div><i class="mdi mdi-file-tree-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body border-bottom">
                    <div class="fw-bold"><i class="mdi mdi-filter"></i> Filter</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('core::membership.members.index') }}" method="get">
                        <div class="mb-3">
                            <label for="org_prov_id" class="form-label">Unit</label>
                            <select class="form-select form-select" name="unit" id="unit_id">
                                <option value=""></option>
                                @foreach ($units as $key => $unit)
                                    <option value="{{ $unit->id }}" @selected(request('unit') == $unit->id)>{{ $unit->type->alias() . ' ' . $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="org_prov_id" class="form-label">Kategori</label>
                            <select class="form-select form-select" name="membership" id="membership">
                                <option value=""></option>
                                @foreach ($memberships as $key => $membership)
                                    <option value="{{ $membership->value }}" data-levels="{{ json_encode($membership->levels()) }}" @selected(request('membership') == $membership->value)>{{ $membership->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Tingkatan</label>
                            <select class="form-select form-select" name="levels[]" id="level_id" multiple>
                                <option selected></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pencarian</label>
                            <input class="form-control" name="search" placeholder="Cari nama atau NBTS ..." value="{{ request('search') }}" />
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-filter-outline"></i> Terapkan</button>
                            <a class="btn btn-light" href="{{ route('core::membership.members.index') }}"><i class="mdi mdi-refresh"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top border-light">
                    @can('store', Modules\Core\Models\Unit::class)
                        <a class="list-group-item list-group-item-action" href="{{ route('core::membership.members.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus-circle-outline"></i> Tambah anggota baru</a>
                    @endcan
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('core::membership.members.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat anggota yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/tom-select/css/tom-select.bootstrap5.min.css') }}">
@endpush

@push('scripts')
    <script>
        const renderTomSelect = (selector) => {
            new TomSelect(selector, {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
            });
        }

        const listMembership = () => {
            [].slice.call(document.querySelectorAll('[name="membership"] option:checked')).map((select) => {
                let opt = '';
                let requestlevel = @JSON(request('levels')) ?? [];
                if (select.dataset.levels) {
                    let levels = JSON.parse(select.dataset.levels);
                    for (i in levels) {
                        opt += '<option value="' + i + '" ' + (requestlevel.includes(i) ? ' selected' : '') + '>' + levels[i] + '</option>';
                    }
                }
                document.querySelector('#level_id').innerHTML = opt.length ? '<option value>-- Pilih --</option>' + opt : '<option value></option>'
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            [].slice.call(document.querySelectorAll('[name="membership"]')).map((e) => {
                e.addEventListener('click', listMembership);
            });
            listMembership();
            renderTomSelect('#unit_id');
        });
    </script>
@endpush
