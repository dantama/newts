@extends('core::layouts.default')

@section('title', 'Unit ')
@section('navtitle', 'Unit')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-10">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ request('next', route('core::administration.units.index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Buat unit baru</h2>
                    <div class="text-secondary">Silakan isi formulir di bawah ini untuk membuat unit baru</div>
                </div>
            </div>
            <div class="card mb-4 border-0">
                <div class="card-body">
                    <form class="form-block" action="{{ route('core::administration.units.store', ['next' => request('next')]) }}" method="POST"> @csrf
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Jenis unit</label>
                            <div class="col-xl-8">
                                <div class="card @error('ctg_id') border-danger mb-1 @enderror">
                                    <div class="overflow-auto rounded" style="max-height: 300px;">
                                        @forelse($types as $type)
                                            <label class="card-body border-secondary d-flex align-items-center @if (!$loop->last) border-bottom @endif py-2">
                                                <input class="form-check-input me-3" type="radio" value="{{ $type->value }}" name="type" data-units="{{ json_encode($type->units()) }}" required>
                                                <div>
                                                    <div class="fw-bold mb-0">{{ $type->label() }}</div>
                                                </div>
                                            </label>
                                        @empty
                                            <div class="card-body text-muted">Tidak ada kategori</div>
                                        @endforelse
                                    </div>
                                </div>
                                @error('ctg_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Kode unit</label>
                            <div class="col-xl-8 col-xxl-4">
                                <input type="text" class="form-control @error('org_code') is-invalid @enderror" name="org_code" value="{{ old('org_code') }}" required />
                                @error('org_code')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Nama unit</label>
                            <div class="col-xl-8 col-xxl-8">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required />
                                @error('name')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Deskripsi</label>
                            <div class="col-lg-8">
                                <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Unit atasan</label>
                            <div class="col-xl-8 col-xxl-6">
                                <select id="type" class="form-select @error('parent_id') is-invalid @enderror" name="parent_id"></select>
                                @error('parent_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <hr class="divider">
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Provinsi</label>
                            <div class="col-xl-8 col-xxl-6">
                                <select id="type" class="form-select @error('org_prov_id') is-invalid @enderror" name="org_prov_id">
                                    <option value="">-- Pilih --</option>
                                    @forelse($provinces as $key => $province)
                                        <option value="{{ $province->id }}" data-regencies="{{ $province->regencies()->pluck('name', 'id') }}">{{ $province->name }}</option>
                                    @empty
                                        <option value="">Tidak ada data provinsi</option>
                                    @endforelse
                                </select>
                                @error('org_prov_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Kabupaten</label>
                            <div class="col-xl-8 col-xxl-8">
                                <select id="type" class="form-select @error('org_regency_id') is-invalid @enderror" name="org_regency_id" onchange="renderDistrictOptions(event)">
                                    <option value="">-- Pilih --</option>
                                </select>
                                @error('org_regency_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Kecamatan</label>
                            <div class="col-xl-8 col-xxl-8">
                                <select id="type" class="form-select @error('org_distric_id') is-invalid @enderror" name="org_distric_id">
                                    <option value="">-- Pilih --</option>
                                </select>
                                @error('org_distric_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="required row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Visibilitas</label>
                            <div class="col-lg-8">
                                <div class="btn-group">
                                    <input class="btn-check" type="radio" id="is_visible1" name="is_visible" value="1" required autocomplete="off" @checked(!is_null(old('is_visible')) && old('is_visible') == 1) required />
                                    <label class="btn btn-outline-light text-dark" for="is_visible1"><i class="mdi mdi-eye-outline"></i></label>
                                    <input class="btn-check" type="radio" id="is_visible0" name="is_visible" value="0" required autocomplete="off" @checked(!is_null(old('is_visible')) && old('is_visible') == 0) required />
                                    <label class="btn btn-outline-light text-dark" for="is_visible0"><i class="mdi mdi-eye-off-outline"></i></label>
                                </div>
                                @error('description')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Email</label>
                            <div class="col-xl-8 col-xxl-8">
                                <div class="input-group">
                                    <span class="input-group-text">@</span>
                                    <input type="email" class="form-control @error('org_email') is-invalid @enderror" name="org_email" value="{{ old('org_email') }}" required />
                                </div>
                                <span class="text-muted small"><cite>Format email harus sesuai, contoh: user@example.com</cite></span>
                                @error('org_email')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">No. Telepon</label>
                            <div class="col-xl-8 col-xxl-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                                    <input type="text" class="form-control @error('org_phone') is-invalid @enderror" name="org_phone" value="{{ old('org_phone') }}" required />
                                </div>
                                <span class="text-muted small"><cite>Gunakan ekstensi 62 untuk nomor handphone</cite></span>
                                @error('org_phone')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8 offset-lg-4 offset-xl-3">
                                <button class="btn btn-soft-danger"><i class="mdi mdi-check"></i> Simpan</button>
                                <a class="btn btn-ghost-light text-dark" href="{{ request('next', route('core::administration.units.index')) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
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
        const renderDistrictOptions = async (e) => {
            let regencyId = e.currentTarget.value;
            let url = @json(route('api::references.search-districs'));

            const fetchDistricts = async (regencyId) => {
                const response = await fetch(`${url}?q=${encodeURIComponent(regencyId)}`);
                const data = await response.json();
                return data.data;
            };

            const districts = await fetchDistricts(regencyId);
            let opt = '';
            for (i in districts) {
                opt += '<option value="' + i + '" ' + (('{{ old('org_distric_id', -1) }}' == i) ? ' selected' : '') + '>' + districts[i] + '</option>';
            }
            document.querySelector('[name="org_distric_id"]').innerHTML = opt.length ? '<option value>-- Pilih --</option>' + opt : '<option value>-- Pilih --</option>'
        };

        const listRegencyId = () => {
            [].slice.call(document.querySelectorAll('[name="org_prov_id"] option:checked')).map((select) => {
                let opt = '';
                if (select.dataset.regencies) {
                    let regencies = JSON.parse(select.dataset.regencies);
                    for (i in regencies) {
                        opt += '<option value="' + i + '" ' + (('{{ old('org_prov_id', -1) }}' == i) ? ' selected' : '') + '>' + regencies[i] + '</option>';
                    }
                }
                document.querySelector('[name="org_regency_id"]').innerHTML = opt.length ? '<option value>-- Pilih --</option>' + opt : '<option value>-- Pilih --</option>'
            });
        }

        const toggleOrg = (e) => {
            let c = '';
            if (e.currentTarget.dataset.units) {
                let units = JSON.parse(e.currentTarget.dataset.units);
                for (i in units) {
                    c += '<option value="' + units[i].id + '" ' + (('{{ old('parent_id', -1) }}' == i) ? ' selected' : '') + '>' + units[i].name + '</option>';
                }
            }
            document.querySelector('[name="parent_id"]').innerHTML = c.length ? '<option value>-- Pilih --</option>' + c : '<option value>-- Pilih --</option>'
        }

        document.addEventListener("DOMContentLoaded", () => {
            [].slice.call(document.querySelectorAll('[name="type"]')).map((e) => {
                e.addEventListener('click', toggleOrg);
            });
            [].slice.call(document.querySelectorAll('[name="org_prov_id"]')).map((el) => {
                el.addEventListener('change', listRegencyId);
            });
            listRegencyId();
        });
    </script>
@endpush
