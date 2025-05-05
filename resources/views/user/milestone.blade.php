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
        .main-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .baby-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
        }

        .milestones-abilities-container {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two equal columns */
            gap: 30px; /* Space between the two sections */
            margin-bottom: 30px;
        }

        .milestones-section, .abilities-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .milestone-list, .abilities-list {
            display: grid;
            grid-template-columns: 1fr; /* Items stack vertically */
            gap: 15px;
        }

        .milestone-item, .ability-item {
            position: relative; /* To position the arrow icon */
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .milestone-item:hover, .ability-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .milestone-item p, .ability-item p {
            font-size: 18px;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .milestone-item span, .ability-item span {
            font-size: 16px;
            color: #555;
        }

        .arrow-icon {
            position: absolute;
            right: 15px; /* Align the arrow to the right */
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #555;
            transition: transform 0.3s ease;
        }

        .milestone-item:hover .arrow-icon, .ability-item:hover .arrow-icon {
            transform: translateY(-50%) rotate(180deg); /* Rotate the arrow on hover */
        }

        /* Add completed statuses with colors */
        .milestone-item span.completed, .ability-item span.completed {
            color: #388e3c; /* Green for completed */
        }

        .milestone-item span.not-completed, .ability-item span.not-completed {
            color: #f44336; /* Red for not completed */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .milestones-abilities-container {
            grid-template-columns: 1fr; /* Stack sections vertically */
    }
}

        .baby-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .baby-selector {
            padding: 8px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .baby-selector:focus {
            border-color: #1976d2;
            outline: none;
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
            <h1>Milestone</h1>
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

        <div class="main-content">
            <div class="baby-header">
                <h2 class="baby-name">Track <span id="selectedBabyNameHeading">Progress</span></h2>
                <select id="babySelector" class="baby-selector" onchange="loadBabyData(this.value)">
                    <option value="" disabled selected hidden>Select a baby</option>
                    @foreach(Auth::user()->babies as $baby)
                        <option value="{{ $baby->id }}" data-name="{{ $baby->name }}">{{ $baby->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="milestones-abilities-container">
                <!-- Milestones Section -->
                <div class="milestones-section">
                    <h3>Milestones</h3>
                    <div class="milestone-list">
                        <div class="milestone-item">
                            <p>Motor Milestones</p>
                            <span class="not-completed">0/5 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="milestone-item">
                            <p>Sensory Milestones</p>
                            <span class="not-completed">0/5 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="milestone-item">
                            <p>Communication Milestones</p>
                            <span class="not-completed">0/6 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="milestone-item">
                            <p>Feeding Milestones</p>
                            <span class="not-completed">0/4 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Abilities Section -->
                <div class="abilities-section">
                    <h3>Abilities</h3>
                    <div class="abilities-list">
                        <div class="ability-item">
                            <p>Play and Social Skills Abilities</p>
                            <span class="not-completed">0/2 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="ability-item">
                            <p>Coordination Abilities</p>
                            <span class="not-completed">0/2 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="ability-item">
                            <p>Daily Activities Abilities</p>
                            <span class="not-completed">0/3 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                        <div class="ability-item">
                            <p>Self-Expression Abilities</p>
                            <span class="not-completed">0/3 completed</span>
                            <i class="fas fa-chevron-down arrow-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        function loadBabyData(babyId) {
            if (!babyId) return;

            // Get the selected option
            const babySelector = document.getElementById('babySelector');
            const selectedOption = babySelector.options[babySelector.selectedIndex];

            // Get the baby's name from the data attribute
            const babyName = selectedOption.getAttribute('data-name');

            // Update the heading with the baby's name
            const heading = document.getElementById('selectedBabyNameHeading');
            heading.textContent = `${babyName}'s Progress`;

            // For now, just log the selected baby ID
            console.log("Selected Baby ID:", babyId);

            // In the future, you can make an AJAX request to fetch the baby's milestones
            // Example:
            // fetch(`/api/babies/${babyId}/milestones`)
            //     .then(response => response.json())
            //     .then(data => {
            //         // Update the milestones and abilities dynamically
            //         console.log(data);
            //     });
        }
    </script>
</body>
</html>
