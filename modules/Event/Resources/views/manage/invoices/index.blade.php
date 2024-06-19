@extends('admin::layouts.default')

@section('title', 'Invoice')
@section('navtitle', 'Invoice')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <section>
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-format-list-bulleted"></i> Daftar invoice pengguna
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pengguna</th>
                                    <th>Kode invoice</th>
                                    <th>Nominal</th>
                                    <th>Tenggat</th>
                                    <th>Status</th>
                                    <th nowrap class="text-center">Bukti Transfer</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr @if ($invoice->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $invoices->firstItem() - 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $invoice->user->name }}</div>
                                            <div class="small text-muted">{{ $invoice->user->email_address }}</div>
                                        </td>
                                        <td>{{ $invoice->code }}</td>
                                        <td>{{ Str::money($invoice->final_price, 0) }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $invoice->due_at?->diffForHumans() ?: '-' }}</div>
                                            <div class="small text-muted">{{ $invoice->due_at?->isoFormat('lll') }}</div>
                                        </td>
                                        <td>{!! $invoice->badge() !!}</td>
                                        <td class="text-center">
                                            @if (Storage::exists($invoice->meta?->evidence ?? -1))
                                                <a class="btn btn-soft-primary rounded px-2 py-1" href="{{ Storage::url($invoice->meta->evidence) }}" target="_blank" data-bs-toggle="tooltip" title="Lihat"><i class="mdi mdi-eye-outline"></i></a>
                                            @endif
                                        </td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($invoice->trashed())
                                                @can('restore', $invoice)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::finance.invoices.restore', ['invoice' => $invoice->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::finance.invoices.kill', ['invoice' => $invoice->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus permanen"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                <a class="btn btn-soft-success rounded px-2 py-1" href="{{ route('admin::finance.invoices.print.show', ['invoice' => $invoice->code]) }}" target="_blank" data-bs-toggle="tooltip" title="Cetak invoice"><i class="mdi mdi-printer-outline"></i></a>
                                                @can('update', $invoice)
                                                    <a class="btn btn-soft-primary rounded px-2 py-1" href="{{ route('admin::finance.invoices.show', ['invoice' => $invoice->id, 'next' => url()->current()]) }}" data-bs-toggle="tooltip" title="Lihat detail"><i class="mdi mdi-eye-outline"></i></a>
                                                @endcan
                                                @can('destroy', $invoice)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::finance.invoices.destroy', ['invoice' => $invoice->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
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
                                                @can('store', Modules\Finance\Models\Invoice::class)
                                                    <div class="mb-lg-5 mb-4 text-center">
                                                        <a class="btn btn-soft-danger" href="{{ route('admin::finance.invoices.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat invoice baru</a>
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
                        {{ $invoices->appends(request()->all())->links() }}
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $invoices_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah invoice</div>
                </div>
                <div><i class="mdi mdi-account-group-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body"><i class="mdi mdi-filter-outline"></i> Filter</div>
                <div class="card-body border-top">
                    <form class="form-block row gy-2 gx-2" action="{{ route('admin::finance.invoices.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="mb-3">
                            <label class="form-label" for="">Pencarian</label>
                            <input class="form-control" name="search" placeholder="Cari nama di sini ..." value="{{ request('search') }}" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Terapkan</button>
                            <a class="btn btn-light" href="{{ route('admin::finance.invoices.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top">
                    @can('store', Modules\Finance\Models\Invoice::class)
                        <a class="list-group-item list-group-item-action" href="{{ route('admin::finance.invoices.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat invoice baru</a>
                    @endcan
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('admin::finance.invoices.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat invoice yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
