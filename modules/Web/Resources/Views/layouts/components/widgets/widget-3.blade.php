<div class="row no-gutters">
    @forelse($posts as $post)
        @if ($post->img)
            <a class="col-6 text-dark mb-2 p-1" href="{{ route('web::read', ['category' => $post->category()->slug, 'slug' => $post->slug]) }}">
                <div class="mb-2">
                    <img class="img-fluid rounded shadow-sm" src="{{ Storage::exists($post->img) ? Storage::url($post->img) : asset('img/gallery/tapak-suci.png') }}" alt="" style="width: 250px; height: 120px;">
                </div>
                {{ Str::limit(ucfirst(Str::lower($post->title)), 50) }}
            </a>
        @endif
    @empty
        Tidak ada postingan
    @endforelse
</div>
