@extends('administration::layouts.default')

@section('title', 'Ubah jabatan ')
@section('navtitle', 'Ubah jabatan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-10">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ request('next', route('administration::units.positions.index', ['unit' => $currentUnit->kd])) }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Ubah jabatan</h2>
                    <div class="text-secondary">Silakan isi formulir di bawah ini untuk mengubah jabatan</div>
                </div>
            </div>
            <div class="card mb-4 border-0">
                <div class="card-body border-bottom">
                    <i class="mdi mdi-plus"></i> Form ubah jabatan
                </div>
                <div class="card-body">
                    <form class="form-block" action="{{ route('administration::units.positions.update', ['unit' => $currentUnit->kd, 'position' => $position->id, 'next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-4 col-form-label">Jabatan</label>
                            <div class="col-lg-8 col-xl-8">
                                <select id="type" class="form-select @error('position_id') is-invalid @enderror" name="position_id">
                                    <option value="">-- Pilih --</option>
                                    @forelse($positions as $key => $value)
                                        <option value="{{ $value->id }}" @selected($value->id == $position->position_id)>{{ $value->name }}</option>
                                    @empty
                                        <option value="">Tidak ada data jabatan</option>
                                    @endforelse
                                </select>
                                @error('position_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-4 col-form-label">Atasan</label>
                            <div class="col-lg-8 col-xl-8">
                                <select id="type" class="form-select @error('parent_id') is-invalid @enderror" name="parent_id">
                                    <option value="">-- Pilih --</option>
                                    @forelse($parents as $key => $parent)
                                        <option value="{{ $parent->id }}" @selected($parent->id == $position->parent_id)>{{ $parent->position->name }}</option>
                                    @empty
                                        <option value="">Tidak ada data position</option>
                                    @endforelse
                                </select>
                                @error('parent_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-lg-4 col-xl-4 col-form-label">Keterangan</label>
                            <div class="col-lg-8 col-xl-8">
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                            </div>
                            @error('description')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="required row mb-3">
                            <label class="col-lg-4 col-xl-4 col-form-label">Visibilitas</label>
                            <div class="col-lg-8 col-xl-8">
                                <div class="btn-group">
                                    <input class="btn-check" type="radio" id="is_visible1" name="is_visible" value="1" required autocomplete="off" @checked(!is_null(old('is_visible')) && old('is_visible', $position->is_visible) == 1) required />
                                    <label class="btn btn-outline-light text-dark" for="is_visible1"><i class="mdi mdi-eye-outline"></i></label>
                                    <input class="btn-check" type="radio" id="is_visible0" name="is_visible" value="0" required autocomplete="off" @checked(!is_null(old('is_visible')) && old('is_visible', $position->is_visible) == 0) required />
                                    <label class="btn btn-outline-light text-dark" for="is_visible0"><i class="mdi mdi-eye-off-outline"></i></label>
                                </div>
                                @error('description')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-8 offset-lg-4 offset-xl-3">
                                <button class="btn btn-soft-danger"><i class="mdi mdi-check"></i> Simpan</button>
                                <a class="btn btn-ghost-light text-dark" href="{{ request('next', route('administration::units.positions.index', ['unit' => $currentUnit->kd])) }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
