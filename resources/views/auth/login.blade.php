<x-guest-layout>
    <style>
        /* Brand colors */
        .text-primary { color: #FF4880; font-weight: bold; }
        .text-secondary { color: #4D65F9; font-weight: bold; }

        /* Layout */
        body{
            background: linear-gradient(to right, #c1c8e4, #c4fff9);
        }
        .split-container {
            display: flex;
            min-height: 100vh;
            margin: 100px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            overflow: hidden;
        }
        .form-section {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: white;
        }

        .image-section {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }

        /* Form styling */
        .auth-card {
            max-width: 400px;
            margin: 0 auto;
            width: 100%;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            justify-content: center; /* Centers horizontally */
            align-items: center; /* Centers vertically */
            flex-direction: column; /* Ensures content stacks vertically */
        }

        .logo-container img {
            width: 150px;
            height: auto;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .auth-subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .form-input:focus {
            border-color: #789DBC;
            outline: none;
            box-shadow: 0 0 0 2px rgba(120, 157, 188, 0.2);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 0.5rem;
        }

        .forgot-password {
            color: #789DBC;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background-color: #789DBC;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            background-color: #6789a8;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #999;
            font-size: 0.8rem;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #eee;
            margin: 0 10px;
        }

        .btn-google {
            width: 100%;
            padding: 0.75rem;
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .btn-google:hover {
            background-color: #f9f9f9;
        }

        .btn-google img {
            width: 18px;
            margin-right: 8px;
        }

        .signup-link {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        .signup-link a {
            color: #789DBC;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }

            .image-section {
                display: none;
            }
        }
    </style>

    <div class="split-container">
        <!-- Left side - Form section -->
        <div class="form-section">
            <div class="auth-card">
                <div class="logo-container">
                    <img src="img/tinytrack-logo.png" alt="TinyTrack logo">
                    <a href="{{route('mainpage')}}" class="navbar-brand">
                    </a>
                </div>

                <h2 class="auth-title">Welcome back</h2>
                <p class="auth-subtitle">Please enter your details</p>

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    </div>

                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <label for="remember_me" class="text-sm text-gray-600">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary">
                        Log in
                    </button>
                </form>


                <div class="signup-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                </div>
            </div>
        </div>

        <!-- Right side - Image section -->
        <div class="image-section"></div>
    </div>
</x-guest-layout>
