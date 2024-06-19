@extends('layouts.dompdf')

@push('styles')
    <style>
        @page {
            margin: 5mm 5mm;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
            font-size: 9pt;
            line-height: 11pt;
        }

        table.no-padding-and-small th,
        table.no-padding-and-small td {
            padding: 1px 0px;
            font-size: 8pt;
        }

        th {
            background: #111;
            color: white;
        }

        table.table-border-bottom {
            border-collapse: collapse;
        }

        table.table-border-bottom td {
            border: 1px solid #eee;
        }
    </style>
@endpush

@section('content')
    <div>
        <img src="{{ public_path('img/logo/pemadttc.png') }}" alt="" width="128">
    </div>
    <br>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%">Tagihan kepada</td>
            <td style="text-align: right; font-size: 12pt;"><strong>INVOICE</strong></td>
        </tr>
        <tr>
            <td rowspan="2">
                <div><strong>{{ $invoice->user->name }}</strong></div>
                <div>{{ implode(', ', array_filter([$invoice->user->getMeta('address_primary'), $invoice->user->getMeta('address_secondary'), $invoice->user->getMeta('address_city')])) }}</div>
            </td>
            <td style="text-align: right;">Tanggal: {{ $invoice->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>{{ $invoice->code }}</strong></td>
        </tr>
    </table>
    <br>
    <table class="table-border-bottom" style="width: 100%;">
        <tr>
            <th width="1%">No.</th>
            <th>Tanggal</th>
            <th width="36%">Keterangan</th>
            <th colspan="2" style="text-align: center;">Unit</th>
            <th width="16%" style="text-align: right;">Harga unit (Rp)</th>
            <th width="16%" style="text-align: right;">Jumlah (Rp)</th>
        </tr>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->created_at?->format('d M Y') }}</td>
                <td>
                    <div><strong>{{ $item->itemable->name }}</strong></div>
                    @isset($item->itemable->levels)
                        <div style="font-size:8pt;">{{ $item->itemable->levels->pluck('name')->join(', ', ' dan ') }}</div>
                    @endisset
                </td>
                <td style="text-align: center;">1</td>
                <td style="text-align: center;">{{ $item->itemable_label }}</td>
                <td style="text-align: right;">{{ Str::money($item->price, 0) }}</td>
                <td style="text-align: right;">{{ Str::money($item->price * 1, 0) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"></td>
            <td colspan="3" style="text-align: right;">PPN 11%</td>
            <td style="text-align: right;">{{ Str::money($tax = $invoice->items->sum('price') * ($tax_value = 0), 0) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <th colspan="3" style="text-align: right;">Total</th>
            <th style="text-align: right;">{{ Str::money($invoice->items->sum('price') + $tax, 0) }}</th>
        </tr>
    </table>
    <br>
    <footer style="position: absolute; bottom: 0; width: 100%;">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div><strong>Bank Account</strong></div>
                        <div style="font-size: 8pt;"><strong>Bank Negara Indonesia (BNI)</strong></div>
                        <table class="no-padding-and-small" style="width: 100%; font-size: 8pt;">
                            <tr>
                                <td>Acc. Name</td>
                                <td>: PT. Pemad International Transearch</td>
                            </tr>
                            <tr>
                                <td>Acc. Number</td>
                                <td>: 2748895677</td>
                            </tr>
                            <tr>
                                <td>Bank Address</td>
                                <td>: Jl. Kaliurang KM. 4 Bulaksumur Blok H No. 4 Yogyakarta, Indonesia</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>: 62(0)274 561019</td>
                            </tr>
                            <tr>
                                <td>Swift Code</td>
                                <td>: BNINIDJA</td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                    <td style="text-align: center;">
                        <div style="height: 75px;"></div>
                        <div><strong>Alwi Atma Ardhana</strong></div>
                        <div><i>Operational Manager</i></div>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <div style="color: #778; font-size: 7pt; text-align: center;">Mohon konfirmasi dan memberikan keterangan saat melakukan pembayaran melalui transfer.</div>
    </footer>
@endsection
