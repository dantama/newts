@extends('blog::layouts.default')

@section('title', 'Testimoni')
@section('navtitle', 'Buat testimoni')

@php($back = request('next', route('blog::testimonies.index')))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-sm-10">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ $back }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Buat testimoni</h2>
                    <div class="text-secondary">Tambahkan testimoni untuk artikel kamu!</div>
                </div>
            </div>
            <div class="card card-body border-0">
                <form class="form-block" action="{{ route('blog::testimonies.store', ['next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf
                    <div class="mb-3">
                        <label class="form-label required">Nama</label>
                        <div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label required">Foto</label>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <input class="form-control" name="file" type="file" id="upload-input" accept="image/*">
                                    <small class="text-muted">Berkas berupa .jpg atau .png maksimal berukuran 2mb</small>
                                </div>
                                @error('file')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <div>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="8">{{ old('content') }}</textarea>
                            @error('content')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
                        <a class="btn btn-light" href="{{ $back }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@push('scripts')
    <!-- Load FilePond library -->
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageEdit);
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[type="file"]');
        const url = @JSON(route('api::references.testimony.images-upload'));

        FilePond.setOptions({
            server: {
                process: {
                    url: url,
                    headers: (file) => {
                        return {
                            "Upload-Name": file.name,
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        }
                    },
                    ondata: (formData) => {
                        // Append each file and its name to the form data
                        Array.from(inputElement.files).forEach(file => {
                            formData.append('filepond', file);
                            formData.append('filename', file.name);
                        });

                        return formData;
                    },
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);
    </script>
@endpush
