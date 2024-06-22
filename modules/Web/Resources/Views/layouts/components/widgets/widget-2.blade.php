<div class="list-group list-group-flush">
    @forelse($posts->load('categories') as $post)
        <a class="list-group-item list-group-item-action @if ($loop->last) border-bottom-0 @endif @if ($loop->first) border-top-0 @endif px-0" style="border-top-style: dotted;" href="{{ route('web::read', ['category' => $post->category()->slug, 'slug' => $post->slug]) }}">
            <span class="d-flex justify-content-between align-items-center flex-row">
                <i class="fas fa-sm fa-chevron-right mr-2"></i>
                <div class="flex-grow-1">
                    <div class="small">
                        @foreach ($post->categories as $category)
                            <strong class="text-danger">{{ $category->name }}</strong>
                        @endforeach
                    </div>
                    {{ Str::limit(ucfirst(Str::lower($post->title)), 50) }}
                </div>
            </span>
        </a>
    @empty
        Tidak ada postingan
    @endforelse
</div>
