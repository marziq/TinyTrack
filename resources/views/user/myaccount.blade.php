<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
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
        <a href="{{route('appointment')}}"><i class="fas fa-calendar"></i> Appointment</a>
        <a href="{{route('chatbot')}}"><i class="fas fa-robot"></i> Chat With Sage</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog"></i> Settings</a>
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

       {{--Main Content--}}
       <div class="container mt-5">
        <div class="row">
            <!-- Left Column: Profile Card -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="profile-img-container mb-3" style="width:170px; height:170px; margin:0 auto;">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img" style="width:100%; height:100%;">
                        </div>
                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="text-muted" style="font-size: 15px; color:#0d47a1 !important">User ID: TT{{ Auth::user()->id }}</p>
                    </div>
                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item">
                            <i class="fas fa-envelope me-2"></i> {{ Auth::user()->email }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-venus-mars me-2"></i>
                            {{ ucfirst(strtolower(Auth::user()->gender)) }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-phone me-2"></i>
                            @php
                                $number = Auth::user()->mobile_number;
                                $formattedNumber = (strlen($number) > 3) ? substr($number, 0, 3) . '-' . substr($number, 3) : $number;
                            @endphp
                            {{ $formattedNumber }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-baby me-2"></i>
                            Babies: {{ Auth::user()->babies->count() }} Babies
                            @php
                                $maleBabies = Auth::user()->babies->where('gender', 'male')->count();
                                $femaleBabies = Auth::user()->babies->where('gender', 'female')->count();
                                $otherBabies = Auth::user()->babies->whereNotIn('gender', ['male', 'female'])->count();
                            @endphp
                            <span class="text-muted" style="font-size: 13px;">
                                (
                                @if($maleBabies) {{ $maleBabies }} Male @endif
                                @if($maleBabies && $femaleBabies) , @endif
                                @if($femaleBabies) {{ $femaleBabies }} Female @endif
                                @if(($maleBabies || $femaleBabies) && $otherBabies) , @endif
                                @if($otherBabies) {{ $otherBabies }} Other @endif
                                )
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: User Info and Favourited Tips -->
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3>Profile Information</h3>
                    </div>
                    <div class="card-body">
                        <!-- View Mode -->
                        <div id="viewMode">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Name</strong></div>
                                <div class="col-sm-8 text-secondary">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email Address</strong></div>
                                <div class="col-sm-8 text-secondary">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Gender</strong></div>
                                <div class="col-sm-8 text-secondary">{{ ucfirst(strtolower(Auth::user()->gender)) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Mobile Number</strong></div>
                                <div class="col-sm-8 text-secondary">
                                    @php
                                        $number = Auth::user()->mobile_number;
                                        $formattedNumber = (strlen($number) > 3) ? substr($number, 0, 3) . '-' . substr($number, 3) : $number;
                                    @endphp
                                    {{ $formattedNumber }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Total Babies</strong></div>
                                <div class="col-sm-8 text-secondary">{{ Auth::user()->babies->count() }}
                                    @php
                                        $maleBabies = Auth::user()->babies->where('gender', 'male')->count();
                                        $femaleBabies = Auth::user()->babies->where('gender', 'female')->count();
                                        $otherBabies = Auth::user()->babies->whereNotIn('gender', ['male', 'female'])->count();
                                    @endphp
                                    Babies
                                    <span class="text-muted" style="font-size: 13px;">
                                        (
                                        @if($maleBabies) {{ $maleBabies }} Male @endif
                                        @if($maleBabies && $femaleBabies) , @endif
                                        @if($femaleBabies) {{ $femaleBabies }} Female @endif
                                        @if(($maleBabies || $femaleBabies) && $otherBabies) , @endif
                                        @if($otherBabies) {{ $otherBabies }} Other @endif
                                        )
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <button style="background-color:#258ef7 !important" type="button" class="btn btn-primary" onclick="toggleEditMode()">Update</button>
                            </div>
                        </div>
                        <!-- Edit Mode -->
                        <div id="editMode" style="display: none;">
                            <form method="POST" action="{{ route('user-profile-information.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Profile Photo</label>
                                    <div class="col-sm-8 d-flex align-items-center">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile Photo" class="rounded-circle me-3" width="60">
                                        <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-4 col-form-label">Email Address</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="gender" class="col-sm-4 col-form-label">Gender</label>
                                    <div class="col-sm-8">
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="mobile_number" class="col-sm-4 col-form-label">Mobile Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', Auth::user()->mobile_number) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Total Babies</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="{{ Auth::user()->babies->count() }}" readonly>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Favourited Baby Tips Card -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Favourited Baby Tips</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="#">How to Soothe a Crying Baby</a>
                                <span style="background-color: #258ef7 !important" class="badge bg-primary">Favourited</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="#">Safe Sleep Practices</a>
                                <span style="background-color: #258ef7 !important" class="badge bg-primary">Favourited</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="#">Introducing Solid Foods</a>
                                <span style="background-color: #258ef7 !important" class="badge bg-primary">Favourited</span>
                            </li>
                        </ul>
                    </div>
                </div>
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

        function toggleEditMode() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');

            if (viewMode.style.display === 'none') {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
            } else {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
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
