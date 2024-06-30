@extends('admin::layouts.default')

@section('title', 'Kategori')
@section('navtitle', 'Buat kategori')

@php($back = request('next', route('blog::article.categories.index')))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-sm-10">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ $back }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Buat kategori</h2>
                    <div class="text-secondary">Tambahkan kategori untuk artikel kamu!</div>
                </div>
            </div>
            <div class="card card-body border-0">
                <form class="form-block" action="{{ route('blog::article.categories.store', ['next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf
                    <div class="mb-3">
                        <label class="form-label required">Nama kategori</label>
                        <div>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <div>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="8">{{ old('description') }}</textarea>
                            @error('description')
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
