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
            top: -4px;
            right: -6px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        /* Bigger bell icon for the redesigned notification */
        .notification-btn i {
            font-size: 22px; /* increase bell size */
            color: #555;
        }

        /* Notification Popup Styles — redesigned */
        .notification-popup {
            position: absolute;
            top: 44px;
            right: 0;
            width: 560px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(20,30,60,0.12);
            z-index: 1001;
            padding: 12px;
            overflow: hidden;
        }

        .notification-popup .popup-header {
            padding: 8px 12px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            border-bottom: 1px solid #f1f5f9;
        }

        .notification-popup .popup-header h4 {
            margin:0;
            font-size:18px;
            color:#0f172a;
        }

        .notification-list {
            list-style: none;
            margin: 0;
            padding: 8px 4px;
            max-height: 420px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px;
            border-radius: 10px;
            background: transparent;
            transition: background .12s, transform .06s;
            cursor: pointer;
            position: relative;
        }

        .notification-item:hover {
            background: #fbfdff;
            transform: translateY(-2px);
        }

        .notification-item.tint {
            background: #f1fbff; /* subtle tint */
        }

        .notification-item + .notification-item {
            margin-top: 6px;
        }

        .notif-avatar {
            width:44px;
            height:44px;
            border-radius:50%;
            overflow:hidden;
            flex: 0 0 44px;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(16,24,40,0.08);
        }

        .notif-avatar img{ width:100%; height:100%; object-fit:cover; }

        .notif-body { flex:1; min-width:0 }

        .notif-title { font-weight:700; color:#0f172a; margin-bottom:4px; font-size:14px }
        .notif-message { color:#475569; font-size:13px; margin-bottom:8px; max-height:36px; overflow:hidden; text-overflow:ellipsis }

        .notif-meta { color:#94a3b8; font-size:12px; display:flex; gap:8px; align-items:center }

        /* Dot cue for unread */
        .notif-dot {
            width:10px;
            height:10px;
            border-radius:50%;
            background:#06b6d4;
            position:absolute;
            left:8px;
            top:18px;
            box-shadow: 0 0 0 4px rgba(6,182,212,0.06);
        }

        .no-notification { padding: 18px; text-align:center; color:#64748b }

        /* scrollbar styling */
        .notification-list::-webkit-scrollbar{ width:8px }
        .notification-list::-webkit-scrollbar-thumb{ background:#e2e8f0; border-radius:8px }

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
                <!-- Notification Icon (redesigned) -->
                <div class="notification-wrapper" style="position: relative;">
                    <button id="notificationBell" class="notification-btn" aria-expanded="false" style="background:none;border:none;padding:6px 8px;cursor:pointer;color:inherit;">
                        <i class="fas fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </button>

                    <div id="notificationPopup" class="notification-popup" style="display: none;">
                        <div class="popup-header">
                            <h4>Notifications</h4>
                            <button id="markAllRead" class="btn btn-sm" style="background:none;border:none;color:#64748b;font-size:13px;padding:6px;">Mark all read</button>
                        </div>

                        <ul class="notification-list">
                            @forelse($userNotifications as $notif)
                                <li class="notification-item {{ $notif->status == 'unread' ? 'tint' : '' }}" data-id="{{ $notif->notification_id }}">
                                    <div class="notif-avatar">
                                        <img src="{{ $notif->avatar ?? asset('storage/baby-photos/tinytrack-logo.png') }}" alt="avatar">
                                    </div>

                                    <div class="notif-body">
                                        <div class="notif-title">{{ $notif->title }}</div>
                                        <div class="notif-message">{{ \Illuminate\Support\Str::limit($notif->message, 120) }}</div>
                                        <div class="notif-meta">
                                            <span>{{ $notif->category ?? '' }}</span>
                                            @if(!empty($notif->category))<span>•</span>@endif
                                            <span>{{ $notif->dateSent }}</span>
                                        </div>
                                    </div>

                                    @if($notif->status == 'unread')
                                        <div class="notif-dot" aria-hidden="true"></div>
                                    @endif
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
                            <li>
                                <button onclick="showInfo('safety5')">
                                    <i class="fa-solid fa-hospital" style="margin-right:8px; color: #1976d2;"></i>
                                    Premature babies
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
                    name: "Dr Kenneth Looi Chia Chuin",
                    role: "Pediatrician, Columbia Asia Hospital Cheras",
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
                    name: 'Dr Kenneth Looi Chia Chuin',
                    role: 'Pediatrician, Columbia Asia Hospital Cheras',
                    title: 'Gentle Baby Massage',
                    content: 'Baby massage is a calming bonding practice that helps babies feel secure, improves circulation, and reduces fussiness.',
                    videoUrl: 'https://www.youtube.com/embed/WgGdAoaiDR0?si=anGlghXX3Kge1k14',
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
                name: "Dr Kenneth Looi Chia Chuin",
                role: "Pediatrician, Columbia Asia Hospital Cheras",
                title: "Talk & Sing to Baby",
                content: "Your voice is your baby’s favourite sound. Talking and singing help build language skills and emotional bonding from day one.",
                heroImage: '{{ asset("img/talksingbaby.jpeg") }}',
                videoUrl: "https://www.youtube.com/embed/6OUGNgTZATw?si=fPDsSOalcD0UhsvE",
                additionalText: "Simple words, lullabies, and playful tones help your baby feel connected and loved.",

                title2: "</br>What Does Talking & Singing Do?",
                additionalText2: "It stimulates baby’s brain development, supports early communication, and strengthens your relationship.",

                title3: "</br>Why It Matters for Malaysian Parents",
                additionalText3: "Using Malay, English, Tamil, Mandarin, or any home language boosts bilingual readiness and cultural bonding.",

                title4: "</br>Benefits of Talking & Singing",
                additionalText4: "- Boosts early language development<br/>- Helps your baby feel calm and secure<br/>- Strengthens memory and attention<br/>- Supports emotional connection",

                title5: "</br>Expert Tip From Malaysian Healthcare",
                additionalText5: "“Parents who sing and talk daily help babies feel safe and loved, while laying strong language foundations.” </br> — Speech Therapist, Hospital Kuala Lumpur"
            },

            bonding4: {
                name: "Dr Kenneth Looi Chia Chuin",
                role: "Pediatrician, Columbia Asia Hospital Cheras",
                title: "Tummy Time Play",
                content: "Tummy time helps your baby strengthen neck, shoulder, and upper body muscles needed for crawling and sitting.",
                heroImage: '{{ asset("img/tummytime.jpeg") }}',
                videoUrl: "https://www.youtube.com/embed/UEnzqSK-j_s?si=yDar3X81datd2C28",
                additionalText: "Start with a few minutes a day and increase gradually.",

                title2: "</br>What Is Tummy Time?",
                additionalText2: "It is supervised time when your baby lies on their tummy while awake.",

                title3: "</br>Why It Matters for Malaysian Parents",
                additionalText3: "The Malaysian Child Health Record Book highlights tummy time as an essential motor development activity.",

                title4: "</br>Benefits of Tummy Time",
                additionalText4: "- Prevents flat head syndrome<br/>- Strengthens muscles<br/>- Builds coordination<br/>- Prepares baby for crawling",

                title5: "</br>Expert Tip From Malaysian Healthcare",
                additionalText5: "“Place colourful toys or your face at eye level to encourage lifting and interaction.” </br> — Physiotherapist, KPJ Damansara Specialist Hospital"
            },

            bonding5: {
                name: "Dr Kenneth Looi Chia Chuin",
                role: "Pediatrician, Columbia Asia Hospital Cheras",
                title: "Help Baby Learn Language",
                content: "Babies learn language long before they speak. Early exposure shapes how they understand and communicate.",
                heroImage: '{{ asset("img/babylanguage.jpeg") }}',
                videoUrl: "https://www.youtube.com/embed/IexHdKm3Zpg?si=e8h2pJlC2WOap_9z",
                additionalText: "Reading, talking, and singing build strong language foundations.",

                title2: "</br>How Babies Learn Language",
                additionalText2: "They absorb sounds, rhythms, and expressions from the people around them.",

                title3: "</br>Why It Matters for Malaysian Parents",
                additionalText3: "Multilingual environments (BM, English, Mandarin, Tamil) strengthen brain flexibility and cultural identity.",

                title4: "</br>Benefits of Early Language Exposure",
                additionalText4: "- Builds vocabulary early<br/>- Improves attention and listening<br/>- Supports emotional bonding<br/>- Encourages confidence when speaking later",

                title5: "</br>Expert Tip From Malaysian Healthcare",
                additionalText5: "“Reading picture books daily—even newborns benefit. Parents who mix languages give babies a head start.” </br> — Early Childhood Educator, Universiti Malaya"
            },

            bonding6: {
                name: "Dr Kenneth Looi Chia Chuin",
                role: "Pediatrician, Columbia Asia Hospital Cheras",
                title: "How to Build Trust with Your Baby",
                content: "Trust forms when babies know their parents will respond to their needs with love and consistency.",
                heroImage: "{{ asset('img/buildtrust.jpeg') }}",
                videoUrl: "https://www.youtube.com/embed/AHMsmn6EX84?si=5vTek8lzKFKjM2PB",
                additionalText: "A secure attachment leads to confident, emotionally healthy children.",

                title2: "</br>How Babies Build Trust",
                additionalText2: "Responding to cries, cuddling, and comforting teaches your baby that the world is safe.",

                title3: "</br>Why Malaysian Parents Should Know This",
                additionalText3: "Healthy parent-child attachment is highlighted in local child development guidelines and the Malaysian Child Health Record Book.",

                title4: "</br>Trust-Building Behaviours",
                additionalText4: "- Respond to cries<br/>- Give cuddles freely<br/>- Maintain routines<br/>- Talk gently and consistently<br/>- Be present during feeding and play",

                title5: "</br>Expert Tip From Malaysian Healthcare",
                additionalText5: "“Consistency matters more than perfection. Babies thrive when parents are reliably loving and responsive.” </br> — Child Psychologist, Universiti Kebangsaan Malaysia"
            },



                /* ---------------------------------------------------------
                S E N S O R Y   T I P S
                --------------------------------------------------------- */
                sensory1: {
                    name: "Dr Anis Siham Binti Zainal Abidin",
                    role: "Pediatrician, Intensive Care at Sunway Medical Center",
                    title: "Eye Contact & Smiles",
                    content: "From the very first gaze to their very first smile — babies use these interactions to bond, learn, and grow. Eye contact and smiling are not just adorable moments; they are powerful developmental milestones that shape emotional security and social skills.",
                    heroImage: "{{asset('img/eyecontact.jpeg')}}",
                    additionalText: "Eye contact helps babies recognise faces, build trust, and communicate even before they can speak.",

                    title2: "</br>What Is Eye Contact and Smiling?",
                    additionalText2: "Eye contact is one of the earliest ways babies connect with caregivers. Smiling, which usually appears around 6–8 weeks, is a sign of social recognition and joy. Together, these behaviours show that your baby is learning to interact with the world.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Malaysia’s Child Health Record Book highlights eye contact and smiling as early developmental milestones. These behaviours reassure parents that their baby is progressing well and forming healthy emotional bonds.",

                    title4: "</br>Benefits of Eye Contact & Smiles",
                    additionalText4: "- Builds emotional connection and trust<br/>- Encourages social development<br/>- Helps babies recognise caregivers<br/>- Supports early communication and language learning<br/>- Boosts confidence in parents",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Respond to your baby’s smile with warmth and eye contact — it teaches them that the world is safe and loving.” </br> — Pediatric Nurse, Sunway Medical Center"
                },

                sensory2: {
                    name: "Dr Anis Siham Binti Zainal Abidin",
                    role: "Pediatrician, Intensive Care at Sunway Medical Center",
                    title: "Respond to Sounds",
                    content: "Your baby is learning to recognise voices, tones, and everyday sounds. Responding to these cues helps them feel heard and teaches the basics of communication. Every coo, giggle, or babble is a step toward language development.",
                    heroImage: "{{asset('img/respondtosound.jpeg')}}",
                    videoUrl: "https://www.youtube.com/embed/-hDwp-xqpPU?si=Hj2ryS4vtUCaPt-Z",
                    additionalText: "Responding to your baby’s sounds helps them learn communication and builds emotional security.",

                    title2: "</br>How Babies Learn Through Sound",
                    additionalText2: "Babies notice tones, rhythms, and voices long before they talk. By responding to their sounds, parents teach turn-taking, listening, and the joy of conversation.",

                    title3: "</br>Benefits of Sound Response",
                    additionalText3: "- Improves listening and attention<br/>- Builds speech foundations<br/>- Helps emotional bonding<br/>- Encourages curiosity and exploration",

                    title4: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText4: "“Talk back when your baby coos — this simple act teaches turn-taking and builds trust.” </br> — Speech Therapist, Hospital Kuala Lumpur"
                },

                sensory3: {
                    name: "Dr Anis Siham Binti Zainal Abidin",
                    role: "Pediatrician, Intensive Care at Sunway Medical Center",
                    title: "Touch & Texture Play",
                    content: "Different textures stimulate your baby’s senses and curiosity. From soft cloths to safe toys, touch-based play helps babies explore their environment and develop motor skills. It’s one of the earliest ways they learn about the world.",
                    heroImage: "https://images.pexels.com/photos/3933271/pexels-photo-3933271.jpeg",
                    videoUrl: "https://www.youtube.com/embed/mFqvxHAuX7k?si=nomh6IfNwdqNI8Qae",
                    additionalText: "Soft cloths, toys, and safe objects help with sensory learning and exploration.",

                    title2: "</br>What Is Texture Play?",
                    additionalText2: "Texture play involves letting babies feel different surfaces — smooth, rough, soft, or bumpy. This helps them build sensory awareness and body coordination.",

                    title3: "</br>Benefits of Texture Play",
                    additionalText3: "- Enhances sensory development<br/>- Builds motor skills<br/>- Encourages exploration and curiosity<br/>- Strengthens hand-eye coordination",

                    title4: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText4: "“Always supervise texture play to ensure safety and choose baby-safe materials. Everyday household items like scarves or wooden spoons can be great learning tools.” </br> — Occupational Therapist, KPJ Ampang Puteri"
                },

                sensory4: {
                    name: "Dr Anis Siham Binti Zainal Abidin",
                    role: "Pediatrician, Intensive Care at Sunway Medical Center",
                    title: "Watch for Jaundice",
                    content: "Jaundice is common in newborns and usually appears as yellowing of the skin and eyes. While most cases are mild and resolve naturally, monitoring is essential to ensure safe recovery.",
                    heroImage: "https://images.pexels.com/photos/3933272/pexels-photo-3933272.jpeg",
                    videoUrl: "https://www.youtube.com/embed/gODhFEH8nNQ?si=1baLX3Ttfv6ey8qT",
                    additionalText: "Look for yellowing of eyes and skin, especially in the first week of life.",

                    title2: "</br>What Is Jaundice?",
                    additionalText2: "Jaundice happens when bilirubin levels rise in the blood. Babies’ livers are still developing, so mild jaundice is common. However, severe cases require medical attention.",

                    title3: "</br>When to Seek Help",
                    additionalText3: "- Baby looks more yellow<br/>- Poor feeding or refusal to feed<br/>- Excessive sleepiness<br/>- Difficulty waking up",

                    title4: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText4: "“Refer to Klinik Kesihatan quickly if symptoms worsen — early treatment prevents complications and reassures parents.” </br> — Pediatrician, Hospital Serdang"
                },

                sensory5: {
                    name: "Dr Anis Siham Binti Zainal Abidin",
                    role: "Pediatrician, Intensive Care at Sunway Medical Center",
                    title: "The 'Balance' Sense",
                    content: "Your baby’s balance develops through movement and body control. Rocking, carrying, and gentle motion stimulate the inner ear and muscles, helping babies learn coordination and body awareness.",
                    heroImage: "https://images.pexels.com/photos/3933273/pexels-photo-3933273.jpeg",
                    videoUrl: "https://www.youtube.com/embed/uSp88t1igAo?si=TK7GkPx8ujNq7WjM",
                    additionalText: "Rocking, carrying, and gentle motion stimulate your baby’s balance system and confidence.",

                    title2: "</br>How Babies Develop Balance",
                    additionalText2: "The inner ear and muscles learn coordination through repeated movement. This prepares babies for sitting, crawling, and eventually walking.",

                    title3: "</br>Benefits of Balance Development",
                    additionalText3: "- Better motor skills<br/>- Earlier sitting and crawling<br/>- Improved body awareness<br/>- Stronger confidence in movement",

                    title4: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText4: "“Gentle rocking and tummy time help babies strengthen their balance system naturally. Parents can also carry babies in slings to encourage safe motion.” </br> — Physiotherapist, Hospital Kuala Lumpur"
                },

                sensory6: {
                    name: "Dr Anis Siham Binti Zainal Abidin",
                    role: "Pediatrician, Intensive Care at Sunway Medical Center",
                    title: "How to Stimulate Baby's Vision",
                    content: "Your baby’s vision is developing rapidly in the first months.",
                    heroImage: "https://images.pexels.com/photos/3933274/pexels-photo-3933274.jpeg",
                    videoUrl: "https://www.youtube.com/embed/U_BuQ_OYE78?si=Hyo92oJZYLY5T8Ty",
                    additionalText: "High-contrast shapes and faces help babies learn to focus.",

                    title2: "</br>How Vision Develops",
                    additionalText2: "Newborns see shapes and light — clarity improves over time.",

                    title3: "</br>Tips for Malaysian Parents",
                    additionalText3: "- Use black-and-white toys<br/>- Hold your face close<br/>- Move objects slowly for tracking practice",

                    title4: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText4: "“Babies love faces — spend time close to them so they learn to focus and bond.” </br> — Pediatric Optometrist, Universiti Malaya Medical Centre"
                },


                /* ---------------------------------------------------------
                S L E E P   T I P S
                --------------------------------------------------------- */
                sleep1: {
                    name: "Dr. Aruna Periasamy ",
                    role: "Consultant Pediatrician, at Columbia Asia r",
                    title: "How Much Sleep Does Baby Need?",
                    content: "Newborns need between 14–17 hours of sleep per day, including naps. Sleep is not just rest — it is essential for brain growth, emotional regulation, and physical development. Babies grow rapidly in the first months, and sleep provides the foundation for healthy milestones.",
                    heroImage: "https://images.pexels.com/photos/3875217/pexels-photo-3875217.jpeg",
                    videoUrl: "https://www.youtube.com/embed/PA3mD8JLFdQ?si=uMOET1TDOkGGF388",
                    additionalText: "Sleep supports brain growth, immune strength, and emotional health. Without enough rest, babies may become fussy and struggle with feeding.",

                    title2: "</br>Sleep Patterns",
                    additionalText2: "Babies sleep in short cycles of 2–4 hours and wake often for feeding. This is normal and helps them get the nutrition they need while their bodies grow.",

                    title3: "</br>Tips for Malaysian Parents",
                    additionalText3: "- Follow hunger cues instead of strict schedules<br/>- Create calm sleep surroundings with dim lights<br/>- Use lightweight cotton clothing suitable for Malaysia’s warm climate<br/>- Keep naps flexible but consistent"
                },

                sleep2: {
                    name: "Dr. Aruna Periasamy ",
                    role: "Consultant Pediatrician, at Columbia Asia ",
                    title: "Creating a Bedtime Routine",
                    content: "A consistent bedtime routine helps your baby recognise when it is time to sleep. Routines provide emotional security and signal to the baby’s brain that rest is coming. Over time, these habits reduce fussiness and improve sleep quality.",
                    heroImage: "https://images.pexels.com/photos/3875220/pexels-photo-3875220.jpeg",
                    videoUrl: "https://www.youtube.com/embed/aUZMirzJA2c?si=FoTA2dZuytAFxzzc",
                    additionalText: "Routines give babies emotional security and help parents feel more confident in managing sleep.",

                    title2: "</br>Examples of Bedtime Routines",
                    additionalText2: "Bathing, gentle massage, reading a short book, singing lullabies, or playing soft music. These activities calm the baby and prepare them for rest.",

                    title3: "</br>Benefits of Bedtime Routines",
                    additionalText3: "- Improves sleep quality<br/>- Reduces night fussiness<br/>- Builds emotional security<br/>- Helps parents bond with baby<br/>- Encourages healthy long-term sleep habits"
                },

                sleep3: {
                    name: "Dr. Aruna Periasamy ",
                    role: "Consultant Pediatrician, at Columbia Asia ",
                    title: "Back is Best",
                    content: "Always place your baby on their back to reduce the risk of Sudden Infant Death Syndrome (SIDS). This safe sleep practice is emphasised worldwide and supported by Malaysia’s health system. Back-sleeping ensures the airway stays open and reduces breathing risks.",
                    heroImage: "{{asset('img/backisbest.jpeg')}}",
                    additionalText: "Safe sleep guidelines are emphasised in Malaysia’s Child Health Record Book and Ministry of Health recommendations.",

                    title2: "</br>Why Back-Sleeping?",
                    additionalText2: "Back-sleeping keeps the airway clear, reduces suffocation risks, and is proven to lower SIDS cases worldwide.",

                    title3: "</br>Safety Tips",
                    additionalText3: "- Use a firm mattress<br/>- Avoid pillows, blankets, or toys in the crib<br/>- Do not bed-share<br/>- Keep baby’s sleep area cool and smoke-free"
                },

                sleep4: {
                    name: "Dr. Aruna Periasamy",
                    role: "Consultant Pediatrician, at Columbia Asia ",
                    title: "Avoid Baby Walkers",
                    content: "Baby walkers may look fun, but they are unsafe and can delay natural walking skills. Malaysia’s Ministry of Health discourages walker use because they increase fall risks and interfere with muscle development. Babies learn best through floor play and safe exploration.",
                    heroImage: "https://images.pexels.com/photos/3875222/pexels-photo-3875222.jpeg",
                    videoUrl: "https://www.youtube.com/embed/nG-8gvHamlQ?si=eb2wYD6zMLN3BTLG",
                    additionalText: "Walkers can give a false sense of mobility and lead to accidents. Natural play is safer and healthier.",

                    title2: "</br>Why Avoid Walkers?",
                    additionalText2: "They increase fall risk, cause injuries, and interfere with natural balance and coordination. Babies may skip crawling stages, which are important for brain development.",

                    title3: "</br>Healthy Alternatives",
                    additionalText3: "- Floor play with mats<br/>- Push toys (supervised)<br/>- Tummy time<br/>- Encouraging crawling and standing naturally"
                },

                sleep5: {
                    name: "Dr. Aruna Periasamy ",
                    role: "Consultant Pediatrician, at Columbia Asia ",
                    title: "Create Calm Nights",
                    content: "Calm, quiet environments help babies sleep better and longer. Reducing noise, dimming lights, and keeping routines consistent signal to your baby that it is time to rest. A peaceful environment also helps parents feel more relaxed.",
                    heroImage: "{{asset('img/calmnights.jpeg')}}",
                    videoUrl: "https://www.youtube.com/embed/ZMCk35lloBM?si=MquwFkk-j6RcZgNk",
                    additionalText: "Reduce noise, dim lights, and avoid overstimulation before sleep. Calm nights build healthy sleep habits.",

                    title2: "</br>Benefits of Calm Nights",
                    additionalText2: "Your baby learns to settle quickly, sleep longer, and wake up happier. Calm nights also reduce parental stress and create a more peaceful household."
                },


                /* ---------------------------------------------------------
                F E E D I N G   T I P S
                --------------------------------------------------------- */
                feeding1: {
                    name: "Lau Wai Hong (Celeste)",
                    role: "Assistant Director, Dietetics at Sunway Medical Center",
                    title: "Breastfeeding Basics",
                    content: "Breastmilk provides the perfect nutrition for newborns, containing the right balance of proteins, fats, vitamins, and minerals. It is uniquely tailored to your baby’s needs and changes as they grow. Beyond nutrition, breastfeeding is a powerful way to build emotional closeness and trust.",
                    heroImage: "{{asset('img/breastfeeding.jpeg')}}",
                    videoUrl: "https://www.youtube.com/embed/g_k50wOf564?si=FYh0IBhKTSBq_61X",
                    additionalText: "Breastfeeding strengthens immunity, supports healthy growth, and creates a strong emotional bond between mother and baby.",

                    title2: "</br>What Is Breastfeeding?",
                    additionalText2: "Breastfeeding is the natural way of feeding your baby, providing complete nutrition and antibodies that protect against illness.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Malaysia’s Ministry of Health strongly promotes breastfeeding through Baby-Friendly Hospital Initiatives and support at Klinik Kesihatan. It is encouraged as the gold standard for infant feeding.",

                    title4: "</br>Benefits of Breastfeeding",
                    additionalText4: "- Strengthens immunity<br/>- Supports healthy growth<br/>- Reduces risk of infections<br/>- Promotes bonding<br/>- Saves cost compared to formula",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Correct latch and frequent feeding are key. Seek help early if you face challenges.” </br> — Lactation Consultant, Sunway Medical Center"
                },

                feeding2: {
                    name: "Tan Jie Sin (Jessie)",
                    role: "Lead Dietitian at Sunway Medical Center",
                    title: "Exclusive Breastfeeding (0–6 Months)",
                    content: "Babies should receive only breastmilk for the first six months of life. Exclusive breastfeeding means no water, juices, or solids — breastmilk alone provides all the hydration and nutrients your baby needs. This practice is strongly recommended by the World Health Organization and Malaysia’s Ministry of Health.",
                    heroImage: "{{asset('img/exclusivebreastfeeding.jpeg')}}",
                    videoUrl: "https://www.youtube.com/embed/OlmKNCBCxrw?si=m77AOOUpp7c1BloL",
                    additionalText: "Exclusive breastfeeding ensures optimal growth, protects against infections, and reduces the risk of allergies.",

                    title2: "</br>What Is Exclusive Breastfeeding?",
                    additionalText2: "It means giving only breastmilk — no water, formula, or solids — for the first six months.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Exclusive breastfeeding is part of Malaysia’s National Breastfeeding Policy. It helps reduce infant mortality and supports long-term health.",

                    title4: "</br>Benefits of Exclusive Breastfeeding",
                    additionalText4: "- Stronger immunity<br/>- Healthy weight gain<br/>- Better bonding<br/>- Reduced risk of diarrhoea and respiratory infections<br/>- Lower chances of obesity later in life",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Breastmilk alone is enough — even in hot climates, babies don’t need extra water.” </br> — Dietitian, Hospital Kuala Lumpur"
                },

                feeding3: {
                    name: "Tan Jie Sin (Jessie)",
                    role: "Lead Dietitian at Sunway Medical Center",
                    title: "Feed on Demand",
                    content: "Feeding on demand means responding to your baby’s hunger cues rather than following a strict schedule. Babies communicate hunger through rooting, sucking motions, fussing, or putting their hands to their mouth. This approach helps babies feel secure and ensures they get enough milk.",
                    heroImage: "{{asset('img/feeddemand.jpeg')}}",
                    additionalText: "Cues include rooting, sucking, fussing, and increased alertness. Crying is often a late hunger sign.",

                    title2: "</br>What Is Feeding on Demand?",
                    additionalText2: "It means watching your baby’s signals instead of the clock. Babies feed when they are hungry, not on a fixed schedule.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Feeding on demand is recommended in Malaysia’s Child Health Record Book. It helps mothers maintain milk supply and reduces stress.",

                    title4: "</br>Benefits of Feeding on Demand",
                    additionalText4: "- Improves milk supply<br/>- Keeps baby satisfied<br/>- Reduces fussiness<br/>- Builds trust and bonding<br/>- Supports healthy growth",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Watch for early hunger cues like rooting or sucking motions — don’t wait until baby cries.” </br> — Lactation Nurse, Klinik Kesihatan"
                },

                feeding4: {
                    name: "Tan Jie Sin (Jessie)",
                    role: "Lead Dietitian at Sunway Medical Center",
                    title: "Start Solids at 6 Months",
                    content: "Introduce solid foods around 6 months of age, when babies are developmentally ready. Start with iron-rich foods such as rice cereal, pureed meats, or lentils, followed by simple fruit and vegetable purees. Solids complement breastmilk or formula, which should remain the main source of nutrition until 12 months.",
                    heroImage: "{{asset('img/startsolid.jpeg')}}",
                    videoUrl: "https://www.youtube.com/embed/LAfn4s8Jcps?si=LUNPK9FbqD6ktMzi",
                    additionalText: "Start with iron-rich foods and simple purees. Avoid adding salt, sugar, or processed foods.",

                    title2: "</br>What Is Starting Solids?",
                    additionalText2: "It means introducing complementary foods while continuing breastfeeding. Babies should be able to sit with support and show interest in food.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "In Malaysia, parents often start with rice porridge (‘bubur nasi’) and mashed local fruits like banana or papaya. These foods are culturally familiar and nutritious.",

                    title4: "</br>Tips for Introducing Solids",
                    additionalText4: "- Introduce one food at a time<br/>- Watch for allergies<br/>- Begin with small amounts<br/>- Gradually increase texture and variety<br/>- Avoid salt, sugar, and processed foods",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Start with iron-rich foods like fortified cereals or pureed meats — they support healthy blood and growth.” </br> — Dietitian, Sunway Medical Center"
                },

                feeding5: {
                    name: "Lau Wai Hong (Celeste)",
                    role: "Assistant Director, Dietetics at Sunway Medical Center",
                    title: "No Sugar, No Honey",
                    content: "Avoid giving sugar and honey to babies under 12 months. Honey can cause infant botulism, a serious illness, while sugar harms early teeth and increases the risk of obesity. Babies do not need added sweeteners — their taste buds are still developing.",
                    heroImage: "{{asset('img/nosugarnohoney.jpeg')}}",
                    additionalText: "Honey can cause infant botulism; sugar harms early teeth and sets unhealthy eating habits.",

                    title2: "</br>Why Avoid Sugar and Honey?",
                    additionalText2: "Honey may contain spores that cause infant botulism, while sugar damages teeth and encourages unhealthy eating habits.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "In Malaysia, honey is sometimes given as a traditional remedy, but health experts strongly advise against it for babies under 12 months.",

                    title4: "</br>What To Give Instead",
                    additionalText4: "- Natural fruits like banana, papaya, or mango<br/>- Breastmilk<br/>- Age-appropriate solids like steamed sweet potato",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Avoid honey and sugar until after 12 months. Natural fruits are the safest way to introduce sweetness.” </br> — Pediatric Dietitian, Hospital Kuala Lumpur"
                },
                /* ---------------------------------------------------------
                S A F E T Y   T I P S
                --------------------------------------------------------- */
                safety1: {
                    name: "Dr Seri Suniza Sufian",
                    role: "Obstetrics & Gynaecology (O&G) at Prince Court Medical Center",
                    title: "Wash Hands Often",
                    content: "Handwashing prevents the spread of germs and protects your newborn. Babies have developing immune systems, making them more vulnerable to infections. Clean hands are the simplest and most effective way to keep your baby safe.",
                    heroImage: "https://images.pexels.com/photos/3875217/pexels-photo-3875217.jpeg",
                    videoUrl: "https://www.youtube.com/embed/example-video-id",
                    additionalText: "Always wash before feeding, changing, or handling your baby. Use soap and water for at least 20 seconds.",

                    title2: "</br>What Is Hand Hygiene?",
                    additionalText2: "It means washing hands with soap and water or using sanitizer before touching your baby.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Malaysia’s Ministry of Health highlights handwashing as a key step in preventing infections like diarrhoea and respiratory illness in infants.",

                    title4: "</br>Benefits of Handwashing",
                    additionalText4: "- Reduces risk of infections<br/>- Protects baby’s weak immune system<br/>- Prevents spread of germs<br/>- Builds safe habits for the whole family",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Wash hands before every feed and after diaper changes — it’s the simplest way to protect your baby.” </br> — Pediatric Nurse, Klinik Kesihatan"
                },

                safety2: {
                    name: "Dr K.Kumar Iswaran",
                    role: "Obstetrics & Gynaecology (O&G) at Prince Court Medical Center",
                    title: "Bathe with Care",
                    content: "Bathing is a special bonding time, but it must be done safely. Babies have delicate skin and sensitive bodies, so gentle products and careful handling are essential.",
                    heroImage: "https://images.pexels.com/photos/3933271/pexels-photo-3933271.jpeg",
                    videoUrl: "https://www.youtube.com/embed/example-video-id",
                    additionalText: "Support your baby’s head and never leave them unattended. Always prepare everything before starting the bath.",

                    title2: "</br>What Is Safe Bathing?",
                    additionalText2: "It means using mild, baby-safe soap, checking water temperature, and keeping your baby supported at all times.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Malaysia’s Child Health Record Book advises parents to bathe babies in lukewarm water and avoid harsh products.",

                    title4: "</br>Tips for Bathing Safely",
                    additionalText4: "- Test water with your wrist<br/>- Use mild soap<br/>- Keep one hand supporting baby’s head<br/>- Prepare towels and clothes before bath",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Never leave your baby alone in the bath, even for a few seconds.” </br> — Midwife, Hospital Serdang"
                },

                safety3: {
                    name: "Dr Maiza Tusimin",
                    role: "Obstetrics & Gynaecology (O&G) at Prince Court Medical Center",
                    title: "No Baby Alone",
                    content: "Never leave your baby alone on beds, sofas, or changing tables. Falls can happen within seconds, even if your baby hasn’t started rolling yet.",
                    heroImage: "https://images.pexels.com/photos/3933272/pexels-photo-3933272.jpeg",
                    videoUrl: "https://www.youtube.com/embed/example-video-id",
                    additionalText: "Always keep one hand on your baby and use safe spaces like playpens or cribs.",

                    title2: "</br>What Is Safe Supervision?",
                    additionalText2: "It means keeping your baby within sight and reach at all times, especially on elevated surfaces.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Accidental falls are one of the most common causes of infant injuries in Malaysia, according to Ministry of Health reports.",

                    title4: "</br>Safe Habits",
                    additionalText4: "- Keep one hand on baby<br/>- Use safe spaces like playpens<br/>- Avoid leaving baby on sofas or beds<br/>- Always supervise diaper changes",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Even newborns can wriggle unexpectedly — never assume they are safe alone.” </br> — Pediatrician, Hospital Kuala Lumpur"
                },

                safety4: {
                    name: "Dr. Ana Vetriana Abd Wahab",
                    role: "Obstetrics & Gynaecology (O&G), Reproductive Medicine, Fertility Care At Gleneagles Hospital Kota Kinabalu",
                    title: "Choose Safe Toys",
                    content: "Toys help babies learn and explore, but safety must come first. Age-appropriate toys with no small, detachable parts reduce choking risks and keep playtime safe.",
                    heroImage: "https://images.pexels.com/photos/3933273/pexels-photo-3933273.jpeg",
                    videoUrl: "https://www.youtube.com/embed/example-video-id",
                    additionalText: "Check labels and avoid choking hazards. Soft, large toys are safest for newborns.",

                    title2: "</br>What Are Safe Toys?",
                    additionalText2: "Safe toys are those designed for your baby’s age, made from non-toxic materials, and free from sharp edges or small parts.",

                    title3: "</br>Why It Matters for Malaysian Parents",
                    additionalText3: "Malaysia’s Consumer Protection guidelines advise parents to check toy labels and avoid items without safety certification.",

                    title4: "</br>Tips for Choosing Toys",
                    additionalText4: "- Choose soft, large toys<br/>- Avoid detachable small parts<br/>- Check safety labels<br/>- Wash toys regularly to keep them clean",

                    title5: "</br>Expert Tip From Malaysian Healthcare",
                    additionalText5: "“Always supervise playtime and inspect toys regularly for wear and tear.” </br> — Pediatric Occupational Therapist, KPJ Damansara Specialist Hospital"
                },

                safety5: {
                    name: "Dr Hasmawati Hassan",
                    role: "Consultant Paediatrician and Neonatologist at Sunway Medical Centre Velocity.",
                    title: "Premature babies: What do you need to know about it?",
                    content: "Premature babies are newborn babies born before 37 weeks. Every year, World Health Organization, estimated 15 million babies are born preterm. That is 1 in 10 babies. Worldwide, Preterm birth complications are the leading cause of death among children under 5 years of age whereby yearly 1 million preterm died.  Preterm births are rising around the world and more than 60% of preterm births occur in Africa and South Asia.<br><br>In Malaysia, about 12.3% deliveries are preterm birth which are about 500,000 preterm babies yearly. Malaysia National Neonatal Registry (data 2015) showed out of 280,764 livebirths, about 3060 (24.5%) are prematured (<32 weeks) and 3415 (27.3%) are less than 1500 g birthweight.<br> Premature, small, or sick babies account for nearly 80% neonatal deaths. They are at greater risk of long-term complications and death. They require specialized care by a highly skilled team of healthcare professionals. For these babies, it is not enough to just survive, we need them to thrive which means strengthening the healthcare system. (Stefan Peterson, Chief of Health for the United Nations Children’s Fund (UNICEF)<br><br>The cause of premature birth is unknown in about half of all cases. Sometimes labor starts on its own without warning. Even if you do everything right during pregnancy, you can still give birth early.",
                    heroImage: "{{asset('img/premature.jpeg')}}",
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
                            <br> Reviewed By: <br> ${topic.name} <br> ${topic.role}
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
