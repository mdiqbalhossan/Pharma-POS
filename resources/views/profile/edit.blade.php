@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    @include('layouts.partials.breadcrumb', [
        'title' => 'Edit Profile',
        'subtitle' => 'Manage your account information',
    ])

    <div class="row">
        <!-- Profile Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Profile Information</h5>
                    <p class="card-subtitle">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->name) }}" required autofocus
                                autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="alert alert-warning mb-3">
                                <p>
                                    Your email address is unverified.

                                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                                        Click here to re-send the verification email.
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-success">
                                        A new verification link has been sent to your email address.
                                    </p>
                                @endif
                            </div>
                        @endif

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>

                            @if (session('status') === 'profile-updated')
                                <span class="text-success ms-2">Profile information updated successfully.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update Password</h5>
                    <p class="card-subtitle">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password"
                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                id="current_password" name="current_password" autocomplete="current-password"
                                placeholder="Current Password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password"
                                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                id="password" name="password" autocomplete="new-password" placeholder="New Password">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password"
                                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                                placeholder="Confirm Password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Password</button>

                            @if (session('status') === 'password-updated')
                                <span class="text-success ms-2">Password updated successfully.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
