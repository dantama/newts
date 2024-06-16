<!DOCTYPE html>
<html>
<head>
	<title>{{ $title }}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		@page {
			size: 3.54in, 2.29in;
			margin: 0.3;
		}
		html, body {
			font-family: helvetica, arial, sans-serif;
		}
		h1,h2,h3,h4,h5,h6,p {
			margin: 0;
		}
		small {
			font-size: .75rem;
		}
	</style>
</head>
<body>

	<div>
		<img src="{{ asset('img/card-front.jpg') }}" style="position: absolute; z-index: -1; width: 3.54in, height: 2.29in;">
		<div style="margin: 2.6cm .4cm -1cm .4cm">
			<table>
				<tr>
					<td width="50">
						<img src="{{ $member->user->profile->avatar_path }}" style="height: 75px; width: 60px; border: 1.5px solid #fff; border-radius: 30%;">
					</td>
					<td style="color: white; padding-left: .3cm;">
						<h5>KARTU ANGGOTA</h5>
						<p style="margin-top: 3px;"><small>{{ $member->nbts }}</small></p>
						<p nowrap style="margin-top: 3px;"><small>{{ $member->user->profile->name }}</small></p>
						<p style="margin-top: 3px;"><small>{{ optional($member->levels->last())->detail->name }}</small></p>
					</td>
				</tr>
			</table>
		</div>
		{{ Storage::url($member->qr) }}
		<img src="{{ Storage::url($member->qr) }}" style="position: absolute; right: .3cm; bottom: -2in; z-index: 9999; height: .85cm; width: .85cm; border: 2px solid #fff;">
	</div>

	<div style="page-break-after: always;"></div>

	<div>
		<img src="{{ asset('img/card-back.jpg') }}" style="position: absolute; z-index: -1; width: 3.54in, height: 2.29in;">
		<div style="margin: .8cm;">
			<table style="width: 100%;">
				<tbody>
				@foreach([
						'Nama' => $member->user->profile->full_name ?? '',
						'Jenis kelamin' => $member->user->profile->sex_name ?? '',
						'Tpt/tgl lahir' => ($member->user->profile->pob ?? '-').'/'.($member->user->profile->dob_name ?? '-'),
						'Pimda' => $member->regency->name ?? '',
						'Pimwil' => $member->regency->management->name ?? '',
						'Alamat' => $member->user->address->full ?? null
					] as $k => $v)
					<tr style="font-size: .6rem;">
						<td>
							{{ $k }}
						</td>
						<td>
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