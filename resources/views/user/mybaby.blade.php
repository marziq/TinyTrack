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
        .sidebar a.active {
            background-color: #1976d2;
            color: #fff !important;
            font-weight: bold;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.18); /* stronger shadow for active */
            border: 2px solid #1976d2; /* darker outline for active */
        }
        /* New Styles for the Redesign */
        .baby-selector-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .baby-selector {
            width: 300px;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .add-baby-btn-top {
            background-color: #1976d2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-baby-btn-top:hover {
            background-color: #1565c0;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 equal columns */
            gap: 20px;
        }

        .baby-info-panel {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            text-align: center; /* Center text */
            gap: 15px; /* Add spacing between elements */
        }

        .baby-photo-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #e3f2fd;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        .baby-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .baby-details {
            font-size: 16px; /* Increase font size for better readability */
            color: #333;
        }

        .baby-name {
            font-size: 20px; /* Larger font for the name */
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .baby-age {
            font-weight: bold;
            color: #1976d2;
        }

        .baby-info {
            font-size: 16px; /* Slightly larger font for details */
            margin: 5px 0;
            color: #555;
        }

        .baby-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .baby-actions button {
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .baby-actions button:hover {
            background-color: #f0f0f0;
        }

        .baby-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 450px;
            display: flex;
            align-items: stretch;
            gap: 20px;
            grid-column: span 2;
            overflow: hidden;
            position: relative;
            /* Remove justify-content to allow custom widths */
            flex-direction: row;
        }

        .chart-title {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
            width: 100%;
            text-align: center;
            z-index: 2;
            pointer-events: none;
        }

        .chart-column {
            flex: 3 1 0%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            max-width: 75%;
            /* Ensure the chart doesn't overlap the title */
            margin-top: 40px;
        }

        .chart-placeholder {
            width: 100%; /* Ensure the placeholder takes up the full width of the column */
            height: auto;
            max-height: 100%; /* Prevent the image from exceeding the column's height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chart-image {
            width: 100%; /* Ensure the image takes up the full width of the placeholder */
            height: auto;
            max-height: 100%; /* Prevent the image from exceeding the placeholder's height */
            object-fit: contain; /* Ensure the image scales proportionally */
            border-radius: 8px; /* Optional: Add rounded corners to the image */
        }

       .text-column {
            flex: 1 1 0%;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            max-width: 25%;
            margin-top: 40px;
        }



        /* Milestones Container */
        .milestones-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-height: 300px; /* Set a fixed height */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .milestone-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .milestone-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border: 1px solid #e3f2fd;
            border-radius: 8px;
            background-color: #e3f2fd;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 10px;
        }

        .milestone-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .milestone-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e3f2fd;
            border-radius: 50%;
            color: #1976d2;
            font-size: 18px;
        }

        .milestone-content {
            display: flex;
            flex-direction: column;
        }

        .milestone-text {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .milestone-date {
            font-size: 14px;
            color: #666;
        }

        .milestone-scroll {
            max-height: 220px; /* Adjust as needed */
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #bbdefb #f8fafc;
        }
        .milestone-scroll::-webkit-scrollbar {
            width: 8px;
            background: #f8fafc;
        }
        .milestone-scroll::-webkit-scrollbar-thumb {
            background: #bbdefb;
            border-radius: 6px;
        }
        /* Vaccine Container */
        .vaccine-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-height: 300px; /* Set a fixed height */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .vaccine-card {
            padding: 15px;
            border-left: 5px solid #1976d2;
            background-color: #e3f2fd;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .vaccine-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .vaccine-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .vaccine-date {
            font-size: 14px;
            color: #666;
        }

        .vaccine-days {
            font-size: 14px;
            color: #1976d2;
            font-weight: bold;
        }

        .vaccine-scroll {
            max-height: 220px; /* Adjust as needed */
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #bbdefb #f8fafc;
        }
        .vaccine-scroll::-webkit-scrollbar {
            width: 8px;
            background: #f8fafc;
        }
        .vaccine-scroll::-webkit-scrollbar-thumb {
            background: #bbdefb;
            border-radius: 6px;
        }

        /* Baby Tips Panel */
        .baby-tips-panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .baby-tips-panel p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .babyh1 {
            text-align: center; /* Centers text horizontally */
            margin: 0 auto; /* Centers the element horizontally */
            display: flex;
            justify-content: center; /* Centers content horizontally */
            align-items: center; /* Centers content vertically */
            height: 100%; /* Adjust height as needed */
            margin-bottom: 30px;
        }

        .baby-tips-scroll {
            max-height: 220px; /* Adjust as needed */
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #bbdefb #f8fafc;
        }
        .baby-tips-scroll::-webkit-scrollbar {
            width: 8px;
            background: #f8fafc;
        }
        .baby-tips-scroll::-webkit-scrollbar-thumb {
            background: #bbdefb;
            border-radius: 6px;
        }
        .baby-info-panel,
        .chart-container,
        .milestones-container,
        .vaccine-container,
        .baby-tips-panel {
            /*border: 2.5px solid #1976d2!important; --- IGNORE ---*/
            box-shadow: 0 4px 8px 0 #646566 !important;
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
        <a href="{{route('mybaby')}}" class="active"><i class="fas fa-child"></i> My Baby</a>
        <a href="{{route('growth')}}"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot"></i> Chat With Sage</a>
        <a href="{{route('checkup')}}"><i class="fas fa-check"></i> Checkups</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog"></i> Settings</a>
    </div>

    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">My Baby</h1>
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

                <div class="dropdown">
                    <button class="profile-btn" type="button" id="accountDropdown">
                        <div class="profile-img-container">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
                        </div>
                        <i class="fas fa-chevron-down arrow-icon"></i>
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item" href="{{ route('mainpage') }}"><i class="fa-solid fa-house"></i> Home</a></li>
                        <li><a class="dropdown-item" href="{{route('mybaby')}}"><i class="fas fa-baby"></i> My Baby</a></li>
                        <li><a class="dropdown-item" href="{{route('myaccount')}}"><i class="fa-solid fa-address-card"></i> My Account</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">
           <div class="baby-selector-container">
            <div>
                <h2>Welcome Back, {{ Auth::user()->name }}!</h2>
                <p>Let's make parenting smarter, together.

                </p>
            </div>
            <button class="add-baby-btn-top" onclick="openAddBabyModal()">
                <i class="fas fa-plus"></i> Add Baby
            </button>
        </div>

        <select id="babySelector"
        onchange="loadBabyData(this.value)"
        class="block w-64 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-200 text-gray-700 truncate">
        <option value="" disabled selected hidden>Select baby</option>
        @foreach(Auth::user()->babies as $baby)
        @php
        $birthDate = \Carbon\Carbon::parse($baby->birth_date);
        $now = \Carbon\Carbon::now();
        $diff = $birthDate->diff($now);

        $years = $diff->y;
        $months = $diff->m;

        if ($years > 0) {
            $ageText = "$years Years, $months Months";
        } else {
            $ageText = "$months Months";
        }
        @endphp

        <option
            value="{{ $baby->id }}"
            data-name="{{ $baby->name }}"
            data-age="{{ $ageText }}"
            data-birthdate="{{ $baby->birth_date }}"
            data-gender="{{ ucfirst($baby->gender) }}"
            data-ethnicity="{{ $baby->ethnicity }}"
            data-photo="{{ $baby->baby_photo_path ? asset('storage/' . $baby->baby_photo_path) : asset('storage/baby-photos/default-baby.png') }}"
            data-premature="{{ $baby->premature ? '1' : '0' }}"
        >
            {{ $baby->name }} ({{ ucfirst($baby->gender) }}, {{ $ageText }})
        </option>

        @endforeach
        </select>
        <hr>
        <div id="babyDashboard" style="display: none;">
            <h1 class="babyh1" id="selectedBabyProfileHeading">Select a baby to view their profile</h1>
            <div class="dashboard-grid">
                <!-- Row 1 -->
                <div class="baby-info-panel">
                    <div class="baby-photo-container">
                        @empty($baby)
                            <img id="selectedBabyPhoto"
                                src="{{ asset('storage/baby-photos/default-baby.png') }}"
                                alt="Default Baby Photo"
                                class="baby-photo">
                        @else
                            <img id="selectedBabyPhoto"
                                src="{{ asset('storage/' . $baby->baby_photo_path) }}"
                                alt="Baby Photo"
                                class="baby-photo">
                        @endempty
                    </div>
                    <div class="baby-details">
                        <h3 id="selectedBabyName" class="baby-name"></h3>
                        <p class="baby-info"><span class="baby-age" id="selectedBabyAge"></span></p>
                        <p class="baby-info" id="selectedBabyBirthDate"></p>
                        <p class="baby-info" id="selectedBabyGender"></p>
                        <p class="baby-info" id="selectedBabyEthnicity"></p>
                        <p class="baby-info" id="selectedBabyPremature"></p>
                    </div>
                    <div class="baby-actions">
                        <button class="btn btn-outline-primary" onclick="editSelectedBaby()">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteSelectedBaby()">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>

                <div class="chart-container">
                    <h3 class="chart-title">Height Growth Chart</h3>
                    <div class="chart-column">
                        <canvas id="heightGrowthChart"></canvas>
                    </div>
                    <div class="text-column">
                        <h4>Storytelling</h4>
                        <p>Height: </br> Measurement: cm </br> Status: Normal</p>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="milestones-container">
                    <h4>Recent Milestones Achieved</h4>
                    <div class="milestone-scroll" style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="milestone-item">
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                First smile
                            </div>
                            <div class="milestone-date">
                                May 15, 2023
                            </div>
                        </div>
                        <div class="milestone-item">
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                Recognized familiar voice
                            </div>
                            <div class="milestone-date">
                                June 2, 2023
                            </div>
                        </div>
                        <div class="milestone-item">
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                First solid food
                            </div>
                            <div class="milestone-date">
                                June 20, 2023
                            </div>
                        </div>
                        <div class="milestone-item">
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                Rolled over tummy
                            </div>
                            <div class="milestone-date">
                                June 25, 2023
                            </div>
                        </div>
                        <div class="milestone-item">
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                Sits without support
                            </div>
                            <div class="milestone-date">
                                June 22, 2023
                            </div>
                        </div>
                        <div class="milestone-item">
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                Stands holding on
                            </div>
                            <div class="milestone-date">
                                June 28, 2023
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vaccine-container">
                    <h4>Next Vaccination</h4>
                    <div class="vaccine-scroll" style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="vaccine-card">
                            <div class="vaccine-name">Hepatitis B (3rd dose)</div>
                            <div class="vaccine-date">July 15, 2023</div>
                            <div class="vaccine-days">in 12 days</div>
                        </div>
                        <div class="vaccine-card" style="border-left-color: #4scaf50; opacity: 0.7;">
                            <div class="vaccine-name">DTaP (2nd dose)</div>
                            <div class="vaccine-date">August 5, 2023</div>
                            <div class="vaccine-days">in 33 days</div>
                        </div>
                        <div class="vaccine-card" style="border-left-color: #4scaf50; opacity: 0.7;">
                            <div class="vaccine-name">MMR (1st dose)</div>
                            <div class="vaccine-date">September 5, 2023</div>
                            <div class="vaccine-days">in 63 days</div>
                        </div>
                        <div class="vaccine-card" style="border-left-color: #4scaf50; opacity: 0.7;">
                            <div class="vaccine-name">Pneumokokal (1st dose)</div>
                            <div class="vaccine-date">October 25, 2023</div>
                            <div class="vaccine-days">in 93 days</div>
                        </div>
                        <div class="vaccine-card" style="border-left-color: #4scaf50; opacity: 0.7;">
                            <div class="vaccine-name">Pneumokokal (2nd dose)</div>
                            <div class="vaccine-date">November 15, 2023</div>
                            <div class="vaccine-days">in 123 days</div>
                        </div>
                    </div>
                </div>

                <!-- Baby Tips -->
                <div class="baby-tips-panel">
                    <h4>Baby Tips</h4>
                    <div class="baby-tips-list baby-tips-scroll" style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="baby-tip-item" style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #e3f2fd; border-radius: 8px; background-color: #e3f2fd; margin-bottom: 5px;">
                            <div class="tip-icon" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #bbdefb; border-radius: 50%; color: #1976d2;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="tip-text" style="flex: 1; font-size: 15px; color: #333;">
                                Always place your baby on their back to sleep.
                            </div>
                            <button class="btn btn-xs btn-outline-danger" style="font-size: 10px; padding: 2px 6px; min-width: unset; height: 22px;" onclick="removeTip(this)">
                                <i class="fas fa-times" style="font-size: 12px;"></i>
                            </button>
                        </div>
                        <div class="baby-tip-item" style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #e3f2fd; border-radius: 8px; background-color: #e3f2fd; margin-bottom: 5px;">
                            <div class="tip-icon" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #bbdefb; border-radius: 50%; color: #1976d2;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="tip-text" style="flex: 1; font-size: 15px; color: #333;">
                                Talk, read, and sing to your baby every day.
                            </div>
                            <button class="btn btn-xs btn-outline-danger" style="font-size: 10px; padding: 2px 6px; min-width: unset; height: 22px;" onclick="removeTip(this)">
                                <i class="fas fa-times" style="font-size: 12px;"></i>
                            </button>
                        </div>
                        <div class="baby-tip-item" style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #e3f2fd; border-radius: 8px; background-color: #e3f2fd; margin-bottom: 5px;">
                            <div class="tip-icon" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #bbdefb; border-radius: 50%; color: #1976d2;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="tip-text" style="flex: 1; font-size: 15px; color: #333;">
                                Never leave your baby unattended on high surfaces.
                            </div>
                            <button class="btn btn-xs btn-outline-danger" style="font-size: 10px; padding: 2px 6px; min-width: unset; height: 22px;" onclick="removeTip(this)">
                                <i class="fas fa-times" style="font-size: 12px;"></i>
                            </button>
                        </div>
                        <div class="baby-tip-item" style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #e3f2fd; border-radius: 8px; background-color: #e3f2fd; margin-bottom: 5px;">
                            <div class="tip-icon" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #bbdefb; border-radius: 50%; color: #1976d2;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="tip-text" style="flex: 1; font-size: 15px; color: #333;">
                                Eat healthy as suggested.
                            </div>
                            <button class="btn btn-xs btn-outline-danger" style="font-size: 10px; padding: 2px 6px; min-width: unset; height: 22px;" onclick="removeTip(this)">
                                <i class="fas fa-times" style="font-size: 12px;"></i>
                            </button>
                        </div>
                        <div class="baby-tip-item" style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #e3f2fd; border-radius: 8px; background-color: #e3f2fd; margin-bottom: 5px;">
                            <div class="tip-icon" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #bbdefb; border-radius: 50%; color: #1976d2;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="tip-text" style="flex: 1; font-size: 15px; color: #333;">
                                Quality Sleeps.
                            </div>
                            <button class="btn btn-xs btn-outline-danger" style="font-size: 10px; padding: 2px 6px; min-width: unset; height: 22px;" onclick="removeTip(this)">
                                <i class="fas fa-times" style="font-size: 12px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <script>
                    function removeTip(btn) {
                        btn.closest('.baby-tip-item').remove();
                    }
                </script>
            </div>
        </div>


        <!-- Add/Edit Baby Modal -->
            <div class="modal fade" id="addEditBabyModal" tabindex="-1" aria-labelledby="addEditBabyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEditBabyModalLabel">Add New Baby</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="babyForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="babyId" name="id">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="babyPhotoInput" class="form-label">Baby Photo</label>
                                    <input type="file" class="form-control" id="babyPhotoInput" name="baby_photo" accept="image/*">
                                    <div id="photoPreview" class="mt-3 text-center"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="babyName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="babyName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="babyBirthDate" class="form-label">Birth Date</label>
                                    <input type="date" class="form-control" id="babyBirthDate" name="birth_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="babyGender" class="form-label">Gender</label>
                                    <select class="form-select" id="babyGender" name="gender" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="babyEthnicity" class="form-label">Ethnicity</label>
                                    <select class="form-select" id="babyEthnicity" name="ethnicity" required>
                                        <option value="" disabled selected hidden>Select Ethnicity</option>
                                        <option value="Malay">Malay</option>
                                        <option value="Chinese">Chinese</option>
                                        <option value="Indian">Indian</option>
                                        <option value="Orang Asli">Orang Asli</option>
                                        <option value="Bumiputera Sabah">Bumiputera Sabah</option>
                                        <option value="Bumiputera Sarawak">Bumiputera Sarawak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="babyPremature" class="form-label">Is the baby premature?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="babyPremature" name="premature" value="1">
                                        <label class="form-check-label" for="babyPremature">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-danger" id="deleteBabyButton" onclick="deleteSelectedBaby()" style="display: none;">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        //chart
        document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('heightGrowthChart').getContext('2d');

        // Example data for height growth (in cm) over months
        const labels = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']; // Months
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Baby Height (cm)',
                    data: [50, 54, 58, 61, 63, 65, 67, 69, 71, 73, 74, 75, 76], // Example height data
                    borderColor: '#1976d2',
                    backgroundColor: 'rgba(25, 118, 210, 0.2)',
                    borderWidth: 2,
                    tension: 0.4, // Smooth curvature
                },
            ],
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Age (Months)',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Height (cm)',
                        },
                        beginAtZero: true,
                    },
                },
            },
        };

        // Render the chart
        new Chart(ctx, config);
    });

        // Initialize modal globally
        let addEditBabyModal;
        let currentBabyId = null;

        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modal
            addEditBabyModal = new bootstrap.Modal(document.getElementById('addEditBabyModal'));

            // Photo preview handler
            document.getElementById('babyPhotoInput')?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        document.getElementById('photoPreview').innerHTML = `
                            <img src="${event.target.result}" class="img-thumbnail rounded-circle" width="150" height="150">
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form submission handler
            document.getElementById('babyForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        // Check if premature checkbox is checked
        const prematureChecked = document.getElementById('babyPremature').checked ? '1' : '0';
        formData.append('premature', prematureChecked);

        // For PUT requests, Laravel needs _method field
        if (form.method.toLowerCase() === 'put') {
            formData.append('_method', 'PUT');
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST', // Always use POST when sending FormData
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(Object.values(errorData.errors).join('\n'));
            }

            const data = await response.json();
            alert('Baby updated successfully!');
            window.location.reload(); // Or update UI as needed
        } catch (error) {
            console.error('Submission error:', error);
            alert(error.message);
        }
        });
        });

        // Load baby data when selected from dropdown
        function loadBabyData(babyId) {
            const selector = document.getElementById('babySelector');
            const selectedOption = selector.options[selector.selectedIndex];

            if (!babyId || !selectedOption) {
                document.getElementById('babyDashboard').style.display = 'none';
                document.getElementById('selectedBabyProfileHeading').textContent = 'Select a baby to view their profile';
                return;
            }

            // Update the heading dynamically
            document.getElementById('selectedBabyProfileHeading').textContent = `${selectedOption.dataset.name}'s At A Glance`;

            // Extract data attributes and update the dashboard
            const defaultPhoto = '/storage/baby-photos/default-baby.png';
            const babyPhoto = selectedOption.dataset.photo;
            document.getElementById('selectedBabyName').textContent = selectedOption.dataset.name;
            document.getElementById('selectedBabyAge').textContent = selectedOption.dataset.age;
            document.getElementById('selectedBabyBirthDate').textContent = "Birth Date: " + selectedOption.dataset.birthdate;
            document.getElementById('selectedBabyGender').textContent = "Gender: " + selectedOption.dataset.gender;
            document.getElementById('selectedBabyEthnicity').textContent = "Ethnicity: " + selectedOption.dataset.ethnicity;
            document.getElementById('selectedBabyPremature').textContent = selectedOption.dataset.premature == '1' ? "Premature: Yes" : "Premature: No";
            document.getElementById('selectedBabyPhoto').src = babyPhoto && babyPhoto !== 'null' ? babyPhoto : defaultPhoto;

            document.getElementById('babyDashboard').style.display = 'block';
        }

        // Edit the currently selected baby
        function editSelectedBaby() {
        const selector = document.getElementById('babySelector');
        const selectedOption = selector.options[selector.selectedIndex];



         if (!selectedOption || !selectedOption.value) {
        alert('Please select a baby to edit.');
                return;
            }

            const babyId = selectedOption.value;
            editBaby(babyId);
        }

        // Delete the currently selected baby
        function deleteSelectedBaby() {
        const selector = document.getElementById('babySelector');
        const selectedOption = selector.options[selector.selectedIndex];

     if (!selectedOption || !selectedOption.value) {
        alert('Please select a baby to delete.');
        return;
     }

        const babyId = selectedOption.value;
        confirmDelete(babyId);
        }

        // Open modal for adding new baby
        function openAddBabyModal() {
            const form = document.getElementById('babyForm');
            form.reset();
            form.action = "/babies";
            document.getElementById('addEditBabyModalLabel').textContent = 'Add New Baby';
            document.getElementById('photoPreview').innerHTML = '';
            document.getElementById('deleteBabyButton').style.display = 'none'; // Hide delete button for creation

            // Clear any existing hidden _method field
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();

            const addEditBabyModal = new bootstrap.Modal(document.getElementById('addEditBabyModal'));
            addEditBabyModal.show();
        }

        // Open modal for editing baby
        async function editBaby(babyId) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(`/babies/${babyId}/edit`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to load baby data');

        const baby = await response.json();
        const form = document.getElementById('babyForm');

        // Populate the form with baby data
        form.action = `/babies/${baby.id}`;
        document.getElementById('addEditBabyModalLabel').textContent = 'Edit Baby';
        document.getElementById('babyId').value = baby.id;
        document.getElementById('babyName').value = baby.name;
        document.getElementById('babyBirthDate').value = baby.birth_date.split('T')[0];
        document.getElementById('babyGender').value = baby.gender;
        document.getElementById('babyEthnicity').value = baby.ethnicity || '';
        document.getElementById('babyPremature').checked = baby.premature == '1';

        // Set photo preview with default image if no photo is available
        const photoPreview = document.getElementById('photoPreview');
        const defaultPhoto = '/path/to/default-baby-photo.jpg'; // Replace with the actual path to your default image
        photoPreview.innerHTML = baby.baby_photo_path
            ? `<img src="/storage/${baby.baby_photo_path}" class="img-thumbnail rounded-circle" width="150" height="150">`
            : `<img src="${defaultPhoto}" class="img-thumbnail rounded-circle" width="150" height="150">`;

        // Add hidden input for PUT method
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'PUT';

        document.getElementById('deleteBabyButton').style.display = 'inline-block'; // Show delete button for editing

        const addEditBabyModal = new bootstrap.Modal(document.getElementById('addEditBabyModal'));
        addEditBabyModal.show();
    } catch (error) {
        console.error('Error loading baby:', error);
        alert('Failed to load baby data. Please try again.');
    }
}

        // Delete baby confirmation
        async function confirmDelete(babyId) {
     if (!confirm('Are you sure you want to delete this baby?')) return;

        try {
        const response = await fetch(`/babies/${babyId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            const error = await response.json().catch(() => null);
            throw new Error(error?.message || 'Failed to delete baby');
        }

        window.location.reload();
        } catch (error) {
        console.error('Delete error:', error);
        alert(error.message);
         }
        }

        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            document.querySelector('.toggle-btn i').className =
                sidebar.classList.contains('hidden') ? 'fas fa-bars' : 'fas fa-times';
        }

        // Profile dropdown
        (function() {
            const profileBtn = document.querySelector('.profile-btn');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            const arrowIcon = document.querySelector('.arrow-icon');

            if (profileBtn && dropdownMenu && arrowIcon) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                    arrowIcon.style.transform = dropdownMenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
                });

                document.addEventListener('click', function() {
                    dropdownMenu.classList.remove('show');
                    arrowIcon.style.transform = 'rotate(0)';
                });
            }
        })();

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

    <style>
        /* Spinner styling */
        .spinner-border {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: text-bottom;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
            margin-right: 0.5rem;
        }
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
    </style>
</body>
</html>
