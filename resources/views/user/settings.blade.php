<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comic+Relief:wght@400;700&family=Outfit:wght@100..900&family=Sigmar&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=IM+Fell+Great+Primer+SC&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #e3f2fd;
            padding: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
            color: #1976d2;
            font-family: 'Outfit', sans-serif;
            font-weight: bold;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border-radius: 6px;
            margin-bottom: 5px;
            font-size: 15px;
        }
        .sidebar a:not([style]) {
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.30);
            margin-bottom: 20px;
        }
        /* Active state for sidebar links (ensure Settings link shows highlighted) */
        .sidebar a.active {
            background-color: #1976d2;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.30);
        }
        /* Force icon color to white even if inline styles were used on the <i> */
        .sidebar a.active i {
            color: #fff !important;
        }
        .sidebar a:hover {
            background-color: #bbdefb;
            color: #0d47a1;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .main {
            flex: 1;
            padding: 20px;
            position: relative;
            transition: margin-left 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.hidden + .main {
            margin-left: -250px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 10px 0;
            position: relative;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #1976d2;
            z-index: 20;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .toggle-btn:hover {
            background-color: #e3f2fd;
        }

        .topbar h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            color: #333;
            font-size: 24px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Notification Icon */
        .notification-icon {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .notification-icon:hover {
            background-color: #e3f2fd;
        }

        .notification-icon i {
            font-size: 20px;
            color: #555;
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        /* Profile Dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        .profile-btn:hover {
            background-color: #e3f2fd;
        }

        .profile-img-container {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .arrow-icon {
            font-size: 12px;
            transition: transform 0.2s;
            color: #777;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 8px 0;
            margin-top: 8px;
            z-index: 1000;
            display: none;
            list-style: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i {
            margin-right: 10px;
            width: 18px;
            text-align: center;
            color: #555;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 8px 0;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-danger:hover {
            color: #c82333 !important;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .card {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin-bottom: 15px;
            color: #555;
            font-size: 24px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 0;
        }

        .form-label, .form-check-label, .form-select, .form-control {
            font-size: 1.1rem;
        }
        .welcome-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #666;
        }

        /* Add spacing between menu and content */
        .settings-row {
            display: flex;
            gap: 32px;
            align-items: flex-start;
        }
        @media (max-width: 991px) {
            .settings-row {
                flex-direction: column;
                gap: 20px;
            }
        }

        /* Add a vertical divider */
        .settings-divider {
            width: 2px;
            min-height: 350px;
            margin: 0 16px;
            border-radius: 2px;
        }

        /* Card padding adjustments for smaller screens */
        @media (max-width: 768px) {
            .card {
                padding: 20px !important;
            }
            .settings-divider {
                display: none;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                height: 100vh;
                z-index: 100;
            }

            .sidebar.hidden {
                transform: translateX(-100%);
            }

            .main {
                width: 100%;
                padding: 15px;
            }

            .topbar h1 {
                position: static;
                transform: none;
                margin-right: auto;
                margin-left: 15px;
                font-size: 20px;
            }

            .topbar {
                flex-wrap: wrap;
                gap: 15px;
            }

            .topbar-right {
                margin-left: auto;
            }
        }
        /* Notification Popup Styles */
        .notification-popup {
            position: absolute;
            top: 35px;
            right: 0;
            min-width: 260px;
            background: #fff;
            border: 1px solid #e3f2fd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            z-index: 1001;
            padding: 10px 0;
        }
        .notification-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .notification-item {
            padding: 10px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            cursor: pointer;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .no-notification {
            padding: 16px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }

        /* Settings Menu Card Styling */
        /* Make the menu a natural column that doesn't force large fixed height and allows consistent gaps */
        .settings-menu-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 12px;
        }
        /* Make the list-group a column layout with consistent gap between items.
           Use flex-start (not space-between) so gaps between items are equal. */
        #settingsMenu {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 12px;
            height: 100%;
        }
        #settingsMenu .list-group-item {
            font-size: 1.18rem;
            padding: 14px 16px;
            border-radius: 8px;
            text-align: center;
            transition: background 0.2s, color 0.2s;
            margin-bottom: 0; /* ensure no extra margins create uneven spacing */
        }
        #settingsMenu .list-group-item.active {
            background-color: #1976d2;
            color: #fff !important;
            font-weight: bold;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.18);
            border: 2px solid #1976d2;
        }
        #settingsMenu .list-group-item:focus {
            outline: none;
            box-shadow: 0 0 0 2px #90caf9;
        }
        @media (max-width: 991px) {
            .settings-menu-card {
                height: auto;
            }
            #settingsMenu .list-group-item {
                font-size: 1.1rem;
                padding: 14px 12px;
            }
        }

        /* Ensure the two columns inside the combined card stretch to the same height */
        .card .card-body .row {
            align-items: stretch;
        }
        body.dark-mode {
            background-color: #181a1b !important;
            color: #e0e0e0 !important;
        }
        .dark-mode .sidebar {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
        }
        .dark-mode .main, .dark-mode .card, .dark-mode .welcome-section {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
            box-shadow: none;
        }
        .dark-mode .card-header, .dark-mode .dropdown-menu {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
        }
        .dark-mode .form-control, .dark-mode .form-select {
            background-color: #23272b !important;
            color: #e0e0e0 !important;
            border-color: #444;
        }
        .dark-mode .dropdown-item {
            color: #e0e0e0 !important;
        }
        .dark-mode .dropdown-item:hover {
            background-color: #333 !important;
        }
        .dark-mode .notification-popup {
            background: #23272b !important;
            color: #e0e0e0 !important;
            border-color: #444;
        }
        /* Font size adjustment */
        body.font-large, .font-large .main, .font-large .card, .font-large .form-control, .font-large .form-select {
            font-size: 1.15rem !important;
        }
        body.font-xlarge, .font-xlarge .main, .font-xlarge .card, .font-xlarge .form-control, .font-xlarge .form-select {
            font-size: 1.3rem !important;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <a href="{{route('mybaby')}}" style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('img/tinytrack-logo.png') }}" alt="Logo" style="height: 36px; width: 36px; object-fit: contain;">
            <h2 style="margin-bottom: 0; font-weight: bold;">My Dashboard</h2>
        </a>
        <hr style="color: #1976d2">
        <a href="{{route('mybaby')}}"><i class="fas fa-child" style="color:rgb(31, 63, 221)"></i> My Baby</a>
        <a href="{{route('growth')}}"><i class="fas fa-chart-line" style="color: rgb(242, 114, 136)"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb" style="color: #FFD700;"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye" style="color: red"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar" style="color: #16fc38"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot" style="color: orangered"></i> Chat With Sage</a>
        <a href="{{route('settings')}}" class="active"><i class="fas fa-cog" style="color: #666"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">Settings</h1>
            <div class="topbar-right">
                <!-- Notification Icon -->
                 <div class="notification-icon" id="notificationBell" style="position: relative;">
                    <i class="fas fa-bell"></i>
                    @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                    @endif
                    <div id="notificationPopup" class="notification-popup" style="display: none;">
                        <ul class="notification-list">
                            @forelse($userNotifications as $notif)
                                <li class="notification-item {{ $notif->status == 'unread' ? 'fw-bold' : '' }}" data-id="{{ $notif->notification_id }}">
                                    <strong>{{ $notif->title }}</strong><br>
                                    <span>{{ $notif->message }}</span>
                                    <div style="font-size: 11px; color: #888;">{{ $notif->dateSent }}</div>
                                </li>
                            @empty
                                <li class="no-notification">No notifications.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="profile-btn" type="button" id="accountDropdown">
                        <div class="profile-img-container">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
                        </div>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item" href="{{route('mainpage')}}"><i class="fa-solid fa-house"></i> Home</a></li>
                        <li><a class="dropdown-item" href="{{route('mybaby')}}"><i class="fas fa-baby"></i> My Baby</a></li>
                        <li><a class="dropdown-item" href="{{route('myaccount')}}"><i class="fa-solid fa-address-card"></i> My Account</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="background: none; border: none; width: 100%; text-align: left;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

       {{--Main Content--}}
       <div class="container" style="max-width: 950px;">
            <div class="settings-row">
                <!-- Combined Settings Card (Menu + Content) -->
                <div style="flex: 1 1 0;">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="font-size:1.25rem; margin:0;">Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Menu Column -->
                                <div class="col-md-4 mb-3">
                                    <div class="settings-menu-card" style="height:100%;">
                                        <div class="list-group" id="settingsMenu">
                                            <button type="button" class="list-group-item list-group-item-action active" data-section="basic">Basic Settings</button>
                                            <button type="button" class="list-group-item list-group-item-action" data-section="notifications">Notification Preferences</button>
                                            <button type="button" class="list-group-item list-group-item-action" data-section="password">Update Password</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Column -->
                                <div class="col-md-8">
                                    <!-- Basic Settings Section -->
                                    <div id="basicSettingsSection">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h3>Basic Settings</h3>
                                            </div>
                                            <div class="card-body">
                                                <!-- Dark Mode Switch -->
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                                    <label class="form-check-label" for="darkModeSwitch">Enable Dark Mode</label>
                                                </div>
                                                <!-- Font Size Adjustment -->
                                                <div class="mb-3">
                                                    <label for="fontSizeSelect" class="form-label">Font Size</label>
                                                    <select class="form-select" id="fontSizeSelect">
                                                        <option value="normal" selected>Normal</option>
                                                        <option value="large">Large</option>
                                                        <option value="xlarge">Extra Large</option>
                                                    </select>
                                                </div>
                                                <!-- Privacy Settings -->
                                                <div class="mb-3">
                                                    <label class="form-label">Privacy</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="showProfile" checked>
                                                        <label class="form-check-label" for="showProfile">Show my profile to other users</label>
                                                    </div>
                                                </div>
                                                <!-- Account Actions -->
                                                <div class="mb-3">
                                                    <button class="btn btn-outline-danger" type="button" onclick="alert('Account deletion is not implemented in this demo.')">Delete Account</button>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="alert('Data download is not implemented in this demo.')">Download My Data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notification Preferences Section -->
                                    <div id="notificationSettingsSection" style="display:none;">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h3>Notification Preferences</h3>
                                            </div>
                                            <div class="card-body">
                                                <!-- Notification Preferences -->
                                                <div class="mb-3">
                                                    <label class="form-label">Choose how you want to be notified:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="notifEmail" checked>
                                                        <label class="form-check-label" for="notifEmail">Email Notifications</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="notifApp" checked>
                                                        <label class="form-check-label" for="notifApp">App Notifications</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Password Section -->
                                    <div id="passwordSettingsSection" style="display:none;">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3>Update Password</h3>
                                            </div>
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('user-password.update') }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Current Password -->
                                                    <div class="mb-3">
                                                        <label for="current_password" class="form-label">Current Password</label>
                                                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                                                    </div>
                                                    <!-- New Password -->
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">New Password</label>
                                                        <input type="password" name="password" id="password" class="form-control" required>
                                                    </div>
                                                    <!-- Confirm Password -->
                                                    <div class="mb-3">
                                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Main Content End--}}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // --- Dark Mode Logic Start ---
        const body = document.body;
        const darkModeSwitch = document.getElementById('darkModeSwitch');
        const localStorageKey = 'userDarkMode';

        // 1. Function to apply the class
        function applyTheme(isDark) {
            if (isDark) {
                body.classList.add('dark-mode');
            } else {
                body.classList.remove('dark-mode');
            }
        }

        // 2. Load the initial state from Local Storage (or default to false/light)
        let initialDarkMode = localStorage.getItem(localStorageKey) === 'true';
        applyTheme(initialDarkMode);

        // 3. Set the switch state on page load
        if (darkModeSwitch) {
            darkModeSwitch.checked = initialDarkMode;

            // 4. Listener for the toggle switch
            darkModeSwitch.addEventListener('change', function() {
                const isChecked = this.checked;
                // a. Apply theme immediately
                applyTheme(isChecked);

                // b. Save preference to Local Storage
                localStorage.setItem(localStorageKey, isChecked);

                // c. OPTIONAL: You can also send an AJAX request here to save it in the database
                // (This is better if you want the setting to sync across devices)
                // saveDarkModePreference(isChecked);
            });
        }

        // --- Dark Mode Logic End ---
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');

            // Update the toggle button icon
            const toggleBtn = document.querySelector('.toggle-btn');
            const iconClass = sidebar.classList.contains('hidden') ? 'fa-bars' : 'fa-times';
            toggleBtn.querySelector('i').className = `fas ${iconClass}`;
        }

        // Profile dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profileBtn = document.querySelector('.profile-btn');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            const arrowIcon = document.querySelector('.arrow-icon');

            if (profileBtn && dropdownMenu && arrowIcon) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                    arrowIcon.style.transform = dropdownMenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    dropdownMenu.classList.remove('show');
                    arrowIcon.style.transform = 'rotate(0)';
                });
            }

            // Close dropdown when clicking on a dropdown item
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    dropdownMenu.classList.remove('show');
                    arrowIcon.style.transform = 'rotate(0)';
                });
            });
        });

        // Make the dropdown menu close when clicking outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.profile-btn') && !event.target.closest('.dropdown-menu')) {
                const dropdowns = document.querySelectorAll('.dropdown-menu');
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
                const arrows = document.querySelectorAll('.arrow-icon');
                arrows.forEach(arrow => {
                    arrow.style.transform = 'rotate(0)';
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const bell = document.getElementById('notificationBell');
            const popup = document.getElementById('notificationPopup');

            bell.addEventListener('click', function(e) {
                e.stopPropagation();
                popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function() {
                popup.style.display = 'none';
            });

            // Mark notification as read and show full message
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const notifId = this.getAttribute('data-id');
                    fetch(`/notifications/${notifId}/mark-read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }).then(() => {
                        // Remove the notification from the popup view
                        this.remove();

                        // Show full notification in a modal
                        showNotificationModal(
                            this.querySelector('strong').innerText,
                            this.querySelector('span').innerText,
                            this.querySelector('div').innerText
                        );

                        // Optionally update badge count
                        let badge = document.querySelector('.notification-badge');
                        if (badge) {
                            let count = parseInt(badge.innerText) - 1;
                            badge.innerText = count > 0 ? count : '';
                            if (count <= 0) badge.style.display = 'none';
                        }

                        // If no notifications left, show "No notifications."
                        if (document.querySelectorAll('.notification-item').length === 0) {
                            const list = document.querySelector('.notification-list');
                            list.innerHTML = '<li class="no-notification">No notifications.</li>';
                        }
                    });
                });
            });
    });
    // Show notification modal
        function showNotificationModal(title, message, date) {
            let modalHtml = `
            <div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="notifModalLabel">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>${message}</p>
                    <div style="font-size: 12px; color: #888;">${date}</div>
                  </div>
                </div>
              </div>
            </div>
            `;
            // Remove existing modal if any
            document.getElementById('notifModal')?.remove();
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            let notifModal = new bootstrap.Modal(document.getElementById('notifModal'));
            notifModal.show();
        }
        // Settings Menu switching logic
        document.addEventListener('DOMContentLoaded', function() {
            const menuButtons = document.querySelectorAll('#settingsMenu button');
            const sections = {
                basic: document.getElementById('basicSettingsSection'),
                notifications: document.getElementById('notificationSettingsSection'),
                password: document.getElementById('passwordSettingsSection')
            };
            menuButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    menuButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    Object.values(sections).forEach(sec => sec.style.display = 'none');
                    sections[this.dataset.section].style.display = '';
                });
            });
        });
    </script>


</body>
</html>
