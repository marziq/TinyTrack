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
            <div class="card" style="max-width: 500px; margin: 0 auto 32px auto; padding: 32px 24px; border-radius: 18px; box-shadow: 0 4px 16px rgba(25,118,210,0.10);">
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
                <div class="card" style="padding: 24px 18px; border-radius: 14px;">
                    <h3 style="color:#1976d2; font-weight:bold; margin-bottom: 18px;">Physical</h3>
                    <div class="skills-horizontal" id="physicalSkills" style="display: flex; gap: 18px; overflow-x: auto; padding-bottom: 8px;">
                        <!-- Skill groups will be injected here -->
                    </div>
                </div>
                <!-- COGNITIVE CARD -->
                <div class="card" style="padding: 24px 18px; border-radius: 14px;">
                    <h3 style="color:#1976d2; font-weight:bold; margin-bottom: 18px;">Cognitive</h3>
                    <div class="skills-horizontal" id="cognitiveSkills" style="display: flex; gap: 18px; overflow-x: auto; padding-bottom: 8px;">
                        <!-- Skill groups will be injected here -->
                    </div>
                </div>
                <!-- SOCIAL CARD -->
                <div class="card" style="padding: 24px 18px; border-radius: 14px;">
                    <h3 style="color:#1976d2; font-weight:bold; margin-bottom: 18px;">Social</h3>
                    <div class="skills-horizontal" id="socialSkills" style="display: flex; gap: 18px; overflow-x: auto; padding-bottom: 8px;">
                        <!-- Skill groups will be injected here -->
                    </div>
                </div>
            </div>
        </div>

        <script>
        // --- DATA PLACEHOLDER ---
        const milestoneData = {
            '0-3': {
                physical: [
                    { title: 'Motor Skills', completed: 1, total: 3, items: ['Lifts head', 'Turns head side to side', 'Makes smooth arm/leg movements'] },
                    { title: 'Sensory Skills', completed: 0, total: 2, items: ['Responds to loud sounds', 'Stares at faces'] },
                ],
                cognitive: [
                    { title: 'Problem Solving', completed: 0, total: 2, items: ['Follows moving objects', 'Recognizes familiar people'] },
                ],
                social: [
                    { title: 'Interaction Skills', completed: 0, total: 2, items: ['Begins to smile', 'Looks at parent'] },
                ]
            },
            '4-6': {
                physical: [
                    { title: 'Motor Skills', completed: 2, total: 4, items: ['Rolls over', 'Sits with support', 'Pushes up on arms', 'Reaches for toys'] },
                    { title: 'Sensory Skills', completed: 1, total: 2, items: ['Responds to sounds', 'Explores with mouth'] },
                ],
                cognitive: [
                    { title: 'Problem Solving', completed: 1, total: 2, items: ['Finds partially hidden objects', 'Transfers objects hand to hand'] },
                ],
                social: [
                    { title: 'Interaction Skills', completed: 1, total: 2, items: ['Laughs', 'Enjoys playing with people'] },
                ]
            },
            '7-9': {
                physical: [
                    { title: 'Motor Skills', completed: 2, total: 5, items: ['Sits without support', 'Crawls', 'Pulls to stand', 'Stands holding on', 'Walks with help'] },
                    { title: 'Sensory Skills', completed: 2, total: 3, items: ['Responds to name', 'Looks for hidden things', 'Understands no'] },
                ],
                cognitive: [
                    { title: 'Problem Solving', completed: 1, total: 2, items: ['Finds hidden objects', 'Looks at correct picture when named'] },
                ],
                social: [
                    { title: 'Interaction Skills', completed: 1, total: 2, items: ['Waves bye', 'Plays peek-a-boo'] },
                ]
            },
            '10-12': {
                physical: [
                    { title: 'Motor Skills', completed: 3, total: 5, items: ['Stands alone', 'Walks with assistance', 'Picks up small objects', 'Drinks from cup', 'Feeds self'] },
                    { title: 'Sensory Skills', completed: 2, total: 3, items: ['Points to objects', 'Imitates gestures', 'Understands simple instructions'] },
                ],
                cognitive: [
                    { title: 'Problem Solving', completed: 2, total: 3, items: ['Looks for things you hide', 'Uses objects correctly', 'Follows simple directions'] },
                ],
                social: [
                    { title: 'Interaction Skills', completed: 2, total: 3, items: ['Shows affection', 'May be shy with strangers', 'Repeats sounds/actions'] },
                ]
            }
        };

        let selectedBaby = null;
        let selectedMonth = '0-3';

        function onBabyChange(babyId) {
            selectedBaby = babyId;
            renderProgress();
            renderAllSkills();
        }
        function onMonthChange(month) {
            selectedMonth = month;
            renderAllSkills();
        }
        function renderProgress() {
            const progressDiv = document.getElementById('progressContent');
            if (!selectedBaby) {
                progressDiv.innerHTML = '<div style="text-align:center; color:#888; font-size:18px; padding:32px 0;">Who you wanna see progress?</div>';
                return;
            }
            // For demo, use static progress. Replace with AJAX for real data.
            let p = 0, c = 0, s = 0;
            const d = milestoneData[selectedMonth];
            if (d) {
                p = Math.round(100 * d.physical.reduce((a, g) => a + g.completed, 0) / d.physical.reduce((a, g) => a + g.total, 0));
                c = Math.round(100 * d.cognitive.reduce((a, g) => a + g.completed, 0) / d.cognitive.reduce((a, g) => a + g.total, 0));
                s = Math.round(100 * d.social.reduce((a, g) => a + g.completed, 0) / d.social.reduce((a, g) => a + g.total, 0));
            }
            progressDiv.innerHTML = `
                <div style="display:flex; flex-direction:column; gap:18px;">
                    <div style="display:flex; align-items:center; gap:16px;">
                        <span style="font-size:2rem; color:#1976d2; background:#e3f2fd; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-dumbbell"></i></span>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-weight:bold; color:#1976d2;">Physical</span>
                                <span style="font-size:15px; color:#1976d2; font-weight:600;">${p}%</span>
                            </div>
                            <div class="progress" style="height: 14px; background:#e3f2fd;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: ${p}%; font-size: 12px;" aria-valuenow="${p}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:16px;">
                        <span style="font-size:2rem; color:#1976d2; background:#e3f2fd; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-brain"></i></span>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-weight:bold; color:#1976d2;">Cognitive</span>
                                <span style="font-size:15px; color:#1976d2; font-weight:600;">${c}%</span>
                            </div>
                            <div class="progress" style="height: 14px; background:#e3f2fd;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: ${c}%; font-size: 12px;" aria-valuenow="${c}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:16px;">
                        <span style="font-size:2rem; color:#1976d2; background:#e3f2fd; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-users"></i></span>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-weight:bold; color:#1976d2;">Social</span>
                                <span style="font-size:15px; color:#1976d2; font-weight:600;">${s}%</span>
                            </div>
                            <div class="progress" style="height: 14px; background:#e3f2fd;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: ${s}%; font-size: 12px;" aria-valuenow="${s}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        function renderSkillSection(section, data) {
            const container = document.getElementById(section + 'Skills');
            container.innerHTML = '';
            if (!selectedBaby) {
                container.innerHTML = '<div style="color:#aaa; font-size:16px; padding:32px 0;">Select a baby to see milestones.</div>';
                return;
            }
            data[section].forEach(group => {
                const groupDiv = document.createElement('div');
                groupDiv.style.minWidth = '260px';
                groupDiv.style.background = '#e3f2fd';
                groupDiv.style.borderRadius = '10px';
                groupDiv.style.boxShadow = '0 2px 8px rgba(25,118,210,0.06)';
                groupDiv.style.padding = '18px 14px';
                groupDiv.style.display = 'flex';
                groupDiv.style.flexDirection = 'column';
                groupDiv.style.alignItems = 'flex-start';
                groupDiv.style.gap = '10px';
                groupDiv.innerHTML = `
                    <div style="font-weight:600; color:#1976d2; margin-bottom:4px;">${group.title}</div>
                    <span style="font-size:13px; color:#1976d2;">${group.completed}/${group.total} completed</span>
                    <div class="progress mb-2" style="height:12px; background:#fff; width:100%;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: ${Math.round(100*group.completed/group.total)}%"></div>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:8px; width:100%;">
                        ${group.items.map(item => `<div class="milestone-card" style="font-size:15px; background:#fff; border-radius:6px; padding:8px 12px; margin-bottom:0; display:flex; align-items:center; justify-content:space-between;"><span>${item}</span><button class="milestone-check"><i class="fas fa-check"></i></button></div>`).join('')}
                    </div>
                `;
                container.appendChild(groupDiv);
            });
        }
        function renderAllSkills() {
            const data = milestoneData[selectedMonth];
            renderSkillSection('physical', data);
            renderSkillSection('cognitive', data);
            renderSkillSection('social', data);
            // Re-attach check button logic
            setTimeout(() => {
                document.querySelectorAll('.milestone-check').forEach(btn => {
                    btn.addEventListener('click', function() {
                        btn.classList.toggle('completed');
                    });
                });
            }, 100);
        }
        // Initial render
        renderProgress();
        renderAllSkills();
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
    </script>
</body>
</html>
