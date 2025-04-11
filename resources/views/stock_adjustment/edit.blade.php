@extends('layouts.app')

@section('title', __('Edit Stock Adjustment'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('Edit Stock Adjustment') }}</h4>
                <h6>{{ __('Update stock adjustment details') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('Back to Adjustments') }}</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Collapse') }}" id="collapse-header"><i
                        data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <form action="{{ route('stock-adjustments.update', $stockAdjustment->id) }}" method="POST" id="stock-adjustment-form">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="medicine_id">{{ __('Medicine') }} <span class="text-danger">*</span></label>
                            <select class="select2 form-control" id="medicine_id" name="medicine_id" required>
                                <option value="">{{ __('Select Medicine') }}</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}"
                                        {{ $stockAdjustment->medicine_id == $medicine->id ? 'selected' : '' }}>
                                        {{ $medicine->name }} ({{ __('Current Stock') }}: {{ $medicine->quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('medicine_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="date">{{ __('Date') }} <span class="text-danger">*</span></label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" id="date" name="date" class="datetimepicker"
                                    value="{{ $stockAdjustment->date }}" required>
                            </div>
                            @error('date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="type">{{ __('Adjustment Type') }} <span class="text-danger">*</span></label>
                            <select class="select2 form-control" id="type" name="type" required>
                                <option value="addition" {{ $stockAdjustment->type == 'addition' ? 'selected' : '' }}>
                                    {{ __('Addition') }}</option>
                                <option value="reduction" {{ $stockAdjustment->type == 'reduction' ? 'selected' : '' }}>
                                    {{ __('Reduction') }}</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="quantity">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" id="quantity" name="quantity" class="form-control"
                                required min="0.01" value="{{ $stockAdjustment->quantity }}">
                            @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="reason">{{ __('Reason') }} <span class="text-danger">*</span></label>
                            <input type="text" id="reason" name="reason" class="form-control" required
                                value="{{ $stockAdjustment->reason }}">
                            @error('reason')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-blocks mb-3">
                            <label for="note">{{ __('Note') }}</label>
                            <textarea id="note" name="note" class="form-control" rows="4">{{ $stockAdjustment->note }}</textarea>
                            @error('note')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="btn-group">
                    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-danger me-2">
                        <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>{{ __('Update Adjustment') }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">{{ __('Add New Supplier') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplier-form">
                        <div class="input-blocks mb-3">
                            <label for="supplier_name">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplier_name" required>
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_email">{{ __('Email') }}</label>
                            <input type="email" class="form-control" id="supplier_email">
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_phone">{{ __('Phone') }}</label>
                            <input type="text" class="form-control" id="supplier_phone">
                        </div>
                        <div class="input-blocks mb-3">
                            <label for="supplier_address">{{ __('Address') }}</label>
                            <textarea class="form-control" id="supplier_address" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary"
                        id="add-supplier-btn">{{ __('Add Supplier') }}</button>
                </div>
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
    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Summernote JS -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Custom Purchase JS -->
    <script src="{{ asset('assets/js/pages/purchase.js') }}"></script>
@endpush
