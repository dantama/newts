@extends('administration::layouts.default')

@section('title', 'Edit kategori')

@php($url = url()->current())

@section('content')
<div class="row d-flex justify-content-center">
	<div class="col-lg-6 col-md-8 col-sm-10">
		<div class="mb-4">
			<h5 class="mb-0">
				<a href="{{ request('next', route('administration::blog.categories.index')) }}"><i class="fas fa-sm fa-arrow-circle-left"></i></a>
				<strong>Edit kategori</strong>
			</h5>
		</div>
		<div class="card border-0 mb-4">
			<div class="card-body">
				<form class="form-block" action="{{ route('administration::blog.categories.update', ['category' => $category->id]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-group required">
						<label>Nama kategori</label>
						<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $category->name) }}" required>
						@error('name')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea class="form-control @error('description') is-invalid @enderror" type="text" name="description">{!! old('description', $category->description) !!}</textarea>
						@error('description')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
						<small class="text-muted">Opsional</small>
					</div>
					<div class="form-group mb-0">
						<button type="submit" class="btn btn-danger"><i class="fas fa-sm fa-check"></i> Simpan</button>
						<a class="btn btn-secondary" href="{{ request('next', route('administration::blog.categories.index')) }}"><i class="fas fa-sm fa-arrow-left"></i> Kembali</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>	
@endsection