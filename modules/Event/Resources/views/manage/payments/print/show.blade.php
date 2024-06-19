@extends('layouts.dompdf')

@php($invoice = $transaction->invoice)
@section('title', 'Bukti Pembayaran - ' . $transaction->code)

@push('styles')
    <style>
        @page {
            margin: 5mm 5mm;
        }

        p {
            font-size: 10pt;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
            line-height: 11pt;
            font-size: 10pt;
        }

        table.no-padding-and-small th,
        table.no-padding-and-small td {
            padding: 1px 0px;
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
    <div style="margin-bottom: 8px;">
        <img src="{{ public_path('img/tanda-terima-header.jpg') }}" alt="" style="width: 100%;">
    </div>
    <div style="padding: 12px 12px; background: #eee;margin-bottom: 8px;">
        <h3 style="text-align: center; font-weight: normal; margin: 0;">Tanda Terima Pembayaran</h3>
    </div>
    <table style="margin-bottom: 8px;">
        <tr>
            <td style="padding-left: 20px;">Nomor</td>
            <td>:</td>
            <td>{{ $transaction->code }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Tanggal</td>
            <td>:</td>
            <td>{{ $transaction->paid_at }}</td>
        </tr>
    </table>
    <p style="margin-bottom: 8px; margin-top: 0;">Telah menerima pembayaran/Cek/Giro sebagai berikut:</p>
    <table style="margin-bottom: 8px;">
        <tr>
            <td style="padding-left: 20px;">Telah diterima dari</td>
            <td>:</td>
            <td>{{ $transaction->payer }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Dengan jumlah</td>
            <td>:</td>
            <td><strong>{{ Str::money($transaction->paid_amount) }}</strong></td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Jumlah terbilang</td>
            <td>:</td>
            <td>{{ inwords($transaction->paid_amount) }} rupiah</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Keterangan</td>
            <td>:</td>
            <td> Pendaftaran {{ $transaction->invoice->items->first()->itemable->name }}</td>
        </tr>
    </table>
    <hr>
    <footer style="position: absolute; bottom: 0; width: 100%;">
        <div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 70%;"></td>
                    <td style="text-align: center; width: 30%;">
                        <div style="z-index: 10;">Mengetahui</div>
                        <div style="height: 45px;">
                            <img style="max-width: 200px; margin-top: -10px; z-index: 0;" src="{{ public_path('img/ttd-ulfah+cap.jpg') }}" alt="">
                        </div>
                        <div><strong>Keuangan</strong></div>
                        <hr>
                        <div><small>{{ now()->isoFormat('LL') }}</small></div>
                    </td>
                </tr>
            </table>
        </div>
    </footer>
@endsection
