@extends('administration::layouts.default')

@section('title', 'Daftar Pelatih Wilayah')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Daftar Pelatih</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8"> 
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar Pelatih Wilayah</div>
            @if(request('trash'))
                <div class="alert alert-warning text-danger rounded-0 mb-1">
                    <i class="fas fa-exclamation-circle fa-fw"></i> Menampilkan data yang dihapus
                </div>
            @endif
            <div class="card-body">
                <form class="form-block" action="{{ route('administration::technical.province-referees.index') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group">
                            <select name="mgmt" class="selectpicker form-control" data-live-search="true" required>
                                <option value="">-- Pilih --</option>
                                @foreach($managements as $management)
                                    <option value="{{ $management->id }}" @if(request('mgmt', $managements->first()->id ?? null) == $management->id) selected @endif>{{ $management->full_name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-danger">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-hover mb-0 border-bottom" id="wasit">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th></th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th></th>                 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refereeProvice as $referee)
                        <tr @if($referee->trashed()) class="text-muted bg-light" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" src="{{ $referee->user->profile->avatar_path }}" height="32" alt=""></td>                                        
                            <td>
                                @if($referee->trashed() || $referee->user->is(auth()->user()))
                                    {{ $referee['user']['profile']['display_name'] }}
                                @else
                                    <a href="{{ route('administration::technical.province-referees.show', ['referee' => $referee->id]) }}">{{ $referee['user']['profile']['display_name'] }}</a>
                                @endif
                            </td>                     
                            <td>{{ $referee['user']['address']['branch'] ?? '-' }}</td>                                                           
                            <td>@if($referee->user->isnot(auth()->user()))
                                    @if($referee->trashed())
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::technical.province-referees.restore', ['referee' => $referee->id]) }}" method="POST"> @csrf @method('PUT')
                                            <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Pulihkan"><i class="fa fa-sync"></i></button>
                                        </form>
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::technical.province-referees.kill', ['referee' => $referee->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus permanen"><i class="fa fa-delete"></i></button>
                                        </form>
                                    @else
                                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ubah siswa" href="{{ route('administration::technical.province-referees.show', ['referee' => $referee->id]) }}"><i class="fa fa-edit"></i></a>
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::technical.province-referees.destroy', ['referee' => $referee->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Buang"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endif
                                @endif
                            </td>                     
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Tidak ada data Pelatih</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Statistik</div>
            <div class="card-body">
                <span class="h1 mb-0 font-weight-bold">{{ $refereeProvince_count }}</span>
                <span class="float-right text-muted font-weight-bold"><i class="far fa-user"></i> Pelatih Wilayah</span>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Tambah Pelatih</div>
            <div class="card-body">
                <form method="POST" action="{{ route('administration::technical.province-referees.store',['next' => request('next',route('administration::technical.province-referees.index'))]) }}">@csrf
                  <div class="form-group">
                    <label for="inputAddress">Pimwil</label>
                    <select name="mgmt_id" id="mgmt_id" class="form-control selectpicker" data-live-search="true">
                        <option value="">-- Pimwil --</option>
                        @foreach($managements as $management)
                        <option value="{{ $management->id }}">{{ $management->full_name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Nama</label>
                    <select name="user_id" id="user_id" class="form-control selectpicker" data-live-search="true">
                        <option value="">Pilih Anggota</option>
                        @foreach($members as $member)
                        <option value="{{ $member->user->id }}">{{ $member->user->profile->display_name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                </form>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Lanjutan</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::technical.province-referees.index', ['trash' => request('trash', 0) ? null : 1]) }}"><i class="fa fa-trash"></i> Tampilkan Pelatih dihapus</a>
            </div>
        </div>
    </div>
</div>
@stop

@push('style')
<link href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#wasit').DataTable();
    });
</script>
@endpush