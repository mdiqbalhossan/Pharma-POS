<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>{{ $title }}</h4>
            <h6>{{ $subtitle }}</h6>
        </div>
    </div>
    @if (isset($button))
        <div class="page-btn">
            <a href="{{ $button['url'] }}" class="btn btn-added"><i data-feather="{{ $button['icon'] }}" class="me-2"></i>
                {{ $button['text'] }}</a>
        </div>
    @endif
</div>
<!-- /product list -->
