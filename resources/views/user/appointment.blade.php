<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Appointment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
            max-width: 800px;
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
            background-color: #f5f5f5;
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
        <a href="{{route('growth')}}"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye"></i> Milestone</a>
        <a href="{{route('appointment')}}" class="active"><i class="fas fa-calendar"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot"></i> Chat With Sage</a>
        <a href="{{route('checkup')}}"><i class="fas fa-check"></i> Checkups</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog"></i> Settings</a>
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
                            <th>Doctor Name</th>
                            <th>Location</th>
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

            <div class="form-group" id="vaccination-type-group" style="display: none;">
                <label for="vaccination-type">Select Vaccination Type</label>
                <select id="vaccination-type" class="form-control small-select">
                    <option value="" selected disabled>Select vaccination</option>
                    <option value="bcg">BCG</option>
                    <option value="hepatitis_b">Hepatitis B</option>
                    <option value="polio">Polio</option>
                    <option value="dpt">DPT</option>
                    <option value="measles">Measles</option>
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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="vaccination-list">
                        <tr>
                            <td colspan="3" class="text-center">Select a baby to view vaccinations.</td>
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
            });

            // Time button selection logic
            const timeButtons = document.querySelectorAll('.appointment-time-btn');
            timeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    timeButtons.forEach(btn => btn.classList.remove('focus'));
                    button.classList.add('focus');
                });
            });

            // Show/hide vaccination type
            const appointmentTypeSelect = document.getElementById('appointment-type');
            const vaccinationTypeGroup = document.getElementById('vaccination-type-group');

            appointmentTypeSelect.addEventListener('change', function () {
                if (this.value === 'vaccination') {
                    vaccinationTypeGroup.style.display = 'block';
                } else {
                    vaccinationTypeGroup.style.display = 'none';
                    document.getElementById('vaccination-type').selectedIndex = 0;
                }
            });

            // Submit appointment logic
            document.getElementById('submit-appointment').addEventListener('click', function () {
                const date = document.querySelector('.flatpickr-day.selected')?.ariaLabel;
                const time = document.querySelector('.appointment-time-btn.focus')?.innerText;
                const appointmentType = appointmentTypeSelect.value;
                const babySelect = document.getElementById('baby-select');
                const babyName = babySelect.options[babySelect.selectedIndex]?.text;

                let vaccinationType = '';
                if (appointmentType === 'vaccination') {
                    vaccinationType = document.getElementById('vaccination-type').value;
                }

                if (!date || !time || !appointmentType || !babyName || (appointmentType === 'vaccination' && !vaccinationType)) {
                    alert('Please fill out all fields before submitting.');
                } else {
                    let message = `Appointment scheduled for ${date} at ${time} for a ${appointmentType}`;
                    if (appointmentType === 'vaccination') {
                        message += ` (${document.getElementById('vaccination-type').options[document.getElementById('vaccination-type').selectedIndex].text})`;
                    }
                    message += ` for ${babyName}.`;
                    alert(message);
                }
            });
        });

        //vaccination section
        document.addEventListener('DOMContentLoaded', function () {
            const babyVaccinationSelector = document.getElementById('baby-vaccination-select');
            const vaccinationList = document.getElementById('vaccination-list');

            // Hardcoded vaccine list
            const vaccines = [
                { date: 'At birth', type: 'BCG' },
                { date: 'At birth', type: 'Hepatitis B' },
                { date: '2 months', type: 'DTP' },
                { date: '2 months', type: 'Polio' },
                { date: '3 months', type: 'DTP' },
                { date: '3 months', type: 'Polio' },
                { date: '4 months', type: 'DTP' },
                { date: '4 months', type: 'Polio' },
                { date: '9 months', type: 'Measles' },
                { date: '12 months', type: 'MMR' },
            ];
            // Store status in memory (per session)
            let vaccineStatus = Array(vaccines.length).fill(false);

            if (babyVaccinationSelector) {
                babyVaccinationSelector.addEventListener('change', function () {
                    // Always show the same hardcoded list
                    vaccinationList.innerHTML = '';
                    vaccines.forEach((vaccine, idx) => {
                        const checked = vaccineStatus[idx] ? 'active' : '';
                        const iconClass = vaccineStatus[idx] ? 'fas fa-check' : 'fas fa-check-circle';
                        const row = `
                            <tr>
                                <td>${vaccine.date}</td>
                                <td>${vaccine.type}</td>
                                <td style="text-align:center;">
                                    <button class="btn btn-outline-success vaccination-tick-btn ${checked}" data-idx="${idx}">
                                        <i class="${iconClass}"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        vaccinationList.innerHTML += row;
                    });
                });
                // Initial state
                babyVaccinationSelector.dispatchEvent(new Event('change'));
            }
            // Event delegation for tick button
            vaccinationList.addEventListener('click', function(e) {
                if (e.target.closest('.vaccination-tick-btn')) {
                    const btn = e.target.closest('.vaccination-tick-btn');
                    const idx = btn.getAttribute('data-idx');
                    vaccineStatus[idx] = !vaccineStatus[idx];
                    btn.classList.toggle('active');
                    const icon = btn.querySelector('i');
                    if (btn.classList.contains('active')) {
                        icon.className = 'fas fa-check';
                    } else {
                        icon.className = 'fas fa-check-circle';
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const babySelector = document.getElementById('baby-appointment-select');
        const appointmentList = document.getElementById('appointment-list');

        babySelector.addEventListener('change', function () {
            const babyId = this.value;

            if (babyId) {
                fetch(`dashboard/appointment/${babyId}`)
                    .then(response => response.json())
                    .then(data => {
                        appointmentList.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(appointment => {
                                const row = `
                                    <tr>
                                        <td>${appointment.appointmentDate}</td>
                                        <td>${appointment.appointmentTime}</td>
                                        <td>${appointment.doctorName}</td>
                                        <td>${appointment.location}</td>
                                        <td>${appointment.purpose}</td>
                                        <td>${appointment.status}</td>
                                    </tr>
                                `;
                                appointmentList.innerHTML += row;
                            });
                        } else {
                            appointmentList.innerHTML = `
                                <tr>
                                    <td colspan="6" class="text-center">No appointments found for this baby.</td>
                                </tr>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching appointments:', error);
                        appointmentList.innerHTML = `
                            <tr>
                                <td colspan="6" class="text-center text-danger">Failed to load appointments.</td>
                            </tr>
                        `;
                    });
            }
        });
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
