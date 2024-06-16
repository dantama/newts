@extends('administration::layouts.default')

@section('title', 'Daftar Pelatih Nasional')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Prestasi</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="jumbotron bg-light py-4 mb-4 border-dark">
            <span class="float-right text-muted font-weight-bold"><i class="far fa-user"></i> Prestasi Daerah</span>
            <h2>{{ $UserAchievementCentral[0]['user']['profile']['name'] }}</h2>
            <hr>
        </div>
        <div class="card text-center mb-4">
            <div class="card-header">Detail</div>
            <div class="card-body">
                <p style="text-align: left;">Dengan ini menerangkan bahwa</p>
                <h4>{{ $UserAchievementCentral[0]['user']['profile']['name'] }}</h4>
                <p>Telah mengikuti Kejuaraan/Pelatihan* <strong>{{ $UserAchievementCentral[0]['name'] }}</strong> dan berhasil memperoleh hasil <strong>{{ $UserAchievementCentral[0]['num']['name'] }}</strong> pada tahun <strong>{{ $UserAchievementCentral[0]['year'] }}</strong> kategori <strong>{{ $UserAchievementCentral[0]['type']['name'] }}</strong></p>
            </div>
        </div> 
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">Lanjutan</div>
            <div class="card-body">
                <form class="form-block" method="POST" enctype="multipart/form-data" action="">@csrf
                    <div class="form-group">
                        <label for="inputAddress">Prestasi</label>
                        <input type="text" name="name" id="name" class="form-control" required="" value="{{ $UserAchievementCentral[0]['name'] }}">
                    </div> 
                    <div class="form-group">
                        <label for="inputAddress">Kategori</label>
                        <select name="type_id" id="type_id" class="form-control">
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ ( $type->id == $UserAchievementCentral[0]['type_id']) ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="inputAddress">Pencapaian</label>
                        <select name="num_id" id="num_id" class="form-control">
                            <option value="">Pilih</option>
                            @foreach($nums as $num)
                            <option value="{{ $num->id }}" {{ ( $num->id == $UserAchievementCentral[0]['num_id']) ? 'selected' : '' }}>{{ $num->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group">
                        <label for="inputAddress">Tahun</label>
                        <input type="text" name="year" id="year" class="form-control" required="" value="{{ $UserAchievementCentral[0]['year'] }}">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Deskripsi</label>
                        <textarea type="text" name="description" id="description" class="form-control">{{ $UserAchievementCentral[0]['description'] ?? 'Belum ada deskripsi' }}</textarea> 
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </form>
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
        $('#kader').DataTable();
    });
</script>
@endpush
