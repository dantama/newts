@extends('event::layouts.default')

@section('title', 'Kategori')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 border-0" id="save-form">
                <div class="card-body border-bottom">
                    <div><i class="mdi mdi-pencil"></i> Ubah kategori</div>
                </div>
                <div class="card-body">
                    <form class="form-block" action="{{ route('event::manage.categories.update', ['category' => $category->id]) }}" method="post"> @csrf @method('put')
                        <div class="mb-3">
                            <label for="inputEmail4" class="form-label">Nama kategori</label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="nama" name="title" value="{{ old('value', $category->title) }}">
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword4" class="form-label">Deskripsi</label>
                            <textarea class="form-control" placeholder="deskripsi" name="description">{{ old('description', $category->description) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-soft-danger"><i class="mdi mdi-pencil"></i> Ubah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
