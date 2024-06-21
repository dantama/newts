@extends('core::layouts.default')

@section('title', 'Managers | ')
@section('navtitle', 'Managers')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-10">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ request('next', route('core::administration.managers.index')) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Buat pengurus baru</h2>
                    <div class="text-secondary">Silakan isi formulir di bawah ini untuk membuat pengurus baru</div>
                </div>
            </div>
            <div class="card mb-4 border-0">
                <div class="card-body">
                    <form class="form-block" action="{{ route('core::administration.managers.store', ['next' => request('next')]) }}" method="POST"> @csrf
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Unit</label>
                            <div class="col-xl-8 col-xxl-6">
                                <select id="type" class="form-select @error('unit_id') is-invalid @enderror" name="unit_id">
                                    <option value=""></option>
                                    @foreach ($units as $key => $unit)
                                        <option value="{{ $unit->id }}" data-depts="{{ $unit->unit_departements->pluck('departement.name', 'id') }}" @selected(old('unit') == $unit->id)>{{ $unit->type->alias() . ' ' . $unit->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Departemen</label>
                            <div class="col-xl-8 col-xxl-8">
                                <select id="type" class="form-select @error('unit_dept_id') is-invalid @enderror" name="unit_dept_id"></select>
                                @error('unit_dept_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Nama anggota</label>
                            <div class="col-xl-8 col-xxl-8">
                                <select id="type" class="form-select @error('member_id') is-invalid @enderror" name="member_id">
                                </select>
                                @error('member_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Jabatan</label>
                            <div class="col-xl-8 col-xxl-6">
                                <select id="type" class="form-select @error('position_id') is-invalid @enderror" name="position_id">
                                </select>
                                @error('position_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row required mb-4">
                            <label class="col-lg-4 col-xl-3 col-form-label">Periode</label>
                            <div class="col-xl-8 col-xxl-8">
                                <div class="input-group form-calculate mb-2">
                                    <input type="date" class="form-control @error('start_at') is-invalid @enderror" name="start_at">
                                    <div class="input-group-text">s.d.</div>
                                    <input type="date" class="form-control @error('end_at') is-invalid @enderror" name="end_at">
                                </div>
                            </div>
                            @error('start_at')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Tipe SK</label>
                            <div class="col-xl-8 col-xxl-6">
                                <select id="type" class="form-select @error('contract_id') is-invalid @enderror" name="contract_id">
                                    @foreach ($contracts as $key => $contract)
                                        <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                    @endforeach
                                </select>
                                @error('contract_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Nomor SK</label>
                            <div class="col-lg-8">
                                <input type="text" name="contract_number" class="form-control @error('contract_number') is-invalid @enderror" value="{{ old('contract_number') }}">
                                @error('contract_number')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Lampiran</label>
                            <div class="col-md-8">
                                <div class="tg-steps-leave-attachment">
                                    <input class="form-control @error('attachment') is-invalid @enderror" name="attachment" type="file" id="upload-input" accept="image/*,application/pdf">
                                    <small class="text-muted">Berkas berupa .jpg, .png atau .pdf maksimal berukuran 2mb</small>
                                    @error('attachment')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-3 col-form-label">Keterangan tambahan</label>
                            <div class="col-lg-8">
                                <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <hr class="divider">
                        <div class="row mb-3">
                            <div class="col-lg-8 offset-lg-4 offset-xl-3">
                                <button class="btn btn-soft-danger"><i class="mdi mdi-check"></i> Simpan</button>
                                <a class="btn btn-ghost-light text-dark" href="{{ request('next', route('core::administration.managers.index')) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
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
        let token = @json(json_decode(Cookie::get(config('auth.cookie')))).access_token;

        const listDept = () => {
            [].slice.call(document.querySelectorAll('[name="unit_id"] option:checked')).map((select) => {
                let c = '';
                if (select.dataset.depts) {
                    let units = JSON.parse(select.dataset.depts);
                    for (i in units) {
                        c += '<option value="' + i + '" ' + (('{{ old('unit_id', -1) }}' == i) ? ' selected' : '') + '>' + units[i] + '</option>';
                    }
                }
                document.querySelector('[name="unit_dept_id"]').innerHTML = c.length ? '<option value>-- Pilih --</option>' + c : '<option value>-- Pilih --</option>'
                fetchMembers(select.value);
                fetchUnit(select.value);
            });
        }

        const fetchMembers = async (unitId) => {
            let url = @json(route('api::references.members.index'));
            const response = await fetch(`${url}?q=${encodeURIComponent(unitId)}`, {
                method: 'GET',
                headers: {
                    "Authorization": `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                let opt = '';
                let members = json.data;
                for (i in members) {
                    opt += '<option value="' + i + '" ' + (('{{ old('member_id', -1) }}' == i) ? ' selected' : '') + '>' + members[i] + '</option>';
                }
                document.querySelector('[name="member_id"]').innerHTML = opt.length ? '<option value>-- Pilih --</option>' + opt : '<option value>-- Pilih --</option>'
            });

        };

        const fetchUnit = async (unitId) => {
            let url = @json(route('api::references.unit.position'));
            const response = await fetch(`${url}?q=${encodeURIComponent(unitId)}`, {
                method: 'GET',
                headers: {
                    "Authorization": `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                return response.json();
            }).then(json => {
                let opt = '';
                let positions = json.data;
                for (i in positions) {
                    opt += '<option value="' + i + '" ' + (('{{ old('member_id', -1) }}' == i) ? ' selected' : '') + '>' + positions[i] + '</option>';
                }
                document.querySelector('[name="position_id"]').innerHTML = opt.length ? '<option value>-- Pilih --</option>' + opt : '<option value>-- Pilih --</option>'
            });

        };

        document.addEventListener("DOMContentLoaded", () => {
            [].slice.call(document.querySelectorAll('[name="unit_id"]')).map((e) => {
                e.addEventListener('click', listDept);
            });
            listDept();
        });
    </script>
@endpush
