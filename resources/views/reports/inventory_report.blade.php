@extends('layouts.app')

@section('title', 'Inventory Report')

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="page-header report">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Inventory Report</h4>
                <h6>View and manage your inventory</h6>
            </div>
        </div>
    </div>

    <!-- Report filter -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.inventory') }}" method="GET">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>Category</label>
                            <select name="category_id" class="select2">
                                <option value="">All Categories</option>
                                @foreach (App\Models\MedicineCategory::all() as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>Medicine Type</label>
                            <select name="type_id" class="select2">
                                <option value="">All Types</option>
                                @foreach (App\Models\MedicineType::all() as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>Stock Status</label>
                            <select name="stock_status" class="select2">
                                <option value="">All Stock</option>
                                <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In
                                    Stock</option>
                                <option value="out_of_stock"
                                    {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>
                                    Low Stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="input-blocks">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('reports.inventory') }}" class="btn btn-info ms-2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Inventory Summary -->
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalInventoryValue, 2) }}</h4>
                    <h5>Total Inventory Value (Selling Price)</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12 d-flex">
            <div class="dash-count border">
                <div class="dash-counts">
                    <h4>{{ show_amount($totalInventoryCost, 2) }}</h4>
                    <h5>Total Inventory Cost (Purchase Price)</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory List -->
    <div class="card table-list-card">
        <div class="card-body">
            <div class="table-responsive product-list">
                <table class="table datanew list">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Unit</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Quantity</th>
                            <th>Total Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicines as $medicine)
                            <tr>
                                <td>{{ $medicine->name }}</td>
                                <td>
                                    @forelse ($medicine->medicine_categories as $category)
                                        {{ $category->name }}
                                    @empty
                                        N/A
                                    @endforelse
                                </td>
                                <td>{{ $medicine->medicine_type ? $medicine->medicine_type->name : 'N/A' }}</td>
                                <td>{{ $medicine->unit ? $medicine->unit->name : 'N/A' }}</td>
                                <td>{{ show_amount($medicine->purchase_price, 2) }}</td>
                                <td>{{ show_amount($medicine->sale_price, 2) }}</td>
                                <td>{{ $medicine->quantity }}</td>
                                <td>{{ show_amount($medicine->quantity * $medicine->sale_price, 2) }}</td>
                                <td>
                                    @if ($medicine->quantity <= 0)
                                        <span class="badge badge-linedangered">Out of Stock</span>
                                    @elseif($medicine->quantity <= $medicine->alert_qty)
                                        <span class="badges-warning">Low Stock</span>
                                    @else
                                        <span class="badge-linesuccess">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush
