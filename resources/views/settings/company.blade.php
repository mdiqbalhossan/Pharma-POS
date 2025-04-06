@extends('layouts.app')

@section('title', 'Company Settings')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">Company Settings</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_name">Company Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="company_name" id="company_name"
                                                    class="form-control @error('company_name') is-invalid @enderror"
                                                    value="{{ old('company_name', $settings['company_name']) }}" required>
                                                @error('company_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_email">Company Email <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="company_email" id="company_email"
                                                    class="form-control @error('company_email') is-invalid @enderror"
                                                    value="{{ old('company_email', $settings['company_email']) }}" required>
                                                @error('company_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="company_phone">Company Phone <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="company_phone" id="company_phone"
                                                    class="form-control @error('company_phone') is-invalid @enderror"
                                                    value="{{ old('company_phone', $settings['company_phone']) }}" required>
                                                @error('company_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="tax_number">Tax/VAT Number</label>
                                                <input type="text" name="tax_number" id="tax_number"
                                                    class="form-control @error('tax_number') is-invalid @enderror"
                                                    value="{{ old('tax_number', $settings['tax_number']) }}">
                                                @error('tax_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="registration_number">Registration Number</label>
                                                <input type="text" name="registration_number" id="registration_number"
                                                    class="form-control @error('registration_number') is-invalid @enderror"
                                                    value="{{ old('registration_number', $settings['registration_number']) }}">
                                                @error('registration_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="pharmacist_license">Pharmacist License Number</label>
                                                <input type="text" name="pharmacist_license" id="pharmacist_license"
                                                    class="form-control @error('pharmacist_license') is-invalid @enderror"
                                                    value="{{ old('pharmacist_license', $settings['pharmacist_license']) }}">
                                                @error('pharmacist_license')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="opening_time">Opening Time</label>
                                                <input type="time" name="opening_time" id="opening_time"
                                                    class="form-control @error('opening_time') is-invalid @enderror"
                                                    value="{{ old('opening_time', $settings['opening_time']) }}">
                                                @error('opening_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="closing_time">Closing Time</label>
                                                <input type="time" name="closing_time" id="closing_time"
                                                    class="form-control @error('closing_time') is-invalid @enderror"
                                                    value="{{ old('closing_time', $settings['closing_time']) }}">
                                                @error('closing_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="company_address">Company Address</label>
                                                <textarea name="company_address" id="company_address"
                                                    class="form-control @error('company_address') is-invalid @enderror" rows="2">{{ old('company_address', $settings['company_address']) }}</textarea>
                                                @error('company_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="company_city">City</label>
                                                <input type="text" name="company_city" id="company_city"
                                                    class="form-control @error('company_city') is-invalid @enderror"
                                                    value="{{ old('company_city', $settings['company_city']) }}">
                                                @error('company_city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="company_state">State/Province</label>
                                                <input type="text" name="company_state" id="company_state"
                                                    class="form-control @error('company_state') is-invalid @enderror"
                                                    value="{{ old('company_state', $settings['company_state']) }}">
                                                @error('company_state')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="company_zip">Postal/Zip Code</label>
                                                <input type="text" name="company_zip" id="company_zip"
                                                    class="form-control @error('company_zip') is-invalid @enderror"
                                                    value="{{ old('company_zip', $settings['company_zip']) }}">
                                                @error('company_zip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="company_country">Country</label>
                                                <input type="text" name="company_country" id="company_country"
                                                    class="form-control @error('company_country') is-invalid @enderror"
                                                    value="{{ old('company_country', $settings['company_country']) }}">
                                                @error('company_country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="mt-3 mb-3">Social Media Links</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="website_link">Website</label>
                                                <input type="url" name="website_link" id="website_link"
                                                    class="form-control @error('website_link') is-invalid @enderror"
                                                    value="{{ old('website_link', $settings['website_link']) }}">
                                                @error('website_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="facebook_link">Facebook</label>
                                                <input type="url" name="facebook_link" id="facebook_link"
                                                    class="form-control @error('facebook_link') is-invalid @enderror"
                                                    value="{{ old('facebook_link', $settings['facebook_link']) }}">
                                                @error('facebook_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="twitter_link">Twitter</label>
                                                <input type="url" name="twitter_link" id="twitter_link"
                                                    class="form-control @error('twitter_link') is-invalid @enderror"
                                                    value="{{ old('twitter_link', $settings['twitter_link']) }}">
                                                @error('twitter_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="instagram_link">Instagram</label>
                                                <input type="url" name="instagram_link" id="instagram_link"
                                                    class="form-control @error('instagram_link') is-invalid @enderror"
                                                    value="{{ old('instagram_link', $settings['instagram_link']) }}">
                                                @error('instagram_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="linkedin_link">LinkedIn</label>
                                                <input type="url" name="linkedin_link" id="linkedin_link"
                                                    class="form-control @error('linkedin_link') is-invalid @enderror"
                                                    value="{{ old('linkedin_link', $settings['linkedin_link']) }}">
                                                @error('linkedin_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="prescription_required_message">Prescription Required
                                                    Message</label>
                                                <textarea name="prescription_required_message" id="prescription_required_message"
                                                    class="form-control @error('prescription_required_message') is-invalid @enderror" rows="2">{{ old('prescription_required_message', $settings['prescription_required_message']) }}</textarea>
                                                <small class="text-muted">This message will be displayed for prescription
                                                    medicines.</small>
                                                @error('prescription_required_message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="invoice_logo">Invoice Logo</label>
                                        <div class="mb-2">
                                            @if ($settings['invoice_logo'])
                                                <img src="{{ photo_url($settings['invoice_logo']) }}" alt="Invoice Logo"
                                                    class="img-fluid img-thumbnail" style="max-height: 150px;">
                                            @else
                                                <div class="border p-3 text-center">
                                                    <i class="fas fa-file-invoice fa-3x text-muted"></i>
                                                    <p class="mt-2 text-muted">No invoice logo uploaded</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" name="invoice_logo" id="invoice_logo"
                                            class="form-control @error('invoice_logo') is-invalid @enderror"
                                            accept="image/*">
                                        <small class="form-text text-muted">This logo will be used on invoices and
                                            receipts. Max file size: 2MB.</small>
                                        @error('invoice_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Company Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
