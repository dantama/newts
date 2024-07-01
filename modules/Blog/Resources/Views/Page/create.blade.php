@extends('blog::layouts.default')

@section('title', 'Laman')
@section('navtitle', 'Buat laman')

@php($back = request('next', route('blog::pages.index')))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-sm-10">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ $back }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Buat laman</h2>
                    <div class="text-secondary">Tambahkan laman untuk artikel kamu!</div>
                </div>
            </div>
            <div class="card card-body border-0">
                <form class="form-block" action="{{ route('blog::pages.store', ['next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf
                    <div class="mb-3">
                        <label class="form-label required">Nama laman</label>
                        <div>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
                        <a class="btn btn-light" href="{{ $back }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
