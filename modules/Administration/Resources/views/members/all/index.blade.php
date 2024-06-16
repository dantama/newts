@extends('administration::layouts.default')

@section('title', 'Daftar anggota')

@section('content-header')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="font-weight-bold mb-0 text-gray-800">Daftar anggota</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">Daftar anggota</div>
            @if(request('trash'))
            <div class="alert alert-warning text-danger rounded-0 mb-1">
                <i class="fas fa-exclamation-circle fa-fw"></i> Menampilkan data yang dihapus
            </div>
            @endif
            <div class="card-body">
                <form action="{{ route('administration::members.account.index') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="cari nama di sini">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-danger">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th></th>
                            <th>Nama</th>
                            <th>Tingkat</th>
                            <th>NBTS</th>
                            <th>Alamat</th>
                            <th nowrap="">Pimda</th>
                            <th nowrap=""></th>
                            <th style="width: 110px;"></th>                  
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warriors as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($warriors->firstItem() - 1) }}</td>
                            <td>
                                @if(!empty($user['avatar']))
                                <img class="rounded-circle" src="{{ $user['avatar'] }}" height="32" alt="">
                                @else
                                <img class="rounded-circle" src="{{ $user['avatar'] }}" height="32" alt="">
                                @endif
                            </td>                                        
                            <td>
                                <strong>{{ $user['name'] }}</strong>
                            </td>                     
                            <td>{{ $user['level'] }}</td>                                                         
                            <td>{{ $user['nbts'] ?? '-' }}</td>  
                            <td>{{ $user['address'] ?? '-' }}</td>  
                            <td>{{ $user['regency_name'] ?? 'Belum ada' }}</td>
                            <td>
                                <select name="pimda_baru" id="pimda_baru{{ $user['id'] }}" class="form-control" hidden="true">
                                    <option value="">Pilih Pimda</option>
                                    @foreach($managements as $val)
                                    <option value="{{ $val->id }}" {{ $val->id == $user['regency_id'] ? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td nowrap>
                                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Ubah Anggota" href="{{ route('administration::members.account.show', ['account' => $user['uid']]) }}" target="_blank"><i class="fa fa-info-circle"></i></a>
                                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ubah Anggota" href="javascript:;" data-id="{{ $user['id'] }}" id="edit{{ $user['id'] }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="Batal Ubah" href="javascript:;" data-id="{{ $user['id'] }}" id="cancel{{ $user['id'] }}" hidden="true"><i class="fa fa-sync"></i></a>
                                <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Simpan" href="javascript:;" data-id="{{ $user['id'] }}" id="save{{ $user['id'] }}" hidden="true"><i class="fa fa-save"></i></a>
                            </td>                     
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Tidak ada data anggota</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{ $warriors->appends(request()->all())->links() }}
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
<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var war = {!! json_encode($warriors) !!};
    var opt = war.data;

    $.each(opt, function(index, value) {

        var idx = opt[index].id;
        // console.log(idx);

        $("#edit"+idx).click(function(e){
            e.preventDefault();

            console.log(idx);
            
            $("#pimda_baru"+idx).attr("hidden", false);
            $("#cancel"+idx).attr("hidden", false);
            $("#save"+idx).attr("hidden", false);
            $("#edit"+idx).attr("hidden", true);

        });

        $("#cancel"+idx).click(function(e){
            e.preventDefault();

            console.log(idx);
            
            location.reload();

        });

        $("#save"+idx).click(function(e) {
            e.preventDefault();

            var data = {};
            data.user_id    = idx;
            data.regency_id = $('#pimda_baru'+idx).val();

            $.ajax({
                url: APP_URL +'/members/account/update',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PUT',
                data: JSON.stringify(data),
                dataType: 'JSON',
                contentType: 'application/json',
                processData: false,
                contentType: false,
                cache: false,

                success: function(data){
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            })
            .always(function(data) {
                console.log('done'); 
            });
        }); 

    });
</script>
@endpush