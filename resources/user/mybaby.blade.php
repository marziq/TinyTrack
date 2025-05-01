<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 10px 0;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #bbdefb;
            border-radius: 6px;
            padding-left: 10px;
        }

        .main {
            flex: 1;
            padding: 20px;
            position: relative;
            transition: margin-left 0.3s ease;
        }

        .sidebar.hidden + .main {
            margin-left: -250px;
        }

    .topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    position: relative;
    }

    .toggle-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #1976d2;
    z-index: 20;
    }

    .topbar h1 {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    margin: 0;
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
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
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
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 8px 0;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #555;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
        }


        .sidebar.hidden {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>My Dashboard</h2>
        <a href="#"><i class="fa-solid fa-table-columns"></i></i> Overview</a>
        <a href="#"><i class="fas fa-child"></i> My Baby</a>
        <a href="#"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="#"><i class="fas fa-calendar"></i> Calendar</a>
        <a href="#"><i class="fas fa-cog"></i> Settings</a>
    </div>

    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>My Baby</h1>
            <div class="topbar-right">
                <!-- Notification Icon -->
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="profile-btn dropdown-toggle" type="button" id="accountDropdown">
                        <div class="profile-img-container">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
                        </div>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item" href="{{route('mainpage')}}"><i class="fa-solid fa-house"></i></i> Home</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-baby me-2"></i> My Baby</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h2>Welcome, {{ Auth::user()->name }}</h2>
        <p>Here's an overview of your baby's progress.</p>
        <br>
        <div class="cards">
            <div class="card">
                <h3>Baby Age</h3>
                <p>8 Months</p>
            </div>
            <div class="card">
                <h3>Next Checkup</h3>
                <p>May 30</p>
            </div>
            <div class="card">
                <h3>Milestones</h3>
                <p>5 Achieved</p>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');

            // Update the toggle button icon
            const toggleBtns = document.querySelectorAll('.toggle-btn, .floating-toggle');
            const iconClass = sidebar.classList.contains('hidden') ? 'fa-bars' : 'fa-times';

            toggleBtns.forEach(btn => {
                btn.querySelector('i').className = `fas ${iconClass}`;
            });
        }

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
    </script>
</body>
</html>
