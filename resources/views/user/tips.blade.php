<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border-radius: 6px;
            margin-bottom: 5px;
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
            padding: 25px;
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
            font-size: 18px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 0;
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
        /* Explore Content */
        .explore-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .explore-header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
        }

        .explore-header select {
            padding: 8px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .topics-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Adjusts to fit available space */
            gap: 20px; /* Space between cards */
            margin-top: 20px;
        }

        .topic-card {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .topic-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .topic-card h3 {
            font-size: 20px;
            color: #1976d2;
            margin-bottom: 15px;
        }

        .topic-list {
            list-style: none;
            padding: 0;
        }

        .topic-list li {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .topic-list li .progress-bar {
            background-color: #e3f2fd;
            height: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }

        .topic-list li .progress-bar span {
            display: block;
            height: 100%;
            background-color: #1976d2;
            border-radius: 5px;
        }

        .topic-list li a {
            text-decoration: none;
            color: #1976d2;
        }

        .topic-list li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>My Dashboard</h2>
        <a href="{{route('dashboard')}}"><i class="fa-solid fa-table-columns"></i> Overview</a>
        <a href="{{route('mybaby')}}"><i class="fas fa-child"></i> My Baby</a>
        <a href="{{route('growth')}}"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar"></i> Appointment</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Baby Tips</h1>
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
        {{-- Main content goes here --}}
        <div class="explore-header">
            <h2>Tips for your Baby</h2>
            <select>
                <option value="0-3">0–3 Months (Current)</option>
                <option value="4-6">4–6 Months</option>
                <option value="7-9">7–9 Months</option>
            </select>
        </div>

        <div class="topics-section">
            <!-- Bonding Topic -->
            <div class="topic-card">
                <h3>Bonding</h3>
                <ul class="topic-list">
                    <li>What is the "Fourth Trimester"? <div class="progress-bar"><span style="width: 9%"></span></div></li>
                    <li>Skin-to-Skin & Baby Massage Tips <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Tips to Help Baby Communicate <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Play Ideas at 1 Month <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Help Baby Learn Language <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>How to Build Trust with Your Baby <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li><a href="#">View all</a></li>
                </ul>
            </div>

            <!-- Early Sensory Topic -->
            <div class="topic-card">
                <h3>Early Sensory</h3>
                <ul class="topic-list">
                    <li>Are Baby's Eyes Crossed? <div class="progress-bar"><span style="width: 13%"></span></div></li>
                    <li>WATCH: The 8 Senses <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Baby's Sense of Smell <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Baby's Hearing Tests <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>The "Balance" Sense <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>How to Stimulate Baby's Vision <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li><a href="#">View all</a></li>
                </ul>
            </div>

            <!-- Sleep and Routines Topic -->
            <div class="topic-card">
                <h3>Sleep and Routines</h3>
                <ul class="topic-list">
                    <li>How Much Sleep Does Baby Need? <div class="progress-bar"><span style="width: 20%"></span></div></li>
                    <li>Creating a Bedtime Routine <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Safe Sleep Practices <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Dealing with Sleep Regression <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Daytime Naps: Tips and Tricks <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li><a href="#">View all</a></li>
                </ul>
            </div>

            <!-- Feeding and Nutrition Topic -->
            <div class="topic-card">
                <h3>Feeding and Nutrition</h3>
                <ul class="topic-list">
                    <li>Breastfeeding Basics <div class="progress-bar"><span style="width: 30%"></span></div></li>
                    <li>Introducing Solid Foods <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Signs of Hunger and Fullness <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Formula Feeding Tips <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Foods to Avoid for Babies <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li><a href="#">View all</a></li>
                </ul>
            </div>

            <!-- Developmental Milestones Topic -->
            <div class="topic-card">
                <h3>Developmental Milestones</h3>
                <ul class="topic-list">
                    <li>Tracking Baby's Growth <div class="progress-bar"><span style="width: 10%"></span></div></li>
                    <li>When Will Baby Start Crawling? <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Baby's First Words <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Encouraging Motor Skills <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li>Understanding Social Development <div class="progress-bar"><span style="width: 0%"></span></div></li>
                    <li><a href="#">View all</a></li>
                </ul>
            </div>
        </div>
        {{--Main  content ends here--}}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
    </script>
</body>
</html>
