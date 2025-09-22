<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Milestones</title>
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
            width: 40%;
            height: auto;
            border-radius: 8px;
            margin: 0 auto 10px auto; /* Center the image and add spacing below */
            display: block;
            object-fit: cover;
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
        <a href="{{route('milestone')}}" class="active"><i class="fa-solid fa-bullseye"></i> Milestone</a>
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
            <h1 style="font-weight: bold">Milestone</h1>
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

            <div class="progress-wrapper">
                <div class="progress-container">
                    <!-- Physical Section -->
                    <div class="physical-section">
                        <h3>Physical</h3>
                        <div class="physical-list">
                            <div class="physical-item">
                                <p onclick="toggleDropdown(this)">Motor Skills <i class="fas fa-chevron-down"></i></p>
                                <div class="dropdown-content">
                                    <img src="{{ asset('img/motorskills.jpg') }}" alt="Motor Skills" class="progress-image-top">
                                    <span class="not-completed">0/5 completed</span>
                                    <div class="progress mb-3">
                                        <div id="physicalProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 40%">40%</div>
                                    </div>
                                    <div class="milestone-cards">
                                        <div class="milestone-card">
                                            <span>Rolls over from tummy to back</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Sits without support</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Crawls on hands and knees</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Stands holding on</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Walks with assistance</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="physical-item">
                                <p onclick="toggleDropdown(this)">Sensory Skills <i class="fas fa-chevron-down"></i></p>
                                <div class="dropdown-content">
                                    <img src="{{ asset('img/sensoryskills.png') }}" alt="Sensory Skills" class="progress-image-top">
                                    <span class="not-completed">0/5 completed</span>
                                    <div class="progress mb-3">
                                        <div id="physicalProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 50%">50%</div>
                                    </div>
                                        <div class="milestone-cards">
                                            <div class="milestone-card">
                                                <span>Responds to sounds by turning head</span>
                                                <button class="milestone-check"><i class="fas fa-check"></i></button>
                                            </div>
                                            <div class="milestone-card">
                                                <span>Follows moving objects with eyes</span>
                                                <button class="milestone-check"><i class="fas fa-check"></i></button>
                                            </div>
                                            <div class="milestone-card">
                                                <span>Reaches for and grasps objects</span>
                                                <button class="milestone-check"><i class="fas fa-check"></i></button>
                                            </div>
                                            <div class="milestone-card">
                                                <span>Explores objects with mouth</span>
                                                <button class="milestone-check"><i class="fas fa-check"></i></button>
                                            </div>
                                            <div class="milestone-card">
                                                <span>Recognizes familiar faces and voices</span>
                                                <button class="milestone-check"><i class="fas fa-check"></i></button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cognitive Section -->
                    <div class="cognitive-section">
                        <h3>Cognitive</h3>
                        <div class="cognitive-list">
                            <div class="cognitive-item">
                                <p onclick="toggleDropdown(this)">Problem Solving <i class="fas fa-chevron-down"></i></p>
                                <div class="dropdown-content">
                                    <img src="{{ asset('img/problemsolving.jpeg') }}" alt="Problem Solving" class="progress-image-top">
                                    <span class="not-completed">0/5 completed</span>
                                    <div class="progress mb-3">
                                        <div id="cognitiveProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 60%">60%</div>
                                    </div>
                                    <div class="milestone-cards">
                                        <div class="milestone-card">
                                            <span>Looks for hidden objects</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Transfers objects from one hand to another</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Tries to get objects that are out of reach</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Finds partially hidden objects</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Shows curiosity about things and tries to get them</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cognitive-item">
                                <p onclick="toggleDropdown(this)">Language Skills <i class="fas fa-chevron-down"></i></p>
                                <div class="dropdown-content">
                                    <img src="{{ asset('img/languageskills.jpg') }}" alt="Language Skills" class="progress-image-top">
                                    <span class="not-completed">0/4 completed</span>
                                    <div class="progress mb-3">
                                        <div id="cognitiveProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 35%">35%</div>
                                    </div>
                                    <div class="milestone-cards">
                                        <div class="milestone-card">
                                            <span>Babbles with expression and copies sounds</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Says simple words like "mama" or "dada"</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Responds to own name</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Understands "no"</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Section -->
                    <div class="social-section">
                        <h3>Social</h3>
                        <div class="social-list">
                            <div class="social-item">
                                <p onclick="toggleDropdown(this)">Interaction Skills <i class="fas fa-chevron-down"></i></p>
                                <div class="dropdown-content">
                                    <img src="{{ asset('img/interaction.png') }}" alt="Interaction Skills" class="progress-image-top">
                                    <span class="not-completed">0/3 completed</span>
                                    <div class="progress mb-3">
                                        <div id="socialProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 10%">10%</div>
                                    </div>
                                    <div class="milestone-cards">
                                        <div class="milestone-card">
                                            <span>Waves goodbye or claps hands</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Plays simple games like peek-a-boo</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>Imitates gestures or sounds</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="social-item">
                                <p onclick="toggleDropdown(this)">Emotional Skills <i class="fas fa-chevron-down"></i></p>
                                <div class="dropdown-content">
                                    <img src="{{ asset('img/emotional.jpg') }}" alt="Emotional Skills" class="progress-image-top">
                                    <span class="not-completed">0/2 completed</span>
                                    <div class="progress mb-3">
                                        <div id="socialProgressBar" class="progress-bar bg-success" role="progressbar" style="width: 20%">20%</div>
                                    </div>
                                    <div class="milestone-cards">
                                        <div class="milestone-card">
                                            <span>Shows affection to familiar people</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="milestone-card">
                                            <span>May be shy or nervous with strangers</span>
                                            <button class="milestone-check"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </script>
</body>
</html>
