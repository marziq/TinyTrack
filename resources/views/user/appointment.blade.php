<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Appointment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet">
    <script>
        (function(){
            try{
                var s = localStorage.getItem('userDarkMode');
                if(s !== null){ if(s === 'true') document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark'); }
                else if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){ document.documentElement.classList.add('dark'); }
            }catch(e){}
        })();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
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
            transition: transform 0.3s ease;
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
            list-style: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
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

        .appointment-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 1100px; /* increased width to make containers wider */
            margin: 0 auto;
            margin-bottom: 30px;
        }

        .appointment-header h2 {
            font-size: 20px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .appointment-header p {
            color: #666;
            font-size: 14px;
        }

        .calendar-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 20px;
        }

        .calendar {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            background-color: #ffffff;
            min-width: 300px;
        }

        .flatpickr-calendar {
            background-color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
            border-radius: 8px !important;
            border: none !important;
            width: 100% !important;
        }

        .calendar h4 {
            font-size: 16px;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .time-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .appointment-time-btn {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #1976d2;
            background-color: #e3f2fd;
            color: #1976d2;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .appointment-time-btn:hover {
            background-color: #bbdefb;
            transform: scale(1.05);
        }

        .appointment-time-btn.focus {
            background-color: #1976d2;
            color: white;
            transform: scale(1.1);
        }

        /* Style for dropdown with arrow */
        .form-control.small-select {
            max-width: 300px;
            appearance: none; /* Remove default browser styling */
            -webkit-appearance: none; /* For Safari */
            -moz-appearance: none; /* For Firefox */
            background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="black" d="M2 0L0 2h4z"/></svg>') no-repeat right 10px center;
            background-size: 10px 10px;
            padding-right: 30px; /* Add space for the arrow */
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control.small-select:focus {
            border-color: #1976d2;
            box-shadow: 0 0 8px rgba(25, 118, 210, 0.5);
        }

        /* Styling for the "Select Baby" section */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 8px;
            display: block;
        }

        .btn {
            background-color: #1976d2;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #1565c0;
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
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.18); /* stronger shadow for active */
            border: 2px solid #1976d2; /* darker outline for active */
        }
        /*Dark mode sidebar*/
        .dark .sidebar {
            background-color: var(--surface, #111317) !important;
            color: var(--text, #e6eef8) !important;
            box-shadow: none;
        }
        .dark .sidebar a {
            color: var(--text, #e6eef8) !important;
        }
        .dark .sidebar a.active {
            background-color: var(--accent, #60a5fa) !important;
            color: #fff !important;
            box-shadow: 0 6px 18px rgba(25,118,210,0.18);
            border-color: var(--accent, #60a5fa) !important;
        }
        /*Dark mode Text*/
        .dark .topbar h1 {
            color: #ffffff !important;
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
        <a href="{{route('appointment')}}"  class="active"><i class="fas fa-calendar" style="color: #16fc38"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot" style="color: orangered"></i> Chat With Sage</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog" style="color: #666"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">Appointment</h1>
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
        <div class="appointment-container">
            <div class="appointment-header">
                <h2>Appointment List for a Baby</h2>
                <p>Select a baby to view their appointment history.</p>
            </div>

            <!-- Baby Selector -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="baby-appointment-select" style="font-size: 16px; font-weight: bold; color: #1976d2;">Select Baby</label>
                <select id="baby-appointment-select" class="form-control small-select">
                    <option value="" selected disabled>Select a baby</option>
                    @foreach($babies as $baby)
                        <option value="{{ $baby->id }}">{{ $baby->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Appointment List Table -->
            <div id="appointment-list-container">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Purpose</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="appointment-list">
                        <tr>
                            <td colspan="6" class="text-center">Select a baby to view appointments.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="appointment-container">
            <div class="appointment-header">
                <h2>Doctor Appointment</h2>
                <p>Select a date, time, and appointment type for your baby's checkup.</p>
            </div>

            <!-- New Baby Selection Section -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="baby-select" style="font-size: 16px; font-weight: bold; color: #1976d2;">Select Baby</label>
                <select id="baby-select" class="form-control small-select">
                    @foreach($babies as $baby)
                        <option value="{{ $baby->id }}">{{ $baby->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="calendar-container">
                <div class="calendar">
                    <h4>Select Appointment Date</h4>
                    <div id="appointment-calendar"></div>
                </div>

                <div class="calendar">
                    <h4>Select Appointment Time</h4>
                    <div class="time-options">
                        <button class="appointment-time-btn">9:00 AM</button>
                        <button class="appointment-time-btn">10:00 AM</button>
                        <button class="appointment-time-btn">11:00 AM</button>
                        <button class="appointment-time-btn">2:00 PM</button>
                        <button class="appointment-time-btn">3:00 PM</button>
                        <button class="appointment-time-btn">4:00 PM</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="appointment-type">Select Appointment Type</label>
                <select id="appointment-type" class="form-control small-select">
                    <option value="checkup">Checkup</option>
                    <option value="vaccination">Vaccination</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <button class="btn" id="submit-appointment">Submit Appointment</button>
        </div>
        <!-- Vaccination Container -->
        <div class="appointment-container">
            <div class="appointment-header">
                <h2>Vaccination Records</h2>
                <p>Select a baby to view their vaccination history.</p>
            </div>

            <!-- Baby Selector for Vaccination -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="baby-vaccination-select" style="font-size: 16px; font-weight: bold; color: #1976d2;">Select Baby</label>
                <select id="baby-vaccination-select" class="form-control small-select">
                    <option value="" selected disabled>Select a baby</option>
                    @foreach($babies as $baby)
                        <option value="{{ $baby->id }}">{{ $baby->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Vaccination List Table -->
            <div id="vaccination-list-container">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Vaccination Date</th>
                            <th>Vaccine Type</th>
                            <th>Administered Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="vaccination-list">
                        <tr>
                            <td colspan="4" class="text-center">Select a baby to view vaccinations.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Flatpickr to show the calendar by default
            flatpickr("#appointment-calendar", {
                inline: true, // Show the calendar inline
                dateFormat: "Y-m-d",
                minDate: "today", // Disable past dates
                defaultDate: "today", // Set default date to today
                theme: "material_blue",
                animate: true,
                time_24hr: false,
                enableTime: false
            });

            // Time button selection logic
            const timeButtons = document.querySelectorAll('.appointment-time-btn');
            timeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    timeButtons.forEach(btn => btn.classList.remove('focus'));
                    button.classList.add('focus');
                });
            });

            // Get appointment type select element
            const appointmentTypeSelect = document.getElementById('appointment-type');

            // Submit appointment logic
            document.getElementById('submit-appointment').addEventListener('click', function () {
                const selectedDate = document.querySelector('.flatpickr-day.selected');
                const selectedTime = document.querySelector('.appointment-time-btn.focus');
                const babySelect = document.getElementById('baby-select');                if (!selectedDate || !selectedTime || !appointmentTypeSelect || !babySelect.value) {
                alert('Please fill out all fields before submitting.');
                return;
            }

            // Get the selected date from flatpickr
            const selectedDateValue = document.querySelector('#appointment-calendar').value;

            const formData = {
                baby_id: babySelect.value,
                appointmentDate: selectedDateValue, // This will be in YYYY-MM-DD format
                appointmentTime: selectedTime.innerText,
                purpose: appointmentTypeSelect.value,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

                // Send the appointment data to the server
                fetch('/appointments', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    alert('Appointment scheduled successfully!');
                    // Refresh the appointment list if the baby is selected in the list view
                    const listBabySelector = document.getElementById('baby-appointment-select');
                    if (listBabySelector.value === babySelect.value) {
                        listBabySelector.dispatchEvent(new Event('change'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to schedule appointment. Please try again.');
                });
            });
        });
        // vaccination section (dynamic + persisted)
        document.addEventListener('DOMContentLoaded', function () {
            const babyVaccinationSelector = document.getElementById('baby-vaccination-select');
            const vaccinationList = document.getElementById('vaccination-list');

            function renderVaccinations(vaccinations) {
                vaccinationList.innerHTML = '';
                if (!vaccinations || vaccinations.length === 0) {
                    vaccinationList.innerHTML = '<tr><td colspan="4" class="text-center">No vaccinations found for this baby.</td></tr>';
                    return;
                }

                vaccinations.forEach((vaccine) => {
                    const isAdmin = vaccine.status === 'administered';
                    const iconClass = isAdmin ? 'fas fa-check' : 'fas fa-check-circle';
                    const btnClass = isAdmin ? 'active' : '';
                    const scheduled = vaccine.scheduled_date ? (new Date(vaccine.scheduled_date)).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }) : '';
                    const administeredText = vaccine.administered_at ? (new Date(vaccine.administered_at)).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }) : 'Pending';
                    const row = `
                        <tr>
                            <td>${scheduled}</td>
                            <td>${vaccine.vaccine_name}</td>
                            <td>${administeredText}</td>
                            <td style="text-align:center;">
                                <button class="btn btn-outline-success vaccination-tick-btn ${btnClass}" data-id="${vaccine.id}">
                                    <i class="${iconClass}"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    vaccinationList.innerHTML += row;
                });
            }

            async function fetchVaccinationsForBaby(babyId) {
                vaccinationList.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';
                try {
                    const res = await fetch(`/vaccinations/baby/${babyId}`);
                    if (!res.ok) throw new Error('Failed to load');
                    const data = await res.json();
                    renderVaccinations(data);
                } catch (err) {
                    console.error(err);
                    vaccinationList.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Failed to load vaccinations.</td></tr>';
                }
            }

            if (babyVaccinationSelector) {
                babyVaccinationSelector.addEventListener('change', function () {
                    const babyId = this.value;
                    if (!babyId) return;
                    fetchVaccinationsForBaby(babyId);
                });

                // initial
                if (babyVaccinationSelector.value) {
                    fetchVaccinationsForBaby(babyVaccinationSelector.value);
                }

                // Event delegation for tick button: toggle vaccination
                vaccinationList.addEventListener('click', async function (e) {
                    const btn = e.target.closest('.vaccination-tick-btn');
                    if (!btn) return;
                    const id = btn.getAttribute('data-id');
                    if (!id) return;

                    btn.disabled = true;
                    try {
                        const res = await fetch(`/vaccinations/${id}/toggle`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        if (!res.ok) throw new Error('Failed to update');
                        const updated = await res.json();

                        // Update the button/icon state in-place
                        const icon = btn.querySelector('i');
                        if (updated.status === 'administered') {
                            btn.classList.add('active');
                            icon.className = 'fas fa-check';
                        } else {
                            btn.classList.remove('active');
                            icon.className = 'fas fa-check-circle';
                        }

                        // Also update the Administered Date cell in the same row immediately
                        try {
                            const row = btn.closest('tr');
                            if (row) {
                                const tds = row.querySelectorAll('td');
                                // Administered Date is the 3rd column (index 2)
                                const adminCell = tds[2];
                                if (adminCell) {
                                    if (updated.administered_at) {
                                        const d = new Date(updated.administered_at);
                                        adminCell.textContent = d.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
                                    } else {
                                        adminCell.textContent = 'Pending';
                                    }
                                }
                            }
                        } catch (err) {
                            console.error('Failed to update administered cell', err);
                        }

                        // Broadcast event so other parts of the app (e.g., My Baby) can refresh if needed
                        try {
                            window.dispatchEvent(new CustomEvent('vaccinationToggled', { detail: updated }));
                        } catch (err) {
                            // ignore if dispatch fails
                            console.error('Event dispatch failed', err);
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Failed to update vaccination status.');
                    } finally {
                        btn.disabled = false;
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
        const babySelector = document.getElementById('baby-appointment-select');
        const appointmentList = document.getElementById('appointment-list');

        // Helper: format date string (YYYY-MM-DD) to 'D Month YYYY' (e.g. '1 November 2025')
        function formatDateDisplay(dateStr) {
            if (!dateStr) return '';
            // Normalize and take only the date part
            const dpart = dateStr.split('T')[0].split(' ')[0];
            const parts = dpart.split('-');
            if (parts.length < 3) return dateStr;
            const year = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            const day = parseInt(parts[2], 10);
            const d = new Date(year, month, day);
            return d.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
        }

        // Helper: convert various time strings to 12-hour format with AM/PM
        function formatTimeDisplay(timeStr) {
            if (!timeStr) return '';
            const s = timeStr.trim();
            // If already contains AM/PM, normalize spacing and casing
            if (/[APap][.]?M[.]?$/.test(s) || /[APap][mM]$/.test(s)) {
                // Remove dots and ensure single space before AM/PM
                return s.replace(/\./g, '').replace(/\s+([AaPp][Mm])$/,' $1').toUpperCase();
            }

            // Match HH:MM or HH:MM:SS (24-hour)
            const m = s.match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
            if (m) {
                let hh = parseInt(m[1], 10);
                const mm = m[2];
                const ampm = hh >= 12 ? 'PM' : 'AM';
                hh = hh % 12;
                if (hh === 0) hh = 12;
                return `${hh}:${mm} ${ampm}`;
            }

            // Match '9 AM' or '9PM' style
            const m2 = s.match(/^(\d{1,2})\s*([AaPp][Mm])$/);
            if (m2) {
                return `${parseInt(m2[1],10)} ${m2[2].toUpperCase()}`;
            }

            // Fallback: return original
            return s;
        }

        // Helper: compute timestamp for sorting using appointment date and time
        function parseDatetimeTimestamp(appt) {
            const dateRaw = (appt.appointmentDate || '').split('T')[0];
            const parts = dateRaw.split('-');
            if (parts.length < 3) return 0;
            const year = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1;
            const day = parseInt(parts[2], 10);

            let hours = 0, minutes = 0;
            const t = (appt.appointmentTime || '').trim();
            if (t) {
                // AM/PM format
                const ampmMatch = t.match(/^(\d{1,2})(?::(\d{2}))?\s*([AaPp][Mm])$/);
                if (ampmMatch) {
                    let h = parseInt(ampmMatch[1], 10);
                    const mm = ampmMatch[2] ? parseInt(ampmMatch[2], 10) : 0;
                    const ampm = ampmMatch[3].toUpperCase();
                    if (ampm === 'PM' && h < 12) h += 12;
                    if (ampm === 'AM' && h === 12) h = 0;
                    hours = h; minutes = mm;
                } else {
                    // 24-hour HH:MM
                    const m = t.match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
                    if (m) {
                        hours = parseInt(m[1], 10);
                        minutes = parseInt(m[2], 10);
                    }
                }
            }

            return new Date(year, month, day, hours, minutes).getTime();
        }

        babySelector.addEventListener('change', function () {
            const babyId = this.value;

            if (babyId) {
                fetch(`/appointments/baby/${babyId}`)
                    .then(response => response.json())
                    .then(data => {
                        appointmentList.innerHTML = '';

                        if (data.length > 0) {
                            // Sort by date/time ascending (earliest first)
                            data.sort((a, b) => parseDatetimeTimestamp(a) - parseDatetimeTimestamp(b));

                            data.forEach(appointment => {
                                const statusClass = appointment.status === 'Waiting' ? 'text-warning' : 'text-success';
                                const dateDisplay = formatDateDisplay(appointment.appointmentDate);
                                const timeDisplay = formatTimeDisplay(appointment.appointmentTime);
                                const purposeDisplay = appointment.purpose ? (appointment.purpose.charAt(0).toUpperCase() + appointment.purpose.slice(1)) : '';
                                const row = `
                                    <tr>
                                        <td>${dateDisplay}</td>
                                        <td>${timeDisplay}</td>
                                        <td>${purposeDisplay}</td>
                                        <td><span class="${statusClass}">${appointment.status}</span></td>
                                    </tr>
                                `;
                                appointmentList.innerHTML += row;
                            });
                        } else {
                            appointmentList.innerHTML = `
                                <tr>
                                    <td colspan="4" class="text-center">No appointments found for this baby.</td>
                                </tr>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        appointmentList.innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center text-danger">Failed to load appointments.</td>
                            </tr>
                        `;
                    });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const bell = document.getElementById('notificationBell');
        const popup = document.getElementById('notificationPopup');

        // Load notifications when page loads
        loadNotifications();

        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);

        bell.addEventListener('click', function(e) {
            e.stopPropagation();
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
            if (popup.style.display === 'block') {
                loadNotifications();
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notification-icon')) {
                popup.style.display = 'none';
            }
        });

        // Mark notification as read and show full message
        document.addEventListener('click', function(e) {
            if (e.target.closest('.notification-item')) {
                const item = e.target.closest('.notification-item');
                e.stopPropagation();
                const notifId = item.getAttribute('data-id');
                const title = item.getAttribute('data-title');
                const message = item.getAttribute('data-message');
                const date = item.getAttribute('data-date');

                // Mark as read via API
                fetch(`/api/notifications/${notifId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        // Remove the notification from the popup view
                        item.remove();

                        // Show full notification in a modal
                        showNotificationModal(title, message, date);

                        // Update badge count
                        loadNotifications();

                        // If no notifications left, show "No notifications."
                        if (document.querySelectorAll('.notification-item').length === 0) {
                            const list = document.querySelector('.notification-list');
                            list.innerHTML = '<li class="no-notification">No notifications.</li>';
                        }
                    }
                }).catch(error => console.error('Error marking notification as read:', error));
            }
        });

        // Load and display notifications
        function loadNotifications() {
            fetch('/api/notifications/unread', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const notificationList = document.querySelector('.notification-list');
                const notificationBadge = document.querySelector('.notification-badge');

                if (data.count > 0) {
                    let html = '';
                    data.notifications.forEach(notification => {
                        const dateFormatted = new Date(notification.dateSent).toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        });
                        html += `
                            <li class="notification-item"
                                data-id="${notification.notification_id}"
                                data-title="${notification.title}"
                                data-message="${notification.message}"
                                data-date="${dateFormatted}">
                                <strong>${notification.title}</strong>
                                <span>${notification.message.substring(0, 100)}...</span>
                                <div style="font-size: 11px; color: #999; margin-top: 5px;">${dateFormatted}</div>
                            </li>
                        `;
                    });
                    notificationList.innerHTML = html;
                    notificationBadge.innerText = data.count;
                    notificationBadge.style.display = 'block';
                } else {
                    notificationList.innerHTML = '<li class="no-notification">No unread notifications.</li>';
                    notificationBadge.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
            });
        }

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
                    <div style="font-size: 12px; color: #888;">Received: ${date}</div>
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
    });
    </script>
</body>
</html>
