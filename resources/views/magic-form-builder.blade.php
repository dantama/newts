@extends('layouts.default')

@section('title', 'Welcome to ')

@section('main')
    <div class="container py-5">
        <h4>Form builder PéMad</h4>
        <br>
        <div class="row">
            <div class="col-lg-8">
                <template id="template">
                    <div class="builder-form card card-body mb-3">
                        <div class="row g-2 mb-3">
                            <div class="col flex-grow-1">
                                <select data-name="type" class="form-select builder-type-select" onchange="renderPreview(event)" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach (Modules\Core\Enums\DynamicFormInputEnum::cases() as $case)
                                        <option value="{{ $case->value }}" data-renderable="{{ $case->value }}">{{ $case->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col flex-grow-0">
                                <button type="button" class="btn btn-soft-danger" onclick="deleteBuilder(event)"><i class="mdi mdi-trash-can-outline"></i></button>
                            </div>
                            <div class="col-lg-7 order-lg-first">
                                <input data-name="label" class="form-control" type="text" placeholder="Nama label" onkeyup="renderPreview(event)" required>
                            </div>
                        </div>
                        <div class="builder-options d-none mb-3">
                            <template>
                                <div class="d-flex template mb-2">
                                    <div class="input-group">
                                        <input data-name="options" class="form-control" type="text" placeholder="Nama opsi" onkeyup="renderPreview(event)">
                                    </div>
                                    <div class="ms-2">
                                        <button type="button" class="btn btn-soft-secondary text-dark rounded-circle" style="padding: .5rem .75rem;" onclick="removeOptions(event);"><i class="mdi mdi-minus"></i></button>
                                    </div>
                                </div>
                            </template>
                            <div class="d-flex mb-2">
                                <div class="input-group">
                                    <input data-name="options" class="form-control" type="text" placeholder="Nama opsi 1" onkeyup="renderPreview(event)">
                                </div>
                                <div class="ms-2">
                                    <button type="button" class="btn btn-secondary rounded-circle" style="padding: .5rem .75rem;" onclick="addOptions(event)"><i class="mdi mdi-plus-circle-outline"></i></button>
                                </div>
                            </div>
                        </div>
                        <label class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="1" data-name="required" onchange="renderPreview(event)">
                            <div class="form-check-label">Wajib diisi</div>
                        </label>
                        <div class="d-flex align-items-center mb-1">
                            <div class="text-muted small">Preview</div>
                            <div class="ms-2 w-100" style="border-bottom:1px solid #ddd; height: 1px;"></div>
                        </div>
                        <div class="card card-body bg-light mb-0 border-0">
                            <div class="builder-preview"></div>
                        </div>
                    </div>
                </template>
                <form id="form">
                </form>
                <div class="mb-3">
                    <button type="button" class="btn btn-soft-danger" onclick="addBuilder(event)">Tambah input baru</button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Result
                    </div>
                    <div class="card-body">
                        <code class="text-wrap mb-0">
                            <pre class="text-wrap mb-0" id="result"></pre>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const addBuilder = (e) => {
            document.querySelector('form#form').insertAdjacentHTML('beforeend', document.querySelector('template#template').innerHTML);
            renderResult();
        }

        const deleteBuilder = (e) => {
            e.currentTarget.closest('.builder-form').remove();
            renderResult();
        }

        const addOptions = (e) => {
            let builder = e.currentTarget.closest('.builder-options');
            builder.insertAdjacentHTML('beforeend', builder.querySelector('template').innerHTML);
            setAutoOptionPlaceholder();
        }

        const removeOptions = (e) => {
            e.currentTarget.closest('.d-flex').remove();
            setAutoOptionPlaceholder();
        }

        const setAutoOptionPlaceholder = () => {
            Array.from(document.querySelectorAll('.builder-options')).map((builder) => {
                Array.from(builder.querySelectorAll('.d-flex input')).map((input, i) => input.placeholder = `Nama opsi ${i+1}`);
            });
            renderResult();
        }

        const toggleBuilderOptions = (el, status) => {
            if (status == false) {
                Array.from(el.querySelectorAll('.d-flex.template')).map(el => el.remove());
                el.querySelector('.d-flex input').value = '';
            }
            el.querySelector('.builder-options').classList.toggle('d-none', !status);
        }

        const renderPreview = (e) => {
            let builder = e.currentTarget.closest('.builder-form');
            let result = {};
            let options = '';
            let content;
            switch (builder.querySelector('[data-name="type"]').value) {
                case 'text':
                    toggleBuilderOptions(builder, false);
                    content = '<input class="form-control" type="text">';
                    break;
                case 'number':
                    toggleBuilderOptions(builder, false);
                    content = '<input class="form-control" type="number">';
                    break;
                case 'textarea':
                    toggleBuilderOptions(builder, false);
                    content = '<textarea class="form-control"></textarea>';
                    break;
                case 'select':
                    toggleBuilderOptions(builder, true);
                    Array.from(builder.querySelectorAll('.builder-options input')).forEach(el => options += `<option>${el.value}</option>`)
                    content = `<select class="form-select"><option>-- Pilih --</option>${options}</select>`;
                    break;
                case 'checkbox':
                    toggleBuilderOptions(builder, true);
                    Array.from(builder.querySelectorAll('.builder-options input')).forEach(el => options += `<label class="d-block"><input class="form-check-input" type="checkbox"><span class="form-check-label ps-2">${el.value}</span></label>`)
                    content = `<div>${options}</div>`;
                    break;
                case 'radio':
                    toggleBuilderOptions(builder, true);
                    let tmp = Math.floor(Math.random() * 1000);
                    Array.from(builder.querySelectorAll('.builder-options input')).forEach(el => options += `<label class="d-block"><input class="form-check-input" name="tmp_${tmp}" type="radio"><span class="form-check-label ps-2">${el.value}</span></label>`)
                    content = `<div>${options}</div>`;
                    break;
                default:
                    content = '<input class="form-control" type="text">';
                    break;
            }

            // Render html
            let html = `<div><label class="mb-2 text-muted">${builder.querySelector('[data-name="label"]').value || 'Tanpa label'}<span class="text-danger">${builder.querySelector('[data-name="required"]').checked ? ' *' : ''}</span></label><div>${content}</div></div>`;
            builder.querySelector('.builder-preview').innerHTML = html;
            renderResult();
        }

        // Render auto input name
        const renderAutoInputName = () => {
            Array.from(document.querySelectorAll('.builder-form')).forEach((builder, i) => {
                Array.from(builder.querySelectorAll('[data-name]')).map(el => {
                    el.name = `input[][${el.dataset.name}]` + (el.dataset.name == 'options' ? '[]' : '')
                })
            });
        }

        // Render result
        const renderResult = () => {
            renderAutoInputName();
            let results = [];
            Array.from(document.querySelectorAll('.builder-form')).forEach((builder, i) => {
                result = {
                    label: builder.querySelector('[data-name="label"]').value,
                    type: builder.querySelector('[data-name="type"]').value,
                    required: builder.querySelector('[data-name="required"]').checked
                }
                if (!builder.querySelector('.builder-options').classList.contains('d-none'))
                    result.options = Array.from(builder.querySelectorAll('.builder-options:not(.d-none) input[data-name="options"]') || []).map(el => el.value)
                results.push(result)
            })
            document.getElementById('result').innerText = JSON.stringify(results)
        };

        document.addEventListener('DOMContentLoaded', () => {
            addBuilder();
        })
    </script>
@endpush
