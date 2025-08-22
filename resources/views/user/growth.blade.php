<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Growth</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=IM+Fell+Great+Primer+SC&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
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
            margin-bottom: 20px; /* Add spacing between cards */
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
        padding: 20px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .input-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            position: relative;
            padding: 40px 20px;
        }

        .slider-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 120px;
        }

        .slider-group input[type="range"] {
            writing-mode: bt-lr; /* Vertical orientation */
            -webkit-appearance: slider-vertical;
            width: 8px;
            height: 200px;
            margin: 20px 0;
        }

        .slider-value {
            font-size: 16px;
            color: #f5af00;
            font-weight: bold;
        }

        .baby-icon-center {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 200px;
            height: 240px;
        }

        .baby-icon-center img {
            margin-top: 50px;
            height: 300px;
            width: auto;
            opacity: 0.5;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .height-group {
            order: 1; /* Left side */
            flex: 1;
        }

        .baby-icon {
            order: 2; /* Center */
            font-size: 50px;
            color: #1976d2;
            margin: 0 20px;
        }

        .weight-group {
            order: 3; /* Right side */
            flex: 1;
        }

        .input-group label {
            font-size: 16px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
            max-width: 150px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }

        .input-wrapper .unit {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #555;
            pointer-events: none;
        }

        .input-group.full-width {
            order: 4; /* Bottom */
            flex-basis: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .input-row {
            display: flex;
            justify-content: center; /* Center the inputs */
            align-items: flex-start;
            gap: 10px; /* Reduce spacing between the inputs */
            width: 100%; /* Make the row span the full width */
            margin-top: 10px; /* Adjust the top margin */
        }

        .input-row .input-group {
            flex: 1; /* Make the inputs take equal space */
            max-width: 250px; /* Limit the maximum width of each input */
        }

        .input-row .input-group label {
            font-size: 14px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 5px; /* Reduce spacing below the label */
            display: block;
        }

        .input-row .input-wrapper {
            width: 100%;
        }

        .baby-selector-container {
            width: 100%;
            max-width: 400px; /* Limit the width */
            margin: 0 auto; /* Center the container */
            text-align: center;
        }
        .chart-area {
            width: 100%; /* Full width of the container */
            max-width: 600px; /* Limit the maximum width */
            height: 300px; /* Set a fixed height */
            margin: 0 auto; /* Center the chart */
        }

        canvas {
            width: 90% !important; /* Ensure the canvas scales properly */
            height: auto !important; /* Ensure the canvas scales properly */
        }

        .submit-btn {
            background-color: #1976d2;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
            width: 100%; /* Make it span the full width */
            max-width: 200px; /* Limit the maximum width */
            margin: 20px auto 0; /* Center the button */
        }

        .submit-btn:hover {
            background-color: #0d47a1;
            transform: translateY(-2px);
        }

        .submit-btn:active {
            background-color: #0b3c91;
            transform: translateY(0);
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
        .sidebar a.active {
            background-color: #1976d2;
            color: #fff !important;
            font-weight: bold;
        }
        .select-arrow-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .select-arrow-wrapper select {
            appearance: none;
            -webkit-appearance: none;
            padding-right: 35px;
        }
        .select-arrow {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #1976d2;
            font-size: 18px;
        }
        .chart-card-flex {
            display: flex;
            flex-direction: row;
            gap: 0;
            width: 100%;
            align-items: stretch;
            min-height: 320px;
            position: relative;
        }
        .chart-content {
            flex: 1 1 0;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .summary-inside {
            width: 30%;
            min-width: 200px;
            max-width: 320px;
            padding: 10px 12px;           /* Reduced vertical padding */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;  /* Align to top */
            align-items: flex-start;      /* Align to left */
            border-radius: 12px;
            margin-left: 2px;
            box-shadow: 0 0 0 0 transparent;
            height: auto;                 /* Let height fit content */
            min-height: unset;            /* Remove min-height if set elsewhere */
            max-height: 120px;            /* Optional: limit max height */
            overflow: auto;               /* Add scroll if content overflows */
        }
            @media (max-width: 900px) {
            .chart-card-flex {
                flex-direction: column;
            }
            .summary-inside {
                width: 100%;
                max-width: 100%;
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <a href="{{route('mybaby')}}" style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('img/tinytrack-logo.png') }}" alt="Logo" style="height: 36px; width: 36px; object-fit: contain;">
            <h2 style="margin-bottom: 0;">My Dashboard</h2>
        </a>
        <hr style="color: #1976d2">
        <a href="{{route('mybaby')}}"><i class="fas fa-child"></i> My Baby</a>
        <a href="{{route('growth')}}" class="active"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot"></i> Chat With Sage</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">Growth</h1>
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

        {{--- Main Content --}}
        <div class="main-content">
            <!-- Height and Weight Input Card -->
            <div class="card">

               <form method="POST" action="{{ route('growth.store') }}">
                    @csrf
                    <div class="input-container">

                        <!-- Weight Slider -->
                        <div class="input-group slider-group weight-slider">
                            <label for="weight-input">Weight(g)</label>
                            <input type="range" id="weight-input" name="weight" min="1000" max="6000" value="2010" step="1">
                            <input type="number" id="weight-value" min="1000" max="6000" step="1" value="2010" class="form-control mt-2" style="width: 100px; text-align: center;">
                        </div>

                        <!-- Baby Icon Silhouette -->
                        <div class="baby-icon-center">
                            <img src="{{asset('img/childrenicon.png')}}" alt="ChildrenIcon">
                        </div>

                        <!-- Height Slider -->
                        <div class="input-group slider-group height-slider">
                            <label for="height-input">Height(cm)</label>
                            <input type="range" id="height-input" name="height" min="40" max="70" value="50" step="1">
                            <input type="number" id="height-value" min="40" max="70" step="1" value="50" class="form-control mt-2" style="width: 100px; text-align: center;">
                        </div>

                        <div class="input-row">
                            <!-- Growth Month -->
                            <div class="input-group">
                                <label for="growthMonth">Growth Month</label>
                                <div class="input-wrapper">
                                    <input type="number" id="growthMonth" name="growthMonth" class="form-control" placeholder="Enter growth month" step="1" required>
                                </div>
                            </div>

                            <!-- Select Baby -->
                            <div class="input-group">
                                <label for="baby_id">Select Baby</label>
                                <div class="input-wrapper select-arrow-wrapper" style="position: relative; display: inline-block; width: 100%;">
                                    <select id="baby_id" name="baby_id" class="form-control" required style="appearance: none; -webkit-appearance: none; padding-right: 35px;">
                                        <option value="" disabled selected>Select a baby</option>
                                        @foreach ($babies as $baby)
                                            <option value="{{ $baby->id }}">{{ $baby->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="select-arrow" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #1976d2; font-size: 18px;">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="input-group full-width">
                            <button type="submit" class="submit-btn">Submit</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="baby-selector-container">
                <h2>Growth Tracking</h2>
                <div class="select-arrow-wrapper" style="position: relative; display: inline-block; width: 100%;">
                    <select id="babySelector" onchange="loadBabyData(this.value)" class="form-control" style="appearance: none; -webkit-appearance: none; padding-right: 35px;">
                        <option value="" disabled selected hidden>Select a baby</option>
                        @foreach(Auth::user()->babies as $baby)
                            <option value="{{ $baby->id }}" data-name="{{ $baby->name }}">
                                {{ $baby->name }} ({{ ucfirst($baby->gender) }})
                            </option>
                        @endforeach
                    </select>
                    <span class="select-arrow" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #1976d2; font-size: 18px;">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>
            </div>
            <hr>
            <div id="babyDashboard" style="display: none;">
                <h3 id="selectedBabyName" class="text-center"></h3>
                <div class="card chart-card-flex" style="position: relative;">
                    <div class="chart-content">
                        <h3>Height Curvature Chart</h3>
                        <canvas id="height-chart"></canvas>
                    </div>
                    <div class="summary-inside" style="background: #f5faff;">
                        <h4 style="color: #1976d2;">Height Summary</h4>
                        <div id="height-summary-text" style="color: #333; font-size: 15px;">
                            Select a baby to see a summary of their height growth here.
                        </div>
                    </div>
                </div>
                <div class="card chart-card-flex" style="position: relative;">
                    <div class="chart-content">
                        <h3>Weight Curvature Chart</h3>
                        <canvas id="weight-chart"></canvas>
                    </div>
                    <div class="summary-inside" style="background: #fff8f7;">
                        <h4 style="color: #e74c3c;">Weight Summary</h4>
                        <div id="weight-summary-text" style="color: #333; font-size: 15px;">
                            Select a baby to see a summary of their weight growth here.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--- Main Content END--}}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Weight sync
            const weightSlider = document.getElementById('weight-input');
            const weightValue = document.getElementById('weight-value');

            weightSlider.addEventListener('input', function () {
                weightValue.value = weightSlider.value;
            });

            weightValue.addEventListener('input', function () {
                let val = Math.min(Math.max(weightValue.value, 1000), 6000); // clamp between min/max
                weightSlider.value = val;
            });

            // Height sync
            const heightSlider = document.getElementById('height-input');
            const heightValue = document.getElementById('height-value');

            heightSlider.addEventListener('input', function () {
                heightValue.value = heightSlider.value;
            });

            heightValue.addEventListener('input', function () {
                let val = Math.min(Math.max(heightValue.value, 40), 70); // clamp between min/max
                heightSlider.value = val;
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const heightChartCtx = document.getElementById('height-chart').getContext('2d');
            const weightChartCtx = document.getElementById('weight-chart').getContext('2d');

            // Initialize empty charts
            const heightChart = new Chart(heightChartCtx, {
                type: 'line',
                data: {
                    labels: [], // Growth months will be added dynamically
                    datasets: [{
                        label: 'Height (cm)',
                        data: [],
                        borderColor: '#1976d2',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            const weightChart = new Chart(weightChartCtx, {
                type: 'line',
                data: {
                    labels: [], // Growth months will be added dynamically
                    datasets: [{
                        label: 'Weight (g)',
                        data: [],
                        borderColor: '#e74c3c',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Load baby data when a baby is selected
            window.loadBabyData = function (babyId) {
                if (!babyId) return;

                // Fetch growth data for the selected baby
                fetch(`/dashboard/growth/${babyId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Fetched data:', data); // Log the fetched data

                        // Update the charts
                        const labels = data.map(entry => entry.growthMonth); // Use growthMonth for labels
                        const heights = data.map(entry => entry.height);
                        const weights = data.map(entry => entry.weight);

                        console.log('Labels:', labels); // Log the labels (growth months)
                        console.log('Heights:', heights); // Log the heights
                        console.log('Weights:', weights); // Log the weights

                        heightChart.data.labels = labels;
                        heightChart.data.datasets[0].data = heights;
                        heightChart.update();

                        weightChart.data.labels = labels;
                        weightChart.data.datasets[0].data = weights;
                        weightChart.update();

                        // Update the baby name
                        const selectedOption = document.querySelector(`#babySelector option[value="${babyId}"]`);
                        document.getElementById('selectedBabyName').textContent = `${selectedOption.dataset.name}'s Growth Tracking`;

                        // Show the dashboard
                        document.getElementById('babyDashboard').style.display = 'block';

                         // --- Height Summary ---
                        const heightSummary = document.getElementById('height-summary-text');
                        if (data.length > 0) {
                            const minH = Math.min(...data.map(e => e.height));
                            const maxH = Math.max(...data.map(e => e.height));
                            const lastH = data[data.length - 1].height;
                            const firstH = data[0].height;
                            heightSummary.textContent = `Started at ${firstH} cm, now ${lastH} cm. Highest: ${maxH} cm, Lowest: ${minH} cm. Growth: ${lastH - firstH} cm.`;
                        } else {
                            heightSummary.textContent = "No height data available for this baby.";
                        }

                        // --- Weight Summary ---
                        const weightSummary = document.getElementById('weight-summary-text');
                        if (data.length > 0) {
                            const minW = Math.min(...data.map(e => e.weight));
                            const maxW = Math.max(...data.map(e => e.weight));
                            const lastW = data[data.length - 1].weight;
                            const firstW = data[0].weight;
                            weightSummary.textContent = `Started at ${firstW} g, now ${lastW} g. Highest: ${maxW} g, Lowest: ${minW} g. Growth: ${lastW - firstW} g.`;
                        } else {
                            weightSummary.textContent = "No weight data available for this baby.";
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching growth data:', error);
                        alert('Failed to load growth data. Please try again.');
                    });
            };
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
    </script>
</body>
</html>
