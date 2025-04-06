<x-auth-layout title="Login">
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
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="login-userset">
                            <div class="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Access the panel using your email and passcode.</h4>
                            </div>

                            <!-- Email Address -->
                            <div class="form-login">
                                <label class="form-label">Email Address</label>
                                <div class="form-addons">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autofocus>
                                    <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input @error('password') is-invalid @enderror"
                                        name="password" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember & Forgot Password -->
                            <div class="form-login authentication-check">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                <input type="checkbox" name="remember">
                                                <span class="checkmarks"></span>Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        @if (Route::has('password.request'))
                                            <a class="forgot-link" href="{{ route('password.request') }}">Forgot
                                                Password?</a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Login Button -->
                            <div class="form-login">
                                <button class="btn btn-login" type="submit">Sign In</button>
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
