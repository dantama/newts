@extends('blog::layouts.default')

@section('title', 'Artikel')
@section('navtitle', 'Buat Artikel')

@php($back = request('next', route('blog::article.posts.index')))

@section('content')
    <form class="form-block" action="{{ route('blog::article.posts.store', ['next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-sm-12">
                <div class="card border-0">
                    <div class="card-body border-bottom">
                        <div><i class="mdi mdi-plus"></i> Tambah artikel</div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required fw-bold">Judul</label>
                            <div>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konten</label>
                            <div>
                                <textarea class="form-control tiny @error('content') is-invalid @enderror" name="content" rows="20">{{ old('content') }}</textarea>
                                @error('content')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata kunci</label>
                            <div>
                                <textarea class="form-control @error('meta[keyword]') is-invalid @enderror" name="meta[keyword]" rows="1">{{ old('meta[keyword]') }}</textarea>
                                @error('meta[keyword]')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta title</label>
                            <div>
                                <textarea class="form-control @error('meta[title]') is-invalid @enderror" name="meta[title]" rows="2">{{ old('meta[title]') }}</textarea>
                                @error('meta[title]')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta description</label>
                            <div>
                                <textarea class="form-control @error('meta[description]') is-invalid @enderror" name="meta[description]" rows="4">{{ old('meta[description]') }}</textarea>
                                @error('meta[description]')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="card mb-4 border-0">
                    <div class="card-body">
                        <div><i class="mdi mdi-information-outline"></i> Informasi</div>
                    </div>
                    <div class="card-body border-top">
                        <div class="mb-3">
                            <label class="col-lg-3 col-form-label required">Kategori</label>
                            <div class="col-lg-12">
                                <div class="card card-body @error('ctg_id') is-invalid @enderror mb-0 p-2">
                                    @foreach ($categories as $category)
                                        <div class="form-check">
                                            <input type="checkbox" id="type-{{ $category->id }}" class="form-check-input" name="ctg_id[]" value="{{ $category->id }}" @checked(in_array($category->id, request('category_id', []))) />
                                            <label class="form-check-label" for="type-{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('ctg_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-lg-3 col-form-label required">Tags</label>
                            <div class="col-lg-12">
                                <select name="tags[]" id="tags" class="form-select">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag }}">{{ $tag }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="mb-3">
                            <label class="col-lg-3 col-form-label required">Cover</label>
                            <input class="form-control" name="file" type="file" id="upload-input" accept="image/*">
                            <small class="text-muted">Berkas berupa .jpg atau .png maksimal berukuran 2mb</small>
                            @error('file')
                                <small class="text-danger d-block"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="" name="is_draft" />
                                <label class="form-check-label" for=""> Simpan sebagai draft </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Publish</button>
                                <a class="btn btn-light" href="{{ $back }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/tom-select/css/tom-select.bootstrap5.min.css') }}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

@push('scripts')
    <!-- Load FilePond library -->
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginImageEdit);
        const inputElement = document.querySelector('input[type="file"]');
        const realElement = document.querySelector('input[name="real_path"]');
        const url = @JSON(route('api::references.blog.images-upload'));

        const filePondOptions = {
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
        }

        FilePond.setOptions(filePondOptions);

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);

        tinymce.init({
            selector: '.tiny',
            height: "480",
            paste_data_images: false,
            relative_urls: false,
            plugins: 'autosave autoresize print preview paste searchreplace code fullscreen image link media table charmap hr pagebreak advlist lists wordcount imagetools noneditable charmap',
            menubar: false,
            toolbar: 'undo redo | bold italic underline | formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat',
            readonly: 0
        });

        document.addEventListener("DOMContentLoaded", async () => {
            new TomSelect('[id="tags"]', {
                create: true,
                maxItems: 10
            });
        });
    </script>
@endpush
