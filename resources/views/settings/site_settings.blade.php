@extends('layouts.app')

@section('title', __('Site Settings'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Site Settings') }}</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('settings.site.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="site_name">{{ __('Site Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="site_name" id="site_name"
                                            class="form-control @error('site_name') is-invalid @enderror"
                                            value="{{ old('site_name', $settings['site_name']) }}" required>
                                        @error('site_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="currency">{{ __('Currency') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="currency" id="currency"
                                            class="form-control @error('currency') is-invalid @enderror"
                                            value="{{ old('currency', $settings['currency']) }}" required>
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="currency_symbol">{{ __('Currency Symbol') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="currency_symbol" id="currency_symbol"
                                            class="form-control @error('currency_symbol') is-invalid @enderror"
                                            value="{{ old('currency_symbol', $settings['currency_symbol']) }}" required>
                                        @error('currency_symbol')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="date_format">{{ __('Date Format') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="date_format" id="date_format"
                                            class="form-control @error('date_format') is-invalid @enderror" required>
                                            <option value="Y-m-d"
                                                {{ $settings['date_format'] == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD
                                            </option>
                                            <option value="m/d/Y"
                                                {{ $settings['date_format'] == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY
                                            </option>
                                            <option value="d/m/Y"
                                                {{ $settings['date_format'] == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY
                                            </option>
                                            <option value="d.m.Y"
                                                {{ $settings['date_format'] == 'd.m.Y' ? 'selected' : '' }}>DD.MM.YYYY
                                            </option>
                                        </select>
                                        @error('date_format')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="time_format">{{ __('Time Format') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="time_format" id="time_format"
                                            class="form-control @error('time_format') is-invalid @enderror" required>
                                            <option value="H:i:s"
                                                {{ $settings['time_format'] == 'H:i:s' ? 'selected' : '' }}>24 Hour
                                                (HH:MM:SS)</option>
                                            <option value="h:i:s A"
                                                {{ $settings['time_format'] == 'h:i:s A' ? 'selected' : '' }}>12 Hour
                                                (HH:MM:SS AM/PM)</option>
                                        </select>
                                        @error('time_format')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="default_tax">{{ __('Default Tax Rate (%)') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="default_tax" id="default_tax"
                                            class="form-control @error('default_tax') is-invalid @enderror"
                                            value="{{ old('default_tax', $settings['default_tax']) }}" required>
                                        @error('default_tax')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="invoice_prefix">{{ __('Invoice Prefix') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="invoice_prefix" id="invoice_prefix"
                                            class="form-control @error('invoice_prefix') is-invalid @enderror"
                                            value="{{ old('invoice_prefix', $settings['invoice_prefix']) }}" required>
                                        @error('invoice_prefix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="invoice_footer">{{ __('Invoice Footer') }}</label>
                                        <textarea name="invoice_footer" id="invoice_footer" class="form-control @error('invoice_footer') is-invalid @enderror"
                                            rows="2">{{ old('invoice_footer', $settings['invoice_footer']) }}</textarea>
                                        @error('invoice_footer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="default_language">{{ __('Default Language') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="default_language" id="default_language"
                                            class="form-control @error('default_language') is-invalid @enderror" required>
                                            <option value="en"
                                                {{ $settings['default_language'] == 'en' ? 'selected' : '' }}>English
                                            </option>
                                            <option value="es"
                                                {{ $settings['default_language'] == 'es' ? 'selected' : '' }}>Spanish
                                            </option>
                                            <option value="fr"
                                                {{ $settings['default_language'] == 'fr' ? 'selected' : '' }}>French
                                            </option>
                                            <option value="de"
                                                {{ $settings['default_language'] == 'de' ? 'selected' : '' }}>German
                                            </option>
                                            <option value="ar"
                                                {{ $settings['default_language'] == 'ar' ? 'selected' : '' }}>Arabic
                                            </option>
                                        </select>
                                        @error('default_language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="timezone">{{ __('Timezone') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="timezone" id="timezone"
                                            class="form-control @error('timezone') is-invalid @enderror" required>
                                            <option value="UTC" {{ $settings['timezone'] == 'UTC' ? 'selected' : '' }}>
                                                UTC</option>
                                            <option value="America/New_York"
                                                {{ $settings['timezone'] == 'America/New_York' ? 'selected' : '' }}>Eastern
                                                Time (US & Canada)</option>
                                            <option value="America/Chicago"
                                                {{ $settings['timezone'] == 'America/Chicago' ? 'selected' : '' }}>Central
                                                Time (US & Canada)</option>
                                            <option value="America/Denver"
                                                {{ $settings['timezone'] == 'America/Denver' ? 'selected' : '' }}>Mountain
                                                Time (US & Canada)</option>
                                            <option value="America/Los_Angeles"
                                                {{ $settings['timezone'] == 'America/Los_Angeles' ? 'selected' : '' }}>
                                                Pacific Time (US & Canada)</option>
                                            <option value="Europe/London"
                                                {{ $settings['timezone'] == 'Europe/London' ? 'selected' : '' }}>London
                                            </option>
                                            <option value="Asia/Dubai"
                                                {{ $settings['timezone'] == 'Asia/Dubai' ? 'selected' : '' }}>Dubai
                                            </option>
                                            <!-- Add more timezones as needed -->
                                        </select>
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="low_stock_alert">{{ __('Low Stock Alert') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="low_stock_alert" id="low_stock_alert"
                                            class="form-control @error('low_stock_alert') is-invalid @enderror"
                                            value="{{ old('low_stock_alert', $settings['low_stock_alert']) }}" required>
                                        @error('low_stock_alert')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="barcode_type">{{ __('Barcode Type') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="barcode_type" id="barcode_type"
                                            class="form-control @error('barcode_type') is-invalid @enderror" required>
                                            <option value="CODE128"
                                                {{ $settings['barcode_type'] == 'CODE128' ? 'selected' : '' }}>CODE128
                                            </option>
                                            <option value="CODE39"
                                                {{ $settings['barcode_type'] == 'CODE39' ? 'selected' : '' }}>CODE39
                                            </option>
                                            <option value="EAN13"
                                                {{ $settings['barcode_type'] == 'EAN13' ? 'selected' : '' }}>EAN13</option>
                                            <option value="UPC"
                                                {{ $settings['barcode_type'] == 'UPC' ? 'selected' : '' }}>UPC</option>
                                        </select>
                                        @error('barcode_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="stock_expiry_alert_days">{{ __('Stock Expiry Alert (days)') }}</label>
                                        <input type="number" name="stock_expiry_alert_days" id="stock_expiry_alert_days"
                                            class="form-control @error('stock_expiry_alert_days') is-invalid @enderror"
                                            value="{{ old('stock_expiry_alert_days', $settings['stock_expiry_alert_days']) }}">
                                        <small
                                            class="text-muted">{{ __('Number of days before expiry to show alerts.') }}</small>
                                        @error('stock_expiry_alert_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="purchase_prefix">{{ __('Purchase Prefix') }}</label>
                                        <input type="text" name="purchase_prefix" id="purchase_prefix"
                                            class="form-control @error('purchase_prefix') is-invalid @enderror"
                                            value="{{ old('purchase_prefix', $settings['purchase_prefix']) }}">
                                        @error('purchase_prefix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="return_prefix">{{ __('Return Prefix') }}</label>
                                        <input type="text" name="return_prefix" id="return_prefix"
                                            class="form-control @error('return_prefix') is-invalid @enderror"
                                            value="{{ old('return_prefix', $settings['return_prefix']) }}">
                                        @error('return_prefix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="pagination_limit">{{ __('Pagination Limit') }}</label>
                                        <input type="number" name="pagination_limit" id="pagination_limit"
                                            class="form-control @error('pagination_limit') is-invalid @enderror"
                                            value="{{ old('pagination_limit', $settings['pagination_limit']) }}">
                                        @error('pagination_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">{{ __('Site Logo') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label>{{ __('Current Site Logo') }}</label>
                                                <div class="mb-3">
                                                    @if (!empty($settings['site_logo']))
                                                        <img src="{{ asset('public/storage/' . $settings['site_logo']) }}"
                                                            alt="{{ __('Site Logo') }}" class="img-fluid img-thumbnail"
                                                            style="max-height: 100px;">
                                                    @else
                                                        <p class="text-muted">{{ __('No logo uploaded') }}</p>
                                                    @endif
                                                </div>
                                                <label for="site_logo">{{ __('Upload New Site Logo') }}</label>
                                                <input type="file" name="site_logo" id="site_logo"
                                                    class="form-control @error('site_logo') is-invalid @enderror"
                                                    accept="image/*">
                                                @error('site_logo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">{{ __('Favicon') }}</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="favicon">{{ __('Current Favicon') }}</label>
                                            <div class="mb-3">
                                                @if (!empty($settings['favicon']))
                                                    <img src="{{ asset('public/storage/' . $settings['favicon']) }}"
                                                        alt="{{ __('Favicon') }}" class="img-fluid img-thumbnail"
                                                        style="max-height: 100px;">
                                                @else
                                                    <p class="text-muted">{{ __('No favicon uploaded') }}</p>
                                                @endif
                                            </div>
                                            <label for="favicon">{{ __('Upload New Favicon') }}</label>
                                            <input type="file" name="favicon" id="favicon"
                                                class="form-control @error('favicon') is-invalid @enderror"
                                                accept="image/*">
                                            @error('favicon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ __('Save Site Settings') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
