@extends('administration::layouts.default')

@section('title', 'Edit Siswa')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.students.show',['student' => $members[0]['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Profil Siswa
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<div class="row">
					<div class="col-md-4" style="border-right:1px solid #ddd;">
						<div id="image-preview"></div>
					</div>
					<div class="col-md-4" style="border-right:1px solid #ddd;">
						<p><label>Select Image</label></p>
						<input type="file" name="upload_image" id="upload_image" />
						<br />
						<br />
						<button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
					<div class="col-md-4">
						<div class="row align-items-center" style="height: 230px; width: 180px; background-color: #333;">
							<div id="uploaded_image" class="mx-auto" align="center" style="height: 160px; width: 120px;"></div>
						</div>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" rel="stylesheet">
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
	$('[name="regency_id"]').select2({
		minimumInputLength: 3,
		theme: 'bootstrap4',
		ajax: {
			url: '{{ route('api.getRegencies') }}',
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

		$image_crop = $('#image-preview').croppie({
			enableExif:true,
			viewport:{
				width:120,
				height:160,
				type:'square'
			},
			boundary:{
				width:180,
				height:230
			}
		});

		$('#upload_image').change(function(){
			var reader = new FileReader();

			reader.onload = function(event){
				$image_crop.croppie('bind', {
					url:event.target.result
				}).then(function(){
					console.log('jQuery bind complete');
				});
			}
			reader.readAsDataURL(this.files[0]);
		});

		$('.crop_image').click(function(event){
			$image_crop.croppie('result', {
				type:'canvas',
				size:'viewport'
			}).then(function(response){
				var _token = $('input[name=_token]').val();
				var user_id = {{ $members[0]['user']['id'] }}
				$.ajax({
					url:'{{ route("administration::members.warriors.avatar-update") }}',
					type:'post',
					data:{"image":response, _token:_token, user_id: user_id},
					dataType:"json",
					success:function(data)
					{
						var crop_image = '<img src="'+data.path+'" />';
						$('#uploaded_image').html(crop_image);
					}
				});
			});
		});

	});  
</script>
@endpush