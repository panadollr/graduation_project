<div class="d-flex align-items-center">
    <label class="me-2 fw-bold">{{ $label }}</label>
    <div class="dropdown">
        <button class="btn btn-inverse btn-fw dropdown-toggle border" style="border-width: 3px !important; " type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ $selectedLabel }}
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="#" wire:click.prevent="{{ $clickAction }}(null)">
                    Tất cả
                </a>
            </li>
            @foreach($items as $key => $item)
                <li class="dropdown-item-with-children">
                    <a class="dropdown-item" href="#" wire:click.prevent="{{ $clickAction }}('{{ $key }}')">
                        {{ $item }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
