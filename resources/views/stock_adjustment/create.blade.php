@extends('layouts.app')

@section('title', __('index.Create Stock Adjustment'))

@push('plugin')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>{{ __('index.New Stock Adjustment') }}</h4>
                <h6>{{ __('index.Create new stock adjustment') }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <div class="page-btn">
                    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>{{ __('index.Back to Adjustments') }}</a>
                </div>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('index.Collapse') }}"
                    id="collapse-header"><i data-feather="chevron-up" class="feather-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <form action="{{ route('stock-adjustments.store') }}" method="POST" id="stock-adjustment-form">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="medicine_id">{{ __('index.Medicine') }} <span class="text-danger">*</span></label>
                            <select class="select2 form-control" id="medicine_id" name="medicine_id" required>
                                <option value="">{{ __('index.Select Medicine') }}</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}
                                        ({{ __('index.Current Stock') }}:
                                        {{ $medicine->quantity }})
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
                            <label for="date">{{ __('index.Date') }} <span class="text-danger">*</span></label>
                            <div class="input-groupicon calender-input">
                                <i data-feather="calendar" class="info-img"></i>
                                <input type="text" id="date" name="date" class="datetimepicker"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            @error('date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="type">{{ __('index.Adjustment Type') }} <span
                                    class="text-danger">*</span></label>
                            <select class="select2 form-control" id="type" name="type" required>
                                <option value="addition">{{ __('index.Addition') }}</option>
                                <option value="reduction">{{ __('index.Reduction') }}</option>
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
                            <label for="quantity">{{ __('index.Quantity') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" id="quantity" name="quantity" class="form-control"
                                required min="0.01">
                            @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label for="reason">{{ __('index.Reason') }} <span class="text-danger">*</span></label>
                            <input type="text" id="reason" name="reason" class="form-control" required>
                            @error('reason')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-blocks mb-3">
                            <label for="note">{{ __('index.Note') }}</label>
                            <textarea id="note" name="note" class="form-control" rows="4"></textarea>
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
                        <i class="fas fa-times me-2"></i>{{ __('index.Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>{{ __('index.Save Adjustment') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
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
@endpush
