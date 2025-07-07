@extends('layouts.app')

@section('title', __('medicine.create_medicine'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => __('medicine.create_medicine'),
        'subtitle' => __('medicine.add_new_medicine'),
    ])

    @include('layouts.partials.alert')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Left Column (col-md-8) for general information -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('medicine.general_information') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ __('medicine.name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}"
                                            placeholder="{{ __('medicine.eg_paracetamol') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="generic_name"
                                            class="form-label">{{ __('medicine.generic_name') }}</label>
                                        <input type="text"
                                            class="form-control @error('generic_name') is-invalid @enderror"
                                            id="generic_name" name="generic_name" value="{{ old('generic_name') }}"
                                            placeholder="{{ __('medicine.eg_paracetamol') }}">
                                        @error('generic_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="input-blocks add-product list">
                                            <label>{{ __('medicine.barcode') }}</label>
                                            <input type="text" class="form-control list"
                                                placeholder="{{ __('medicine.please_enter_barcode') }}" id="barcode"
                                                name="barcode" value="{{ old('barcode') }}">
                                            <button type="button" class="btn btn-primaryadd" id="generate-barcode">
                                                {{ __('medicine.generate_barcode') }}
                                            </button>
                                        </div>
                                        @error('barcode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="add-newplus">
                                            <label for="medicine_type_id"
                                                class="form-label">{{ __('medicine.medicine_type') }} <span
                                                    class="text-danger">*</span></label>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#add-medicine-type"><i data-feather="plus-circle"
                                                    class="plus-down-add"></i><span>{{ __('medicine.add_new') }}</span></a>
                                        </div>
                                        <select class="select @error('medicine_type_id') is-invalid @enderror"
                                            id="medicine_type_id" name="medicine_type_id" required>
                                            <option value="">{{ __('medicine.select_type') }}</option>
                                            @foreach ($medicineTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('medicine_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('medicine_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="add-newplus">
                                            <label for="medicine_leaf_id"
                                                class="form-label">{{ __('medicine.medicine_leaf') }} <span
                                                    class="text-danger">*</span></label>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#add-medicine-leaf"><i data-feather="plus-circle"
                                                    class="plus-down-add"></i><span>{{ __('medicine.add_new') }}</span></a>
                                        </div>
                                        <select class="select @error('medicine_leaf_id') is-invalid @enderror"
                                            id="medicine_leaf_id" name="medicine_leaf_id" required>
                                            <option value="">{{ __('medicine.select_leaf') }}</option>
                                            @foreach ($medicineLeafs as $leaf)
                                                <option value="{{ $leaf->id }}"
                                                    {{ old('medicine_leaf_id') == $leaf->id ? 'selected' : '' }}>
                                                    {{ $leaf->type }} ({{ $leaf->qty_box }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('medicine_leaf_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="add-newplus">
                                            <label for="unit_id" class="form-label">{{ __('medicine.unit') }} <span
                                                    class="text-danger">*</span></label>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#add-units"><i data-feather="plus-circle"
                                                    class="plus-down-add"></i><span>{{ __('medicine.add_new') }}</span></a>
                                        </div>
                                        <select class="select @error('unit_id') is-invalid @enderror" id="unit_id"
                                            name="unit_id" required>
                                            <option value="">{{ __('medicine.select_unit') }}</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="add-newplus">
                                            <label for="medicine_categories"
                                                class="form-label">{{ __('medicine.categories') }} <span
                                                    class="text-danger">*</span></label>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#add-category"><i data-feather="plus-circle"
                                                    class="plus-down-add"></i><span>{{ __('medicine.add_new') }}</span></a>
                                        </div>
                                        <select class="select select2 @error('medicine_categories') is-invalid @enderror"
                                            id="medicine_categories" name="medicine_categories[]" multiple
                                            placeholder="{{ __('medicine.select_categories') }}">
                                            @foreach ($medicineCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('medicine_categories') && in_array($category->id, old('medicine_categories')) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('medicine_categories')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="add-newplus">
                                            <label for="supplier_id" class="form-label">{{ __('medicine.supplier') }}
                                                <span class="text-danger">*</span></label>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#add-supplier"><i data-feather="plus-circle"
                                                    class="plus-down-add"></i><span>{{ __('medicine.add_new') }}</span></a>
                                        </div>
                                        <select class="select select2 @error('supplier_id') is-invalid @enderror"
                                            id="supplier_id" name="supplier_id">
                                            <option value="">{{ __('medicine.select_supplier') }}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="add-newplus">
                                            <label for="vendor_id" class="form-label">{{ __('medicine.vendor') }} <span
                                                    class="text-danger">*</span></label>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#add-vendor"><i data-feather="plus-circle"
                                                    class="plus-down-add"></i><span>{{ __('medicine.add_new') }}</span></a>
                                        </div>
                                        <select class="select select2 @error('vendor_id') is-invalid @enderror"
                                            id="vendor_id" name="vendor_id">
                                            <option value="">{{ __('medicine.select_vendor') }}</option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}"
                                                    {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('vendor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="reorder_level"
                                            class="form-label">{{ __('medicine.reorder_level') }}</label>
                                        <input type="number"
                                            class="form-control @error('reorder_level') is-invalid @enderror"
                                            id="reorder_level" name="reorder_level" value="{{ old('reorder_level') }}"
                                            placeholder="{{ __('medicine.eg_10') }}">
                                        @error('reorder_level')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="alert_quantity"
                                            class="form-label">{{ __('medicine.alert_quantity') }}</label>
                                        <input type="number"
                                            class="form-control @error('alert_quantity') is-invalid @enderror"
                                            id="alert_quantity" name="alert_quantity"
                                            value="{{ old('alert_quantity') }}"
                                            placeholder="{{ __('medicine.eg_10') }}">
                                        @error('alert_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="shelf" class="form-label">{{ __('medicine.shelf') }}</label>
                                        <input type="text" class="form-control @error('shelf') is-invalid @enderror"
                                            id="shelf" name="shelf" value="{{ old('shelf') }}"
                                            placeholder="{{ __('medicine.eg_A1') }}">
                                        @error('shelf')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="batch_number"
                                            class="form-label">{{ __('medicine.batch_number') }}</label>
                                        <input type="text"
                                            class="form-control @error('batch_number') is-invalid @enderror"
                                            id="batch_number" name="batch_number" value="{{ old('batch_number') }}"
                                            placeholder="{{ __('medicine.eg_1234567890') }}">
                                        @error('batch_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="dosage" class="form-label">{{ __('medicine.dosage') }}</label>
                                        <input type="text" class="form-control @error('dosage') is-invalid @enderror"
                                            id="dosage" name="dosage" value="{{ old('dosage') }}"
                                            placeholder="{{ __('medicine.eg_10mg') }}">
                                        @error('dosage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="input-blocks">
                                            <label for="manufacturing_date"
                                                class="form-label">{{ __('medicine.manufacturing_date') }}</label>
                                            <div class="input-group-icon calender-input position-relative">
                                                <i data-feather="calendar" class="info-img"></i>
                                                <input type="text"
                                                    class="datetimepicker @error('manufacturing_date') is-invalid @enderror"
                                                    id="manufacturing_date" name="manufacturing_date"
                                                    placeholder="{{ __('medicine.choose_date') }}"
                                                    value="{{ old('manufacturing_date') }}">
                                            </div>
                                            @error('manufacturing_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="input-blocks">
                                            <label for="expiration_date"
                                                class="form-label">{{ __('medicine.expiration_date') }}</label>
                                            <div class="input-group-icon calender-input position-relative">
                                                <i data-feather="calendar" class="info-img"></i>
                                                <input type="text"
                                                    class="datetimepicker @error('expiration_date') is-invalid @enderror"
                                                    id="expiration_date" name="expiration_date"
                                                    placeholder="{{ __('medicine.choose_date') }}"
                                                    value="{{ old('expiration_date') }}">
                                            </div>
                                            @error('expiration_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="igta_field"
                                            class="form-label">{{ __('medicine.igta_field') }}</label>
                                        <input type="text"
                                            class="form-control @error('igta_field') is-invalid @enderror"
                                            id="igta_field" name="igta_field" value="{{ old('igta_field') }}"
                                            placeholder="{{ __('medicine.eg_1234567890') }}">
                                        @error('igta_field')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="hns_code" class="form-label">{{ __('medicine.hns_code') }}</label>
                                        <input type="text"
                                            class="form-control @error('hns_code') is-invalid @enderror" id="hns_code"
                                            name="hns_code" value="{{ old('hns_code') }}"
                                            placeholder="{{ __('medicine.eg_1234567890') }}">
                                        @error('hns_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="serial_number"
                                            class="form-label">{{ __('medicine.serial_number') }}</label>
                                        <input type="text"
                                            class="form-control @error('serial_number') is-invalid @enderror"
                                            id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                                            placeholder="{{ __('medicine.eg_1234567890') }}">
                                        @error('serial_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="lot_number"
                                            class="form-label">{{ __('medicine.lot_number') }}</label>
                                        <input type="text"
                                            class="form-control @error('lot_number') is-invalid @enderror"
                                            id="lot_number" name="lot_number" value="{{ old('lot_number') }}"
                                            placeholder="{{ __('medicine.eg_45785') }}">
                                        @error('lot_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="storage_condition"
                                            class="form-label">{{ __('medicine.storage_condition') }}</label>
                                        <input type="text"
                                            class="form-control @error('storage_condition') is-invalid @enderror"
                                            id="storage_condition" name="storage_condition"
                                            value="{{ old('storage_condition') }}"
                                            placeholder="{{ __('medicine.eg_room_temperature') }}">
                                        @error('storage_condition')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="image"
                                            class="form-label">{{ __('medicine.medicine_image') }}</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="description"
                                            class="form-label">{{ __('medicine.description') }}</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="{{ __('medicine.eg_this_is_a_description') }}">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="side_effects"
                                            class="form-label">{{ __('medicine.side_effects') }}</label>
                                        <textarea class="form-control @error('side_effects') is-invalid @enderror" id="side_effects" name="side_effects"
                                            rows="3" placeholder="{{ __('medicine.eg_this_is_a_side_effect') }}">{{ old('side_effects') }}</textarea>
                                        @error('side_effects')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="contraindications"
                                            class="form-label">{{ __('medicine.contraindications') }}</label>
                                        <textarea class="form-control @error('contraindications') is-invalid @enderror" id="contraindications"
                                            name="contraindications" rows="3" placeholder="{{ __('medicine.eg_this_is_a_contraindication') }}">{{ old('contraindications') }}</textarea>
                                        @error('contraindications')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input @error('prescription_required') is-invalid @enderror"
                                                type="checkbox" id="prescription_required" name="prescription_required"
                                                value="1" {{ old('prescription_required') ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="prescription_required">{{ __('medicine.prescription_required') }}</label>
                                            @error('prescription_required')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input @error('is_active') is-invalid @enderror"
                                                type="checkbox" id="is_active" name="is_active" value="1"
                                                {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="is_active">{{ __('medicine.active') }}</label>
                                            @error('is_active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (col-md-4) for pricing information -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">{{ __('medicine.price_information') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="sale_price" class="form-label">{{ __('medicine.sale_price') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('sale_price') is-invalid @enderror"
                                            id="sale_price" name="sale_price" value="{{ old('sale_price') }}"
                                            placeholder="{{ __('medicine.eg_100') }}" required>
                                        @error('sale_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="purchase_price"
                                            class="form-label">{{ __('medicine.purchase_price') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('purchase_price') is-invalid @enderror"
                                            id="purchase_price" name="purchase_price"
                                            value="{{ old('purchase_price') }}"
                                            placeholder="{{ __('medicine.eg_80') }}" required>
                                        @error('purchase_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="vat_percentage" class="form-label">{{ __('medicine.vat') }}
                                            (%)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('vat_percentage') is-invalid @enderror"
                                            id="vat_percentage" name="vat_percentage"
                                            value="{{ old('vat_percentage') }}"
                                            placeholder="{{ __('medicine.eg_10') }}">
                                        @error('vat_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="discount_percentage"
                                            class="form-label">{{ __('medicine.discount') }} (%)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('discount_percentage') is-invalid @enderror"
                                            id="discount_percentage" name="discount_percentage"
                                            value="{{ old('discount_percentage') }}"
                                            placeholder="{{ __('medicine.eg_10') }}">
                                        @error('discount_percentage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="loyalty_point"
                                            class="form-label">{{ __('medicine.loyalty_point') }}</label>
                                        <input type="number"
                                            class="form-control @error('loyalty_point') is-invalid @enderror"
                                            id="loyalty_point" name="loyalty_point" value="{{ old('loyalty_point') }}"
                                            placeholder="{{ __('medicine.eg_10') }}">
                                        @error('loyalty_point')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input @error('sell_unit_multiple') is-invalid @enderror"
                                                type="checkbox" id="sell_unit_multiple" name="sell_unit_multiple"
                                                value="1" {{ old('sell_unit_multiple') ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="sell_unit_multiple">{{ __('medicine.sell_unit_multiple') }}</label>
                                            @error('sell_unit_multiple')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id="multiple-units-container" class="col-md-12 mb-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="card-title mb-0">{{ __('medicine.additional_units') }}</h6>
                                                <button type="button" class="btn btn-sm btn-primary" id="add-unit-btn">
                                                    <i data-feather="plus-circle"></i> {{ __('medicine.add_unit') }}
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div id="unit-rows-container">
                                                    <!-- Units will be added here dynamically -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('medicine.create_medicine') }}</button>
                        <a href="{{ route('medicines.index') }}"
                            class="btn btn-secondary">{{ __('medicine.cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Template for unit row - this will be hidden and used by JavaScript -->
    <template id="unit-row-template">
        <div class="unit-row mb-3 border p-3 rounded">
            <div class="row">
                <div class="col-md-12 mb-2 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('medicine.unit') }} #<span class="unit-number">1</span></h6>
                    <button type="button" class="btn btn-sm btn-danger remove-unit-btn">
                        <i data-feather="trash-2"></i>
                    </button>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">{{ __('medicine.unit') }} <span class="text-danger">*</span></label>
                    <select class="form-select unit-select" name="medicine_units[unit_id][]" required>
                        <option value="">{{ __('medicine.select_unit') }}</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" data-bs-toggle="tooltip"
                        data-bs-placement="top">{{ __('medicine.conversion_factor') }}
                        <span class="text-danger">*</span>
                        <i data-feather="info" class="info-img" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ __('medicine.conversion_factor_tooltip') }}"></i>
                    </label>
                    <input type="number" step="0.01" class="form-control" name="medicine_units[conversion_factor][]"
                        placeholder="{{ __('medicine.eg_10') }}" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">{{ __('medicine.sale_price') }} <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" name="medicine_units[sale_price][]"
                        placeholder="{{ __('medicine.eg_100') }}" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">{{ __('medicine.purchase_price') }} <span
                            class="text-danger">*</span></label>
                    <input type="number" step="0.01" class="form-control" name="medicine_units[purchase_price][]"
                        placeholder="{{ __('medicine.eg_80') }}" required>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-check">
                        <input class="form-check-input default-unit-checkbox" type="checkbox"
                            name="medicine_units[is_default][]" value="1">
                        <label class="form-check-label">{{ __('medicine.default_unit') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </template>

    @include('medicine.modal._unit')
    @include('medicine.modal._category')
    @include('medicine.modal._medicineLeaf')
    @include('medicine.modal._medicineType')
    @include('medicine.modal._supplier')
    @include('medicine.modal._vendor')
@endsection

@push('script')
    <!-- Select2 JS -->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Medicine JS -->
    <script src="{{ asset('assets/js/pages/medicine.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2();

            // Handle showing/hiding multiple units container
            $('#sell_unit_multiple').change(function() {
                if ($(this).is(':checked')) {
                    $('#multiple-units-container').show();
                } else {
                    $('#multiple-units-container').hide();
                }
            });

            // Trigger the change event to set initial state
            $('#sell_unit_multiple').trigger('change');

            // Handle adding new unit row
            $('#add-unit-btn').click(function() {
                const template = document.querySelector('#unit-row-template');
                const container = document.querySelector('#unit-rows-container');

                // Clone the template content
                const clone = document.importNode(template.content, true);

                // Set the unit number
                const unitNumber = container.querySelectorAll('.unit-row').length + 1;
                clone.querySelector('.unit-number').textContent = unitNumber;

                // Append the new row
                container.appendChild(clone);

                // Initialize feather icons for the new row
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }

                // Setup remove button event
                const newRow = container.lastElementChild;
                $(newRow).find('.remove-unit-btn').click(function() {
                    $(this).closest('.unit-row').remove();
                    updateUnitNumbers();
                });

                // Setup default unit checkbox
                $(newRow).find('.default-unit-checkbox').change(function() {
                    if ($(this).is(':checked')) {
                        // Uncheck all other default checkboxes
                        $('.default-unit-checkbox').not(this).prop('checked', false);
                    }
                });
            });

            // Function to update unit numbers after removal
            function updateUnitNumbers() {
                $('.unit-row').each(function(index) {
                    $(this).find('.unit-number').text(index + 1);
                });
            }

            // Add at least one unit row if sell_unit_multiple is checked
            if ($('#sell_unit_multiple').is(':checked') && $('#unit-rows-container').children().length === 0) {
                $('#add-unit-btn').click();
            }
        });
    </script>
@endpush
