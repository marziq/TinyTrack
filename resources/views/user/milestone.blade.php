<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Milestones</title>
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

            .milestones-abilities-container {
                display: grid;
                grid-template-columns: 1fr; /* Stack sections vertically */
                gap: 30px; /* Space between the two sections */
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

        .progress-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
        }

        .progress-container {
            width: 80%; /* Adjust the width as needed */
            max-width: 800px; /* Limit the maximum width */
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .physical-section, .cognitive-section, .social-section {
            margin-bottom: 20px;
        }

        .physical-item, .cognitive-item, .social-item {
            padding: 10px;
            background-color: #e3f2fd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin: 20px;
        }

        .progress-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
            float: left;
        }

        .progress-image-top {
            width: 100%;
            height: 140px; /* fixed consistent height for all skill images */
            max-height: 140px;
            border-radius: 8px;
            margin: 0 auto 10px auto; /* Center the image and add spacing below */
            display: block;
            object-fit: cover;
            background-color: #f1f5f9; /* subtle background while image loads */
        }

        .dropdown-content {
            display: none;
            margin-top: 10px;
            text-align: center;
        }

        .dropdown-content img {
            display: block;
            margin: 0 auto;
        }

        .dropdown-content span {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .physical-item p, .cognitive-item p, .social-item p {
            cursor: pointer;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .physical-item p:hover, .cognitive-item p:hover, .social-item p:hover {
            color: #1976d2;
        }

        .physical-item .fa-chevron-down, .cognitive-item .fa-chevron-down, .social-item .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .progress-container {
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

        .sidebar a.active {
            background-color: #1976d2;
            color: #fff !important;
            font-weight: bold;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.18); /* stronger shadow for active */
            border: 2px solid #1976d2; /* darker outline for active */
        }
        .milestone-cards {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 20px 0;
        }
        .milestone-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border-radius: 8px;
            padding: 12px 18px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            font-size: 16px;
        }
        .milestone-check {
            background: #fff;
            border: 2px solid #19d276;
            color: #19d276;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }
        .milestone-check.completed, .milestone-check:active {
            background: #19d276;
            color: #fff;
        }
        .milestone-check i {
            pointer-events: none;
        }

        /* Skill Cards Styling */
        .skills-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .skills-section h3 {
            color: #333;
            margin-bottom: 16px;
            font-size: 18px;
            font-weight: 600;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 16px;
        }

        .skill-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            border: 1px solid #e9ecef;
            height: 100%;
        }

        .skill-card h4 {
            color: #1976d2;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .skill-card .progress {
            margin-bottom: 12px;
        }

        .skill-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .skill-items li {
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .skill-items li:last-child {
            border-bottom: none;
        }

        .skill-items li i {
            color: #19d276;
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
        .dark .baby-name{
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
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb" style="color: #FFD700;"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"  class="active"><i class="fa-solid fa-bullseye" style="color: red"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar" style="color: #16fc38"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot" style="color: orangered"></i> Chat With Sage</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog" style="color: #666"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">Milestone</h1>
            <div class="topbar-right">
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

        <!-- MAIN LAYOUT RESTRUCTURE: Four main card sections, selectors, and horizontal scroll for skill groups -->
        <div class="main-content">
            <div class="baby-header" style="justify-content: space-between; align-items: center; margin-bottom: 0;">
                <h2 class="baby-name" style="margin-bottom: 0;">Track <span id="selectedBabyNameHeading">Progress</span></h2>
                <select id="babySelector" class="baby-selector" onchange="onBabyChange(this.value)">
                    <option value="" disabled selected hidden>Select a baby</option>
                    @foreach(Auth::user()->babies as $baby)
                        <option value="{{ $baby->id }}" data-name="{{ $baby->name }}">{{ $baby->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card" style="max-width: 800px; margin: 0 auto 32px auto; padding: 32px 24px; border-radius: 18px; box-shadow: 0 4px 16px rgba(25,118,210,0.10);">
                <h3 style="color:#1976d2; font-weight:bold; margin-bottom: 18px;">Progress Overview</h3>
                <div id="progressContent">
                    <div style="text-align:center; color:#888; font-size:18px; padding:32px 0;">Who you wanna see progress?</div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 32px;">
                <!-- Month Range Selector -->
                <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 0;">
                    <label for="monthRange" style="font-weight:600; color:#1976d2;">Select month range:</label>
                    <select id="monthRange" class="baby-selector" style="width:auto; min-width:120px;" onchange="onMonthChange(this.value)">
                        <option value="0-3">0-3 months</option>
                        <option value="4-6">4-6 months</option>
                        <option value="7-9">7-9 months</option>
                        <option value="10-12">10-12 months</option>
                    </select>
                </div>
                <!-- PHYSICAL CARD -->
                <div class="card" style="padding: 24px 18px; border-radius: 14px; width: 100%;">
                    <h3 style="color:#FF69B4; font-weight:bold; margin-bottom: 18px;">Physical</h3>
                    <div class="skills-horizontal" id="physicalSkills" style="display: flex; gap: 30px; overflow-x: auto; padding-bottom: 8px; width: 100%; justify-content: center;">
                        <!-- Skill groups will be injected here -->
                    </div>
                </div>
                <!-- COGNITIVE CARD -->
                <div class="card" style="padding: 24px 18px; border-radius: 14px; width: 100%;">
                    <h3 style="color:#008000 !important; font-weight:bold; margin-bottom: 18px;">Cognitive</h3>
                    <div class="skills-horizontal" id="cognitiveSkills" style="display: flex; gap: 30px; overflow-x: auto; padding-bottom: 8px; width: 100%; justify-content: center;">
                        <!-- Skill groups will be injected here -->
                    </div>
                </div>
                <!-- SOCIAL CARD -->
                <div class="card" style="padding: 24px 18px; border-radius: 14px; width: 100%;">
                    <h3 style="color:#ad9201; font-weight:bold; margin-bottom: 18px;">Social</h3>
                    <div class="skills-horizontal" id="socialSkills" style="display: flex; gap: 30px; overflow-x: auto; padding-bottom: 8px; width: 100%; justify-content: center;">
                        <!-- Skill groups will be injected here -->
                    </div>
                </div>
            </div>
        </div>

        <script>
        // --- Dynamic milestone loading and persisting ---
        let selectedBaby = null;
        let selectedMonth = '0-3';

        document.getElementById('babySelector')?.addEventListener('change', function() {
            const babyId = this.value;
            selectedBaby = babyId;
            const babyName = this.options[this.selectedIndex].getAttribute('data-name');
            document.getElementById('selectedBabyNameHeading').textContent = `${babyName}'s Progress`;
            fetchMilestones(babyId);
        });

        document.getElementById('monthRange')?.addEventListener('change', function() {
            selectedMonth = this.value;
            // month filtering could be applied server-side later; for now re-render using same data
            if (selectedBaby) fetchMilestones(selectedBaby);
        });

        function fetchMilestones(babyId) {
            if (!babyId) return;
            const url = `/babies/${babyId}/milestones?range=${encodeURIComponent(selectedMonth)}`;
            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    renderProgressFromData(data);
                    renderCategoryFromData('physical', data.physical);
                    renderCategoryFromData('cognitive', data.cognitive);
                    renderCategoryFromData('social', data.social);
                }).catch(err => console.error(err));
        }

        function renderProgressFromData(data) {
            const progressDiv = document.getElementById('progressContent');
            if (!selectedBaby) {
                progressDiv.innerHTML = '<div style="text-align:center; color:#888; font-size:18px; padding:32px 0;">Who you wanna see progress?</div>';
                return;
            }
            const p = data.physical.percentage ?? 0;
            const c = data.cognitive.percentage ?? 0;
            const s = data.social.percentage ?? 0;

            progressDiv.innerHTML = `
                <div style="display:flex; flex-direction:column; gap:18px;">
                    ${renderProgressRow('Physical', 'fas fa-dumbbell', p, '#FFD8DF', '#FF69B4')}
                    ${renderProgressRow('Cognitive', 'fas fa-brain', c, '#A8DF8E', '#008000')}
                    ${renderProgressRow('Social', 'fas fa-users', s, '#D9C4B0', '#ad9201')}
                </div>
            `;
        }

        function renderProgressRow(title, iconClass, percent, color, textColor) {
            return `<div style="display:flex; align-items:center; gap:16px;">
                        <span style="font-size:2rem; color: ${color}; background:#e3f2fd; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center;"><i class="${iconClass}"></i></span>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-weight:bold; color:${textColor};">${title}</span>
                                <span style="font-size:15px; color:#1976d2; font-weight:600;">${percent}%</span>
                            </div>
                            <div class="progress" style="height: 14px; background:#e3f2fd;">
                                <div class="progress-bar" role="progressbar" style="width: ${percent}%; font-size: 12px; background-color: ${color};" aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>`;
        }

        function renderCategoryFromData(section, payload) {
            const container = document.getElementById(section + 'Skills');
            container.innerHTML = '';
            if (!selectedBaby) {
                container.innerHTML = '<div style="color:#aaa; font-size:16px; padding:32px 0;">Select a baby to see milestones.</div>';
                return;
            }
            // payload.groups is an array of group objects
            const colorMap = { physical: '#FF69B4', cognitive: '#008000', social: '#ad9201' };

            // helper to convert hex to rgba for light backgrounds/shadows
            function hexToRgba(hex, alpha) {
                const c = hex.replace('#','');
                const bigint = parseInt(c, 16);
                const r = (bigint >> 16) & 255;
                const g = (bigint >> 8) & 255;
                const b = bigint & 255;
                return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            }

            // base path for skill images (slug-based filenames)
            const skillsBase = "{{ asset('img/skills') }}";

            payload.groups.forEach(group => {
                const mainColor = colorMap[section] || '#1976d2';
                const lightBg = hexToRgba(mainColor, 0.10);
                const shadowColor = hexToRgba(mainColor, 0.10);

                const groupDiv = document.createElement('div');
                groupDiv.style.minWidth = '260px';
                groupDiv.style.background = lightBg; // follow category color (light)
                groupDiv.style.borderRadius = '10px';
                groupDiv.style.boxShadow = `0 2px 8px ${shadowColor}`;
                groupDiv.style.padding = '14px';
                groupDiv.style.display = 'flex';
                groupDiv.style.flexDirection = 'column';
                groupDiv.style.alignItems = 'flex-start';
                groupDiv.style.gap = '8px';
                groupDiv.style.width = '320px';

                const title = document.createElement('div');
                title.style.fontWeight = '700';
                title.style.color = mainColor; // use category color
                title.style.fontSize = '16px';
                title.textContent = group.groupTitle;
                groupDiv.appendChild(title);

                // Add optional group image immediately after the title so it appears above the stats
                const imgEl = document.createElement('img');
                imgEl.className = 'progress-image-top';
                imgEl.alt = group.groupTitle + ' image';
                imgEl.style.marginBottom = '8px';
                imgEl.style.width = '100%';
                imgEl.style.height = '140px';
                imgEl.style.objectFit = 'cover';
                // Use provided image fields if available; otherwise try PNG -> JPG -> SVG -> placeholder
                const pngPath = `${skillsBase}/${group.slug || group.id}.png`;
                const jpgPath = `${skillsBase}/${group.slug || group.id}.jpg`;
                const svgPath = `${skillsBase}/${group.slug || group.id}.svg`;
                const placeholderPath = `${skillsBase}/skill-placeholder.svg`;

                function setFallbacks(el) {
                    el.dataset.attempt = el.dataset.attempt || 'png';
                    el.onerror = function() {
                        if (this.dataset.attempt === 'png') {
                            this.dataset.attempt = 'jpg';
                            this.src = jpgPath;
                        } else if (this.dataset.attempt === 'jpg') {
                            this.dataset.attempt = 'svg';
                            this.src = svgPath;
                        } else if (this.dataset.attempt === 'svg') {
                            this.dataset.attempt = 'placeholder';
                            this.src = placeholderPath;
                        } else {
                            this.src = placeholderPath;
                        }
                    };
                }

                if (group.image || group.imageUrl) {
                    imgEl.src = group.image || group.imageUrl;
                    // if custom URL fails, fall back to slug images then placeholder
                    imgEl.dataset.attempt = 'custom';
                    imgEl.onerror = function() {
                        this.dataset.attempt = 'png';
                        this.src = pngPath;
                        setFallbacks(this);
                    };
                } else {
                    imgEl.src = pngPath;
                    setFallbacks(imgEl);
                }
                groupDiv.appendChild(imgEl);

                const sub = document.createElement('div');
                sub.style.display = 'flex';
                sub.style.justifyContent = 'space-between';
                sub.style.width = '100%';
                const stat = document.createElement('span');
                stat.style.fontSize = '13px';
                stat.style.color = mainColor; // use category color
                stat.textContent = `${group.achieved}/${group.total} completed`;
                const percent = document.createElement('span');
                percent.style.fontSize = '13px';
                percent.style.color = mainColor; // use category color
                percent.style.fontWeight = '600';
                percent.textContent = `${group.percentage}%`;
                sub.appendChild(stat);
                sub.appendChild(percent);
                groupDiv.appendChild(sub);

                // image relocated above; kept here intentionally empty for layout clarity

                const progWrap = document.createElement('div');
                progWrap.className = 'progress mb-2';
                progWrap.style.height = '10px';
                progWrap.style.background = '#fff';
                progWrap.style.width = '100%';
                const progBar = document.createElement('div');
                progBar.className = 'progress-bar';
                progBar.setAttribute('role','progressbar');
                progBar.style.width = `${group.percentage}%`;
                progBar.style.backgroundColor = mainColor; // color matches category main progress color
                progBar.style.height = '10px';
                progWrap.appendChild(progBar);
                groupDiv.appendChild(progWrap);

                const listWrap = document.createElement('div');
                listWrap.style.display = 'flex';
                listWrap.style.flexDirection = 'column';
                listWrap.style.gap = '8px';
                listWrap.style.width = '100%';

                group.items.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'milestone-card';
                    itemDiv.style.fontSize = '14px';
                    itemDiv.style.background = '#fff';
                    itemDiv.style.borderRadius = '8px';
                    itemDiv.style.padding = '10px';
                    itemDiv.style.display = 'flex';
                    itemDiv.style.alignItems = 'center';
                    itemDiv.style.justifyContent = 'space-between';

                    const left = document.createElement('div');
                    left.style.display = 'flex';
                    left.style.flexDirection = 'column';
                    left.style.gap = '4px';
                    const titleSpan = document.createElement('span');
                    titleSpan.textContent = item.title;
                    titleSpan.style.fontWeight = '600';
                    const dateSpan = document.createElement('small');
                    dateSpan.style.color = '#666';
                    dateSpan.textContent = item.achievedDate ? `Achieved: ${item.achievedDate}` : '';
                    left.appendChild(titleSpan);
                    left.appendChild(dateSpan);

                    const btn = document.createElement('button');
                    btn.className = 'milestone-check';
                    btn.style.marginLeft = '12px';
                    btn.setAttribute('data-id', item.id);
                    if (item.achieved) {
                        btn.classList.add('completed');
                    }
                    btn.innerHTML = `<i class="fas fa-check"></i>`;

                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const milestoneId = this.getAttribute('data-id');
                        const currently = this.classList.contains('completed');
                        const newState = !currently;
                        const payload = { achieved: newState };
                        if (newState) payload.achievedDate = new Date().toISOString().slice(0,10);

                        fetch(`/milestones/${milestoneId}/toggle`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        }).then(r => r.json()).then(resp => {
                            if (resp.achieved) {
                                btn.classList.add('completed');
                                dateSpan.textContent = `Achieved: ${resp.achievedDate}`;
                            } else {
                                btn.classList.remove('completed');
                                dateSpan.textContent = '';
                            }
                            if (selectedBaby) fetchMilestones(selectedBaby);
                        }).catch(console.error);
                    });

                    itemDiv.appendChild(left);
                    itemDiv.appendChild(btn);
                    listWrap.appendChild(itemDiv);
                });

                groupDiv.appendChild(listWrap);
                container.appendChild(groupDiv);
            });
        }

        // initial state: no baby selected
        document.addEventListener('DOMContentLoaded', function() {
            // pre-select first baby if present
            const sel = document.getElementById('babySelector');
            if (sel && sel.options.length > 0) {
                // do nothing automatic to avoid surprising the user
            }
        });
        </script>
        <style>
        .skills-horizontal::-webkit-scrollbar {
            height: 8px;
        }
        .skills-horizontal::-webkit-scrollbar-thumb {
            background: #bbdefb;
            border-radius: 4px;
        }
        .skills-horizontal {
            scrollbar-color: #bbdefb #e3f2fd;
            scrollbar-width: thin;
        }
        </style>
        <!-- END MAIN LAYOUT RESTRUCTURE -->
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

        function toggleDropdown(element) {
            const dropdownContent = element.nextElementSibling;
            const icon = element.querySelector('.fa-chevron-down');

            if (dropdownContent.style.display === 'block') {
                dropdownContent.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
            } else {
                dropdownContent.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
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

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.milestone-check').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.classList.toggle('completed');
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
