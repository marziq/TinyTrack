<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <title>Calendar</title>
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
            top: -4px;
            right: -6px;
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

        /* Bigger bell icon for the redesigned notification */
        .notification-btn i {
            font-size: 22px; /* increase bell size */
            color: #555;
        }

        /* Notification Popup Styles — redesigned */
        .notification-popup {
            position: absolute;
            top: 44px;
            right: 0;
            width: 560px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(20,30,60,0.12);
            z-index: 1001;
            padding: 12px;
            overflow: hidden;
        }

        .notification-popup .popup-header {
            padding: 8px 12px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            border-bottom: 1px solid #f1f5f9;
        }

        .notification-popup .popup-header h4 {
            margin:0;
            font-size:18px;
            color:#0f172a;
        }

        .notification-list {
            list-style: none;
            margin: 0;
            padding: 8px 4px;
            max-height: 420px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px;
            border-radius: 10px;
            background: transparent;
            transition: background .12s, transform .06s;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background: #fbfdff;
            transform: translateY(-2px);
        }

        .notification-item.tint {
            background: #f1fbff; /* subtle tint */
        }

        .notification-item + .notification-item {
            margin-top: 6px;
        }

        .notif-avatar {
            width:44px;
            height:44px;
            border-radius:50%;
            overflow:hidden;
            flex: 0 0 44px;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(16,24,40,0.08);
        }

        .notif-avatar img{ width:100%; height:100%; object-fit:cover; }

        .notif-body { flex:1; min-width:0 }

        .notif-title { font-weight:700; color:#0f172a; margin-bottom:4px; font-size:14px }
        .notif-message { color:#475569; font-size:13px; margin-bottom:8px; max-height:36px; overflow:hidden; text-overflow:ellipsis }

        .notif-meta { color:#94a3b8; font-size:12px; display:flex; gap:8px; align-items:center }

        /* Dot cue for unread */
        .notif-dot {
            width:10px;
            height:10px;
            border-radius:50%;
            background:#06b6d4;
            position:absolute;
            left:8px;
            top:18px;
            box-shadow: 0 0 0 4px rgba(6,182,212,0.06);
        }

        .no-notification { padding: 18px; text-align:center; color:#64748b }

        /* scrollbar styling */
        .notification-list::-webkit-scrollbar{ width:8px }
        .notification-list::-webkit-scrollbar-thumb{ background:#e2e8f0; border-radius:8px }


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

        /* Add this to your existing styles */
        #appointmentCalendar {
            max-width: 100%;
            margin: 0 auto;
        }

        .fc-event {
            cursor: pointer;
            color: #000 !important;
        }

        /* Custom colors for different appointment types */
        .fc-event-checkup {
            background-color: #4CAF50;
            border-color: #4CAF50;
            color: #000 !important;
        }

        .fc-event-vaccination {
            background-color: #2196F3;
            border-color: #2196F3;
            color: #000 !important;
        }

        .fc-event-consultation {
            background-color: #FF9800;
            border-color: #FF9800;
            color: #000 !important;
        }

        .fc-toolbar-title {
            font-size: 1.2em;
        }

        .fc-col-header-cell {
            background-color: #f8f9fa;
        }

        /* Override FullCalendar default text colors */
        .fc-h-event .fc-event-main {
            color: #000 !important;
        }

        .fc-event .fc-event-title {
            color: #000 !important;
        }

        .fc-daygrid-event .fc-event-title {
            color: #000 !important;
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
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="nav-icons">
                <!-- Notification Icon -->
                <div class="notification-wrapper" style="position: relative;">
                    <button id="notificationBell" class="notification-btn" aria-expanded="false" style="background:none;border:none;padding:6px 8px;cursor:pointer;color:inherit;">
                        <i class="fas fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </button>

                    <div id="notificationPopup" class="notification-popup" style="display: none;">
                        <div class="popup-header">
                            <h4>Notifications</h4>
                            <button id="markAllRead" class="btn btn-sm" style="background:none;border:none;color:#64748b;font-size:13px;padding:6px;">Mark all read</button>
                        </div>

                        <ul class="notification-list">
                            @forelse($userNotifications as $notif)
                                <li class="notification-item {{ $notif->status == 'unread' ? 'tint' : '' }}" data-id="{{ $notif->notification_id }}">
                                    <div class="notif-avatar">
                                        <img src="{{ $notif->avatar ?? asset('storage/baby-photos/tinytrack-logo.png') }}" alt="avatar">
                                    </div>

                                    <div class="notif-body">
                                        <div class="notif-title">{{ $notif->title }}</div>
                                        <div class="notif-message">{{ \Illuminate\Support\Str::limit($notif->message, 120) }}</div>
                                        <div class="notif-meta">
                                            <span>{{ $notif->category ?? '' }}</span>
                                            @if(!empty($notif->category))<span>•</span>@endif
                                            <span>{{ $notif->dateSent }}</span>
                                        </div>
                                    </div>

                                    @if($notif->status == 'unread')
                                        <div class="notif-dot" aria-hidden="true"></div>
                                    @endif
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
                                {{-- Use stored asset if user uploaded a profile photo (profile_photo_path), otherwise fall back to profile_photo_url --}}
                                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
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
                <h2 class="mb-4">Appointment Calendar</h2>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"> </h5>
                        </div>
                        <div id="appointmentCalendar"></div>
                    </div>
                </div>
        </div>
        <!-- Dashboard Content -->

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

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the calendar
            var calendarEl = document.getElementById('appointmentCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: function(info, successCallback, failureCallback) {
                    fetch('/api/admin/appointments')
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching appointments:', error);
                            failureCallback(error);
                        });
                },
                eventDisplay: 'block',
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                eventContent: function(arg) {
                    return { html: arg.event.title };
                },
                eventDidMount: function(info) {
                    let status = info.event.extendedProps.status;

                    if (status === 'Done') {
                        info.el.style.backgroundColor = '#A8DCAB';
                        info.el.style.borderColor = '#27ae60';
                        info.el.style.color = '#000';
                    }

                    if (status === 'Waiting') {
                        info.el.style.backgroundColor = '#FFEE8C';
                        info.el.style.borderColor = '#d4ac0d';
                        info.el.style.color = '#000';
                    }
                },
                eventClick: function(info) {
                    // When an appointment is clicked, show details
                    const event = info.event;
                    const status = event.extendedProps.status || 'pending';
                    const purpose = event.extendedProps.purpose || 'Appointment';
                    const time = event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    let modalHtml = `
                    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="appointmentModalLabel">Appointment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Type:</strong> ${event.title}</p>
                            <p><strong>Time:</strong> ${time}</p>
                            <p><strong>Status:</strong> <span style="text-transform: capitalize;">${status}</span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                    `;

                    // Remove existing modal if any
                    document.getElementById('appointmentModal')?.remove();
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    let appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                    appointmentModal.show();
                }
            });

            calendar.render();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
