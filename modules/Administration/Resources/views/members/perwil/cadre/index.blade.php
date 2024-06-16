@extends('administration::layouts.default')

@section('title', 'Daftar pendekar')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Perwil Cadres</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card border-0 shadow mb-4">
            <div class="card-header"><i class="fa fa-list"></i><strong> List Cadres</strong></div>
            @if(request('trash'))
                <div class="alert alert-warning text-danger rounded-0 mb-1">
                    <i class="fas fa-exclamation-circle fa-fw"></i> Show deleted warrirors
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('administration::members.perwil-cadres.index') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group">
                            <select name="perwil" class="selectpicker form-control" data-live-search="true" required>
                                <option value="">-- Choose --</option>
                                @foreach($managements as $management)
                                    <option value="{{ $management->id }}" @if(request('perwil', $managements->first()->id ?? null) == $management->id) selected @endif>{{ $management->full_name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-filter"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table dt-responsive" id="pendekar" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th></th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>NBTS</th>
                            <th>Address</th>
                            <th style="width: 110px;"></th>                  
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cadres as $user)
                        <tr @if($user->trashed()) class="text-muted bg-light" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if(!empty($user->user->profile->avatar))
                                <img class="rounded-circle" src="{{ $user->user->profile->avatar_path }}" height="32" alt="">
                                @else
                                <img class="rounded-circle" src="{{ $user->user->profile->avatar_path }}" height="32" alt="">
                                @endif
                            </td>                                        
                            <td>
                                @if($user->trashed() || $user->user->is(auth()->user()))
                                    {{ $user['user']['profile']['display_name'] }}
                                @else
                                    <a @if(auth()->user()->isManagerCenters()) href="{{ route('administration::members.perwil-cadres.show', ['perwil_cadre' => $user->id]) }}" @endif>{{ $user['user']['profile']['display_name'] }}</a>
                                @endif
                            </td>                     
                            <td>
                                @foreach($user['levels'] as $k => $v)
                                    @if($loop->last)
                                        {{ $v->detail->name }}
                                    @endif
                                @endforeach
                            </td>                                                         
                            <td>{{ $user['nbts'] ?? '-' }}</td>  
                            <td>{{ $user['user']['address']['branch'] ?? '-' }}</td>  
                            <td nowrap>
                                @if($user->user->isnot(auth()->user()))
                                    @if($user->trashed())
                                        @if(auth()->user()->isManagerCenters())
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::members.perwil-cadres.restore', ['perwil_cadre' => $user->id]) }}" method="POST"> @csrf @method('PUT')
                                            <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Pulihkan"><i class="fa fa-sync"></i></button>
                                        </form>
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::members.perwil-cadres.kill', ['perwil_cadre' => $user->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus permanen"><i class="fa fa-delete"></i></button>
                                        </form>
                                        @endif
                                    @else
                                        @if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
                                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ubah pendekar" href="{{ route('administration::members.perwil-cadres.show', ['perwil_cadre' => $user->id]) }}"><i class="fa fa-edit"></i></a>
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::members.perwil-cadres.reset-password', ['user' => $user->user->id]) }}" method="POST"> @csrf @method('PUT')
                                            <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Reset"><i class="fas fa-lock-open"></i></button>
                                        </form>
                                        @endif
                                        @if(auth()->user()->isManagerCenters())
                                        <form class="d-inline form-block form-confirm" action="{{ route('administration::members.perwil-cadres.destroy', ['perwil_cadre' => $user->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Buang"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @endif
                                    @endif
                                @endif
                            </td>                     
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">empty warriors data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cadres</div>
                        <h1 class="mb-0 font-weight-bold text-gray-800">{{ $members_count }}</h1>
                    </div>
                    <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow mb-4">
            <div class="card-header"><i class="fa fa-cog"></i><strong> Option</strong></div>
            <div class="list-group list-group-flush">
                @if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
                <a class="list-group-item list-group-item-action text-success" href="{{ route('administration::members.perwil-cadres.create') }}"><i class="fa fa-plus-circle"></i> Add new cadres</a>
                <a class="list-group-item list-group-item-action text-success" href="{{ route('administration::members.cadres.index') }}"><i class="fa fa-list"></i> Show indonesian cadres</a>
                <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::members.perwil-cadres.index', ['trash' => request('trash', 0) ? null : 1, 'pimwil' => request('pimwil')]) }}"><i class="fa fa-trash"></i> Show {{ request('trash', 0) ? 'not' : '' }} deleted cadres</a>
                @endif
                <a class="list-group-item list-group-item-action text-primary" href="{{ route('administration::members.perwil-cadres.download-all-perwil-cadres',['perwil' => request('perwil')]) }}" target="_blank"><i class="fa fa-arrow-circle-down"></i> Download Data</a>
            </div>
        </div>
        @if(auth()->user()->isManagerCenters())
        <div class="card border-0 shadow mb-4">
            <div class="card-header"><i class="fa fa-file-import"></i><strong> Import</strong></div>
            <div class="card-body">
                <form id="upload-form" method="POST" enctype="multipart/form-data" action="{{ route('administration::members.perwil-cadres.import-perwil-cadres') }}"> @csrf
                    <div class="form-group">
                        <label>choose excel file</label>
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
        $('#pendekar').DataTable();
    });
</script>
@endpush