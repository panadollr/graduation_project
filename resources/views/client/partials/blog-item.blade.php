<article class="entry entry-grid">
    <figure class="entry-media">
        <a >
            <img src="{{ Storage::url($item->image) }}" alt="image desc">
        </a>
    </figure><!-- End .entry-media -->

    <div class="entry-body">
        <div class="entry-meta">
            <a href="#">Ngày đăng: {{ optional($item->created_at)->format('d/m/Y') }}</a>
        </div><!-- End .entry-meta -->

        <h2 class="entry-title">
            <a wire:navigate href="{{ route('blog.detail', ['slug' => $item->slug ])}}">{{ $item->title }}</a>
        </h2><!-- End .entry-title -->

        <div class="entry-cats">
            {{ $item->category->name }}
        </div><!-- End .entry-cats -->
    </div><!-- End .entry-body -->
</article><!-- End .entry -->