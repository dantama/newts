@extends('administration::layouts.default')

@section('title', 'Pimpinan Wilayah')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Pimpinan wilayah</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar Pimwil</div>
            <div class="card-body">
                <table class="table dt-responsive" id="provinceTbl" style="width: 100%">
                    <thead class="thead-dark">
                        <th>No</th>
                        <th nowrap>Nama Pilwil</th>
                        <th>Kode</th>
                        <th>Alamat</th>
                        <th nowrap>No Telpon</th>
                        <th>Email</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($managements as $pw)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pw->name }}</td>
                            <td>{{ $pw->pimwil_code }}</td>
                            <td>{{ $pw->address }}</td>
                            <td>{{ $pw->phone }}</td>
                            <td>{{ $pw->email }}</td>
                            <td nowrap><a href="{{ route('administration::managements.provinces.show', ['province' => $pw->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(auth()->user()->isManagerCenters())
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Tambah pimpinan wilayah</div>
            <div class="card-body">
                <form class="form-block" action="{{ route('administration::managements.provinces.store', ['next' => request('next', route('administration::managements.provinces.index'))]) }}" method="POST"> @csrf
                    <div class="form-group">
                        <label for="inputEmail4">Provinsi</label>
                        <select name="province_id" id="province_id" class="form-control @error('province_id') is-invalid @enderror selectpicker" data-live-search="true">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $prop)
                                <option value="{{ $prop->id }}" @if(old('province_id') == $prop->id) selected @endif>{{ $prop->name }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>  
                    <div class="form-group">
                        <label for="inputAddress">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Pimwil" required value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telp">No Telp</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="telp" name="phone" placeholder="Telp" required value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="alamat" name="address" placeholder="ex: Jl Kaliurang" required value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telp">Kode Wilayah</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="ex: VI" required value="{{ old('code') }}">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDistric">Kecamatan</label>
                        <select id="district_id" name="district_id" class="form-control @error('district_id') is-invalid @enderror">
                            @if(old('district_id'))
                                @php($district = \App\Models\References\ProvinceRegencyDistrict::find(old('district_id')))
                                <option value="{{ $district->id }}" selected>{{ $district->regional }}</option>
                            @endif
                        </select>
                        @error('district_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Data sudah saya isi dengan benar.
                            </label>
                        </div>
                    </div>
                    <button id="btn-submit" type="submit" class="btn btn-danger disabled">Simpan</button>
                </form>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total pimpinan wilayah</div>
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
                <a class="list-group-item list-group-item-action text-danger" href="{{ route('administration::managements.provinces-managers.index', ['pimwil' => request('pimwil')]) }}"><i class="far fa-user"></i> Data pengurus</a>
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
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#provinceTbl').DataTable();
    });
</script>
@endpush