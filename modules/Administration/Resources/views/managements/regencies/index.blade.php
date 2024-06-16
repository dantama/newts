@extends('administration::layouts.default')

@section('title', 'Pimpinan Daerah')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Pimpinan daerah</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar Pimda</div>
            <div class="card-body">
                <table class="table dt-responsive" id="regencyTbl" style="width: 100%">
                    <thead class="thead-dark">
                        <th>No</th>
                        <th nowrap>Nama Pimda</th>
                        <th>Kode</th>
                        <th>Alamat</th>
                        <th nowrap>No Telpon</th>
                        <th>Email</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($pd as $pd)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pd['name'] }}</td>
                            <td>{{ $pd['pimda_code'] }}</td>
                            <td>{{ $pd['address'] }}</td>
                            <td>{{ $pd['phone'] }}</td>
                            <td>{{ $pd['email'] }}</td>
                            <td nowrap>
                                <a href="{{ route('administration::managements.regencies.show',['id' => $pd['id']]) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                @if(auth()->user()->isManagerCenters())
                                <form class="d-inline form-block form-confirm" action="{{ route('administration::managements.regencies.destroy', ['id' => $pd->id]) }}" method="POST"> @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Buang"><i class="fa fa-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(auth()->user()->isManagerCenters())
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Lanjutan</div>
            <div class="card-body">
                <form class="form-block" action="{{ route('administration::managements.regencies.store', ['next' => request('next', route('administration::managements.regencies.index'))]) }}" method="POST"> @csrf
                    <div class="form-group">
                        <label for="inputEmail4">Pimpinan Wilayah</label>
                        <select name="province_id" id="province_id" class="form-control selectpicker" data-live-search="true">
                            <option value="">Pilih Pimwil</option>
                            @foreach($pw as $pw)
                            <option value="{{ $pw->id }}">{{ $pw->name }}</option>
                            @endforeach               
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="inputEmail4">Daerah</label>
                        <select name="regency_id" id="regency_id" class="form-control selectpicker" data-live-search="true">
                            <option value="">Pilih Kabupaten</option>
                            @foreach($daerah as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                            @endforeach               
                        </select>
                    </div>  
                    <div class="form-group">
                        <label for="inputAddress">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pimda" required value="{{ old('name') }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telp">No Telp</label>
                            <input type="text" class="form-control" id="telp" name="phone" placeholder="Telp" required value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="address" placeholder="ex: Jl Kaliurang" required value="{{ old('address') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telp">Kode Daerah</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="ex: 13" required value="{{ old('code') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDistric">Kecamatan</label>
                        <select id="district_id" name="district_id" class="form-control">
                            <option selected>Choose...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Data sudah saya isi dengan benar.
                            </label>
                        </div>
                    </div>
                    @if(count($errors))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <button id="btn-submit" type="submit" class="btn btn-danger disabled">Simpan</button>
                </form>
            </div>
        </div>
        @endif
        @if(auth()->user()->isManagerRegencies())
        <div class="card border-0 shadow mb-4" id="fmcab" style="display: none;">
            <div class="card-header">Lanjutan</div>
            <div class="card-body">
                <form action="{{ route('administration::managements.districts.store') }}" method="POST"> @csrf
                    <div class="form-group">
                        <label for="inputAddress">Pimda</label>
                        <input type="text" class="form-control" value="{{ $pd['name'] }}" disabled="">
                        <input type="hidden" class="form-control" id="mgmt_regency_id" name="mgmt_regency_id" value="{{ $pd['id'] }}">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Nama Cabang</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama cabang" required value="{{ old('name') }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telp">No Telp</label>
                            <input type="text" class="form-control" id="telp" name="phone" placeholder="Telp" required value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="address" placeholder="ex: Jl Kaliurang" required value="{{ old('address') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telp">Kode Cabang</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="ex: 13" required value="{{ old('code') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDistric">Kecamatan</label>
                        <select id="district_id" name="district_id" class="form-control">
                            <option selected>Choose...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Data sudah saya isi dengan benar.
                            </label>
                        </div>
                    </div>
                    @if(count($errors))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <button id="btn-submit-cab" type="submit" class="btn btn-danger disabled">Simpan</button>
                </form>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total pimpinan daerah</div>
                        <h1 class="mb-0 font-weight-bold text-gray-800">{{ $managements_count }}</h1>
                    </div>
                    <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                </div>
            </div>
        </div>
        <div class="card border-left-danger border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total pengurus daerah</div>
                        <h1 class="mb-0 font-weight-bold text-gray-800">{{ $managers_count }}</h1>
                    </div>
                    <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->isManagerCenters())
        <div class="card border-left-success border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Buka Pendaftaran</div>
                        <h1 class="mb-0 font-weight-bold text-gray-800"><a href="{{ route('administration::managements.regencies.open-registers') }}"><i class="fa fa-plus-circle"></i></a></h1>
                    </div>
                    <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                </div>
            </div>
        </div>
        @endif
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Lanjutan</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::managements.regencies-managers.index', ['pimwil' => request('pimwil')]) }}"><i class="far fa-user"></i> Data pengurus</a>
                @if(auth()->user()->isManagerRegencies())
                <a class="list-group-item list-group-item-action text-danger" id="showcab" href="#"><i class="far fa-user"></i> Tambah Cabang</a>
                @endif
            </div>
        </div>
    </div>
</div>
@stop


@push('style')
<link href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" rel="stylesheet">
<style type="text/css">
    .bootstrap-select .btn {
        background-color: #fff;
        border-style: solid;
        border: 1px solid #ced4da;
    }  
</style>
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
<script>
    $('#gridCheck').change((e) => {
        $(e.target).prop('checked') ? $('#btn-submit').removeClass('disabled') : $('#btn-submit').addClass('disabled');
        $(e.target).prop('checked') ? $('#btn-submit-cab').removeClass('disabled') : $('#btn-submit-cab').addClass('disabled');
    })
    $('[name="district_id"]').select2({
        minimumInputLength: 3,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ route('api.getDistricts') }}',
            dataType: 'json',
            delay: 500,
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });
    $('#showcab').click(function(){
        $('#fmcab').show();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#regencyTbl').DataTable();
    });
</script>
@endpush