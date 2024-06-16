<form wire:submit.prevent="submit">
    <div class="d-flex">
        <input name="trash" type="hidden" value="{{ request('trash') }}">
        <div class="flex-grow-1 col-auto">
            <input class="form-control" name="search" placeholder="Cari nama, username, atau email ..." value="{{ request('search') }}" />
        </div>
        <div class="col-auto">
            <a class="btn btn-light" href="{{ route('admin::evaluation.areas.index', request()->only('trashed', 'closed')) }}"><i class="mdi mdi-refresh"></i> <span class="d-sm-none">Reset</span></a>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-dark"><i class="mdi mdi-magnify"></i> Cari</button>
        </div>
    </div>
</form>
