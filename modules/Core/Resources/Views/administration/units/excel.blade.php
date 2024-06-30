<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div class="header">
        <h3>Daftar unit</h3>
        <br>
    </div>
    <table class="table-striped table">
        <thead>
            <tr>
                <th>#</th>
                <th>Unit ID</th>
                <th>Pimda</th>
                <th>Pimda Kode</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>NBTS</th>
                <th>NBM</th>
                <th>Tanggal bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($units as $unit)
                <tr @if ($unit->trashed()) class="table-light text-muted" @endif>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->getMeta('org_code') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br>
</body>

</html>
