@extends('admin::layouts.default')

@section('title', 'Invoice')
@section('navtitle', 'Detail invoice')

@php($back = request('next', route('admin::finance.invoices.index')))

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9">
            <div class="d-flex align-items-center mb-4">
                <a class="text-decoration-none" href="{{ $back }}"><i class="mdi mdi-arrow-left-circle-outline mdi-36px"></i></a>
                <div class="ms-4">
                    <h2 class="mb-1">Detail invoice</h2>
                    <div class="text-secondary">Tagihkan ke pengguna mengenai pelatihan yang diregistrasikan.</div>
                </div>
            </div>
            <form class="form-block" action="{{ route('admin::finance.invoices.update', ['invoice' => $invoice->id, 'next' => $back]) }}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT')
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-file-outline"></i> Invoice
                    </div>
                    <div class="card-body border-top">
                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label required">No invoice</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror border-0" name="code" value="{{ old('code', $invoice->code) }}" readonly>
                                </div>
                                @error('code')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label required">Nama pengguna</label>
                            <div class="col-md-6">
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih pengguna --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id', $invoice->user_id) == $user->id)>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-lg-3 col-form-label">Tenggat waktu</label>
                            <div class="col-md-8">
                                <input type="datetime-local" class="form-control @error('due_at') is-invalid @enderror" name="due_at" value="{{ old('due_at', $invoice->due_at) }}">
                                @error('due_at')
                                    <small class="text-danger d-block"> {{ $message }} </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <i class="mdi mdi-table"></i> Item invoice
                    </div>
                    <div class="table-responsive border-top">
                        <table class="table-bordered table">
                            <thead>
                                <tr>
                                    <th>Nama item</th>
                                    <th>Harga</th>
                                    <th class="p-1" width="10">
                                        <button type="button" class="btn btn-soft-success bg-transparent" onclick="addItem()"><i class="mdi mdi-plus-circle-outline"></i></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody-items"></tbody>
                            <tbody>
                                <tr>
                                    <td>Total</td>
                                    <td class="p-1">
                                        <div class="input-group">
                                            <div class="input-group-text border-0 bg-transparent">Rp</div>
                                            <input class="form-control border-0 bg-transparent text-end" name="final_price" type="number" readonly>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card card-body border-0">
                    <div>
                        <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Simpan</button>
                        <a class="btn btn-light" href="{{ $back }}"><i class="mdi mdi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <template id="item-template">
        <tr>
            <td nowrap class="p-1">
                <input class="d-none" type="hidden" data-name="itemable_type" value="{{ old('itemable_type', $invoice->itemable_type) }}">
                <select data-name="itemable_id" id="itemable_id" class="form-select @error('itemable_id') is-invalid @enderror" required>
                    <option value="">-- Pilih item --</option>
                    @foreach ($itemables as $model => $items)
                        <optgroup label="{{ $model }}">
                            @forelse($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->name }}</option>
                            @empty
                                <option disabled>Tidak ada {{ strtolower($model) }}</option>
                            @endforelse
                        </optgroup>
                    @endforeach
                </select>
                @error('itemable_id')
                    <small class="text-danger d-block"> {{ $message }} </small>
                @enderror
            </td>
            <td nowrap class="p-1" style="width: 180px;">
                <div class="input-group flex-nowrap" style="width: 180px;">
                    <div class="input-group-text bg-transparent">Rp</div>
                    <input class="form-control text-end" type="number" data-name="price" onkeyup="calculatePrice()">
                </div>
            </td>
            <td nowrap class="p-1" width="10">
                <button type="button" class="btn btn-soft-danger bg-transparent" onclick="deleteItem(event)"><i class="mdi mdi-trash-can-outline"></i></button>
            </td>
        </tr>
    </template>
    <script>
        const itemTemplate = document.getElementById('item-template')
        const tbodyItems = document.getElementById('tbody-items')

        const addItem = (itemable_type = false, itemable_id = false) => {
            let el = itemTemplate.content.cloneNode(true);
            let id = el.querySelector('[data-name="itemable_id"]').id = `ts-${Math.floor(Math.random() * 10000)}`;

            el.querySelector('[data-name="itemable_id"]').addEventListener('change', e => {
                const group = e.target.querySelector(':checked').closest('optgroup');
                document.querySelector('[data-name="itemable_type"]').value = group && group.label ? group.label : '';
                group.closest('tr').querySelector('[data-name="price"]').value = e.target.querySelector(':checked').dataset.price;
                calculatePrice();
            })

            if (itemable_type && itemable_id) {
                el.querySelector('[data-name="itemable_type"]').value = itemable_type;
                el.querySelector(`[label="${itemable_type}"]`).querySelector(`[value="${itemable_id}"]`).selected = 'selected';
            }

            tbodyItems.appendChild(el);

            renderTbodyInput();
        }

        const deleteItem = (e) => {
            e.currentTarget.closest('tr').remove();
            renderTbodyInput();
            calculatePrice();
        }

        const renderTbodyInput = () => {
            [...tbodyItems.querySelectorAll('tr')].forEach((tr, i) => {
                [...tr.querySelectorAll('[data-name]')].forEach(el => {
                    el.name = `items[${i}][${el.dataset.name}]`;
                })
            })
        }

        const calculatePrice = () => {
            let prices = [...tbodyItems.querySelectorAll('[data-name="price"]')].map(el => parseFloat(el.value || 0));
            document.querySelector('[name="final_price"]').value = prices.length ? prices.reduce((r, n) => r + n) : 0
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if (old('items', $invoice->items))
                const items = @json(old('items', $invoice->items));
                for (item of items) {
                    addItem(item.itemable_label, item.itemable_id)
                }
            @endif
        })
    </script>
@endpush
