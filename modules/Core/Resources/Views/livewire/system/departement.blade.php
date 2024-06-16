<div class="card border-0">
    <div class="card-body border-bottom">
        <div class="d-flex justify-content-between">
            <div>
                <i class="mdi mdi-format-list-bulleted"></i> Daftar supplier
            </div>
            <div class="flex-end flex-grow">
                @if (!$isCreating)
                    @can('store', App\Models\Departement::class)
                        <button class="btn btn-sm btn-outline-secondary" wire:click="showCreateForm"><i class="mdi mdi-plus-circle-outline"></i> Tambah Supplier</button>
                    @endcan
                @endif
            </div>
        </div>
    </div>
    @if ($isCreating)
        <div class="card-body">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'save' }}">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" class="form-control" wire:model="name">
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" wire:model="email">
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">+62</span>
                        <input type="text" id="phone" class="form-control" wire:model="phone">
                    </div>
                    @error('phone')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Address</label>
                    <textarea id="address" class="form-control" wire:model="address"></textarea>
                    @error('address')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-soft-primary" type="submit"><i class="mdi mdi-content-save"></i> {{ $isEditing ? 'Perbarui' : 'Simpan' }}</button>
                <button class="btn btn-soft-danger" type="button" wire:click="hideCreateForm"><i class="mdi mdi-sync"></i> Batalkan</button>
            </form>
        </div>
    @endif
    @if (!$isCreating)
        <div class="card-body border-bottom">
            <input wire:model.live="search" type="text" class="form-control my-3" placeholder="Search supplier name">
        </div>
        <div class="table-responsive">
            <table class="table-hover table-sortable mb-0 table align-middle">
                <thead>
                    <tr role="row">
                        <th class="text-center">#</th>
                        <th wire:click="sort('name')" class="sort">Nama</th>
                        <th>Visibilitas</th>
                        <th class="text-center">Jumlah jabatan</th>
                        <th class="text-center">Tanggal pembuatan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departements as $dept)
                        <tr @if ($dept->trashed()) class="text-muted" @endif>
                            <td class="text-center">{{ $loop->iteration + $departements->firstItem() - 1 }}</td>
                            <td style="min-width: 200px;" class="py-3">
                                <div>{{ $dept->name }}</div>
                            </td>
                            <td>
                                @if ($dept->is_visible)
                                    <i class="mdi mdi-eye-outline"></i>
                                @else
                                    <i class="mdi mdi-eye-off-outline text-danger"></i>
                                @endif
                            </td>
                            <td class="text-center">{{ $department->positions_count }} jabatan</td>
                            <td class="text-center">{{ $department->created_at->diffForHumans() }}</td>
                            <td nowrap class="py-1 text-end">
                                @if ($dept->trashed())
                                    @can('restore', $dept)
                                        <form class="form-block form-confirm d-inline" action="#" method="post"> @csrf @method('put')
                                            <button class="btn btn-soft-info rounded px-2 py-1" data-bs-toggle="tooltip" title="Pulihkan"><i class="mdi mdi-refresh"></i></button>
                                        </form>
                                    @endcan
                                @else
                                    @can('update', $dept)
                                        <button class="btn btn-soft-primary px-2 py-1" title="Ubah" wire:click="edit({{ $dept->id }})"><i class="mdi mdi-pencil"></i></button>
                                    @endcan
                                    @can('destroy', $dept)
                                        <button class="btn btn-soft-danger px-2 py-1" title="Hapus" wire:click="delete({{ $dept->id }})"><i class="mdi mdi-trash-can"></i></button>
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
            {{ $departements->appends(request()->all())->links() }}
        </div>
    @endif
</div>
