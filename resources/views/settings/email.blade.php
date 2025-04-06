@extends('layouts.app')

@section('title', 'Email Settings')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">Email Settings</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('settings.email.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="mail_mailer">Mail Driver <span class="text-danger">*</span></label>
                                        <select name="mail_mailer" id="mail_mailer"
                                            class="form-control @error('mail_mailer') is-invalid @enderror" required>
                                            <option value="smtp"
                                                {{ $settings['mail_mailer'] == 'smtp' ? 'selected' : '' }}>
                                                SMTP</option>
                                            <option value="sendmail"
                                                {{ $settings['mail_mailer'] == 'sendmail' ? 'selected' : '' }}>Sendmail
                                            </option>
                                            <option value="mailgun"
                                                {{ $settings['mail_mailer'] == 'mailgun' ? 'selected' : '' }}>Mailgun
                                            </option>
                                            <option value="ses"
                                                {{ $settings['mail_mailer'] == 'ses' ? 'selected' : '' }}>Amazon SES
                                            </option>
                                            <option value="postmark"
                                                {{ $settings['mail_mailer'] == 'postmark' ? 'selected' : '' }}>Postmark
                                            </option>
                                        </select>
                                        @error('mail_mailer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="mail_host">Mail Host <span class="text-danger">*</span></label>
                                        <input type="text" name="mail_host" id="mail_host"
                                            class="form-control @error('mail_host') is-invalid @enderror"
                                            value="{{ old('mail_host', $settings['mail_host']) }}" required>
                                        <small class="text-muted">Ex: smtp.gmail.com, smtp.mailtrap.io</small>
                                        @error('mail_host')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="mail_port">Mail Port <span class="text-danger">*</span></label>
                                        <input type="text" name="mail_port" id="mail_port"
                                            class="form-control @error('mail_port') is-invalid @enderror"
                                            value="{{ old('mail_port', $settings['mail_port']) }}" required>
                                        <small class="text-muted">Common ports: 25, 465, 587, 2525</small>
                                        @error('mail_port')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="mail_username">Mail Username</label>
                                        <input type="text" name="mail_username" id="mail_username"
                                            class="form-control @error('mail_username') is-invalid @enderror"
                                            value="{{ old('mail_username', $settings['mail_username']) }}">
                                        <small class="text-muted">Usually your email address</small>
                                        @error('mail_username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="mail_password">Mail Password</label>
                                        <input type="password" name="mail_password" id="mail_password"
                                            class="form-control @error('mail_password') is-invalid @enderror"
                                            value="{{ old('mail_password', $settings['mail_password']) }}">
                                        <small class="text-muted">For Gmail, use app password</small>
                                        @error('mail_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="mail_encryption">Mail Encryption</label>
                                        <select name="mail_encryption" id="mail_encryption"
                                            class="form-control @error('mail_encryption') is-invalid @enderror">
                                            <option value=""
                                                {{ $settings['mail_encryption'] == '' ? 'selected' : '' }}>None
                                            </option>
                                            <option value="tls"
                                                {{ $settings['mail_encryption'] == 'tls' ? 'selected' : '' }}>TLS
                                            </option>
                                            <option value="ssl"
                                                {{ $settings['mail_encryption'] == 'ssl' ? 'selected' : '' }}>SSL
                                            </option>
                                        </select>
                                        @error('mail_encryption')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="mail_from_address">From Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="mail_from_address" id="mail_from_address"
                                            class="form-control @error('mail_from_address') is-invalid @enderror"
                                            value="{{ old('mail_from_address', $settings['mail_from_address']) }}"
                                            required>
                                        <small class="text-muted">Email address that appears in the "From" field</small>
                                        @error('mail_from_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="mail_from_name">From Name <span class="text-danger">*</span></label>
                                        <input type="text" name="mail_from_name" id="mail_from_name"
                                            class="form-control @error('mail_from_name') is-invalid @enderror"
                                            value="{{ old('mail_from_name', $settings['mail_from_name']) }}" required>
                                        <small class="text-muted">Name that appears in the "From" field</small>
                                        @error('mail_from_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        After changing these settings, it's recommended to test your email configuration by
                                        sending a test email.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Email Settings
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-12">
                                <h5>Send Test Email</h5>
                                <p class="text-muted">Send a test email to verify your email configuration is working
                                    correctly.</p>

                                @if (session('email_success'))
                                    <div class="alert alert-success">
                                        {{ session('email_success') }}
                                    </div>
                                @endif

                                @if (session('email_error'))
                                    <div class="alert alert-danger">
                                        {{ session('email_error') }}
                                        @if (session('error_details'))
                                            <br>
                                            <small>{{ session('error_details') }}</small>
                                        @endif
                                    </div>
                                @endif

                                <form action="{{ route('settings.email.test') }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="input-group mb-3">
                                                <input type="email" name="test_email"
                                                    class="form-control @error('test_email') is-invalid @enderror"
                                                    placeholder="Enter email address to send test" required>
                                                <button class="btn btn-info" type="submit">
                                                    <i class="fas fa-paper-plane"></i> Send Test Email
                                                </button>
                                            </div>
                                            @error('test_email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
