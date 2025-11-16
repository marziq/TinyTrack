<x-guest-layout>
    <style>
        body {
            margin: 0;
            background: linear-gradient(to right, #c1c8e4, #c4fff9);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .card {
            display: flex;
            width: 1000px;
            height: auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .left-panel {
            width: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel {
            width: 50%;
            background: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; /* Remove padding to avoid gaps */
            overflow: hidden; /* Ensure no overflow */
        }

        .right-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the entire panel */
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
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        .welcome-text {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            text-align: center;
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
            border-color: #789DBC;
            box-shadow: 0 0 0 2px rgba(120, 157, 188, 0.2);
        }

        .form-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }

        .btn-register {
            width: 100%;
            background-color: #789DBC;
            color: white;
            padding: 12px;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background-color: #6789a8;
        }

        .form-footer {
            text-align: center;
            font-size: 0.85rem;
            margin-top: 1.5rem;
        }

        .form-footer a {
            text-decoration: none;
            color: #789DBC;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .terms {
            font-size: 0.75rem;
            color: #999;
            margin-top: 1rem;
            text-align: center;
        }

        .terms a {
            color: #789DBC;
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

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
            }

            .left-panel,
            .right-panel {
                width: 100%;
            }

            .right-panel {
                display: none;
            }
        }
    </style>

    <div class="register-container">
        <div class="card">
            <!-- Left side - Form section -->
            <div class="left-panel">
                <div class="logo">
                    <img src="/img/tinytrack-logo.png" alt="TinyTrack Logo">
                </div>
                <h2 class="title">Create Your Account</h2>
                <p class="welcome-text">Join us today to get started</p>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-user"></i></span>
                        <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Full Name" />
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-envelope"></i></span>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required placeholder="Email Address" />
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-phone"></i></span>
                        <input id="mobile_number" class="form-input" type="text" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" />
                        @error('mobile_number')
                            <div style="color:#d9534f; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="padding-left:10px;">
                        <label style="display:block; margin-bottom:6px; color:#666; font-size:0.9rem;">Gender</label>
                        <label style="margin-right:12px; font-size:0.95rem; color:#333;"><input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> Male</label>
                        <label style="font-size:0.95rem; color:#333;"><input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Female</label>
                        @error('gender')
                            <div style="color:#d9534f; font-size:0.85rem; margin-top:6px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input id="password" class="form-input" type="password" name="password" required placeholder="Password" />
                    </div>

                    <div class="form-group">
                        <span class="form-icon"><i class="fas fa-lock"></i></span>
                        <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required placeholder="Confirm Password" />
                    </div>
                    <div class="terms">
                            <label>
                                <input type="checkbox" name="terms" required />
                                I agree to the
                                <a href="#" onclick="document.getElementById('tncModal').style.display='block'">Terms & Conditions</a>.
                            </label>
                    </div>

                    <button type="submit" class="btn-register">Sign Up</button>

                    <div class="divider">or</div>

                    <div class="form-footer">
                        Already have an account? <a href="{{ route('login') }}">Sign in</a>
                    </div>
                </form>
            </div>

            <!-- Right side - Image section -->
            <div class="right-panel">
                <img src="img/babyregister.jpg" alt="Registration Illustration">
            </div>
        </div>
    </div>

    <!-- FontAwesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Terms & Conditions Modal -->
    <div id="tncModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); padding:40px; overflow:auto;">

        <div style="background:#fff; padding:30px; border-radius:15px; max-width:700px; margin:auto;">
            <h2 style="margin-bottom:15px;">Terms & Conditions</h2>

            <p>
                By creating an account on TinyTrack, you acknowledge and agree to the following terms regarding
                your personal data and your baby's developmental information.
            </p>

            <h3>1. Collection of Personal and Baby Data</h3>
            <p>
                TinyTrack collects personal information such as your name, email, and account details, along with
                data about your baby including name, birthdate, growth measurements, milestones, and health
                records. This information is necessary for the accurate tracking of your baby's development.
            </p>

            <h3>2. Purpose of Data Usage</h3>
            <p>
                All collected data is used strictly for providing TinyTrack's features, such as growth charts,
                milestone tracking, vaccination reminders, and personalized insights. Your data will not be sold,
                shared, or used for advertising without your explicit consent.
            </p>

            <h3>3. Parental Consent</h3>
            <p>
                By registering, you confirm that you are the parent or legal guardian of the baby whose data is
                submitted. You agree you have the authority to provide this information and permit TinyTrack to
                store and process it.
            </p>

            <h3>4. Data Protection and Security</h3>
            <p>
                TinyTrack implements security measures to protect your personal and baby data. However, no system
                is entirely risk-free. By using the platform, you acknowledge that you understand and accept the
                inherent risks of online data storage.
            </p>

            <h3>5. Access and Control</h3>
            <p>
                You maintain full ownership and control of both your data and your baby's data. You may update,
                download, or request deletion of your account and related information at any time.
            </p>

            <h3>6. Accuracy of Information</h3>
            <p>
                You are responsible for ensuring that all information provided (including baby weights, heights,
                milestones, and medical notes) is accurate to maintain correct tracking and insights.
            </p>

            <h3>7. Updates to Terms</h3>
            <p>
                TinyTrack may update these Terms & Conditions periodically. Continued use of the platform
                indicates your acceptance of any changes.
            </p>

            <br>
            <button onclick="document.getElementById('tncModal').style.display='none'"
                    style="background:#789DBC; color:white; border:none; padding:10px 20px;
                        border-radius:8px; cursor:pointer;">
                Close
            </button>
        </div>
    </div>
</x-guest-layout>
