<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
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
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .dashboard-content h2 {
            color: #333;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .dashboard-content p {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }

        /* Card Container */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #555;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        /* Chart Container */
        .chart-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .chart-container > div {
            flex: 0 1 48%;  /* Adjust width to ensure charts share space equally */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            height: 500px;  /* Set consistent height for both charts */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .chart-container h3 {
            color: #333;
            font-size: 18px;  /* Title font size */
            font-weight: 600;
            margin-bottom: 15px;
        }

        #babiesChart, #genderChart {
            width: 100%;  /* Ensure both charts fill the width of their container */
            height: 100%;  /* Make the height match the container */
            display: block;
        }


        /* Progress Bar */
        .projects {
            margin-top: 40px;
        }

        /* Card Styling for the entire Projects section */
        .projects-card {
            background-color: #ffffff; /* White background for the card */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 20px; /* Space below the card */
        }

        .projects h3 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        /* Styling for progress bars */
        .progress-bar p {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
        }

        .progress {
            height: 15px;
            background-color: #e0e0e0;
            border-radius: 10px;
            width: 100%;
            position: relative;
        }

        .progress .progress-bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 1s ease;
        }

        .progress-bar-fill.server-migration {
            background-color: #e74c3c; /* Red for Server Migration */
            width: 20%;
        }

        .progress-bar-fill.sales-tracking {
            background-color: #f39c12; /* Yellow for Sales Tracking */
            width: 40%;
        }

        .progress-bar-fill.customer-database {
            background-color: #3498db; /* Blue for Customer Database */
            width: 60%;
        }

        .progress-bar .percentage {
            position: absolute;
            top: 0;
            right: 10px;
            font-weight: 600;
            color: #fff;
            font-size: 12px;
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

            .card-container {
                grid-template-columns: 1fr 1fr;
            }

            .dashboard-content {
                padding: 10px;
            }

            .chart-container {
                width: 100%;
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

        /* Add this to your existing styles */
        #appointmentCalendar {
            max-width: 100%;
            margin: 0 auto;
        }

        .fc-event {
            cursor: pointer;
        }

        /* Custom colors for different appointment types */
        .fc-event-checkup {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .fc-event-vaccination {
            background-color: #2196F3;
            border-color: #2196F3;
        }

        .fc-event-consultation {
            background-color: #FF9800;
            border-color: #FF9800;
        }

        .fc-toolbar-title {
            font-size: 1.2em;
        }

        .fc-col-header-cell {
            background-color: #f8f9fa;
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
            <h2>Welcome Admin</h2>
            <p>Here's an overview of your activities and statistics.</p>

            <!-- Card Section -->
            <div class="card-container">
                <div class="card">
                    <h3>Total Users</h3>
                    <p>{{$totalUsers}}</p>
                </div>
                <div class="card">
                    <h3>Total Babies</h3>
                    <p>{{$totalBabies}}</p>
                </div>
                <div class="card">
                    <h3>Vaccine Completed</h3>
                    <p>{{ $vaccineCompleted ?? 0 }} Completed · {{ $vaccinePending ?? 0 }} Pending</p>
                </div>
                <div class="card">
                    <h3>Milestones Completed</h3>
                    <p>{{ $milestonesCompleted ?? 0 }} Completed · {{ $milestonesPending ?? 0 }} Pending</p>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-container">
                <div>
                    <h3 style="padding-top: 30px !important;">Babies Added Each Month</h3>
                    <canvas id="babiesChart"></canvas>
                </div>

                <div>
                    <h3 style="padding-top: 30px !important;">User Gender Distribution</h3>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Progress Bar Section -->
            <div class="projects-card">
                <h3>Appointment Progression</h3>
                <!-- Project for Server Migration -->
                <div class="progress-bar">
                    <p>General</p>
                    <div class="progress">
                        <div class="progress-bar-fill server-migration" style="width: {{ $appointmentProgress['general'] ?? 0 }}%;"></div>
                        <span class="percentage" style="color: black;">{{ $appointmentProgress['general'] ?? 0 }}%</span>
                    </div>
                </div>

                <!-- Project for Sales Tracking -->
                <div class="progress-bar">
                    <p>Checkup</p>
                    <div class="progress">
                        <div class="progress-bar-fill sales-tracking" style="width: {{ $appointmentProgress['checkup'] ?? 0 }}%;"></div>
                        <span class="percentage" style="color: black;">{{ $appointmentProgress['checkup'] ?? 0 }}%</span>
                    </div>
                </div>

                <!-- Project for Customer Database -->
                <div class="progress-bar">
                    <p>Vaccination</p>
                    <div class="progress">
                        <div class="progress-bar-fill customer-database" style="width: {{ $appointmentProgress['vaccination'] ?? 0 }}%;"></div>
                        <span class="percentage" style="color: black;">{{ $appointmentProgress['vaccination'] ?? 0 }}%</span>
                    </div>
                </div>

                <!-- Project for Payout Details -->
                <div class="progress-bar">
                    <p>Others</p>
                    <div class="progress">
                        <div class="progress-bar-fill" style="width: {{ $appointmentProgress['others'] ?? 0 }}%; background-color: #2ecc71;"></div>
                        <span class="percentage" style="color: black;">{{ $appointmentProgress['others'] ?? 0 }}%</span>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        // Babies chart: data provided by server as $babiesPerMonth (12 values, Jan-Dec)
        const babiesLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const babiesData = {!! json_encode($babiesPerMonth ?? array_fill(0,12,0)) !!};

        var ctx1 = document.getElementById('babiesChart').getContext('2d');
        var babiesChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: babiesLabels,
                datasets: [{
                    label: 'Babies Added',
                    data: babiesData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Gender distribution: server should pass an array [maleCount, femaleCount]
        const genderData = {!! json_encode($genderDistribution ?? [0,0]) !!};
        var ctx2 = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    label: 'User Gender Distribution',
                    data: genderData,
                    backgroundColor: ['#36A2EB', '#FF6384'],
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
