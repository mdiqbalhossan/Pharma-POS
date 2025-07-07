@if (session()->has('store_id'))
    @php
        $currentStore = \App\Models\Store::find(session('store_id'));
    @endphp
    <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="storeDropdown" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fas fa-store me-1"></i>
            {{ $currentStore->name }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="storeDropdown">
            <li><span class="dropdown-item-text">Current Store</span></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('store.change') }}">
                    <i class="fas fa-exchange-alt me-1"></i> Change Store
                </a></li>
        </ul>
    </div>
@endif
