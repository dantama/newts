<div class="row justify-content-between">
    <div class="col-xl-5 col-lg-6 mb-lg-0 mb-3">
        <div class="input-group">
            <div class="input-group-text">Showing</div>
            <select class="form-select w-25" wire:model.live="limit">
                @foreach ([5, 10, 25, 50, 100] as $limiter)
                    <option value="{{ $limiter }}" @if (request('limit', 10) == $limiter) selected @endif>{{ $limiter }}</option>
                @endforeach
            </select>
            <div class="input-group-text">items</div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-6">
        @if ($paginator->hasPages())
            <div class="input-group">
                <a class="btn btn-light text-secondary @if ($paginator->onFirstPage()) text-muted @else text-dark @endif" style="font-size:12pt; line-height: 1.3rem;" wire:click="gotoPage(1)" wire:loading.attr="disabled">&laquo;</a>
                <a class="btn btn-light text-secondary @if ($paginator->onFirstPage()) text-muted @else text-dark @endif" style="font-size:12pt; line-height: 1.3rem;" wire:click="previousPage" wire:loading.attr="disabled">&lsaquo;</a>
                <div class="input-group-text">Page</div>
                <select class="form-select w-25" wire:change="gotoPage($event.target.value)">
                    @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                        <option value="{{ $page }}" @if (request('page') == $page) selected @endif>{{ $page }}</option>
                    @endfor
                </select>
                <a class="btn btn-light text-secondary @if ($paginator->hasMorePages()) text-dark @endif" style="font-size:12pt; line-height: 1.3rem;" wire:click="nextPage" wire:loading.attr="disabled">&rsaquo;</a>
                <a class="btn btn-light text-secondary @if ($paginator->hasMorePages()) text-dark @endif" style="font-size:12pt; line-height: 1.3rem;" wire:click="gotoPage({{ $paginator->lastPage() }})" wire:loading.attr="disabled">&raquo;</a>
            </div>
        @endif
    </div>
</div>
