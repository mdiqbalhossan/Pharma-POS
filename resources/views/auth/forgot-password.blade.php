<x-auth-layout title="Forgot Password">
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
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="login-userset">
                            <div class="login-userheading">
                                <h3>Forgot password?</h3>
                                <h4>If you forgot your password, well,</h4>
                                <h4>then we'll email you instructions to reset your password.</h4>
                            </div>

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="alert alert-success mb-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autofocus>
                                    <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Email Password Reset Link</button>
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
