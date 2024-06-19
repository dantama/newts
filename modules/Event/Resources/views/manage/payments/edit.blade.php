@extends('admin::layouts.default')

@section('title', 'Pembayaran')
@section('navtitle', 'Ubah pembayaran')

@php($back = request('next', route('admin::finance.payments.index')))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ $back }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Detail pembayaran</h2>
                    <div class="text-secondary">Detail pembayaran yang sudah diinputkan ke sistem.</div>
                </div>
            </div>
            <form class="form-block" action="{{ route('admin::finance.payments.update', ['transaction' => $transaction->id, 'next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-file-outline"></i> Pembayaran
                    </div>
                    <div class="card-body border-top">
                        <div class="row mb-4">
                            <label class="col-md-4 col-lg-4 col-form-label required">Kode accurate</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $transaction->code) }}" required>
                                </div>
                                @error('code')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-4 col-lg-4 col-form-label required">Nominal</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-text" id="type-amount-label">IDR</div>
                                    <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" name="paid_amount" value="{{ old('paid_amount', $transaction->paid_amount) }}" required>
                                </div>
                                @error('paid_amount')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-4 col-lg-4 col-form-label required">Metode pembayaran</label>
                            <div class="col-md-8 col-lg-4">
                                <div class="form-radio">
                                    <input class="form-radio-input" type="radio" name="method" id="method-1" value="1" @if (old('method', $transaction->method) == 1) checked @endif>
                                    <label class="form-radio-label" for="method-1">Tunai</label>
                                </div>
                                <div class="form-radio">
                                    <input class="form-radio-input" type="radio" name="method" id="method-2" value="2" @if (old('method', $transaction->method) == 2) checked @endif>
                                    <label class="form-radio-label" for="method-2">Non-Tunai</label>
                                </div>
                                @error('method')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-4 col-lg-4 col-form-label required">Dibayar pada</label>
                            <div class="col-md-8">
                                <input type="datetime-local" class="form-control @error('paid_at') is-invalid @enderror" name="paid_at" value="{{ old('paid_at', $transaction->paid_at) }}" required>
                                @error('paid_at')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8 col-lg-9 offset-lg-4 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="paid_off" id="paid_off" value="1">
                                    <label class="form-check-label" for="paid_off">Centang jika kamu ingin menandai sebagai <strong>LUNAS</strong></label>
                                </div>
                                @error('paid_off')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-8 col-lg-9 offset-lg-4 offset-md-4">
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
                            <div class="col-md-8 offset-lg-4 offset-md-4">
                                <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
                                <a class="btn btn-light" href="{{ $back }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
