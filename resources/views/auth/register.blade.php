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

        <div style="background:#fff; padding:30px; border-radius:15px; max-width:900px; margin:auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:16px;">
                <h2 style="margin:0; font-weight:bold;">Terms &amp; Conditions</h2>
                <small style="color:#666;">Effective date: January 1, 2026</small>
            </div>

            <div style="margin-top:12px; color:#444; line-height:1.6; font-size:0.95rem;">
                <p>
                    Thank you for choosing TinyTrack. These Terms &amp; Conditions describe how we collect,
                    use, disclose and protect your personal information and your child's developmental data when
                    you use our services. By registering an account, you accept and agree to these terms.
                </p>

                <h3 style="margin-top:14px; font-weight:bold;">1. What we collect</h3>
                <ul>
                    <li>Account details: name, email, password (securely stored), contact number.</li>
                    <li>Child information: name, date of birth, gender, growth measurements, milestones, immunizations and medical notes you choose to record.</li>
                    <li>Usage data: preferences, features used, device and browser information, and logs to help improve the service.</li>
                </ul>

                <h3 style="margin-top:10px; font-weight:bold;">2. Purpose and legal basis</h3>
                <p>
                    We process your data to provide and improve TinyTrack features (growth charts, milestone tracking,
                    reminders, and personalized insights), to communicate with you, and to meet legal and security requirements.
                    Where required by law, we rely on your consent or on legitimate interests to process data.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">3. Malaysian Personal Data Protection Act (PDPA 2010)</h3>
                <p>
                    If you are located in Malaysia, the collection and processing of personal data is governed by the
                    Personal Data Protection Act 2010 (PDPA). In accordance with PDPA:
                </p>
                <ul>
                    <li>We will collect and use your personal data only for purposes that are necessary and related to the services we provide.</li>
                    <li>We will obtain consent where required and will not process your personal data in a way that is incompatible with the purpose for which it was collected.</li>
                    <li>You have the right to request access to, correction of, or deletion of your personal data held by us, subject to applicable exceptions under law.</li>
                    <li>We will implement reasonable measures to protect personal data from loss, misuse, modification or unauthorised access.</li>
                </ul>
                <p>
                    To make a PDPA-related request (access, correction, deletion, or complaint), please contact our Data Protection Officer at the contact details below.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">4. Consent &amp; parental responsibility</h3>
                <p>
                    By submitting your child's information you confirm that you are the parent or legal guardian authorized to provide such information.
                    You may withdraw consent for certain processing activities at any time by contacting us, subject to legal or contractual restrictions.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">5. Sharing, disclosures and third parties</h3>
                <p>
                    We do not sell personal data. We may disclose information to service providers who act on our behalf (e.g., hosting, email, analytics),
                    and to comply with legal obligations or to protect rights and safety. We require third parties to safeguard your data.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">6. Data retention and transfers</h3>
                <p>
                    We retain personal data only as long as necessary for the purposes described, or to comply with legal obligations. Data may be
                    transferred or stored outside your country of residence; where transfers occur we take steps to ensure appropriate safeguards are in place.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">7. Security</h3>
                <p>
                    We use reasonable technical and organisational measures to protect data. However, no internet service is completely secure; you accept
                    the small inherent risks of online services when using TinyTrack.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">8. Your rights</h3>
                <ul>
                    <li>Access: Request a copy of the personal data we hold about you.</li>
                    <li>Rectification: Request correction of inaccurate or incomplete data.</li>
                    <li>Erasure: Request deletion of your personal data (subject to legal retention requirements).</li>
                    <li>Restriction &amp; objection: Request restriction of processing or object to certain processing based on legitimate grounds.</li>
                </ul>
                <p>
                    To exercise these rights, contact our Data Protection Officer. We may require identity verification before fulfilling requests.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">9. Children and parental controls</h3>
                <p>
                    TinyTrack is designed for parents and guardians. We do not knowingly collect personal data directly from children without parental consent.
                    If you believe a child's personal data has been provided without proper consent, contact us and we will take steps to remove it.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">10. Changes to these terms</h3>
                <p>
                    We may update these Terms &amp; Conditions periodically. We will post changes within the app and update the effective date. Continued use
                    after changes indicates acceptance of the updated terms.
                </p>

                <h3 style="margin-top:10px; font-weight:bold;">11. Contact &amp; complaints</h3>
                <p>
                    For questions, PDPA requests, or to lodge a privacy complaint, contact:
                </p>
                <ul>
                    <li>Data Protection Officer: TinyTrack</li>
                    <li>Email: <a href="mailto:privacy@tinytrack.example">privacy@tinytrack.example</a></li>
                    <li>Address: Gombak, Selangor</li>
                </ul>

                <p style="margin-top:8px; font-weight:bold;">
                    If you remain unsatisfied after contacting us, you may refer your complaint to the relevant data protection authority
                    (for Malaysia: the Personal Data Protection Commissioner) or the authority in your jurisdiction.
                </p>

                <div style="text-align:center; margin-top:18px;">
                    <button onclick="document.getElementById('tncModal').style.display='none'"
                            style="background:#789DBC; color:white; border:none; padding:10px 22px;
                                border-radius:8px; cursor:pointer;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
