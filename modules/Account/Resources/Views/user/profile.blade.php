@extends('account::layouts.default')

@section('title', 'My profile | ')

@php
    $user = Auth::user();
@endphp

@section('content')
    <div class="card card-body d-flex flex-sm-row align-items-center gap-sm-4 rounded border-0 p-4" style="background: linear-gradient(to bottom, #fcf1f1, transparent);">
        <i class="mdi mdi-shield-account-outline mdi-48px text-danger mx-2"></i>
        <div class="text-sm-start text-center">
            <h2 class="mb-1">My profile</h2>
            <div class="text-muted">Manage your personal information like name, email, contact and address.</div>
        </div>
    </div>
    @if ($errors->count())
        <div class="alert alert-warning text-danger alert-dismissible fade show border-0" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card card-body bg-light border-0 p-4">
        <form class="form-block" action="{{ route('account::user.profile', ['next' => request('next', url()->current())]) }}" method="POST"> @csrf @method('PUT')
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label required">Nama lengkap</label>
                <div class="col-lg-7 col-xl-8">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label required">Alamat surel</label>
                <div class="col-lg-5 col-xl-6">
                    <input type="email" class="form-control @error('email_address') is-invalid @enderror" name="email_address" value="{{ old('email_address', $user->email_address) }}" required>
                    @error('email_address')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label required">Nomor kontak</label>
                <div class="col-lg-4 col-xl-5">
                    <input type="number" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number', $user->getMeta('contact_number')) }}" required>
                    @error('contact_number')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <hr class="text-secondary my-4">
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label">Alamat utama</label>
                <div class="col-lg-7 col-xl-8">
                    <input type="text" class="form-control @error('address_primary') is-invalid @enderror" name="address_primary" value="{{ old('address_primary', $user->getMeta('address_primary')) }}">
                    @error('address_primary')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label">Alamat tambahan</label>
                <div class="col-lg-7 col-xl-8">
                    <input type="text" class="form-control @error('address_secondary') is-invalid @enderror" name="address_secondary" value="{{ old('address_secondary', $user->getMeta('address_secondary')) }}">
                    @error('address_secondary')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label">Kota</label>
                <div class="col-lg-5 col-xl-7">
                    <input type="text" class="form-control @error('address_city') is-invalid @enderror" name="address_city" value="{{ old('address_city', $user->getMeta('address_city')) }}">
                    @error('address_city')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-lg-4 col-xl-3 col-form-label">Kode pos</label>
                <div class="col-lg-5 col-xl-3">
                    <input type="number" class="form-control @error('address_postal') is-invalid @enderror" name="address_postal" value="{{ old('address_postal', $user->getMeta('address_postal')) }}">
                    @error('address_postal')
                        <small class="text-danger d-block"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-4 col-xl-9 offset-xl-3">
                    <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Update profile</button>
                </div>
            </div>
        </form>
    </div>
@endsection
