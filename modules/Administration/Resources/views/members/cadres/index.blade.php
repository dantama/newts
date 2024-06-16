@extends('administration::layouts.default')

@section('title', 'Daftar kader')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Daftar kader</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-9"> 
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar Kader</div>
            @if(request('trash'))
            <div class="alert alert-warning text-danger rounded-0 mb-1">
                <i class="fas fa-exclamation-circle fa-fw"></i> Menampilkan data yang dihapus
            </div>
            @endif
            <div class="card-body">
                <form action="{{ route('administration::members.cadres.index') }}" method="GET">
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
                <table class="table table-hover dt-responsive" id="kader" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th></th>
                            <th>Nama</th>
                            <th>Tingkat</th>
                            <th>NBTS</th>
                            <th>Alamat</th>
                            <th style="width: 110px;"></th>                 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cadres as $cadre)
                        <tr @if($cadre->trashed()) class="text-muted bg-light" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="rounded-circle" src="{{ $cadre->user->profile->avatar_path }}" height="32" alt=""></td>                                        
                            <td>
                                @if($cadre->trashed() || $cadre->user->is(auth()->user()))
                                {{ $cadre['user']['profile']['display_name'] }}
                                @else
                                <a @if(auth()->user()->isManagerCenters()) href="{{ route('administration::members.cadres.show', ['cadre' => $cadre->id]) }}" @endif>{{ $cadre['user']['profile']['display_name'] }}</a>
                                @endif
                            </td>     
                            <td>
                                @foreach($cadre['levels'] as $k => $v)
                                @if($loop->last)
                                {{ $v->detail->name }}
                                @endif
                                @endforeach
                            </td>                                                         
                            <td>{{ $cadre['nbts'] ?? '-' }}</td>                 
                            <td>{{ $cadre['user']['address']['branch'] ?? '-' }}</td>                                                          
                            <td>@if($cadre->user->isnot(auth()->user()))
                                @if($cadre->trashed())
                                @if(auth()->user()->isManagerCenters())
                                <form class="d-inline form-block form-confirm" action="{{ route('administration::members.cadres.restore', ['cadre' => $cadre->id]) }}" method="POST"> @csrf @method('PUT')
                                    <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Pulihkan"><i class="fa fa-sync"></i></button>
                                </form>
                                <form class="d-inline form-block form-confirm" action="{{ route('administration::members.cadres.kill', ['cadre' => $cadre->id]) }}" method="POST"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus permanen"><i class="fa fa-delete"></i></button>
                                </form>
                                @endif
                                @else
                                @if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
                                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ubah kader" href="{{ route('administration::members.cadres.show', ['cadre' => $cadre->id]) }}"><i class="fa fa-edit"></i></a>
                                <form class="d-inline form-block form-confirm" action="{{ route('administration::members.cadres.reset-password', ['user' => $cadre->user->id]) }}" method="POST"> @csrf @method('PUT')
                                    <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Reset"><i class="fas fa-lock-open"></i></button>
                                </form>
                                @endif
                                @if(auth()->user()->isManagerCenters())
                                <form class="d-inline form-block form-confirm" action="{{ route('administration::members.cadres.destroy', ['cadre' => $cadre->id]) }}" method="POST"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Buang"><i class="fa fa-trash"></i></button>
                                </form>
                                @endif
                                @endif
                                @endif
                            </td>                     
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Tidak ada data kader</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Statistik</div>
            <div class="card-body">
                <span class="h1 mb-0 font-weight-bold">{{ $members_count }}</span>
                <span class="float-right text-muted font-weight-bold"><i class="far fa-user"></i> KADER</span>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Lanjutan</div>
            <div class="list-group list-group-flush">
                @if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
                <a class="list-group-item list-group-item-action text-success" href="{{ route('administration::members.cadres.create') }}"><i class="fa fa-plus-circle"></i> Tambah Kader</a>
                <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::members.cadres.index', ['trash' => request('trash', 0) ? null : 1]) }}"><i class="fa fa-trash"></i> Tampilkan Kader {{ request('trash', 0) ? 'tidak' : '' }} dihapus</a>
                @endif
                <a class="list-group-item list-group-item-action text-primary" href="{{ route('administration::members.cadres.download-all-cadres', ['mgmt' => request('mgmt')]) }}" target="_blank"><i class="fa fa-arrow-circle-down"></i> Download Data</a>
            </div>
        </div>
        @if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Import</div>
            <div class="card-body">
                <form id="upload-form" method="POST" enctype="multipart/form-data" action="{{ route('administration::members.cadres.import-cadres') }}"> @csrf
                    <div class="form-group">
                        <label>Pilih file excel</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="upload-input" name="file" required>
                            <label class="custom-file-label" for="upload-input">Choose file</label>
                        </div>
                        @error('file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button id="btn-block" type="submit" class="btn btn-primary btn-sm">Import</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@stop

@push('style')
<link href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#kader').DataTable();
    });
</script>
@endpush