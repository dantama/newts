@extends('admin::layouts.default')

@section('title', 'Pembayaran')
@section('navtitle', 'Pembayaran')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <section>
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-format-list-bulleted"></i> Riwayat transaksi pengguna
                    </div>
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Nomor invoice</th>
                                    <th>Nominal</th>
                                    <th>Dibayar pada</th>
                                    <th>Dibayar oleh</th>
                                    <th class="text-center">Validasi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr @if ($transaction->trashed()) class="table-light text-muted" @endif>
                                        <td>{{ $loop->iteration + $transactions->firstItem() - 1 }}</td>
                                        <td>{{ $transaction->id }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $transaction->invoice->code ?? 'Tidak ada kode' }}</div>
                                        </td>
                                        <td>{{ Str::money($transaction->paid_amount, 0) }}</td>
                                        <td>{{ $transaction->paid_at?->format('d M Y') }}</td>
                                        <td>{{ $transaction->payer }}</td>
                                        <td class="text-center">
                                            @if ($transaction->validated_at)
                                                <i class="mdi mdi-check text-success"></i>
                                            @else
                                                <i class="mdi mdi-close text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="py-2 text-end" nowrap>
                                            @if ($transaction->trashed())
                                                @can('restore', $transaction)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::finance.payments.restore', ['transaction' => $transaction->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('put')
                                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                                    </form>
                                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::finance.payments.kill', ['transaction' => $transaction->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
                                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus permanen"><i class="mdi mdi-trash-can-outline"></i></button>
                                                    </form>
                                                @endcan
                                            @else
                                                <a class="btn btn-soft-success rounded px-2 py-1" href="{{ route('admin::finance.payments.receipt.show', ['transaction' => $transaction->id]) }}" target="_blank" data-bs-toggle="tooltip" title="Bukti pembayaran"><i class="mdi mdi-printer-outline"></i></a>
                                                <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('admin::finance.payments.edit', ['transaction' => $transaction->id]) }}" data-bs-toggle="tooltip" title="Ubah pembayaran"><i class="mdi mdi-pencil"></i></a>
                                                @can('destroy', $transaction)
                                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::finance.payments.destroy', ['transaction' => $transaction->id, 'next' => url()->current()]) }}" method="post"> @csrf @method('delete')
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
                                                @can('store', Modules\Finance\Models\InvoiceTransaction::class)
                                                    <div class="mb-lg-5 mb-4 text-center">
                                                        <a class="btn btn-soft-danger" href="{{ route('admin::finance.payments.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat pembayaran baru</a>
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
                        {{ $transactions->appends(request()->all())->links() }}
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <div class="card card-body d-flex justify-content-between align-items-center flex-row border-0 py-4">
                <div>
                    <div class="display-4">{{ $transactions_count }}</div>
                    <div class="small fw-bold text-secondary text-uppercase">Jumlah payment</div>
                </div>
                <div><i class="mdi mdi-account-group-outline mdi-48px text-light"></i></div>
            </div>
            <div class="card border-0">
                <div class="card-body"><i class="mdi mdi-filter-outline"></i> Filter</div>
                <div class="card-body border-top">
                    <form class="form-block row gy-2 gx-2" action="{{ route('admin::finance.payments.index') }}" method="get">
                        <input name="trash" type="hidden" value="{{ request('trash') }}">
                        <div class="mb-3">
                            <label class="form-label" for="">Pencarian</label>
                            <input class="form-control" name="search" placeholder="Cari nama di sini ..." value="{{ request('search') }}" />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Terapkan</button>
                            <a class="btn btn-light" href="{{ route('admin::finance.payments.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">Menu lainnya</div>
                <div class="list-group list-group-flush border-top">
                    @can('store', Modules\Finance\Models\InvoiceTransaction::class)
                        <a class="list-group-item list-group-item-action" href="{{ route('admin::finance.payments.create', ['next' => url()->current()]) }}"><i class="mdi mdi-plus"></i> Buat pembayaran baru</a>
                    @endcan
                    <a class="list-group-item list-group-item-action text-danger" href="{{ route('admin::finance.payments.index', ['trash' => !request('trash')]) }}"><i class="mdi mdi-trash-can-outline"></i> Lihat transaksi yang {{ request('trash') ? 'tidak' : '' }} dihapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
