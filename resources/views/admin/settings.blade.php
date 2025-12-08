<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
            transition: all 0.3s;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #243b55 0%, #141e30 100%);
            color: #fff;
            height: 100vh;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 12px rgba(20,30,48,0.08);
            border-right: 1px solid #22304a;
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .sidebar-header {
            padding: 28px 20px 20px 20px;
            background: rgba(20,30,48,0.95);
            display: flex;
            justify-content: flex-start;
            align-items: center;
            border-bottom: 1px solid #22304a;
        }

        .sidebar-header h3 {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #fff;
            margin: 0;
        }

        .sidebar-menu {
            padding: 30px 0 0 0;
        }

        .sidebar-menu li {
            list-style: none;
            padding: 14px 28px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border-left 0.2s;
            font-size: 16px;
            border-left: 4px solid transparent;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            width: 100%;
            color: inherit;
            text-decoration: none;
            background: none;
            border: none;
            font: inherit;
            padding: 0;
            transition: color 0.2s;
            cursor: pointer;
        }

        .sidebar-menu li a:visited,
        .sidebar-menu li a:active,
        .sidebar-menu li a:focus {
            color: inherit;
            text-decoration: none;
            outline: none;
        }

        .sidebar-menu li:hover {
            background: rgba(52, 152, 219, 0.12);
            color: #3498db;
            border-left: 4px solid #3498db;
        }

        .sidebar-menu li.active {
            background: rgba(52, 152, 219, 0.18);
            color: #3498db;
            border-left: 4px solid #3498db;
            font-weight: 600;
        }

        .sidebar-menu li i {
            margin-right: 16px;
            width: 22px;
            text-align: center;
            font-size: 18px;
            color: inherit;
            transition: color 0.2s;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            transition: all 0.3s;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Top Navigation Styles */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #333;
            padding: 5px;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
        }

        .notification-icon i {
            font-size: 20px;
            color: #555;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        /* Profile Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 8px;
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
             padding-left: 0;
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
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 8px 0;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 30px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 25px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #555;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .dropdown-menu li {
            list-style: none;
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-nav {
                padding: 15px 20px;
            }

            .dropdown-menu {
                min-width: 180px;
            }
        }
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
        .edit-mode {
            display: none;
        }
        .edit-mode.active {
            display: block;
        }
        .view-mode {
            display: block;
        }
        .view-mode.hidden {
            display: none;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-group-edit {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn-save {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-save:hover {
            background-color: #2980b9;
        }
        .btn-cancel {
            background-color: #95a5a6;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-cancel:hover {
            background-color: #7f8c8d;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }
        /* Profile Photo Wrapper Styles */
        .profile-photo-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 10px auto;
        }

        .profile-photo-wrapper img.profile-img-preview {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .edit-photo-icon {
            position: absolute;
            right: -6px;
            bottom: -6px;
            background: #0d47a1;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(255,92,0,0.22);
            border: 4px solid #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-photo-icon:hover {
            background-color: #1565c0;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        .form-input {
            border-radius: 8px;
            box-shadow: none;
            border: 1px solid #e6eef9;
            padding: 12px 14px;
        }

        .form-input:focus {
            border-color: #0d47a1;
            box-shadow: 0 0 0 0.2rem rgba(13, 71, 161, 0.25);
        }

        .save-btn {
            background: linear-gradient(135deg, #1976d2 0%, #0d47a1 100%);
            color: #fff;
            border: none;
            padding: 12px 42px;
            border-radius: 28px;
            box-shadow: 0 18px 36px rgba(255,92,0,0.18);
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: transform .12s ease, box-shadow .12s ease, opacity .12s ease;
            display: inline-block;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(13,71,161,0.22);
        }

        .save-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #e9ecef;
            padding: 0 0 15px 0;
        }

        .card-header h3 {
            margin: 0;
            color: #555;
            font-size: 18px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3>Dashboard</h3>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('analytics') ? 'active' : '' }}">
                <a href="{{ route('dashboard-admin') }}"><i class="fas fa-chart-line"></i> Analytics</a>
            </li>
            <li class="{{ request()->routeIs('users') ? 'active' : '' }}">
                <a href="{{ route('users-admin') }}"><i class="fas fa-users"></i> Users</a>
            </li>
            <li class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                <a href="{{ route('adminsettings') }}"><i class="fas fa-cog"></i> Settings</a>
            </li>
            <li class="{{ request()->routeIs('messages') ? 'active' : '' }}">
                <a href="{{ route('messages-admin') }}"><i class="fas fa-envelope"></i> Messages</a>
            </li>
            <li class="{{ request()->routeIs('calendar') ? 'active' : '' }}">
                <a href="{{ route('admincalendar') }}"><i class="fas fa-calendar"></i> Calendar</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="nav-icons">
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
                <div class="dropdown">
                    <!-- Profile picture button -->
                    <button class="profile-btn" type="button" id="accountDropdown">
                        <div class="profile-img-container">
                            @if (Auth::check())
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
                            @else
                                <script>
                                    window.location.href = "{{ route('login') }}";  // Redirect to login page
                                </script>
                            @endif
                        </div>
                        <i class="fas fa-chevron-down text-muted arrow-icon"></i>
                    </button>

                    <!-- Dropdown menu -->
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item" href="{{ route('dashboard-admin') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>

                    <!-- Hidden logout form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="container mt-5">
                @if ($message = Session::get('success'))
                    <div class="alert-success">
                        {{ $message }}
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Profile Information Card -->
                        <div class="card">
                            <h3>Profile Information</h3>
                            <div class="card-body">
                                <!-- Inline Edit Mode (matches myaccount design) -->
                                @php
                                    $nameParts = explode(' ', trim(Auth::user()->name ?? ''), 2);
                                    $firstName = $nameParts[0] ?? '';
                                    $lastName = $nameParts[1] ?? '';
                                @endphp
                                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="text-start" id="inlineProfileForm">
                                    @csrf
                                    <input type="hidden" name="name" id="full_name_input" value="{{ old('name', Auth::user()->name) }}">

                                    <div class="profile-photo-wrapper">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img-preview">
                                        <label class="edit-photo-icon" title="Change photo">
                                            <i class="fas fa-pencil-alt"></i>
                                            <input type="file" name="profile_photo" id="inline_profile_photo" style="display:none">
                                        </label>
                                    </div>

                                    <h4 class="text-center mb-3">{{ Auth::user()->name }}</h4>
                                    <p class="text-muted" style="font-size: 15px; color:#0d47a1 !important">User ID: {{ Auth::user()->id }}</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="first_name" class="form-control form-input" value="{{ old('first_name', $firstName) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control form-input" value="{{ old('last_name', $lastName) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control form-input" value="{{ old('email', Auth::user()->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="mobile_number" class="form-control form-input" value="{{ old('mobile_number', Auth::user()->mobile_number) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" class="form-control form-input">
                                                <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Account Type</label>
                                            <div class="form-control form-input" style="background-color: #f8f9fa;">
                                                Admin
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save button section -->
                                    <div class="d-flex justify-content-center mt-4">
                                        @if(!isset($isEditing))
                                            <button type="button" class="save-btn" id="editButton" onclick="toggleEditMode(true)">Update Profile</button>
                                        @else
                                            <button type="submit" class="save-btn">Save Changes</button>
                                            <button type="button" class="btn btn-secondary ms-2" onclick="toggleEditMode(false)">Cancel</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Social Media Settings Card -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h3>Social Media Settings</h3>
                            </div>
                            <div class="card-body">
                                <form id="socialMediaForm" method="POST" action="{{ route('admin.settings.update') }}" class="text-start">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label"><i class="fas fa-globe me-2"></i>Website</label>
                                            <input type="url" name="website" class="form-control form-input" placeholder="https://example.com" value="{{ Auth::user()->website ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><i class="fab fa-github me-2"></i>Github</label>
                                            <input type="text" name="github" class="form-control form-input" placeholder="github-username" value="{{ Auth::user()->github ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><i class="fab fa-twitter me-2"></i>Twitter</label>
                                            <input type="text" name="twitter" class="form-control form-input" placeholder="@twitter-handle" value="{{ Auth::user()->twitter ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><i class="fab fa-instagram me-2"></i>Instagram</label>
                                            <input type="text" name="instagram" class="form-control form-input" placeholder="instagram-username" value="{{ Auth::user()->instagram ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><i class="fab fa-facebook me-2"></i>Facebook</label>
                                            <input type="text" name="facebook" class="form-control form-input" placeholder="facebook-username" value="{{ Auth::user()->facebook ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="submit" class="save-btn">Save Social Links</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleSidebar = document.getElementById('toggleSidebar');

            // Toggle sidebar
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                // Change icon based on state
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-indent');
                } else {
                    icon.classList.remove('fa-indent');
                    icon.classList.add('fa-bars');
                }
            });

            // For mobile view
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                    toggleSidebar.querySelector('i').classList.add('fa-bars');
                } else {
                    // Reset to default for larger screens
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            }

            // Check on load and resize
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);

            // Add click event to menu items
            const menuItems = document.querySelectorAll('.sidebar-menu li');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Profile dropdown functionality
            const profileBtn = document.querySelector('.profile-btn');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            const arrowIcon = document.querySelector('.arrow-icon');

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

            // Notification popup functionality
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

            // Profile form edit/save functionality
            function toggleEditMode(edit) {
                const form = document.getElementById('inlineProfileForm');
                const inputs = form.querySelectorAll('input:not([type="hidden"]), select');
                const editButton = document.getElementById('editButton');

                inputs.forEach(input => {
                    if (input.type !== 'file') {  // Don't disable file input
                        input.disabled = !edit;
                    }
                });

                if (edit) {
                    editButton.closest('.d-flex').innerHTML = `
                        <button type="submit" class="save-btn">Save Changes</button>
                        <button type="button" class="btn btn-secondary ms-2" onclick="toggleEditMode(false)">Cancel</button>
                    `;
                } else {
                    location.reload(); // Reload page to reset form
                }
            }

            // Initialize form in disabled state
            const form = document.getElementById('inlineProfileForm');
            const inputs = form.querySelectorAll('input:not([type="hidden"]), select');
            inputs.forEach(input => {
                if (input.type !== 'file') {
                    input.disabled = true;
                }
            });

            // Profile photo preview handler
            const fileInput = document.getElementById('inline_profile_photo');
            const preview = document.querySelector('.profile-img-preview');

            if (fileInput && preview) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.src = ev.target.result;
                    }
                    reader.readAsDataURL(file);
                });
            }

            // Combine first and last names into 'name' hidden input before submit
            if (form) {
                form.addEventListener('submit', function() {
                    const f = form.querySelector('input[name="first_name"]')?.value || '';
                    const l = form.querySelector('input[name="last_name"]')?.value || '';
                    const full = (f + ' ' + l).trim();
                    const hidden = document.getElementById('full_name_input');
                    if (hidden) hidden.value = full || '{{ Auth::user()->name }}';
                });
            }
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
