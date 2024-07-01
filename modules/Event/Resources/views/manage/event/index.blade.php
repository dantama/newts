@extends('event::layouts.default')

@section('title', 'Kategori')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 border-0">
                <div class="card-body border-bottom">
                    <div><i class="mdi mdi-list"></i> Daftar kategori</div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ctgs as $ctg)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + $ctgs->firstItem() - 1 }}</td>
                                    <td class="fw-bold">{{ $ctg->title }}</td>
                                    <td>{{ $ctg->description }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-soft-warning" data-toggle="tooltip" title="Ubah kategori" href="{{ route('event::manage.categories.show', ['category' => $ctg->id]) }}" id="change_ctgs"><i class="mdi mdi-pencil"></i></a>
                                        <form class="d-inline form-block form-confirm" action="{{ route('event::manage.categories.destroy', ['category' => $ctg->id]) }}" method="POST"> @csrf @method('DELETE')
                                            <button class="btn btn-soft-danger" data-toggle="tooltip" title="Buang"><i class="mdi mdi-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    {{ $ctgs->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 border-0">
                <div class="card-body border-bottom">
                    <div><i class="mdi mdi-plus"></i> Buat kategori baru</div>
                </div>
                <div class="card-body">
                    <form class="form-block" action="{{ route('event::manage.categories.store') }}" method="post"> @csrf
                        <div class="mb-3">
                            <label for="inputEmail4">Nama kategori</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputEmail4" placeholder="nama" name="title">
                            @error('title')
                                <span>
                                    <small class="text-danger">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword4">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" placeholder="deskripsi" name="description"></textarea>
                            @error('description')
                                <span>
                                    <small class="text-danger">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-soft-danger">Tambahkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
