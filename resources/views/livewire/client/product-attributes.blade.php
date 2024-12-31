<div>
    @foreach ($productAttributes as $attributeId => $options)
    <div class="details-filter-row details-row-size">
        <label>{{ $options->first()->attribute->name }}:</label>
        @foreach($options as $option)
        <li class="color-item"
            wire:click="selectOption({{ $attributeId }}, {{ $option->id }})"
            style="cursor: pointer; {{ isset($selectedOptions[$attributeId]) && $selectedOptions[$attributeId] == $option->id ? 'font-weight: bold; color: red;' : '' }}">
            {{ $option->value }}
        </li>
        @endforeach
    </div>
    @endforeach

    <h3>Thông tin SKU</h3>
    @if ($selectedSku)
        <div>
            <p><strong>Mã SKU:</strong> {{ $selectedSku->code }}</p>
            <p><strong>Giá:</strong> {{ $selectedSku->price }} ₫</p>
            <img src="{{ $selectedSku->image_url }}" alt="">
            <p><strong>Số lượng:</strong> {{ $selectedSku->quantity }}</p>
        </div>
    @else
        <p>Chọn các thuộc tính để xem SKU.</p>
    @endif
</div>
