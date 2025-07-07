@extends('layouts.app')

@section('title', 'Select Store')

@section('content')
    <div class="container-fluid px-4">
        <h3 class="my-4">Select Store</h3>

        <div class="row">
            @foreach ($stores as $store)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ photo_url($store->cover_image) }}" alt="{{ $store->name }}"
                                        class="img-fluid rounded" style="width: 60px; height: 60px;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="card-title mb-0">{{ $store->name }}</h4>
                                    <p class="text-muted mb-0">Store Code: {{ str_pad($store->id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                    <span>Address: {{ $store->address }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    <span>Phone: {{ $store->phone }}</span>
                                </div>
                                @if ($store->email)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope me-2 text-muted"></i>
                                        <span>Email: {{ $store->email }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between">
                                <form action="{{ route('store.set') }}" method="POST" class="me-2">
                                    @csrf
                                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt"></i> Enter
                                    </button>
                                </form>

                                <div class="d-flex">
                                    <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
