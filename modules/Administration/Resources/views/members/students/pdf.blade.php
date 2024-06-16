<html>
<head>
	<title>Daftar Siswa</title>
	<style>
		body {
			font-size: 10pt;
			line-height: 1.2;
		}
		table {
			border-collapse: collapse;
  			width: 100%;
		}
		table tr td,
		table tr {
			font-size: 10pt;
		}
		th {
			height: 20px;
		}
	</style>
</head>
<body>
	<div>
		<table class="table" border="0" style="border-bottom:2px solid #ada7a7;">
			<tr>
				<td width="100px"><img src="{{ asset('img/logo/tapak-suci-png-5.png') }}" alt="logo" width="90px"></td>
				<td>
					<p style="line-height: 0.5;"><strong>PIMPINAN PUSAT</strong></p>
					<p style="line-height: 0.5;"><strong>PERGURUAN SENI BELADIRI INDONESIA</strong></p>
					<h4 style="line-height: 0.5;">TAPAK SUCI PUTERA MUHAMMADIYAH</h4>  
					<p>Kantor Pusat: Jl. Taqwa No. 8 Notoprajan Yogyakarta 55262 Telp. (0274) 381826. email : pimpinanpusat_tapaksuci@yahoo.com. Website : www.tapaksuci.or.id</p>
				</th>	 
				</td>
			</tr>			
		</table>
	</div>
	<div><p>DAFTAR SISWA</p></div>
	<div>
		<table class="table" border="1" style="border-bottom:2px solid #ada7a7;">
			<thead>
				<tr>
					<td>No</td>
					<td>Nama</td>
					<td>Tingkat</td>
					<td>Telp</td>
					<td>Email</td>
					<td>Alamat</td>
				</tr>
			</thead>
			<tbody>
				@foreach($members as $m)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $m->user->profile->name }}</td>
					<td>{{ $m->levels->last()->detail->name }}</td>
					<td>{{ $m->user->phone->number ?? 'belum diisi' }}</td>
					<td>{{ $m->user->email->address ?? 'belum diisi' }}</td>
					<td>{{ $m->user->address->branch ?? 'belum diisi' }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</body>
</html>