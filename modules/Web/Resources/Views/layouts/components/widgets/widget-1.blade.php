<div class="mb-4">
    @forelse($posts as $post)
        <a class="text-dark" href="{{ route('web::read', ['category' => $post->category()->slug, 'slug' => $post->slug]) }}">
            <div class="d-flex align-items-center justify-content-between mb-2 flex-row">
                <div class="me-2 rounded" style="background: url({{ Storage::exists($post->img) ? Storage::url($post->img) : asset('img/logo/logo-icon.png') }}) center center no-repeat; background-size: cover; min-width: 45px; height: 45px;"></div>
                <div class="flex-grow-1">
                    <div class="fw-bold">{{ Str::limit(ucfirst(Str::lower($post->title)), 50) }}</div>
                    <div class="text-muted">
                        <i class="fas fa-sm fa-eye"></i> <small>{{ $post->views_count }}</small>
                        <i class="fas fa-sm fa-comment"></i> <small>{{ $post->comments_count }}</small>
                        <i class="fas fa-sm fa-calendar"></i> <small>{{ $post->created_at ? $post->created_at->ISOFormat('L') : '-' }}</small>
                    </div>
                </div>
            </div>
        </a>
    @empty
        Tidak ada postingan
    @endforelse
</div>
