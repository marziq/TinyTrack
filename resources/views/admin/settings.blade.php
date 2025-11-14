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

                <div class="row">

                    <!-- Left Column: Profile Card (Hardcoded Edit) -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                @if (Auth::check())
                                    <img src="{{ Auth::user()->profile_photo_url }}" class="rounded-circle mb-3" width="120" alt="Profile" style="border: 3px solid #3498db; !important">
                                    <h4 id="display-name">{{ Auth::user()->name }}</h4>
                                    <p class="text-secondary mb-1" style="color: #3498db !important">Admin</p>
                                    <p class="text-muted" style="color:#3498db !important; font-size: 15px;">User ID: TT{{ Auth::user()->id }}</p>
                                @else
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="rounded-circle mb-3" width="120" alt="Profile">
                                    <h4>Guest</h4>
                                    <p class="text-secondary mb-1">Admin</p>
                                    <p class="text-muted">-</p>
                                @endif
                            </div>
                            <ul class="list-group list-group-flush text-start">
                                <li class="list-group-item"><i class="fas fa-globe me-2"></i> Website: <span class="text-muted" id="display-website">{{ Auth::user()->website ?? 'Not provided' }}</span></li>
                                <li class="list-group-item"><i class="fab fa-github me-2"></i> Github: <span class="text-muted" id="display-github">{{ Auth::user()->github ?? 'Not provided' }}</span></li>
                                <li class="list-group-item"><i class="fab fa-twitter me-2"></i> Twitter: <span class="text-muted" id="display-twitter">{{ Auth::user()->twitter ?? 'Not provided' }}</span></li>
                                <li class="list-group-item"><i class="fab fa-instagram me-2"></i> Instagram: <span class="text-muted" id="display-instagram">{{ Auth::user()->instagram ?? 'Not provided' }}</span></li>
                                <li class="list-group-item"><i class="fab fa-facebook me-2"></i> Facebook: <span class="text-muted" id="display-facebook">{{ Auth::user()->facebook ?? 'Not provided' }}</span></li>
                            </ul>
                            <div class="mb-2">
                                <br>
                                <button class="btn btn-outline-primary btn-sm" id="editProfileBtn">Edit</button>
                            </div>
                        </div>

                        <!-- Edit Modal for Profile Card -->
                        <div id="editProfileModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center;">
                            <div style="background: white; padding: 30px; border-radius: 8px; width: 90%; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                <h5 style="margin-bottom: 20px; font-weight: 600;">Edit Social Links</h5>
                                <form id="socialLinksForm" method="POST" action="{{ route('admin.settings.update') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="edit-website">Website:</label>
                                        <input type="text" id="edit-website" name="website" placeholder="https://example.com" value="{{ Auth::user()->website ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-github">Github:</label>
                                        <input type="text" id="edit-github" name="github" placeholder="github-username" value="{{ Auth::user()->github ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-twitter">Twitter:</label>
                                        <input type="text" id="edit-twitter" name="twitter" placeholder="@twitter-handle" value="{{ Auth::user()->twitter ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-instagram">Instagram:</label>
                                        <input type="text" id="edit-instagram" name="instagram" placeholder="instagram-username" value="{{ Auth::user()->instagram ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-facebook">Facebook:</label>
                                        <input type="text" id="edit-facebook" name="facebook" placeholder="facebook-username" value="{{ Auth::user()->facebook ?? '' }}">
                                    </div>
                                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    <div class="btn-group-edit">
                                        <button type="submit" class="btn-save" id="saveProfileBtn">Save</button>
                                        <button type="button" class="btn-cancel" id="cancelProfileBtn">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: User Info (Database Edit) -->
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <!-- View Mode -->
                            <div class="view-mode" id="viewMode">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Full Name</strong></div>
                                        <div class="col-sm-9 text-secondary" id="display-full-name">{{ Auth::user()->name }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Email</strong></div>
                                        <div class="col-sm-9 text-secondary" id="display-email">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Gender</strong></div>
                                        <div class="col-sm-9 text-secondary" id="display-gender">{{ Auth::user()->gender ?? 'Not specified' }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Mobile</strong></div>
                                        <div class="col-sm-9 text-secondary" id="display-mobile">{{ Auth::user()->mobile_number ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary" id="editUserInfoBtn" style="padding:5px 20px 5px 20px; !important;">Edit</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Mode -->
                            <div class="edit-mode" id="editMode">
                                <form id="userSettingsForm" method="POST" action="{{ route('admin.settings.update') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="edit-name">Full Name</label>
                                            <input type="text" id="edit-name" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-email">Email</label>
                                            <input type="email" id="edit-email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-gender">Gender</label>
                                            <select id="edit-gender" name="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ Auth::user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ Auth::user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ Auth::user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit-mobile">Mobile Number</label>
                                            <input type="text" id="edit-mobile" name="mobile_number" class="form-control" value="{{ Auth::user()->mobile_number ?? '' }}">
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary" style="padding:5px 20px 5px 20px; !important;">Save</button>
                                            <button type="button" id="cancelUserInfoBtn" class="btn btn-secondary" style="padding:5px 20px 5px 20px; !important;">Cancel</button>
                                        </div>
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

            // Edit Profile Card (Database - Left Column)
            const editProfileBtn = document.getElementById('editProfileBtn');
            const editProfileModal = document.getElementById('editProfileModal');
            const cancelProfileBtn = document.getElementById('cancelProfileBtn');
            const saveProfileBtn = document.getElementById('saveProfileBtn');
            const socialLinksForm = document.getElementById('socialLinksForm');

            editProfileBtn.addEventListener('click', function() {
                editProfileModal.style.display = 'flex';
            });

            cancelProfileBtn.addEventListener('click', function() {
                editProfileModal.style.display = 'none';
            });

            editProfileModal.addEventListener('click', function(e) {
                if (e.target === editProfileModal) {
                    editProfileModal.style.display = 'none';
                }
            });

            saveProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                socialLinksForm.submit();
            });

            // Edit User Info (Database - Right Column)
            const editUserInfoBtn = document.getElementById('editUserInfoBtn');
            const cancelUserInfoBtn = document.getElementById('cancelUserInfoBtn');
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');

            editUserInfoBtn.addEventListener('click', function() {
                viewMode.classList.add('hidden');
                editMode.classList.add('active');
            });

            cancelUserInfoBtn.addEventListener('click', function() {
                viewMode.classList.remove('hidden');
                editMode.classList.remove('active');
                // Reset form to current values
                document.getElementById('edit-name').value = document.getElementById('display-full-name').textContent;
                document.getElementById('edit-email').value = document.getElementById('display-email').textContent;
                document.getElementById('edit-mobile').value = document.getElementById('display-mobile').textContent;
            });

            // User settings form submission
            document.getElementById('userSettingsForm').addEventListener('submit', function(e) {
                // Form will submit normally to update the database
                // After submission, the page will redirect with success message
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
