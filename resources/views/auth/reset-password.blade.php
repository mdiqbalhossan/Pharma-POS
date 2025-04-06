<x-auth-layout title="Reset Password">
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="container">
                <div class="login-content user-login">
                    <div class="login-logo">
                        <img src="{{ photo_url(setting('site_logo')) }}" alt="img">
                        <a href="{{ url('/') }}" class="login-logo logo-white">
                            <img src="{{ photo_url(setting('site_logo')) }}" alt="">
                        </a>
                    </div>
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="login-userset">
                            <div class="login-userheading">
                                <h3>Reset Password</h3>
                                <h4>Enter New Password & Confirm Password</h4>
                            </div>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="alert alert-success mb-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <!-- Email Address -->
                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', $request->email) }}" required autofocus
                                        readonly>
                                    <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-login">
                                <label>New Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-login">
                                <label>Confirm Password</label>
                                <div class="pass-group">
                                    <input type="password" class="form-control" name="password_confirmation" required
                                        autocomplete="new-password">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Reset Password</button>
                            </div>
                            <div class="signinform text-center">
                                <h4>Return to <a href="{{ route('login') }}" class="hover-a">login</a></h4>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                    <p>Copyright &copy; {{ date('Y') }} {{ setting('site_name') }}. All rights reserved</p>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
