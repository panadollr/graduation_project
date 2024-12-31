@props([
    'sortable' => null,
    'direction' => null,
    'onSort' => null, // Add this prop for the sort action callback
])

<th>
    @unless($sortable)
        <!-- Không có khả năng sắp xếp -->
        <span>{{ $slot }}</span>
    @else
        <!-- Có khả năng sắp xếp -->
        <button class="btn btn-link p-0 m-0 text-decoration-none" wire:click="{{ $onSort }}" style="color: inherit;">
            <span>{{ $slot }}</span>
            <!-- Hiển thị mũi tên nếu đang sắp xếp -->
            @if($direction === 'asc')
                <i class="fa fa-sort-asc"></i> <!-- Mũi tên lên (sắp xếp tăng dần) -->
            @elseif($direction === 'desc')
                <i class="fa fa-sort-desc"></i> <!-- Mũi tên xuống (sắp xếp giảm dần) -->
            @endif
        </button>
    @endunless
</th>
