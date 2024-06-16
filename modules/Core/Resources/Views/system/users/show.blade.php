@extends('core::layouts.default')

@section('title', 'Pengguna')
@section('navtitle', 'Pengguna')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a class="text-decoration-none" href="{{ request('next', route('core::system.users.index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
        <div class="ms-4">
            <h2 class="mb-1">Lihat detail pengguna</h2>
            <div class="text-secondary">Menampilkan informasi pengguna, detail kontak, alamat, dan peran.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="card border-0">
                <div class="card-body text-center">
                    <div class="rounded-circle mx-auto mb-4" style="background: url('{{ $user->getMeta('profile_avatar') ? $user->getMeta('profile_avatar') : asset('img/default-avatar.svg') }}') center center no-repeat; background-size: cover; width: 128px; height: 128px;"></div>
                    <h5 class="mb-1"><strong>{{ $user->name }}</strong></h5>
                    <p>{{ $user->username }}</p>
                    <h4 class="mb-0">
                        @if ($user->getMeta('phone_whatsapp'))
                            <a class="text-danger px-1" href="https://wa.me/{{ $user->getMeta('phone_code') . $user->getMeta('phone_number') }}" target="_blank"><i class="mdi mdi-whatsapp"></i></a>
                        @endif
                        @if ($user->email_verified_at)
                            <a class="text-danger px-1" href="mailto:{{ $user->email_address }}"><i class="mdi mdi-email-outline"></i></a>
                        @endif
                    </h4>
                </div>
                <div class="list-group list-group-flush border-top">
                    <form class="d-inline form-block form-confirm" action="{{ route('core::system.users.repass', ['user' => $user->id]) }}" method="POST" id="reset-password"> @csrf @method('PUT')
                        <a class="list-group-item list-group-item-action text-danger border-0" href="javascript:;" onclick="event.preventDefault(); $('#reset-password').submit();"><i class="mdi mdi-lock-open"></i> Atur ulang sandi</a>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="mb-1">Peran sistem</h4>
                    <p class="text-muted mb-2">Tentukan hak akses ke pengguna</p>
                </div>
                <div class="card-body">
                    <form class="form-block" action="{{ route('core::system.users.roles', ['user' => $user->id]) }}" method="post"> @csrf @method('PUT')
                        <div class="mb-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" @checked($user->roles->contains('id', $role->id))>
                                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Update peran</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="mb-1">Info akun</h4>
                    <p class="text-muted mb-2">Informasi tentang akun {{ $user->display_name }}</p>
                </div>
                <div class="list-group list-group-flush">
                    @foreach ([
            'Bergabung pada' => $user->created_at->diffForHumans(),
        ] as $k => $v)
                        <div class="list-group-item border-0">
                            {{ $k }} <br>
                            <span class="{{ $v ? 'fw-bold' : 'text-muted' }}">
                                {{ $v ?? 'Belum diisi' }}
                            </span>
                        </div>
                    @endforeach
                    <div class="list-group-item text-muted border-0">
                        <i class="mdi mdi-account-circle"></i> User ID : {{ $user->id }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card border-0">
                <div class="card-body border-bottom">
                    <i class="mdi mdi-pencil"></i> Ubah profil
                </div>
                <div class="card-body border-0">
                    <form class="form-block" action="{{ route('core::system.users.update.profile', ['user' => $user->id]) }}" method="POST"> @csrf @method('PUT')
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
            </div>
        </div>
    </div>
@endsection
