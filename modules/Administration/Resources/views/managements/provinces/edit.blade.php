@extends('administration::layouts.default')

@section('title', 'Edit Provinsi')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::managements.provinces.index') }}"> <i class="fa fa-arrow-circle-left"></i></a> Daftar Pimwil
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::managements.provinces.update',['province' =>$province[0]['id']]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-group">
                        <label for="inputAddress">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $province[0]['name'] }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $province[0]['email'] ?? 'belum diisi' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telp">No Telp</label>
                            <input type="text" class="form-control" id="telp" name="phone" value="{{ $province[0]['phone'] ?? 'belum diisi' }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="address" value="{{ $province[0]['address'] ?? 'belum diisi' }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telp">Kode Wilayah</label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ $province[0]['pimwil_code'] ?? 'belum diisi' }}" {{ (auth()->user()->isManagerCenters()) ? '' : 'readonly' }}>
                        </div>
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
	</div>
</div>
@stop

@push('style')
<link href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}" rel="stylesheet">
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
</script>
@endpush