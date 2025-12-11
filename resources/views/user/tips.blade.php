<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Tips</title>
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
            background-color: white !important;
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

        /* Font size adjustment */
        body.font-large * {
            font-size: 1.15rem !important;
        }
        body.font-xlarge * {
            font-size: 1.3rem !important;
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
                            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
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
                /* ---------------------------------------------------------
                B O N D I N G   T I P S
                --------------------------------------------------------- */
                bonding1: {
                    title: 'Skin-to-Skin Cuddles',
                    content: 'Explore the science and tradition behind skin-to-skin cuddles — a beautiful first step in bonding that supports your baby’s health, emotional well-being and development from the very first hours of life.',
                    additionalText: 'Skin-to-skin contact also helps regulate your baby’s temperature, heart rate, and breathing. It promotes bonding and can even help with breastfeeding success.',
                    heroImage: '{{ asset("img/skintoskin2.jpeg") }}',
                    videoUrl: 'https://www.youtube.com/embed/VOjGhwMuWFU?si=EEowDG50bdKRLGHo',
                    title2: '</br>What Is Skin-to-Skin Contact?',
                    additionalText2: 'Skin-to-skin contact, also known as kangaroo care, is when a newborn is placed directly against the bare chest of a parent. This natural method helps babies feel safe, warm, and calm.',
                    title3: '</br>Why It Matters for Malaysian Parents',
                    additionalText3: 'The Malaysian Child Health Record Book encourages early contact, closeness, and exclusive breastfeeding, all of which are supported by skin-to-skin cuddles.',
                    title4: '</br>Benefits of Skin-to-Skin Cuddles',
                    additionalText4: '- Regulates temperature and heartbeat<br/>- Encourages better breastfeeding<br/>- Reduces crying and stress<br/>- Supports weight gain and immune health<br/>- Strengthens bonding and early development',
                    title5: '</br>Expert Tip From Malaysian Healthcare',
                    additionalText5: '“Just a few minutes of skin-to-skin daily can give your newborn emotional security and help parents feel more connected.” </br> — Nurse Supervisor, Klinik Kesihatan'
                },

                bonding2: {
                    title: 'Gentle Baby Massage',
                    content: 'Baby massage is a calming bonding practice that helps babies feel secure, improves circulation, and reduces fussiness.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Regular massage can improve sleep quality and strengthen the emotional bond between parent and baby.',
                    title2: '</br>What Is Baby Massage?',
                    additionalText2: 'Baby massage uses gentle strokes on your baby’s arms, legs, tummy, and back. Parents commonly practice it after bath time when the baby is calm.',
                    title3: '</br>Why Malaysian Parents Love This Tip',
                    additionalText3: 'Many Malaysian families already practice “urut bayi,” a traditional form of baby massage. Modern research supports its benefits in reducing colic and promoting relaxation.',
                    title4: '</br>Benefits of Baby Massage',
                    additionalText4: '- Improves digestion and reduces gas<br/>- Promotes longer, deeper sleep<br/>- Reduces crying and fussiness<br/>- Helps your baby learn body awareness<br/>- Builds trust and bonding',
                    title5: '</br>Expert Tip',
                    additionalText5: 'Use natural, baby-safe oils and watch your baby’s cues. If they turn away or cry, try again later.'
                },

                    bonding3: {
                        title: 'Talk & Sing to Baby',
                        content: 'Your voice is your baby’s favourite sound. Talking and singing help build language skills and emotional bonding from day one.',
                        heroImage: '{{ asset("img/placeholder.jpg") }}',
                        videoUrl: 'https://www.youtube.com/embed/example-video-id',
                        additionalText: 'Simple words, lullabies, and playful tones help your baby feel connected and loved.',

                        title2: '</br>What Does Talking & Singing Do?',
                        additionalText2: 'It stimulates baby’s brain development, supports early communication, and strengthens your relationship.',

                        title3: '</br>Malaysian Context',
                        additionalText3: 'Using Malay, English, Tamil, Mandarin, or any home language boosts bilingual readiness and cultural bonding.',

                        title4: '</br>Benefits',
                        additionalText4: '- Boosts early language development<br/>- Helps your baby feel calm and secure<br/>- Strengthens memory and attention<br/>- Supports emotional connection',

                        title5: '</br>Expert Tip',
                        additionalText5: 'Use a gentle, exaggerated tone (“parentese”). Babies respond best to expressive voices.'
                    },

                    bonding4: {
                        title: 'Tummy Time Play',
                        content: 'Tummy time helps your baby strengthen neck, shoulder, and upper body muscles needed for crawling and sitting.',
                        heroImage: '{{ asset("img/placeholder.jpg") }}',
                        videoUrl: 'https://www.youtube.com/embed/example-video-id',
                        additionalText: 'Start with a few minutes a day and increase gradually.',

                        title2: '</br>What Is Tummy Time?',
                        additionalText2: 'It is supervised time when your baby lies on their tummy while awake.',

                        title3: '</br>Why It Matters',
                        additionalText3: 'The Malaysian Child Health Record Book highlights tummy time as an essential motor development activity.',

                        title4: '</br>Benefits',
                        additionalText4: '- Prevents flat head syndrome<br/>- Strengthens muscles<br/>- Builds coordination<br/>- Prepares baby for crawling',

                        title5: '</br>Expert Tip',
                        additionalText5: 'Place toys or your face at eye level to encourage your baby to lift their head.'
                    },

                    bonding5: {
                        title: 'Help Baby Learn Language',
                        content: 'Babies learn language long before they speak. Early exposure shapes how they understand and communicate.',
                        heroImage: '{{ asset("img/placeholder.jpg") }}',
                        videoUrl: 'https://www.youtube.com/embed/example-video-id',
                        additionalText: 'Reading, talking, and singing build strong language foundations.',

                        title2: '</br>How Babies Learn Language',
                        additionalText2: 'They absorb sounds, rhythms, and expressions from the people around them.',

                        title3: '</br>Why Malaysian Babies Benefit',
                        additionalText3: 'Multilingual environments (BM, English, Mandarin, Tamil) strengthen brain flexibility.',

                        title4: '</br>Benefits',
                        additionalText4: '- Builds vocabulary early<br/>- Improves attention and listening<br/>- Supports emotional bonding<br/>- Encourages confidence when speaking later',

                        title5: '</br>Expert Tip',
                        additionalText5: 'Read picture books daily—even newborns benefit.'
                    },

                    bonding6: {
                        title: 'How to Build Trust with Your Baby',
                        content: 'Trust forms when babies know their parents will respond to their needs with love and consistency.',
                        heroImage: '{{ asset("img/placeholder.jpg") }}',
                        videoUrl: 'https://www.youtube.com/embed/example-video-id',
                        additionalText: 'A secure attachment leads to confident, emotionally healthy children.',

                        title2: '</br>How Babies Build Trust',
                        additionalText2: 'Responding to cries, cuddling, and comforting teaches your baby that the world is safe.',

                        title3: '</br>Why Malaysian Parents Should Know This',
                        additionalText3: 'Healthy parent-child attachment is highlighted in local child development guidelines.',

                        title4: '</br>Trust-Building Behaviours',
                        additionalText4: '- Respond to cries<br/>- Give cuddles freely<br/>- Maintain routines<br/>- Talk gently and consistently',

                        title5: '</br>Expert Tip',
                        additionalText5: 'You don’t have to be perfect — just consistent and loving.'
                    },


                /* ---------------------------------------------------------
                S E N S O R Y   T I P S
                --------------------------------------------------------- */
                sensory1: {
                    title: 'Eye Contact & Smiles',
                    content: 'From the very first gaze to their very first smile — learn how your baby uses these interactions to bond and grow.',
                    heroImage: '{{ asset("img/eye-contact.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Eye contact helps babies recognise faces and communicate.',
                    title2: 'What Is Eye Contact and Smiling?',
                    additionalText2: 'These are early social skills that show your baby is learning to connect.',
                    additionalText3: 'Malaysia’s Child Health Record Book includes eye contact and smiling as early developmental milestones.'
                },

                sensory2: {
                    title: 'Respond to Sounds',
                    content: 'Your baby is learning to recognise voices and everyday sounds.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Responding to your baby’s sounds helps them learn communication.',
                    title2: '</br>How Babies Learn Through Sound',
                    additionalText2: 'Babies notice tones, rhythms, and voices long before they talk.',
                    title3: '</br>Benefits',
                    additionalText3: '- Improves listening<br/>- Builds speech foundations<br/>- Helps emotional bonding',
                    title4: '</br>Expert Tip',
                    additionalText4: 'Talk back when your baby coos—this teaches turn-taking.'
                },

                sensory3: {
                    title: 'Touch & Texture Play',
                    content: 'Different textures help stimulate your baby’s senses and curiosity.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Soft cloths, toys, and safe objects help with sensory learning.',
                    title2: '</br>What Is Texture Play?',
                    additionalText2: 'Babies use their hands to learn about the world.',
                    title3: '</br>Benefits',
                    additionalText3: '- Enhances sensory development<br/>- Builds motor skills<br/>- Encourages exploration',
                    title4: '</br>Expert Tip',
                    additionalText4: 'Always supervise texture play to ensure safety.'
                },

                sensory4: {
                    title: 'Watch for Jaundice',
                    content: 'Jaundice is common in newborns. Early monitoring helps ensure safe recovery.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Look for yellowing of eyes and skin, especially in the first week.',
                    title2: '</br>What Is Jaundice?',
                    additionalText2: 'It happens when bilirubin levels rise. Most cases are mild and resolve naturally.',
                    title3: '</br>When to Seek Help',
                    additionalText3: '- Baby looks more yellow<br/>- Poor feeding<br/>- Excessive sleepiness',
                    title4: '</br>Expert Tip',
                    additionalText4: 'Refer to Klinik Kesihatan quickly if symptoms worsen.'
                },

                sensory5: {
                    title: 'The "Balance" Sense',
                    content: 'Your baby’s balance develops through movement and body control.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Rocking, carrying, and gentle motion stimulate your baby’s balance system.',
                    title2: '</br>How Babies Develop Balance',
                    additionalText2: 'The inner ear and muscles learn coordination through movement.',
                    title3: '</br>Benefits',
                    additionalText3: '- Better motor skills<br/>- Earlier sitting and crawling<br/>- Improved body awareness'
                },

                sensory6: {
                    title: 'How to Stimulate Baby\'s Vision',
                    content: 'Your baby’s vision is developing rapidly in the first months.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'High-contrast shapes and faces help babies learn to focus.',
                    title2: '</br>How Vision Develops',
                    additionalText2: 'Newborns see shapes and light — clarity improves over time.',
                    title3: '</br>Tips',
                    additionalText3: '- Use black-and-white toys<br/>- Hold your face close<br/>- Move objects slowly for tracking practice'
                },

                /* ---------------------------------------------------------
                S L E E P   T I P S
                --------------------------------------------------------- */
                sleep1: {
                    title: 'How Much Sleep Does Baby Need?',
                    content: 'Newborns need 14–17 hours of sleep per day, including naps.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Sleep supports brain growth and emotional health.',
                    title2: '</br>Sleep Patterns',
                    additionalText2: 'Babies sleep in short cycles and wake often for feeding.',
                    title3: '</br>Tips',
                    additionalText3: '- Follow hunger cues<br/>- Create calm sleep surroundings'
                },

                sleep2: {
                    title: 'Creating a Bedtime Routine',
                    content: 'A consistent bedtime routine helps your baby recognize sleep time.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Routines give babies emotional security.',
                    title2: '</br>Examples',
                    additionalText2: 'Bathing, gentle massage, book reading, soft music.',
                    title3: '</br>Benefits',
                    additionalText3: '- Improves sleep quality<br/>- Reduces night fussiness'
                },

                sleep3: {
                    title: 'Back is Best',
                    content: 'Always place your baby on their back to reduce the risk of SIDS.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Safe sleep guidelines are emphasised in Malaysia’s health system.',
                    title2: '</br>Why Back-Sleeping?',
                    additionalText2: 'It ensures the airway stays open and reduces breathing risks.',
                    title3: '</br>Safety Tips',
                    additionalText3: '- Firm mattress<br/>- No pillows or toys<br/>- No bed-sharing'
                },

                sleep4: {
                    title: 'Avoid Baby Walkers',
                    content: 'Baby walkers are unsafe and delay walking skills.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Malaysia’s Ministry of Health discourages walker use.',
                    title2: '</br>Why Avoid Walkers?',
                    additionalText2: 'They increase fall risk and interfere with natural development.',
                    title3: '</br>Healthy Alternatives',
                    additionalText3: '- Floor play<br/>- Push toys (supervised)<br/>- Tummy time'
                },

                sleep5: {
                    title: 'Create Calm Nights',
                    content: 'Calm, quiet environments help babies sleep better.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Reduce noise and dim lights before sleep.',
                    title2: '</br>Benefits',
                    additionalText2: 'Your baby learns to settle quickly and sleep longer.'
                },

                /* ---------------------------------------------------------
                F E E D I N G   T I P S
                --------------------------------------------------------- */
                feeding1: {
                    title: 'Breastfeeding Basics',
                    content: 'Breastmilk provides perfect nutrition for newborns.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Breastfeeding also strengthens immunity and bonding.',
                    title2: '</br>Tips',
                    additionalText2: 'Correct latch, frequent feeding, and supportive positioning.'
                },

                feeding2: {
                    title: 'Exclusive Breastfeeding (0–6 Months)',
                    content: 'Babies should receive only breastmilk for the first six months.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'No water, juices, or solids are needed.',
                    title2: '</br>Benefits',
                    additionalText2: 'Stronger immunity, healthy weight gain, better bonding.'
                },

                feeding3: {
                    title: 'Feed on Demand',
                    content: 'Feed whenever your baby shows hunger cues.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Cues include rooting, sucking, and fussing.',
                    title2: '</br>Benefits',
                    additionalText2: 'Improves milk supply and keeps baby satisfied.'
                },

                feeding4: {
                    title: 'Start Solids at 6 Months',
                    content: 'Introduce solid foods around 6 months of age.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Start with iron-rich foods and simple purees.',
                    title2: '</br>Tips',
                    additionalText2: 'Introduce one food at a time and watch for allergies.'
                },

                feeding5: {
                    title: 'No Sugar, No Honey',
                    content: 'Avoid giving sugar and honey to babies under 12 months.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Honey can cause infant botulism; sugar harms early teeth.',
                    title2: '</br>What To Give Instead',
                    additionalText2: 'Natural fruits, breastmilk, and age-appropriate solids.'
                },

                /* ---------------------------------------------------------
                S A F E T Y   T I P S
                --------------------------------------------------------- */
                safety1: {
                    title: 'Wash Hands Often',
                    content: 'Handwashing prevents the spread of germs and protects your newborn.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Always wash before feeding, changing, or handling your baby.',
                    title2: '</br>Why It Matters',
                    additionalText2: 'Newborns have weak immune systems and need protection.'
                },

                safety2: {
                    title: 'Bathe with Care',
                    content: 'Use gentle products and check water temperature carefully.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Support your baby’s head and never leave them unattended.',
                    title2: '</br>Tips',
                    additionalText2: 'Test water with your wrist and use mild soap.'
                },

                safety3: {
                    title: 'No Baby Alone',
                    content: 'Never leave your baby alone on beds, sofas, or changing tables.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Falls can happen within seconds.',
                    title2: '</br>Safe Habits',
                    additionalText2: 'Keep one hand on baby, use safe spaces like playpens.'
                },

                safety4: {
                    title: 'Choose Safe Toys',
                    content: 'Select age-appropriate toys with no small, detachable parts.',
                    heroImage: '{{ asset("img/placeholder.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id',
                    additionalText: 'Check labels and avoid choking hazards.',
                    title2: '</br>Tips',
                    additionalText2: 'Soft, large toys are safest for newborns.'
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

        // --- Font Size Logic ---
        const fontStorageKey = 'userFontSize';
        const body = document.body;

        function applyFontSize(size) {
            // Reset all font classes
            body.classList.remove('font-large', 'font-xlarge');

            if (size === 'large') {
                body.classList.add('font-large');
            } else if (size === 'xlarge') {
                body.classList.add('font-xlarge');
            }
            // 'normal' = no class
        }

        // Load saved font size preference on page load
        const savedSize = localStorage.getItem(fontStorageKey);
        if (savedSize) {
            applyFontSize(savedSize);
        }
    </script>
</body>
</html>
