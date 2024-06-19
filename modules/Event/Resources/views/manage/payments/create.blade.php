@extends('admin::layouts.default')

@section('title', 'Pembayaran')
@section('navtitle', 'Buat pembayaran')

@php($back = request('next', route('admin::finance.payments.index')))

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a class="text-decoration-none" href="{{ $back }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
        <div class="ms-4">
            <h2 class="mb-1">Buat pembayaran</h2>
            <div class="text-secondary">Buat rincian pembayaran.</div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-6">
            <form class="form-block" action="{{ route('admin::finance.payments.create', ['next' => $back]) }}" method="get">
                <div class="card border-0">
                    <div class="card-body border-top">
                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label required">No invoice</label>
                            <div class="col-md-8 col-lg-9">
                                <div class="justify-content-between d-flex gap-2">
                                    <select name="invoice" id="invoice" class="form-select flex-grow-1 @error('invoice') is-invalid @enderror" required>
                                        <option selected disabled value="">Cari invoice</option>
                                        @foreach ($invoices as $_invoice)
                                            <option value="{{ $_invoice->code }}" @selected(request('invoice') == $_invoice->code)>{{ $_invoice->code }} - {{ $_invoice->user->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-danger text-nowrap"> <i class="mdi mdi-magnify"></i> Cari</button>
                                    <a class="btn btn-soft-secondary text-dark text-nowrap" href={{ route('admin::finance.payments.create', ['next' => $back]) }}> <i class="mdi mdi-sync"></i> Reset</a>
                                </div>
                                @error('code')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if ($invoice)
                @if (isset($invoice->meta->evidence) && is_null($invoice->paid_off_at))
                    <div class="card card-body border-success border">
                        <div class="row align-items-center gap-lg-0 gap-3">
                            <div class="col-lg-8">
                                <h6 class="fw-bold mb-1">Lihat bukti transfer</h6>
                                <div class="text-muted">
                                    Peserta telah mengunggah bukti transfer, silakan cek terlebih dahulu untuk memastikan keabsahan data.
                                </div>
                            </div>
                            <div class="col-lg-4 text-lg-end">
                                <a class="btn text-nowrap btn-soft-success" href="{{ Storage::url($invoice->meta->evidence) }}" target="_blank"><i class="mdi mdi-eye-outline"></i> Lihat bukti transfer</a>
                            </div>
                        </div>
                    </div>
                @endif
                <form class="form-block" action="{{ route('admin::finance.payments.store', ['next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <div class="card border-0">
                        <div class="card-body">
                            <i class="mdi mdi-file-outline"></i> Invoice
                        </div>
                        <div class="card-body border-top">
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label required">Kode accurate</label>
                                <div class="col-md-5">
                                    <input type="string" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required>
                                    @error('code')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label required">Nominal pembayaran</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" name="paid_amount" value="{{ old('paid_amount') }}" required>
                                    </div>
                                    @error('paid_amount')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label required">Nama pembayar</label>
                                <div class="col-md-6">
                                    <input name="payer" class="form-control @error('payer') is-invalid @enderror" value="{{ old('payer', $invoice->user->name) }}" required />
                                    @error('payer')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label required">Dibayar pada</label>
                                <div class="col-md-8">
                                    <input type="datetime-local" class="form-control @error('paid_at') is-invalid @enderror" name="paid_at" value="{{ old('paid_at', now()) }}" required>
                                    @error('paid_at')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label required">Metode pembayaran</label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-radio">
                                        <input class="form-radio-input" type="radio" name="method" id="method-1" value="1" @if (old('method', 2) == 1) checked @endif>
                                        <label class="form-radio-label" for="method-1">Tunai</label>
                                    </div>
                                    <div class="form-radio">
                                        <input class="form-radio-input" type="radio" name="method" id="method-2" value="2" @if (old('method', 2) == 2) checked @endif>
                                        <label class="form-radio-label" for="method-2">Non-Tunai</label>
                                    </div>
                                    @error('method')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8 col-lg-9 offset-lg-3 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="paid_off" id="paid_off" value="1">
                                        <label class="form-check-label" for="paid_off">Centang jika kamu ingin menandai sebagai <strong>LUNAS</strong></label>
                                    </div>
                                    @error('paid_off')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8 col-lg-9 offset-lg-3 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="validated" id="validated" value="1" required>
                                        <label class="form-check-label" for="validated">Dengan ini saya selaku keuangan menyatakan data yang saya input di atas adalah benar.</label>
                                    </div>
                                    @error('validated')
                                        <small class="text-danger d-block"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 offset-lg-3 offset-md-4">
                                    <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
                                    <a class="btn btn-light" href="{{ $back }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
        <div class="col-xl-6">
            <div class="card border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div><i class="mdi mdi-table"></i> Item invoice</div>
                    @if ($invoice)
                        <a class="btn btn-soft-success" href="{{ route('admin::finance.invoices.print.show', ['invoice' => $invoice->code]) }}" target="_blank"><i class="mdi mdi-printer-outline"></i> Cetak invoice</a>
                    @endif
                </div>
                <div class="table-responsive border-top">
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th>Jenis item</th>
                                <th>Nama item</th>
                                <th class="text-end">Harga unit (Rp)</th>
                                <th class="text-center">QTY</th>
                                <th class="pe-3 text-end">Harga (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoice->items ?? [] as $item)
                                <tr>
                                    <td>Kelas</td>
                                    <td>{{ $item->itemable->name }}</td>
                                    <td class="text-end">{{ Str::money($item->price, 0) }}</td>
                                    <td class="text-center">1 kelas</td>
                                    <td class="pe-3 text-end">{{ Str::money($item->price, 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">@include('components.notfound')</td>
                                </tr>
                            @endforelse
                            @if ($invoice)
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">PPN 11%</th>
                                    <td class="pe-3 text-end">{{ Str::money($tax = $invoice->items->sum('price') * ($tax_value = 0), 0) }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">Total</th>
                                    <td class="pe-3 text-end">{{ Str::money($tax + $invoice->items->sum('price'), 0) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div><i class="mdi mdi-table"></i> Riwayat transaksi</div>
                </div>
                <div class="table-responsive border-top">
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Nominal</th>
                                <th>Dibayar pada</th>
                                <th>Dibayar oleh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoice->transactions ?? [] as $transaction)
                                <tr>
                                    <td>Kelas</td>
                                    <td>{{ Str::money($transaction->paid_amount, 0) }}</td>
                                    <td>{{ $transaction->paid_at?->format('d M Y') }}</td>
                                    <td>{{ $transaction->payer }}</td>
                                    <td class="py-2 text-end" nowrap>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted py-4 text-center">Tidak ada riwayat transaksi</td>
                                </tr>
                            @endforelse
                            @if ($invoice && count($invoice->transactions))
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="2">Total</th>
                                    <td class="pe-3 text-end">{{ Str::money($invoice->transactions->sum('paid_amount'), 0) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
        document.addEventListener('DOMContentLoaded', () => {
            new TomSelect('[name="invoice"]');
        })
    </script>
@endpush
