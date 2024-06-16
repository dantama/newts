<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="http://fonts.cdnfonts.com/css/aller?styles=27,24,22,21,23,25" rel="stylesheet">
    <style>
        @page {
            /*size: 3.47in, 2.15in;*/
            /*margin: 0.05in, 0.05in, 0.05in, 0.05in;*/
            margin: 0mm 5mm 5mm 5mm;
        }

        @font-face {
            font-family: 'Aller';
            font-style: normal;
            font-weight: normal;
            src: url({{ asset('fonts/Aller_Rg.ttf') }}) format('truetype');
        }

        html,
        body {
            /*font-family: "Lucida Console", "Courier New", monospace;*/
            font-family: 'Aller', sans-serif;

        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0;
        }

        small {
            font-size: .75rem;
        }

        .alnright {
            text-align: right;
        }

        .alnleft {
            text-align: left;
        }

        .f12 {
            font-size: 12px;
        }

        .f10 {
            font-size: 10px;
        }

        .f7 {
            font-size: 7px;
        }
    </style>
</head>

<body>

    <div>
        <img src="{{ asset('storage/img/bg-front-new1.jpeg') }}" style="position: absolute; z-index: -1; top: 0mm; left: -5mm; width: 240.945pt; height: 155.906pt;">
        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(@$member->user->profile->avatar_path)) }}" style="position: absolute; right: .3cm; bottom: -1.25in; height: 60px; width: 45px; border: 1.5px solid #fff; border-radius: 30%;">
        {{-- <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->errorCorrection('H')->color(255,0,0)->size(200)->generate($param)) }}" style="position: absolute; top: 15mm; left: 10mm; z-index: 9999; height: 1.1cm; width: 1.1cm; border: 2px solid #fff;"> --}}
        @php($qr = asset('storage/' . $member->qr))
        <img src="{{ $qr }}" style="position: absolute; top: 15mm; left: 10mm; z-index: 9999; height: 1.1cm; width: 1.1cm; border: 2px solid #fff;">
        <div style="margin: 3.1cm .1cm -1cm .4cm">
            <table width="100%" style="line-height: .4em margin-left: .3cm" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" class="alnright" style="color: white; padding-top: .2cm;">
                        <p class="f12 alnright" style="margin: 3px -10 0 0; letter-spacing: 3px;">{{ str_replace('-', ' ', $member->nbts) }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="alnright" style="color: white; padding-left: .1cm;">
                        <table width="100%" border="0">
                            <tr>
                                <td class="alnright" style="color: white; padding-left: .1cm;">
                                    <p class="f7">Member</p>
                                    <p class="f7">Since</p>
                                </td>
                                <td class="alnright" style="color: white; padding-left: .1cm;" width="12%">
                                    <p class="f12">| {{ substr($member->joined_at, -2) ?? '00' }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="alnleft" width="25%" style="color: white;">
                        <p class="f7" style="margin-left: 7mm;">Created</p>
                        <p class="f10" style="margin-top: 3px; margin-left: 7mm;"><b>{{ date('m/y') }}</b></p>
                    </td>
                    <td class="alnright" style="color: white; padding-left: .1cm;">
                        <p class="f10" nowrap style="margin-top: 3px;">{{ $member->user->profile->name }}</p>
                        <p class="f10" style="margin-top: 3px; letter-spacing: 2px; margin-right: -2px;">{{ optional($member->levels->last())->detail->name }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div style="page-break-after: always;"></div>

    <!-- <div>
  <img src="{{ asset('img/belakang.jpg') }}" style="position: absolute; z-index: -1; width: 3.37in, height: 2.2in;">
  <div style="margin: .8cm;">
  </div>
 </div> -->
    <div>
        <img src="{{ public_path('img/bg-back-new.jpeg') }}" style="position: absolute; z-index: -1; top: 0mm; left: -5mm; width: 240.945pt; height: 155.906pt;">
        <div style="margin: .8cm;">
            <table style="width: 100%; margin-left: .8cm; margin-top: 1cm;">
                <tbody>
                    @foreach ([
        'Pimda' => str_pad($member->regency->pimda_code, 3, '0', STR_PAD_LEFT) . ' - ' . $member->regency->name ?? '',
        'Pimwil' => $member->regency->management->pimwil_code . ' - ' . $member->regency->management->name ?? '',
    ] as $k => $v)
                        <tr style="font-size: .6rem;">
                            <td style="color: white;">
                                {{ $k }}
                            </td>
                            <td style="color: white;">
                                : {{ $v }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
