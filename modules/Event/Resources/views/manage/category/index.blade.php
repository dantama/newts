@extends('event::layouts.default')

@section('title', 'Event')

@section('content')
<div class="row">
	<div class="col-md-9">
		<div class="card mb-4 border-0 shadow">
			<div class="card-header">
				<div><i class="fas fa-list"></i> Daftar kategori</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="bg-dark text-light">
						<tr>
							<td>No</td>
							<td>Nama Kategori</td>
							<td>Deskripsi</td>
							<td></td>
						</tr>
						<tbody>
							@forelse($events as $event)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $event->name }}</td>
								<td>{{ $event->description }}</td>
								<td>
									<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Ubah kategori" href="#" id="change_ctgs" data-attribute="{{ $event->id }}"><i class="fa fa-edit"></i></a>
									<form class="d-inline form-block form-confirm" action="{{ route('event::manage.category.destroy', ['category' => $event->id]) }}" method="POST"> @csrf @method('DELETE')
										<button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Buang"><i class="fa fa-trash"></i></button>
									</form>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="4">Belum ada data</td>
							</tr>
							@endforelse
						</tbody>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card mb-4 border-0 shadow" id="save-form">
			<div class="card-header">
				<div><i class="fas fa-plus-circle"></i> Buat kategori baru</div>
			</div>
			<div class="card-body">
				<form class="form-block" action="{{ route('event::manage.category.store') }}" method="post"> @csrf
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Nama kategori</label>
							<input type="text" class="form-control" id="inputEmail4" placeholder="nama" name="name">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputPassword4">Deskripsi</label>
							<textarea class="form-control" placeholder="deskripsi" name="description"></textarea>
						</div>
					</div>
					<button type="submit" class="btn btn-info btn-sm">Tambahkan</button>
				</form>
			</div>
		</div>
		<div class="card mb-4 border-0 shadow" id="update-form" style="display: none;">
			<div class="card-header">
				<div><i class="fas fa-plus-circle"></i> Update kategori</div>
			</div>
			<div class="card-body">
				<form class="form-block" action="{{ route('event::manage.category.update',['category' => $event->id]) }}" method="post"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Nama kategori</label>
							<div id="idup"></div>
							<div id="nmup"></div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputPassword4">Deskripsi</label>
							<div id="dcup"></div>
						</div>
					</div>
					<button type="submit" class="btn btn-info btn-sm">Perbarui</button>
					<a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Batalkan" href="#" id="cancel">Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>
@stop


@push('script')
	<script>
		$(() => {

			var url = {!! json_encode(url('/')) !!} +'/api/getEventCategory';

			$("a[id=change_ctgs]").click(function(e){ //on add input button click
		    	e.preventDefault();
		    	var id = $(this).attr("data-attribute");
		    	$("#update-form").show();
		    	$("#save-form").hide();

		    	$.ajax({
		    		type: 'GET',
		    		url: url,
		    		data: { 
		    			'id': id,
		    		},

		    		success: function(val){
		    			var x = val[0].id;
		                var y = val[0].name;
		                var z = val[0].description;
		    			var xup = $('<input type="hidden" class="form-control" name="updateid" id="updateid" value="'+x+'">');
		    			var yup = $('<input type="text" class="form-control" name="updatename" id="updatename" value="'+y+'">');
		    			var zup = $('<textarea class="form-control" name="updatedesc" id="updatedesc" placeholder="deskripsi">'+z+'</textarea>');
		    			$('#idup').html(xup); 
		    			$('#nmup').html(yup); 
		    			$('#dcup').html(zup); 

		    			// console.log(val[0].name);
		    		},
		    	});

		    }); 

		    $("#cancel").click(function(e){
		    	e.preventDefault();
		    	$("#update-form").hide();
		    	$("#save-form").show();
		    })
		})
	</script>
@endpush