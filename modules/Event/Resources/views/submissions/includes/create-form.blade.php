@php($types = \App\Models\EventType::all())

<form class="form-block" action="{{ route('event::submissions.store') }}" method="post" enctype="multipart/form-data"> @csrf
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="name">Nama event</label>
				<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
				@error('name')
					<span class="invalid-feedback">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="content">Deskripsi</label>
				<textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" required style="min-height: 100px;">{{ old('content') }}</textarea>
				@error('content')
					<span class="invalid-feedback">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="type_id">Jenis event</label>
				<select class="form-control @error('type_id') is-invalid @enderror" id="type_id" name="type_id">
					<option value="">Umum</option>
					@foreach($types as $type)
						<option value="{{ $type->id }}" @if(old('type_id') == $type->id) checked @endif>{{ $type->name }}</option>
					@endforeach
				</select>
				@error('type_id')
					<span class="invalid-feedback">{{ $message }}</span>
				@enderror
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="price">Waktu pelaksanaan</label>
				<div class="input-group">
					<input type="date" class="form-control @error('start_at') is-invalid @enderror" id="start_at" name="start_at" value="{{ old('start_at') }}" required>
					<input type="date" class="form-control @error('end_at') is-invalid @enderror" id="end_at" name="end_at" value="{{ old('end_at') }}" required>
				</div>
				@error('start_at')
					<small class="text-danger">{{ $message }}</small>
				@enderror
				@error('end_at')
					<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="form-group">
				<label for="price">Registrasi</label>
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<span class="input-group-text"><small>Rp</small></span>
					</div>
					<input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
				</div>
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" id="registrable" value="1" name="registrable" @if(old('registrable', 1)) checked @endif>
					<label class="custom-control-label" for="registrable">Centang untuk mengaktifkan fitur registrasi</label>
				</div>
				@error('price')
					<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="inputfile">File</label>
				<div class="input-group">
					<div class="custom-file">
						<input type="file" name="file" class="custom-file-input cle" id="upload-input" accept="image/*">
						<label class="custom-file-label" for="upload-input">select file ...</label>
					</div>
				</div>
				@error('file')
				<small class="text-danger"> {{ $message }} </small>
				@enderror
			</div>
		</div>
	</div>
	<div class="mt-4">
		<button class="btn btn-danger"><i class="fas fa-paper-plane"></i> Ajukan sekarang!</button>
	</div>
</form>

@push('script')
	<script>
        $(() => {         
            function readURL(input) {
                if (input.files && input.files[0]) {
                    $('[for="upload-input"]').html(input.files[0].name)
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#upload-preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#upload-input").change(function(e) {
                readURL(this);
            });

        })
    </script>
@endpush