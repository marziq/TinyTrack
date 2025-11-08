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
        @import url('https://fonts.googleapis.com/css2?family=Comic+Relief:wght@400;700&family=Outfit:wght@100..900&family=Sigmar&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=IM+Fell+Great+Primer+SC&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Outfit", sans-serif;
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
            margin-bottom: 2px;
            font-size: 15px;
            height: 45px;
            display: flex;
            align-items: center;
        }

        .sidebar a:not([style]) {
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.28);
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
            margin-right: 70px;
            margin-bottom: 50px;
            margin-left: 70px;
        }

        .baby-info-panel {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(48, 48, 48, 0.05);
            display: flex;
            height: 420px;
            margin-bottom: 20px;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            text-align: center; /* Center text */
            gap: 15px; /* Add spacing between elements */
        }

        /* Favorite Tips Panel Styles */
        .favorite-tips-panel {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(48, 48, 48, 0.05);
            margin-bottom: 20px;
        }

        .favorite-tips-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e3f2fd;
        }

        .favorite-tips-header h3 {
            color: #1976d2;
            font-size: 1.25rem;
            margin: 0;
        }

        .favorite-tips-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .favorite-tip-card {
            background: #f8fafc;
            border-radius: 10px;
            padding: 15px;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .favorite-tip-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .favorite-tip-title {
            color: #1976d2;
            font-size: 1.1rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .favorite-tip-category {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .favorite-tip-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }

        .favorite-tip-remove:hover {
            background-color: rgba(220, 53, 69, 0.1);
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
            box-shadow: 0 4px 12px rgba(49, 49, 49, 0.05);
            height: 420px;
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
            max-height: 1000px; /* Set a fixed height */
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
            color: #16fc38; /* light green for milestone check icon */
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

        .milestone-item {
            position: relative; /* allow absolute positioning of date */
        }

        .milestone-date {
            font-size: 12px;
            color: #666;
            position: absolute;
            right: 12px;
            bottom: 8px;
        }

        .milestone-text {
            flex: 1; /* take remaining space so date doesn't overlap */
            padding-right: 100px; /* leave room for absolute date */
        }

        .milestone-scroll {
            max-height: 420px; /* Adjust as needed */
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
            max-height: 1000px; /* Set a fixed height */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .vaccine-card {
            padding: 15px;
            border-left: 5px solid #9c27b0; /* purple left border for vaccinations */
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
            max-height: 420px; /* Adjust as needed */
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
            max-height: 420px; /* Adjust as needed */
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
            box-shadow: 0 4px 8px 0 #b8b8b8 !important;
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
        <a href="{{route('mybaby')}}" class="active"><i class="fas fa-child" style="color:rgb(31, 63, 221)"></i> My Baby</a>
        <a href="{{route('growth')}}"><i class="fas fa-chart-line" style="color: rgb(242, 114, 136)"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb" style="color: #FFD700;"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye" style="color: red"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar" style="color: #16fc38"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot" style="color: orangered"></i> Chat With Sage</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog" style="color: #666"></i> Settings</a>
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
                <!-- Tip Info Modal -->
                <div class="modal fade" id="tipInfoModal" tabindex="-1" aria-labelledby="tipInfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tipInfoModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="tipInfoModalBody">
                            </div>
                        </div>
                    </div>
                </div>
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
                    </div>
                </div>

                <div class="chart-container">
                    <h3 class="chart-title" id="growthChartTitle">Growth</h3>
                    <div style="position: absolute; top: 18px; right: 20px; z-index:3; display:flex; gap:8px;">
                        <button id="toggleHeight" class="btn btn-sm" style="background:#43a047;color:#fff;border-radius:8px;">Height</button>
                        <button id="toggleWeight" class="btn btn-sm" style="background:#ff8a65;color:#fff;border-radius:8px;">Weight</button>
                    </div>
                    <div class="chart-column">
                        <canvas id="growthChart"></canvas>
                    </div>
                    <div class="text-column">
                        <h4>Summary</h4>
                        <p id="growthStory">Select a baby to view growth data (height / weight) over time.</p>
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
                    <div id="vaccineScroll" class="vaccine-scroll" style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="padding:12px; color:#666;">Select a baby to view upcoming vaccinations.</div>
                    </div>
                </div>

                <!-- Baby Tips (render favourited tips here) -->
                <div class="baby-tips-panel">
                    <h4>Baby Tips</h4>
                    <div class="baby-tips-list baby-tips-scroll">
                        @forelse(Auth::user()->favoriteTips as $tip)
                            <div class="baby-tip-item" style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #e3f2fd; border-radius: 8px; background-color: #e3f2fd; margin-bottom: 5px;"
                                 data-id="{{ $tip->id }}"
                                 data-title="{{ $tip->title }}"
                                 data-content="{{ $tip->rich_content }}"
                                 data-image="{{ $tip->image_url }}"
                                 data-video="{{ $tip->video_url }}"
                                 onclick="showTipDetails(event, this)">
                                <div class="tip-icon" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #fff8e1; border-radius: 50%; color: #FFD700;">
                                    <i class="fas fa-lightbulb" style="color: #FFD700;"></i>
                                </div>
                                <div class="tip-text" style="flex: 1; font-size: 15px; color: #333;">
                                    {{ $tip->title }}
                                </div>
                                <button class="btn btn-xs btn-outline-danger" style="font-size: 10px; padding: 2px 6px; min-width: unset; height: 22px;" onclick="removeFavoriteTip(event, {{ $tip->id }})">
                                    <i class="fas fa-times" style="font-size: 12px;"></i>
                                </button>
                            </div>
                        @empty
                            <div class="baby-tip-item" style="padding:12px; color:#666;">You haven't favourited any tips yet.</div>
                        @endforelse
                    </div>
                </div>
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
        // Growth chart: single canvas that toggles between Height and Weight
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('growthChart').getContext('2d');
            let growthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, position: 'top' }
                    },
                    scales: {
                        x: { title: { display: true, text: 'Age (Months)' } },
                        y: { title: { display: true, text: '' }, beginAtZero: true }
                    }
                }
            });

            const GREEN = '#43a047';
            const ORANGE = '#ff8a65';

            function renderGrowth(type, labels, values) {
                growthChart.data.labels = labels;
                growthChart.data.datasets = [{
                    label: type === 'height' ? 'Height (cm)' : 'Weight (g)',
                    data: values,
                    borderColor: type === 'height' ? GREEN : ORANGE,
                    backgroundColor: type === 'height' ? 'rgba(67,160,71,0.12)' : 'rgba(255,138,101,0.15)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }];
                growthChart.options.scales.y.title.text = type === 'height' ? 'Height (cm)' : 'Weight (g)';
                // Update chart title
                const titleEl = document.getElementById('growthChartTitle');
                if (titleEl) titleEl.textContent = type === 'height' ? 'Height Chart' : 'Weight Chart';
                growthChart.update();

                // update storytelling summary
                const storyEl = document.getElementById('growthStory');
                if (storyEl) {
                    if (!labels || labels.length === 0) {
                        storyEl.innerText = 'No growth data available for this baby.';
                    } else {
                        const last = values[values.length - 1];
                        const lastLabel = labels[labels.length - 1];
                        storyEl.innerText = `${type === 'height' ? 'Height' : 'Weight'} at ${lastLabel} month(s): ${last} ${type === 'height' ? 'cm' : 'g'}`;
                    }
                }
            }

            // Toggle buttons
            const btnH = document.getElementById('toggleHeight');
            const btnW = document.getElementById('toggleWeight');
            let currentType = 'height';
            btnH?.addEventListener('click', function() {
                currentType = 'height';
                btnH.style.opacity = '1'; btnW.style.opacity = '0.75';
                const titleEl = document.getElementById('growthChartTitle');
                if (titleEl) titleEl.textContent = 'Height Chart';
                // if we have last loaded data stored, re-render from it
                if (window._lastGrowthData) renderGrowth('height', window._lastGrowthData.labels, window._lastGrowthData.height);
            });
            btnW?.addEventListener('click', function() {
                currentType = 'weight';
                btnW.style.opacity = '1'; btnH.style.opacity = '0.75';
                const titleEl = document.getElementById('growthChartTitle');
                if (titleEl) titleEl.textContent = 'Weight Chart';
                if (window._lastGrowthData) renderGrowth('weight', window._lastGrowthData.labels, window._lastGrowthData.weight);
            });

            // Expose loader for other scripts
            window.loadGrowthChart = async function(babyId) {
                if (!babyId) return;
                try {
                    const res = await fetch(`/dashboard/growth/${babyId}`);
                    if (!res.ok) throw new Error('Failed to fetch growth data');
                    const payload = await res.json();

                    // Normalize response into { labels:[], height:[], weight:[] }
                    let labels = [];
                    let height = [];
                    let weight = [];

                    if (Array.isArray(payload)) {
                        // handle Growth model array entries { growthMonth, height, weight, ... }
                        payload.sort((a,b)=> (a.growthMonth ?? a.age_months ?? 0) - (b.growthMonth ?? b.age_months ?? 0));
                        labels = payload.map(p => String(p.growthMonth ?? p.age_months ?? '0'));
                        height = payload.map(p => p.height ?? p.height_cm ?? null);
                        weight = payload.map(p => p.weight ?? p.weight_g ?? null);
                    } else if (payload.labels && (payload.heightData || payload.height) ) {
                        labels = payload.labels;
                        height = payload.heightData || payload.height || [];
                        weight = payload.weightData || payload.weight || [];
                    } else if (payload.growths) {
                        const g = payload.growths;
                        g.sort((a,b)=> (a.age_months||0)-(b.age_months||0));
                        labels = g.map(x=> String(x.age_months ?? '0'));
                        height = g.map(x=> x.height_cm ?? null);
                        weight = g.map(x=> x.weight_g ?? null);
                    } else {
                        // fallback: try to find arrays
                        labels = payload.labels || [];
                        height = payload.height || payload.heightData || [];
                        weight = payload.weight || payload.weightData || [];
                    }

                    // store last data for toggling
                    window._lastGrowthData = { labels, height, weight };

                    // render current type
                    if (currentType === 'weight') {
                        renderGrowth('weight', labels, weight);
                    } else {
                        renderGrowth('height', labels, height);
                    }
                } catch (err) {
                    console.error('Growth load error', err);
                }
            };

            // Small visual initial state
            btnH && (btnH.style.opacity = '1');
            btnW && (btnW.style.opacity = '0.75');
            // Set initial title
            const initialTitle = document.getElementById('growthChartTitle');
            if (initialTitle) initialTitle.textContent = 'Height Chart';
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
            // Load growth chart data for selected baby (if loader is available)
            if (typeof window.loadGrowthChart === 'function') {
                window.loadGrowthChart(babyId);
            }
            // Load recent achieved milestones for this baby
            (async function loadRecentMilestones() {
                try {
                    const res = await fetch(`/babies/${babyId}/milestones/recent`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Failed to fetch recent milestones');
                    const payload = await res.json();
                    const container = document.querySelector('.milestone-scroll');
                    if (!container) return;
                    container.innerHTML = '';
                    const items = payload.recent || [];
                    if (items.length === 0) {
                        container.innerHTML = '<div style="padding:12px; color:#666;">No recent milestones.</div>';
                        return;
                    }
                    items.forEach(it => {
                        const itemEl = document.createElement('div');
                        itemEl.className = 'milestone-item';
                        itemEl.innerHTML = `
                            <div class="milestone-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="milestone-text">
                                ${it.title}
                            </div>
                            <div class="milestone-date">
                                ${it.achievedDate || ''}
                            </div>
                        `;
                        container.appendChild(itemEl);
                    });
                } catch (err) {
                    console.error(err);
                }
            })();
            // Load upcoming vaccinations for this baby
            // Expose a function so other scripts (and events) can refresh the list
            window.loadVaccinationsForBaby = async function(babyIdToLoad) {
                try {
                    const res = await fetch(`/vaccinations/baby/${babyIdToLoad}`, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) throw new Error('Failed to fetch vaccinations');
                    const payload = await res.json();
                    const container = document.getElementById('vaccineScroll');
                    if (!container) return;

                    container.innerHTML = '';

                    // Separate pending (not administered) and administered vaccines
                    const all = Array.isArray(payload) ? payload : [];
                    const pending = all.filter(v => v.status !== 'administered');
                    const administered = all.filter(v => v.status === 'administered');

                    // Sort both by scheduled_date ascending (nearest first)
                    function sortByDateAsc(a, b) {
                        const da = a.scheduled_date ? new Date(a.scheduled_date) : new Date(8640000000000000); // far future if missing
                        const db = b.scheduled_date ? new Date(b.scheduled_date) : new Date(8640000000000000);
                        return da - db;
                    }

                    pending.sort(sortByDateAsc);
                    administered.sort(sortByDateAsc);

                    if (pending.length === 0 && administered.length === 0) {
                        container.innerHTML = '<div style="padding:12px; color:#666;">No vaccinations scheduled.</div>';
                        return;
                    }

                    // Render pending vaccines first (nearest on top)
                    // For pending: show vaccine name and status (Pending)
                    pending.slice(0, 10).forEach((v, idx) => {
                        const styleParts = [];
                        if (container.children.length !== 0) styleParts.push('border-left-color: #9c27b0');

                        const card = document.createElement('div');
                        card.className = 'vaccine-card';
                        if (styleParts.length) card.setAttribute('style', styleParts.join('; ') + ';');
                        card.innerHTML = `
                            <div class="vaccine-name">${v.vaccine_name}</div>
                            <div class="vaccine-date">Pending</div>
                        `;
                        container.appendChild(card);
                    });

                    // If there are administered vaccines, add a small separator label then render them faded
                    if (administered.length > 0) {
                        const sep = document.createElement('div');
                        sep.style.padding = '6px 0';
                        sep.style.color = '#666';
                        sep.style.fontWeight = '600';
                        sep.textContent = 'Administered';
                        container.appendChild(sep);

                        administered.slice(0, 50).forEach((v) => {
                            // For administered vaccines: show vaccine name and administered date (if available)
                            const administeredAt = v.administered_at ? new Date(v.administered_at) : null;
                            const administeredText = administeredAt ? administeredAt.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }) : (v.scheduled_date ? new Date(v.scheduled_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' }) : '');

                            const styleParts = ['opacity: 0.5'];
                            if (container.children.length !== 0) styleParts.push('border-left-color: #9c27b0');

                            const card = document.createElement('div');
                            card.className = 'vaccine-card';
                            if (styleParts.length) card.setAttribute('style', styleParts.join('; ') + ';');
                            card.innerHTML = `
                                <div class="vaccine-name">${v.vaccine_name}</div>
                                <div class="vaccine-date">${administeredText}</div>
                            `;
                            container.appendChild(card);
                        });
                    }

                } catch (err) {
                    console.error(err);
                }
            };

            // call it initially for this selection
            window.loadVaccinationsForBaby(babyId);

            // Listen for vaccination toggle events from other pages (appointment) and refresh if it concerns the currently selected baby
            window.addEventListener('vaccinationToggled', function(e) {
                try {
                    const detail = e.detail || {};
                    const toggledBabyId = detail.baby_id || detail.babyId || detail.babyId;
                    const selector = document.getElementById('babySelector');
                    if (!selector) return;
                    const current = selector.value;
                    if (String(current) === String(toggledBabyId)) {
                        // refresh only vaccinations for the currently selected baby
                        window.loadVaccinationsForBaby(current);
                    }
                } catch (err) {
                    console.error('vaccinationToggled handler error', err);
                }
            });
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
        <script>
            // Show tip details in modal
            function showTipDetails(event, element) {
                // Prevent triggering when clicking remove button
                if (event.target.closest('.favorite-tip-remove')) {
                    return;
                }

                const tipData = element.dataset;
                const modalTitle = document.getElementById('tipInfoModalLabel');
                const modalBody = document.getElementById('tipInfoModalBody');

                modalTitle.innerText = tipData.title;

                // Parse the rich content to extract sections
                const richContent = tipData.content || '';
                const sections = richContent.split('\n').filter(s => s.trim() !== '');

                modalBody.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 style="color: #1976d2; margin: 0; font-size: 28px;">${tipData.title}</h3>
                            <div style="margin-top:8px; color:#1976d2; font-size:13px; line-height:1.2;">
                                <div>Reviewed By:</div>
                                <div>Dr Aiman Khalid</div>
                                <div>Consultant Pediatrician at Selangor Specialist Hospital</div>
                            </div>
                        </div>
                        <div>
                            <button id="removeFavoriteModalBtn" class="btn btn-primary">Remove from Favourites</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="lead mb-4" style="color:#333;">${sections[0] || tipData.content || ''}</p>
                    </div>

                    ${tipData.image ? `
                    <div class="text-center mb-4">
                        <img src="${tipData.image}" alt="${tipData.title}" class="img-fluid rounded" style="max-width: 700px; width:100%;">
                    </div>
                    ` : ''}

                    ${tipData.video ? `
                    <div class="mb-4">
                        <div class="ratio ratio-16x9">
                            <iframe src="${tipData.video}" allowfullscreen style="border-radius:10px;"></iframe>
                        </div>
                    </div>
                    ` : ''}

                    <div>
                        ${sections.slice(1).map((section) => {
                            if (section.startsWith('</br>')) {
                                return '<h4 class="text-primary mt-4">' + section.replace('</br>', '') + '</h4>';
                            } else {
                                return '<p class="mb-3" style="color:#444;">' + section + '</p>';
                            }
                        }).join('')}
                    </div>`;

                // wire up remove button in modal
                const removeBtn = document.getElementById('removeFavoriteModalBtn');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        // call existing removal which also updates UI
                        removeFavoriteTip(e, tipData.id || tipData['id']);
                    });
                }

                let tipModal = new bootstrap.Modal(document.getElementById('tipInfoModal'));
                tipModal.show();
            }

            // Remove favorite tip
            function removeFavoriteTip(event, tipId) {
                event.stopPropagation();
                if (!confirm('Are you sure you want to remove this tip from favorites?')) {
                    return;
                }

                fetch(`/favorite-tip/${tipId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove any matching favorite card(s) from UI
                        const favCard = document.querySelector(`.favorite-tip-card[data-id="${tipId}"]`);
                        const babyCard = document.querySelector(`.baby-tip-item[data-id="${tipId}"]`);
                        if (favCard) favCard.remove();
                        if (babyCard) babyCard.remove();

                        // Hide modal if open
                        try {
                            const modalEl = document.getElementById('tipInfoModal');
                            if (modalEl) {
                                const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                bsModal.hide();
                            }
                        } catch (err) {
                            // ignore
                        }

                        // Show success message
                        showNotificationModal('Success', 'Tip removed from favorites!', new Date().toLocaleDateString());
                    } else {
                        alert(data.message || 'Error removing tip from favorites');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error removing tip from favorites');
                });
            }
        </script>
</body>
</html>
