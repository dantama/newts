<div class="card border-0">
    <div class="card-body border-bottom">
        <input wire:model.live="search" type="text" class="form-control my-3" placeholder="Search area name">
    </div>
    <div class="table-responsive">
        <table class="table-hover table-sortable mb-0 table align-middle">
            <thead>
                <tr role="row">
                    <th class="text-center">#</th>
                    <th wire:click="sort('name')" class="sort">Nama Area</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Tabel</th>
                    <th class="text-center">Kategori</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($evaluations as $evaluation)
                    <tr @if ($evaluation->trashed()) class="text-muted" @endif>
                        <td class="text-center">{{ $loop->iteration + $evaluations->firstItem() - 1 }}</td>
                        <td style="min-width: 200px;" class="py-3">
                            <div>{{ $evaluation->name }}</div>
                        </td>
                        <td>{{ $evaluation->description }}</td>
                        <td class="text-center">{{ $evaluation->tables->count() ?? 0 }}</td>
                        <td class="text-center">{{ $evaluation->categories->count() ?? 0 }}</td>
                        <td nowrap class="py-1 text-end">
                            @if ($evaluation->trashed())
                                @can('restore', $evaluation)
                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::evaluation.areas.restore', ['area' => $evaluation->id, 'next' => url()->full()]) }}" method="post"> @csrf @method('put')
                                        <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                    </form>
                                @endcan
                            @else
                                @can('store', Modules\Evaluation\Models\Evaluation::class)
                                    <a class="btn btn-soft-secondary rounded px-2 py-1" href="{{ route('admin::evaluation.areas.tables.index', ['area' => $evaluation->id, 'next' => url()->full()]) }}" data-bs-toggle="tooltip" title="Pembagian tabel pertanyaan"><i class="mdi mdi-file-table-box-multiple-outline"></i></a>
                                @endcan
                                @can('update', $evaluation)
                                    <a class="btn btn-soft-warning rounded px-2 py-1" href="{{ route('admin::evaluation.areas.edit', ['area' => $evaluation->id, 'next' => url()->full()]) }}" method="post" data-bs-toggle="tooltip" title="Ubah"><i class="mdi mdi-pencil-outline"></i></a>
                                @endcan
                                @can('destroy', $evaluation)
                                    <form class="form-block form-confirm d-inline" action="{{ route('admin::evaluation.areas.destroy', ['area' => $evaluation->id, 'next' => url()->full()]) }}" method="post"> @csrf @method('delete')
                                        <button class="btn btn-soft-danger rounded px-2 py-1" data-bs-toggle="tooltip" title="Hapus"><i class="mdi mdi-trash-can-outline"></i></button>
                                    </form>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">@include('components.notfound')</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $evaluations->appends(request()->all())->links() }}
    </div>
</div>
