<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
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

        /* Make sure the page background covers the full scrollable area
           Use min-height so body can grow beyond the viewport when content is long
           Also set the html background so any area outside body inherits the same color */
        html {
            background-color: #f8fafc;
            min-height: 100%;
        }

        body {
            display: flex;
            height: 100vh; /* match other pages so sidebar/main sizing is consistent */
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Ensure the main content area grows to fill remaining width and doesn't cause horizontal gaps */
        .main {
            flex: 1;
            padding: 20px;
            position: relative;
            transition: margin-left 0.3s ease;
            overflow-y: auto;
        }

        /* When sidebar is hidden, shift the main content to occupy the freed space (matches other pages) */
        .sidebar.hidden + .main {
            margin-left: -250px;
        }

        /* Make the container responsive and centered while allowing full-width background to show */
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
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

        .save-btn {
            background: linear-gradient(135deg, #1976d2 0%, #0d47a1 100%);
            color: #fff;
            border: none;
            padding: 10px 28px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(13,71,161,0.18);
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: transform .12s ease, box-shadow .12s ease, opacity .12s ease;
            display: inline-block;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(13,71,161,0.22);
        }

        .save-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .form-input {
            border-radius: 8px;
            box-shadow: none;
            border: 1px solid #e6eef9;
            padding: 12px 14px;
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

        /* Ensure topbar layout matches other pages (keeps right-side icons aligned) */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 10px 20px; /* align spacing with other pages */
            position: relative;
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
            /* Make card wider but still responsive: cap at 1000px and center */
            width: min(100%, 1000px);
            max-width: 1000px;
            margin: 0 auto;
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

        .profile-photo-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-img-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e0e0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #profile_photo {
            max-width: 300px;
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
        /* Profile edit form styles to match design */
        .profile-photo-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 10px auto;
        }

        .profile-photo-wrapper img.profile-img-preview {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .edit-photo-icon {
            position: absolute;
            right: -6px;
            bottom: -6px;
            background: #0d47a1;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(255,92,0,0.22);
            border: 4px solid #fff;
            cursor: pointer;
        }

        .save-btn{
            background: #0d47a1;
            color: #fff;
            border: none;
            padding: 12px 42px;
            border-radius: 28px;
            box-shadow: 0 18px 36px rgba(255,92,0,0.18);
            font-weight: 600;
            font-size: 16px;
        }

        .form-input {
            border-radius: 8px;
            box-shadow: none;
            border: 1px solid #e6eef9;
            padding:
             12px 14px;
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
            <h1 style="font-weight: bold">My Account</h1>
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
                            {{-- Use stored asset if user uploaded a profile photo (profile_photo_path), otherwise fall back to profile_photo_url --}}
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

       {{--Main Content--}}
        <div class="container mt-5">
            <div class="row justify-content-center">
                <!-- wider, responsive column so .card can expand up to its max-width -->
                <div class="col-12 col-lg-10 mx-auto">
                    <!-- Profile Information Card -->
                    <div class="card">
                        <h3>Profile Information</h3>
                        <div class="card-body">
                            <!-- Inline Edit Mode (matches design) -->
                                @php
                                    $nameParts = explode(' ', trim(Auth::user()->name ?? ''), 2);
                                    $firstName = $nameParts[0] ?? '';
                                    $lastName = $nameParts[1] ?? '';
                                @endphp
                                <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data" class="text-start" id="inlineProfileForm">
                                    @csrf
                                    <input type="hidden" name="name" id="full_name_input" value="{{ old('name', Auth::user()->name) }}">

                                    <div class="profile-photo-wrapper">
                                        {{-- Use stored asset if present (profile_photo_path), otherwise fall back to profile_photo_url --}}
                                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img-preview">
                                        <label class="edit-photo-icon" title="Change photo">
                                            <i class="fas fa-pencil-alt"></i>
                                            <input type="file" name="profile_photo" id="inline_profile_photo" style="display:none">
                                        </label>
                                    </div>

                                    <h4 class="text-center mb-3">{{ Auth::user()->name }}</h4>
                                    <p class="text-muted" style="font-size: 15px; color:#0d47a1 !important">User ID: {{ Auth::user()->id }}</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="first_name" class="form-control form-input" value="{{ old('first_name', $firstName) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control form-input" value="{{ old('last_name', $lastName) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control form-input" value="{{ old('email', Auth::user()->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="mobile_number" class="form-control form-input" value="{{ old('mobile_number', Auth::user()->mobile_number) }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" class="form-control form-input" {{ !isset($isEditing) ? 'disabled' : '' }}>
                                                <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Total Babies</label>
                                            <div class="form-control form-input" style="background-color: #f8f9fa;">
                                                @php
                                                    $boys = Auth::user()->babies()->where('gender', 'Male')->count();
                                                    $girls = Auth::user()->babies()->where('gender', 'Female')->count();
                                                    $total = $boys + $girls;
                                                @endphp
                                                {{ $total }} ({{ $boys }} boy{{ $boys != 1 ? 's' : '' }}, {{ $girls }} girl{{ $girls != 1 ? 's' : '' }})
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Replace the save button section with: -->
                                    <div class="d-flex justify-content-center mt-4">
                                        @if(!isset($isEditing))
                                            <button type="button" class="save-btn" id="editButton" onclick="toggleEditMode(true)">Update Profile</button>
                                        @else
                                            <button type="submit" class="save-btn">Save Changes</button>
                                            <button type="button" class="btn btn-secondary ms-2" onclick="toggleEditMode(false)">Cancel</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                    </div>
                    <!-- Favourited Baby Tips Card -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3>Favourited Baby Tips</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group" id="favoritesList">
                                @if(isset($favorites) && $favorites->count())
                                    @foreach($favorites as $fav)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="javascript:void(0)" class="fav-item"
                                               data-id="{{ $fav->id }}"
                                               data-title="{{ e($fav->title) }}"
                                               data-content="{{ e($fav->rich_content ?? $fav->content) }}"
                                               data-image="{{ e($fav->image_url) }}"
                                               data-video="{{ e($fav->video_url) }}">
                                                {{ $fav->title }}
                                            </a>
                                            <span class="badge bg-primary">Favourited</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">You have no favourited tips yet.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tip Info Modal (for favourited tips) -->
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

        <!-- Edit Profile Modal (place this just before </body>) -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                <form method="POST" action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3 justify-content-center">
                            <label class="col-sm-4 col-form-label text-end">Profile Photo</label>
                                <div class="col-sm-6 d-flex align-items-center">
                                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : Auth::user()->profile_photo_url }}" alt="Profile Photo" class="rounded-circle me-3" width="60">
                                <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="name" class="col-sm-4 col-form-label text-end">Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="email" class="col-sm-4 col-form-label text-end">Email Address</label>
                            <div class="col-sm-6">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="gender" class="col-sm-4 col-form-label text-end">Gender</label>
                            <div class="col-sm-6">
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <label for="mobile_number" class="col-sm-4 col-form-label text-end">Mobile Number</label>
                            <div class="col-sm-6">
                                <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', Auth::user()->mobile_number) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
       {{--Main Content End--}}
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

        function toggleEditMode(edit) {
            const form = document.getElementById('inlineProfileForm');
            const inputs = form.querySelectorAll('input:not([type="hidden"]), select');
            const editButton = document.getElementById('editButton');

            inputs.forEach(input => {
                if (input.type !== 'file') {  // Don't disable file input
                    input.disabled = !edit;
                }
            });

            if (edit) {
                editButton.closest('.d-flex').innerHTML = `
                    <button type="submit" class="save-btn">Save Changes</button>
                    <button type="button" class="btn btn-secondary ms-2" onclick="toggleEditMode(false)">Cancel</button>
                `;
            } else {
                location.reload(); // Reload page to reset form
            }
        }

        // Initialize form in disabled state
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('inlineProfileForm');
            const inputs = form.querySelectorAll('input:not([type="hidden"]), select');
            inputs.forEach(input => {
                if (input.type !== 'file') {
                    input.disabled = true;
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
        // Inline profile photo preview and name combine
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('inline_profile_photo');
            const preview = document.querySelector('.profile-img-preview');

            if (fileInput && preview) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        preview.src = ev.target.result;
                    }
                    reader.readAsDataURL(file);
                });
            }

            // Combine first and last names into 'name' hidden input before submit
            const form = document.getElementById('inlineProfileForm');
            if (form) {
                form.addEventListener('submit', function() {
                    const f = form.querySelector('input[name="first_name"]')?.value || '';
                    const l = form.querySelector('input[name="last_name"]')?.value || '';
                    const full = (f + ' ' + l).trim();
                    const hidden = document.getElementById('full_name_input');
                    if (hidden) hidden.value = full || '{{ Auth::user()->name }}';
                });
            }
        });

        // Show favourited tip details in a modal and allow removing from here
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.fav-item').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    const title = this.dataset.title || '';
                    const content = this.dataset.content || '';
                    const favId = this.dataset.id;

                    const modalTitle = document.getElementById('tipInfoModalLabel');
                    const modalBody = document.getElementById('tipInfoModalBody');

                    const imageUrl = this.dataset.image;
                    const videoUrl = this.dataset.video;

                    modalTitle.innerText = title;
                    modalBody.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; flex-direction: column; flex: 1;">
                                <h3 style="color: #1976d2; margin: 0;">${title}</h3>
                                <a style="color: #1976d2; margin: 0; font-size: 12px;">
                                    <br> Reviewed By: <br> Dr Aiman Khalid <br> Consultant Pediatrician at Selangor Specialist Hospital
                                </a>
                            </div>
                            <button id="removeFavoriteBtn" class="btn btn-primary">Remove from Favourites</button>
                        </div>
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            <p>${content}</p>
                        </div>
                        ${imageUrl ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center;">
                            <img src="${imageUrl}" alt="${title}" style="width:100%; border-radius:10px;">
                        </div>
                        ` : ''}
                        ${videoUrl ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center;">
                            <iframe width="100%" height="315" src="${videoUrl}" frameborder="0" allowfullscreen style="border-radius:10px;"></iframe>
                        </div>
                        ` : ''}
                    `;

                    let tipModal = new bootstrap.Modal(document.getElementById('tipInfoModal'));
                    tipModal.show();

                    // Wire remove button
                    document.getElementById('removeFavoriteBtn').addEventListener('click', function() {
                        fetch(`/favorite-tip/${favId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(r => r.json()).then(resp => {
                            if (resp.success) {
                                // Remove the list item from UI
                                el.closest('li')?.remove();
                                tipModal.hide();
                            } else {
                                alert(resp.message || 'Error removing favorite');
                            }
                        }).catch(() => alert('Error removing favorite'));
                    });
                });
            });
        });

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
