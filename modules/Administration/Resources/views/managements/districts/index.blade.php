@extends('administration::layouts.default')

@section('title', 'Pimpinan Daerah')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Pimpinan Cabang</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar Cabang</div>
            <div class="card-body">
                <table class="table dt-responsive" id="districTbl" style="width: 100%">
                    <thead class="thead-dark">
                        <th>No</th>
                        <th nowrap>Nama Cabang</th>
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
                            <td>{{ $pd['address'] }}</td>
                            <td>{{ $pd['phone'] }}</td>
                            <td>{{ $pd['email'] }}</td>
                            <td nowrap>
                                <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-warning border-0 shadow py-2 mb-4">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total pimpinan cabang</div>
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
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total pengurus cabang</div>
                        <h1 class="mb-0 font-weight-bold text-gray-800">{{ $managers_count }}</h1>
                    </div>
                    <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                </div>
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
        $('#districTbl').DataTable();
    });
</script>
@endpush