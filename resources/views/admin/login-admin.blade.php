<x-guest-layout>
    <style>
        body {
            margin: 0;
            background: linear-gradient(to right, #c1c8e4, #c4fff9);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            display: flex;
            width: 900px;
            height: 500px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-panel {
            width: 50%;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* Remove padding to avoid gaps */
            overflow: hidden; /* Ensure no overflow */
        }

        .left-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the entire panel */
        }

        .right-panel {
            width: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .logo img {
            width: 120px;
        }

        .title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border-left: 3px solid #a26ff2;
            padding-left: 10px;
            color: #333;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 0.95rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #a26ff2;
            box-shadow: 0 0 0 2px rgba(162, 111, 242, 0.2);
        }

        .form-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }

        .btn-login {
            width: 100%;
            background-color: #a26ff2;
            color: white;
            padding: 12px;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #8b5fe9;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-top: 1rem;
        }

        .form-footer a {
            text-decoration: none;
            color: #a26ff2;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: center;
            font-size: 0.75rem;
            color: #999;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                height: auto;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
            }
        }
    </style>

    <div class="login-container">
        <div class="card">
            <div class="left-panel">
                <img src="img/babyadmin.jpg" alt="Illustration">
            </div>
            <div class="right-panel">
                <div class="logo">
                    <img src="img/tinytrack-logo.png" alt="Logo">
                </div>
                <div class="title">Login as a Admin User</div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <span class="form-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <input id="email" class="form-input" type="email" name="email" placeholder="johndoe@xyz.com" required autofocus>
                    </div>

                    <div class="form-group">
                        <span class="form-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" class="form-input" type="password" name="password" placeholder="********" required>
                    </div>

                    <button type="submit" class="btn-login">LOGIN</button>

                    <div class="form-footer">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>

                    <div class="terms">
                        Terms of use. Privacy policy
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</x-guest-layout>
