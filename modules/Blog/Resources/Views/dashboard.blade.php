@extends('blog::layouts.default')

@section('title', 'Dashboard ')

@php
    $user = Auth::user();
    $stats = [
        [
            'icon' => 'mdi mdi-cash-check',
            'color' => 'warning',
            'count' => \Modules\Blog\Models\BlogCategory::count(),
            'desc' => 'Kategori',
        ],
        [
            'icon' => 'mdi mdi-ticket-confirmation-outline',
            'color' => 'danger',
            'count' => \Modules\Blog\Models\BlogPost::count(),
            'desc' => 'Artikel',
        ],
        [
            'icon' => 'mdi mdi-account-box-multiple-outline',
            'color' => 'primary',
            'count' => \Modules\Blog\Models\Subscriber::count(),
            'desc' => 'Jumlah Subscriber',
        ],
        [
            'icon' => 'mdi mdi-account-group-outline',
            'color' => 'success',
            'count' => \Modules\Blog\Models\BlogPostComment::count(),
            'desc' => 'Jumlah Komentar',
        ],
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-body border-0 p-1">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between">
                    <div>
                        <img class="w-100" src="{{ asset('img/manypixels/Designer_Flatline.svg') }}" alt="" style="height: 160px;">
                    </div>
                    <div class="order-md-first text-md-start text-center">
                        <div class="px-4 py-3">
                            <h2 class="fw-normal">Selamat datang {{ $user->name }}!</h2>
                            <div class="text-muted">di Admin {{ config('app.name') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($stats as $stat)
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card card-body position-relative border-0">
                            <div class="position-absolute" style="right: 1.5rem; top: 1.75rem;">
                                <i class="{{ $stat['icon'] }} mdi-36px text-{{ $stat['color'] }}"></i>
                            </div>
                            <div class="display-4">{{ $stat['count'] }}</div>
                            <div class="text-muted small">{{ $stat['desc'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0">
                <div class="card-body">
                    <i class="mdi mdi-google-classroom"></i> Komentar baru
                </div>
                <div class="list-group list-group-flush border-top">
                    <div class="list-group-item py-4 text-center">
                        <img class="w-100" src="{{ asset('img/manypixels/Online_report_Flatline.svg') }}" alt="" style="height: 140px;">
                        <div class="text-muted">Tidak ada komentar baru</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
