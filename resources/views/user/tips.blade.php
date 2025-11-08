<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Tips</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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

        /* Slider Container */
        .topics-section {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            overflow: hidden;
            margin: 20px auto;
        }

        .slider-container {
            width: 90%; /* Adjust width to fit the slider */
            overflow: hidden;
        }

        .slider-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        /* Topic Card */
        .topic-card {
            flex: 0 0 30%; /* Show 3 cards at a time */
            margin: 10px;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .topic-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .topic-card h3 {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
            text-align: center;
        }

        .topic-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .topic-card ul li {
            margin-bottom: 10px;
        }

        .topic-card ul li button {
            width: 100%;
            padding: 12px 14px; /* slightly bigger for better tap targets */
            font-size: 15px; /* increased for readability */
            color: #1976d2;
            background-color: #e3f2fd;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.15s ease;
        }

        .topic-card ul li button:hover {
            background-color: #bbdefb;
            transform: translateY(-2px);
        }

        /* Make the "All" or primary filter button slightly more prominent if used */
        .btn-filter-all {
            padding: 14px 18px;
            font-size: 16px;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .topic-card ul li button {
                padding: 14px; /* slightly larger touch area on mobile */
                font-size: 16px;
            }
        }

        /* Info Section */
        .info-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: none; /* Hidden by default */
        }

        .info-section h3 {
            font-size: 20px;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .info-section p {
            font-size: 16px;
            color: #555;
        }

        /* Slider Buttons */
        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #1976d2, #42a5f5); /* Gradient background */
            color: white;
            border: none;
            border-radius: 50%; /* Circular buttons */
            width: 50px;
            height: 50px;
            cursor: pointer;
            z-index: 10; /* Ensure buttons are above the slider content */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
        }

        .slider-btn:hover {
            background: linear-gradient(135deg, #1565c0, #1e88e5); /* Darker gradient on hover */
            transform: translateY(-50%) scale(1.1); /* Slightly enlarge on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); /* Stronger shadow on hover */
        }

        .prev-btn {
            left: 10px; /* Position the button inside the container */
        }

        .next-btn {
            right: 10px; /* Position the button inside the container */
        }

        @media (max-width: 768px) {
            .prev-btn {
                left: 5px; /* Adjust position for smaller screens */
            }

            .next-btn {
                right: 5px; /* Adjust position for smaller screens */
            }

            .slider-btn {
                width: 40px;
                height: 40px; /* Smaller buttons for smaller screens */
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
        #tipInfoModal .modal-dialog.modal-lg {
            max-width: 1200px !important;
            width: 95vw !important;
        }
        @media (max-width: 768px) {
            #tipInfoModal .modal-dialog.modal-lg {
                max-width: 98vw !important;
                width: 98vw !important;
                margin: 0;
            }
        }
        #tipInfoModal .modal-content {
            padding: 0 !important;
        }
        #tipInfoModal .modal-body {
            padding: 32px 32px 24px 32px !important;
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
        <a href="{{route('tips')}}"  class="active"><i class="fa-solid fa-lightbulb" style="color: #FFD700;"></i> Baby Tips</a>
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
            <h1 style="font-weight: bold">Baby Tips</h1>
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
        {{-- Main content goes here --}}
        <div class="explore-header">
            <h2>Tips for your Baby</h2>
        </div>
        <div class="topics-section">
            <button class="slider-btn prev-btn" onclick="moveSlide(-1)">&#10094;</button>
            <div class="slider-container">
                <div class="slider-track">
                    <!-- Bonding Topic -->
                    <div class="topic-card">
                        <img src="{{ asset('img/bonding.jpg') }}" alt="Bonding" class="topic-image">
                        <h3>Bonding</h3>
                        <ul class="topic-list">
                            <li>
                                <button onclick="showInfo('bonding1')">
                                    <i class="fa-solid fa-hand-holding-heart" style="margin-right:8px; color: rgb(250, 115, 138);"></i>
                                    Skin-to-Skin Cuddles
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('bonding2')">
                                    <i class="fa-solid fa-baby" style="margin-right:8px; color: rgb(239, 159, 94);"></i>
                                    Gentle Baby Massage
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('bonding3')">
                                    <i class="fa-solid fa-microphone" style="margin-right:8px; color: rgb(89, 247, 11);"></i>
                                    Talk & Sing to Baby
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('bonding4')">
                                    <i class="fa-regular fa-lightbulb" style="margin-right:8px; color: rgb(238, 255, 5);"></i>
                                    Tummy Time Play
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('bonding5')">
                                    <i class="fa-solid fa-language" style="margin-right:8px; color: rgb(43, 131, 194);"></i>
                                    Help Baby Learn Language
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('bonding6')">
                                    <i class="fa-solid fa-handshake" style="margin-right:8px; color: rgb(244, 20, 225);"></i>
                                    How to Build Trust with Your Baby
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Early Sensory Topic -->
                    <div class="topic-card">
                        <img src="{{ asset('img/earlysensory.jpg') }}" alt="Early Senses" class="topic-image">
                        <h3>Early Sensory</h3>
                        <ul class="topic-list">
                            <li>
                                <button onclick="showInfo('sensory1')">
                                    <i class="fa-regular fa-face-smile" style="margin-right:8px; color: #fbc02d;"></i>
                                    Eye Contact & Smiles
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sensory2')">
                                    <i class="fa-solid fa-ear-listen" style="margin-right:8px; color: #42a5f5;"></i>
                                    Respond to Sounds
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sensory3')">
                                    <i class="fa-solid fa-hand-dots" style="margin-right:8px; color: #8bc34a;"></i>
                                    Touch & Texture Play
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sensory4')">
                                    <i class="fa-solid fa-droplet" style="margin-right:8px; color: #ffb300;"></i>
                                    Watch for Jaundice
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sensory5')">
                                    <i class="fa-solid fa-scale-balanced" style="margin-right:8px; color: #ab47bc;"></i>
                                    The "Balance" Sense
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sensory6')">
                                    <i class="fa-regular fa-eye" style="margin-right:8px; color: #1976d2;"></i>
                                    How to Stimulate Baby's Vision
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Sleep and Routines Topic -->
                    <div class="topic-card">
                        <img src="{{ asset('img/sleep.jpeg') }}" alt="sleep" class="topic-image">
                        <h3>Sleep and Routines</h3>
                        <ul class="topic-list">
                            <li>
                                <button onclick="showInfo('sleep1')">
                                    <i class="fa-solid fa-bed" style="margin-right:8px; color: #1976d2;"></i>
                                    How Much Sleep Does Baby Need?
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sleep2')">
                                    <i class="fa-solid fa-moon" style="margin-right:8px; color: #fbc02d;"></i>
                                    Creating a Bedtime Routine
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sleep3')">
                                    <i class="fa-solid fa-child" style="margin-right:8px; color: #42a5f5;"></i>
                                    Back is Best
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sleep4')">
                                    <i class="fa-solid fa-ban" style="margin-right:8px; color: #e57373;"></i>
                                    Avoid Baby Walkers
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('sleep5')">
                                    <i class="fa-solid fa-cloud-moon" style="margin-right:8px; color: #ab47bc;"></i>
                                    Create Calm Nights
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Feeding and Nutrition Topic -->
                    <div class="topic-card">
                        <img src="{{ asset('img/feeding.jpg') }}" alt="feeding" class="topic-image">
                        <h3>Feeding and Nutrition</h3>
                        <ul class="topic-list">
                            <li>
                                <button onclick="showInfo('feeding1')">
                                    <i class="fa-solid fa-droplet"></i>
                                    Breastfeeding Basics
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('feeding2')">
                                    <i class="fa-solid fa-baby" style="margin-right:8px; color: #42a5f5;"></i>
                                    Exclusive Breastfeeding (0–6 Months)
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('feeding3')">
                                    <i class="fa-solid fa-clock" style="margin-right:8px; color: #ab47bc;"></i>
                                    Feed on Demand
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('feeding4')">
                                    <i class="fa-solid fa-utensils" style="margin-right:8px; color: #8bc34a;"></i>
                                    Start Solids at 6 Months
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('feeding5')">
                                    <i class="fa-solid fa-ban" style="margin-right:8px; color: #e57373;"></i>
                                    No Sugar, No Honey
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Safety and Hygiene Topic -->
                    <div class="topic-card">
                        <img src="{{ asset('img/hygiene.jpg') }}" alt="Safety and Hygiene" class="topic-image">
                        <h3>Safety & Hygiene</h3>
                        <ul class="topic-list">
                            <li>
                                <button onclick="showInfo('safety1')">
                                    <i class="fa-solid fa-hands-bubbles" style="margin-right:8px; color: #42a5f5;"></i>
                                    Wash Hands Often
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('safety2')">
                                    <i class="fa-solid fa-soap" style="margin-right:8px; color: #8bc34a;"></i>
                                    Bathe with Care
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('safety3')">
                                    <i class="fa-solid fa-user-lock" style="margin-right:8px; color: #e57373;"></i>
                                    No Baby Alone
                                </button>
                            </li>
                            <li>
                                <button onclick="showInfo('safety4')">
                                    <i class="fa-solid fa-cube" style="margin-right:8px; color: #fbc02d;"></i>
                                    Choose Safe Toys
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <button class="slider-btn next-btn" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <!-- Section to display more information -->
        <!---<div id="info-section" class="info-section">
            <h3 id="info-title"></h3>
            <p id="info-content"></p>
        </div>--->
        {{--Main  content ends here--}}

        <!-- Tip Info Modal -->
        <div class="modal fade" id="tipInfoModal" tabindex="-1" aria-labelledby="tipInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tipInfoModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="tipInfoModalBody"></div>
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

        let currentSlide = 0;

        function moveSlide(direction) {
            const sliderTrack = document.querySelector('.slider-track');
            const topicCards = document.querySelectorAll('.topic-card');
            const cardWidth = topicCards[0].offsetWidth + 20; // Include margin
            const visibleSlides = 3; // Number of visible slides
            const totalSlides = topicCards.length;

            // Calculate the new slide index
            currentSlide += direction;

            // Prevent sliding out of bounds
            if (currentSlide < 0) {
                currentSlide = 0;
            } else if (currentSlide > totalSlides - visibleSlides) {
                currentSlide = totalSlides - visibleSlides;
            }

            // Move the slider track
            sliderTrack.style.transform = `translateX(-${currentSlide * cardWidth}px)`;
        }

        function showInfo(topicId) {
            const modalTitle = document.getElementById('tipInfoModalLabel');
            const modalBody = document.getElementById('tipInfoModalBody');
            const topics = {
                bonding1: {
                    title: 'Skin-to-Skin Cuddles',
                    content: 'Explore the science and tradition behind skin-to-skin cuddles — a beautiful first step in bonding that supports your baby’s health, emotional well-being and development from the very first hours of life.',
                    additionalText: 'Skin-to-skin contact also helps regulate your baby’s temperature, heart rate, and breathing. It promotes bonding and can even help with breastfeeding success.',
                    heroImage: '{{ asset("img/skintoskin2.jpeg") }}', // Replace with actual image path
                    videoUrl: 'https://www.youtube.com/embed/VOjGhwMuWFU?si=EEowDG50bdKRLGHo', // Replace with actual video URL
                    title2: '</br>What Is Skin-to-Skin Contact?',
                    additionalText2: 'Skin-to-skin contact, also known as kangaroo care, is when a newborn (usually wearing just a diaper) is placed directly against the bare chest of a parent. This natural method is recommended right after birth and can be practiced daily during the baby’s first year. It helps babies feel safe, warm, and calm — and encourages parents to feel more confident in caring for their newborn.',
                    title3: '</br>Why It Matters for Malaysian Parents',
                    additionalText3: 'According to the Child Health Record Book issued by the Ministry of Health Malaysia, early care and close bonding are essential for your baby’s development. Although the book may not use the exact phrase "skin-to-skin," it strongly encourages immediate closeness after birth and exclusive breastfeeding for the first six months — both of which are supported by skin-to-skin cuddles. This practice is also aligned with public health advice in Malaysia to promote breastfeeding, bonding, and safer sleep patterns in babies.',
                    title4:'</br>Benefits of Skin-to-Skin Cuddles',
                    additionalText4: '- Regulates your baby’s body temperature, heartbeat and breathing <br/> - Encourages exclusive breastfeeding by triggering natural milk supply. </br> - Reduces crying, supports better sleep, and lowers stress for both baby and parent. </br> - Boosts baby immune system and healthy weight gain </br> Strengthens emotional bonding and early brain development.',
                    title5: '</br> Expert Tip From Malaysian Healthcare',
                    additionalText5: '“Skin-to-skin care, even for a few minutes a day, can help parents feel more connected and confident, while giving babies a better start in life.” </br> — Nurse Supervisor, Klinik Kesihatan Selangor'
                },
                bonding2: {
                    title: 'Gentle Baby Massage',
                    content: 'Skin-to-skin contact helps regulate your baby’s temperature and heartbeat. Baby massage can soothe and relax your baby.',
                    heroImage: '{{ asset("img/baby-massage.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL

                },
                bonding3: {
                    title: 'Talk & Sing to Baby',
                    content: 'Skin-to-skin contact helps regulate your baby’s temperature and heartbeat. Baby massage can soothe and relax your baby.',
                    heroImage: '{{ asset("img/baby-massage.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL

                },
                bonding4: {
                    title: 'Tummy Time Play',
                    content: 'Tummy time is important for your baby’s development. It helps strengthen their neck, shoulders, and back muscles.',
                    heroImage: '{{ asset("img/tummy-time.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                bonding5: {
                    title: 'Help Baby Learn Language',
                    content: 'Talking and singing to your baby helps them learn language. It’s never too early to start reading to your baby!',
                    heroImage: '{{ asset("img/language-learning.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                bonding6: {
                    title: 'How to Build Trust with Your Baby',
                    content: 'Building trust with your baby is important for their emotional development. Responding to their needs helps build this trust.',
                    heroImage: '{{ asset("img/build-trust.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory1: {
                    title: 'Eye Contact & Smiles',
                    content: 'From the very first gaze to their very first smile — learn how your baby uses these powerful early interactions to bond with you, grow emotionally and develop key brain functions during their first year.',
                    heroImage: '{{ asset("img/eye-contact.jpg") }}',
                    additionalText: 'This Malaysian parenting segment explains how eye contact and facial expressions help babies recognise, connect and communicate. Watch how small actions can spark big developments in your little one.',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id', // Replace with actual video URL
                    title2: 'What Is Eye Contact and Smiling in Baby Development?',
                    additionalText2: 'Eye contact and smiling are two of the very first ways your baby interacts with the world. As early as a few weeks old, babies begin to focus on faces — especially those of parents and caregivers. Smiling is often their first social behaviour.',
                    additionalText3: 'The Child Health Record Book by the Ministry of Health Malaysia includes these milestones in its early screening checklist: <br/> <ul><li> Does your child look at your face when you speak?</li><li>Does your child look into your eyes?</li> <li> Does your child smile in response to your face or voice?</li></ul> These actions are important indicators of emotional growth and healthy brain development.',
                },
                sensory2: {
                    title: 'Respond to Sounds',
                    content: 'Your baby is learning to recognize your voice and other sounds around them. Responding to sounds helps your baby learn about their world.',
                    additionalText: 'Play soft music or talk to your baby. This helps them learn to recognize different sounds and voices.',
                    heroImage: '{{ asset("img/respond-to-sounds.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory3: {
                    title: 'Touch & Texture Play',
                    content: 'Your baby is learning about the world through touch. Different textures can help stimulate your baby’s senses.',
                    heroImage: '{{ asset("img/touch-texture.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory4: {
                    title: 'Watch for Jaundice',
                    content: 'Jaundice is common in newborns. It’s important to monitor your baby for signs of jaundice and seek medical advice if necessary.',
                    heroImage: '{{ asset("img/jaundice.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory5: {
                    title: 'The "Balance" Sense',
                    content: 'Your baby is learning to balance and coordinate their movements. This is an important part of their physical development.',
                    heroImage: '{{ asset("img/balance-sense.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory6: {
                    title: 'How to Stimulate Baby\'s Vision',
                    content: 'Your baby’s vision is developing rapidly. There are many ways to stimulate your baby’s vision and help them learn.',
                    heroImage: '{{ asset("img/stimulate-vision.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep1: {
                    title: 'How Much Sleep Does Baby Need?',
                    content: 'Newborns sleep a lot! They need about 14-17 hours of sleep a day. This includes naps and nighttime sleep.',
                    heroImage: '{{ asset("img/sleep-needs.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep2: {
                    title: 'Creating a Bedtime Routine',
                    content: 'A consistent bedtime routine can help your baby learn when it’s time to sleep. This can include activities like bathing, reading, and cuddling.',
                    heroImage: '{{ asset("img/bedtime-routine.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep3: {
                    title: 'Back is Best',
                    content: 'Always place your baby on their back to sleep. This helps reduce the risk of Sudden Infant Death Syndrome (SIDS).',
                    heroImage: '{{ asset("img/back-is-best.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep4: {
                    title: 'Avoid Baby Walkers',
                    content: 'Baby walkers can be dangerous. They can lead to falls and injuries. It’s best to avoid using them.',
                    heroImage: '{{ asset("img/avoid-walkers.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep5: {
                    title: 'Create Calm Nights',
                    content: 'Creating a calm and quiet environment can help your baby sleep better. This includes dimming the lights and reducing noise.',
                    heroImage: '{{ asset("img/calm-nights.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding1: {
                    title: 'Breastfeeding Basics',
                    content: 'Breastfeeding is the best way to feed your baby. It provides all the nutrients your baby needs.',
                    heroImage: '{{ asset("img/breastfeeding.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding2: {
                    title: 'Exclusive Breastfeeding (0–6 Months)',
                    content: 'Exclusive breastfeeding is recommended for the first 6 months. This means no other foods or drinks, not even water.',
                    heroImage: '{{ asset("img/exclusive-breastfeeding.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding3: {
                    title: 'Feed on Demand',
                    content: 'Feed your baby whenever they show signs of hunger. This helps ensure they get enough milk.',
                    heroImage: '{{ asset("img/feed-on-demand.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding4: {
                    title: 'Start Solids at 6 Months',
                    content: 'Introduce solid foods around 6 months. Start with single-grain cereals and pureed fruits and vegetables.',
                    heroImage: '{{ asset("img/start-solids.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding5: {
                    title: 'No Sugar, No Honey',
                    content: 'Avoid giving your baby sugar and honey. These can be harmful to their health.',
                    heroImage: '{{ asset("img/no-sugar.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety1: {
                    title: 'Wash Hands Often',
                    content: 'Washing hands often helps prevent the spread of germs. Make sure to wash your hands before handling your baby.',
                    heroImage: '{{ asset("img/wash-hands.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety2: {
                    title: 'Bathe with Care',
                    content: 'Bathing your  baby is important for hygiene. Make sure to use gentle products and be careful with water temperature.',
                    heroImage: '{{ asset("img/bathe-with-care.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety3: {
                    title: 'No Baby Alone',
                    content: 'Never leave your baby alone on a high surface. Always keep an eye on them to prevent falls.',
                    heroImage: '{{ asset("img/no-baby-alone.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety4: {
                    title: 'Choose Safe Toys',
                    content: 'Make sure to choose age-appropriate toys for your baby. Avoid toys with small parts that can be a choking hazard.',
                    heroImage: '{{ asset("img/safe-toys.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                }
            };

            if (topics[topicId]) {
                const topic = topics[topicId];
                const favourites = JSON.parse(localStorage.getItem('favourites')) || [];
                const isFavourite = favourites.includes(topicId);

                modalTitle.innerHTML = topic.title;
                if(topic.html){
                    modalBody.innerHTML = topic.html;
                }
                else{
                modalBody.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; flex-direction: column; flex: 1;">
                            <h3 style="color: #1976d2; margin: 0;">${topic.title}</h3>
                            <a style="color: #1976d2; margin: 0; font-size: 12px;">
                            <br> Reviewed By: <br> Dr Aiman Khalid <br> Consultant Pediatrician at Selangor Specialist Hospital
                            </a>
                        </div>
                        <button id="favouriteButton" class="btn btn-primary" style="margin-left: 20px;">
                            ${isFavourite ? 'Remove from Favourites' : 'Add to Favourites'}
                        </button>
                    </div>
                    <p><br>${topic.content}</p>
                    ${topic.additionalText ? `
                        <div style="margin: 0 auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            </br> ${topic.additionalText}
                        </div>` : ''}
                    ${topic.heroImage ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center;">
                            <img src="${topic.heroImage}" alt="${topic.title}" style="width:100%; border-radius:10px;">
                        </div>` : ''}
                    ${topic.videoUrl ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center;">
                            <iframe width="100%" height="315" src="${topic.videoUrl}" frameborder="0" allowfullscreen style="border-radius:10px;"></iframe>
                        </div>` : ''}
                    ${topic.title2 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title2}</h3>` : ''}
                    ${topic.additionalText2 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            ${topic.additionalText2}
                        </div>` : ''}
                    ${topic.title3 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title3}</h3>` : ''}
                    ${topic.additionalText3 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            ${topic.additionalText3}
                        </div>` : ''}
                    ${topic.title4 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title4}</h3>` : ''}
                    ${topic.additionalText4 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: justify; line-height: 1.6; color: #555;">
                            ${topic.additionalText4}
                        </div>` : ''}
                    ${topic.title5 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title5}</h3>` : ''}
                    ${topic.additionalText5 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            ${topic.additionalText5}
                        </div>` : ''}
                `;
                }

                // Show the modal
                let tipModal = new bootstrap.Modal(document.getElementById('tipInfoModal'));
                tipModal.show();

                // Add event listener for the favourite button (uses server-side favorites)
                setTimeout(() => {
                    const favouriteButton = document.getElementById('favouriteButton');
                    if (favouriteButton) {
                        // Initialize button state by checking backend
                        favouriteButton.dataset.favoriteId = '';
                        fetch(`/check-favorite/${topicId}`, {
                            headers: { 'Accept': 'application/json' }
                        }).then(r => r.json()).then(data => {
                            if (data.success && data.isFavorite) {
                                favouriteButton.textContent = 'Remove from Favourites';
                                favouriteButton.dataset.favoriteId = data.favoriteId || '';
                            } else {
                                favouriteButton.textContent = 'Add to Favourites';
                                favouriteButton.dataset.favoriteId = '';
                            }
                        }).catch(() => {
                            favouriteButton.textContent = 'Add to Favourites';
                        });

                        favouriteButton.addEventListener('click', function () {
                            const favId = this.dataset.favoriteId;
                            if (!favId) {
                                // Save favorite
                                fetch('/save-favorite-tip', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        tip_id: topicId,
                                        title: topic.title || topicId,
                                        content: topic.content || '',
                                        category: topic.category || 'General',
                                        rich_content: topic.content, // Full content with formatting
                                        image_url: topic.heroImage || '',
                                        video_url: topic.videoUrl || '',
                                    })
                                }).then(r => r.json()).then(resp => {
                                    if (resp.success) {
                                        this.textContent = 'Remove from Favourites';
                                        this.dataset.favoriteId = resp.data.id || '';
                                    } else {
                                        alert(resp.message || 'Error saving favorite');
                                    }
                                }).catch(() => alert('Error saving favorite'));
                            } else {
                                // Remove favorite
                                fetch(`/favorite-tip/${favId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                }).then(r => r.json()).then(resp => {
                                    if (resp.success) {
                                        this.textContent = 'Add to Favourites';
                                        this.dataset.favoriteId = '';
                                    } else {
                                        alert(resp.message || 'Error removing favorite');
                                    }
                                }).catch(() => alert('Error removing favorite'));
                            }
                        });
                    }
                }, 100);
            }
        }

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
