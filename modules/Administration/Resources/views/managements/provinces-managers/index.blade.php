@extends('administration::layouts.default')

@section('title', 'Pengurus Pusat')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Pengurus wilayah</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8"> 
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar Pengurus</div>
            @if(request('trash'))
                <div class="alert alert-warning text-danger rounded-0 mb-1">
                    <i class="fas fa-exclamation-circle fa-fw"></i> Menampilkan data yang dihapus
                </div>
            @endif
            <div class="card-body">
                <form class="form-block" action="{{ route('administration::managements.provinces-managers.index') }}" method="GET">
                    <div class="form-group mb-0">
                        <div class="input-group">
                            <select name="mgmt" class="form-control selectpicker" data-live-search="true" required>
                                <option value="">-- Pilih --</option>
                                @foreach($managements as $management)
                                    <option value="{{ $management->id }}" @if(request('mgmt', $managements->first()->id ?? null) == $management->id) selected @endif>{{ $management->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-danger">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 border-bottom">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th></th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th></th>                 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($managers as $manager)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" src="{{ $manager->user->profile->avatar_path }}" height="32" alt=""></td>                     
                            <td>{{ $manager->user->profile->name }}</td>                                      
                            <td>{{ $manager->position->name }}</td>
                            <td nowrap>
                                @if($manager->isnot(auth()->user()))
                                    @if($manager->trashed())
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::managements.provinces-managers.restore', ['manager' => $manager->id]) }}" method="POST"> @csrf @method('PUT')
                                            <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Pulihkan"><i class="fa fa-sync"></i></button>
                                        </form>
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::managements.provinces-managers.kill', ['manager' => $manager->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus permanen"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @else
                                        @can('admin')
                                            <form class="d-inline form-block form-confirm" action="{{ route('administration::managements.provinces-managers.adminable', ['manager' => $manager->id]) }}" method="POST"> @csrf @method('PUT')
                                                <button class="btn btn-{{ $manager->user->adminable ? 'danger' : 'success' }} btn-sm" data-toggle="tooltip" title="{{ $manager->user->adminable ? 'Set Bukan Admin' : 'Set Admin' }}"><i class="fa fa-{{ $manager->user->adminable ? 'times' : 'check' }}"></i></button>
                                            </form>
                                        @endcan
                                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ubah" href="{{ route('administration::managements.provinces-managers.show', ['manager' => $manager->id]) }}"><i class="fa fa-edit"></i></a>
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::managements.provinces-managers.destroy', ['manager' => $manager->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Buang"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endif
                                @endif
                            </td>                     
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Tidak ada data penguus</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Tambah</div>
            <div class="card-body pb-1">
                <form class="form-row" method="POST" action="{{ route('administration::managements.provinces-managers.store',['next' => request('next',route('administration::managements.provinces-managers.index'))]) }}">@csrf
                    <div class="form-group col-md">
                        <select name="user_id" id="user_id" class="selectpicker form-control" data-live-search="true">
                            <option value="">-- Nama --</option> 
                            @foreach($members as $member)
                            <option value="{{ $member->user->id }}">{{ $member->user->profile->display_name }}</option>
                            @endforeach              
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <select name="position_id" id="position_id" class="selectpicker form-control">
                            <option value="">-- Jabatan --</option> 
                            @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach              
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <select name="managerable_id" id="managerable_id" class="selectpicker form-control" data-live-search="true">
                            <option value="">-- Pimwil --</option> 
                            @foreach($managements as $management)
                            <option value="{{ $management->id }}">{{ $management->name }}</option>
                            @endforeach             
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <button type="submit" class="btn btn-danger">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-danger border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total pengurus wilayah</div>
                        <h1 class="mb-0 font-weight-bold text-gray-800">{{ $managers_count }}</h1>
                    </div>
                    <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Lanjutan</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::managements.provinces-managers.index', ['trash' => request('trash', 0) ? null : 1, 'pimwil' => request('pimwil')]) }}"><i class="fa fa-trash"></i> Tampilkan data {{ request('trash', 0) ? 'tidak dihapus' : 'dihapus' }}</a>
            </div>
        </div>
    </div>
</div>
@stop

@push('style')
<link href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}" rel="stylesheet">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
@endpush