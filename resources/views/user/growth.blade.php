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
            margin-bottom: 20px; /* Add spacing between cards */
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

        .main-content {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .input-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            position: relative;
            padding: 40px 20px;
        }

        .slider-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 120px;
        }

        .slider-group input[type="range"] {
            writing-mode: bt-lr; /* Vertical orientation */
            -webkit-appearance: slider-vertical;
            width: 8px;
            height: 200px;
            margin: 20px 0;
        }

        .slider-value {
            font-size: 16px;
            color: #f5af00;
            font-weight: bold;
        }

        .baby-icon-center {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 200px;
            height: 240px;
        }

        .baby-icon-center img {
            margin-top: 50px;
            height: 300px;
            width: auto;
            opacity: 0.5;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .height-group {
            order: 1; /* Left side */
            flex: 1;
        }

        .baby-icon {
            order: 2; /* Center */
            font-size: 50px;
            color: #1976d2;
            margin: 0 20px;
        }

        .weight-group {
            order: 3; /* Right side */
            flex: 1;
        }

        .input-group label {
            font-size: 16px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
            max-width: 150px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: center;
        }

        .input-wrapper .unit {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #555;
            pointer-events: none;
        }

        .input-group.full-width {
            order: 4; /* Bottom */
            flex-basis: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .input-row {
            display: flex;
            justify-content: center; /* Center the inputs */
            align-items: flex-start;
            gap: 10px; /* Reduce spacing between the inputs */
            width: 100%; /* Make the row span the full width */
            margin-top: 10px; /* Adjust the top margin */
        }

        .input-row .input-group {
            flex: 1; /* Make the inputs take equal space */
            max-width: 250px; /* Limit the maximum width of each input */
        }

        .input-row .input-group label {
            font-size: 14px;
            font-weight: bold;
            color: #1976d2;
            margin-bottom: 5px; /* Reduce spacing below the label */
            display: block;
        }

        .input-row .input-wrapper {
            width: 100%;
        }

        .baby-selector-container {
            width: 100%;
            max-width: 400px; /* Limit the width */
            margin: 0 auto; /* Center the container */
            text-align: center;
        }
        .chart-area {
            width: 100%; /* Full width of the container */
            max-width: 600px; /* Limit the maximum width */
            height: 300px; /* Set a fixed height */
            margin: 0 auto; /* Center the chart */
        }

        canvas {
            width: 90% !important; /* Ensure the canvas scales properly */
            height: auto !important; /* Ensure the canvas scales properly */
        }

        .submit-btn {
            background-color: #1976d2;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-align: center;
            width: 100%; /* Make it span the full width */
            max-width: 200px; /* Limit the maximum width */
            margin: 20px auto 0; /* Center the button */
        }

        .submit-btn:hover {
            background-color: #0d47a1;
            transform: translateY(-2px);
        }

        .submit-btn:active {
            background-color: #0b3c91;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <a href="{{route('mybaby')}}"><h2 >My Dashboard</h2></a>
        <hr>
        <a href="{{route('mybaby')}}"><i class="fas fa-child"></i> My Baby</a>
        <a href="{{route('growth')}}"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="{{route('tips')}}"><i class="fa-solid fa-lightbulb"></i> Baby Tips</a>
        <a href="{{route('milestone')}}"><i class="fa-solid fa-bullseye"></i> Milestone</a>
        <a href="{{route('appointment')}}"><i class="fas fa-calendar"></i> Appointment</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">Growth</h1>
            <div class="topbar-right">
                <!-- Notification Icon -->
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="profile-btn dropdown-toggle" type="button" id="accountDropdown">
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

        {{--- Main Content --}}
        <div class="main-content">
            <!-- Height and Weight Input Card -->
            <div class="card">

               <form method="POST" action="{{ route('growth.store') }}">
                    @csrf
                    <div class="input-container">

                        <!-- Weight Slider -->
                        <div class="input-group slider-group weight-slider">
                            <label for="weight-input">Weight</label>
                            <input type="range" id="weight-input" name="weight" min="1000" max="6000" value="2010" step="10">
                            <span class="slider-value" id="weight-value">2010 g</span>
                        </div>

                        <!-- Baby Icon Silhouette -->
                        <div class="baby-icon-center">
                            <img src="{{asset('img/childrenicon.png')}}" alt="ChildrenIcon">
                        </div>

                        <!-- Height Slider -->
                        <div class="input-group slider-group height-slider">
                            <label for="height-input">Height</label>
                            <input type="range" id="height-input" name="height" min="40" max="70" value="50" step="1">
                            <span class="slider-value" id="height-value">50 cm</span>
                        </div>

                        <div class="input-row">
                            <!-- Growth Month -->
                            <div class="input-group">
                                <label for="growthMonth">Growth Month</label>
                                <div class="input-wrapper">
                                    <input type="number" id="growthMonth" name="growthMonth" class="form-control" placeholder="Enter growth month" step="1" required>
                                </div>
                            </div>

                            <!-- Select Baby -->
                            <div class="input-group">
                                <label for="baby_id">Select Baby</label>
                                <div class="input-wrapper">
                                    <select id="baby_id" name="baby_id" class="form-control" required>
                                        <option value="" disabled selected>Select a baby</option>
                                        @foreach ($babies as $baby)
                                            <option value="{{ $baby->id }}">{{ $baby->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="input-group full-width">
                            <button type="submit" class="submit-btn">Submit</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="baby-selector-container">
                <h2>Growth Tracking</h2>
                <select id="babySelector" onchange="loadBabyData(this.value)" class="form-control">
                    <option value="" disabled selected hidden>Select a baby</option>
                    @foreach(Auth::user()->babies as $baby)
                        <option value="{{ $baby->id }}" data-name="{{ $baby->name }}">
                            {{ $baby->name }} ({{ ucfirst($baby->gender) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <hr>
            <div id="babyDashboard" style="display: none;">
                <h3 id="selectedBabyName" class="text-center"></h3>
                <div class="card">
                    <h3>Height Curvature Chart</h3>
                    <canvas id="height-chart"></canvas>
                </div>
                <div class="card">
                    <h3>Weight Curvature Chart</h3>
                    <canvas id="weight-chart"></canvas>
                </div>
            </div>
        </div>
        {{--- Main Content END--}}
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Weight Slider
            const weightSlider = document.getElementById('weight-input');
            const weightValue = document.getElementById('weight-value');

            weightSlider.addEventListener('input', function () {
                weightValue.textContent = `${weightSlider.value} g`; // Update the weight value dynamically
            });

            // Height Slider
            const heightSlider = document.getElementById('height-input');
            const heightValue = document.getElementById('height-value');

            heightSlider.addEventListener('input', function () {
                heightValue.textContent = `${heightSlider.value} cm`; // Update the height value dynamically
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const heightChartCtx = document.getElementById('height-chart').getContext('2d');
            const weightChartCtx = document.getElementById('weight-chart').getContext('2d');

            // Initialize empty charts
            const heightChart = new Chart(heightChartCtx, {
                type: 'line',
                data: {
                    labels: [], // Growth months will be added dynamically
                    datasets: [{
                        label: 'Height (cm)',
                        data: [],
                        borderColor: '#1976d2',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            const weightChart = new Chart(weightChartCtx, {
                type: 'line',
                data: {
                    labels: [], // Growth months will be added dynamically
                    datasets: [{
                        label: 'Weight (g)',
                        data: [],
                        borderColor: '#e74c3c',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Load baby data when a baby is selected
            window.loadBabyData = function (babyId) {
                if (!babyId) return;

                // Fetch growth data for the selected baby
                fetch(`/dashboard/growth/${babyId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Fetched data:', data); // Log the fetched data

                        // Update the charts
                        const labels = data.map(entry => entry.growthMonth); // Use growthMonth for labels
                        const heights = data.map(entry => entry.height);
                        const weights = data.map(entry => entry.weight);

                        console.log('Labels:', labels); // Log the labels (growth months)
                        console.log('Heights:', heights); // Log the heights
                        console.log('Weights:', weights); // Log the weights

                        heightChart.data.labels = labels;
                        heightChart.data.datasets[0].data = heights;
                        heightChart.update();

                        weightChart.data.labels = labels;
                        weightChart.data.datasets[0].data = weights;
                        weightChart.update();

                        // Update the baby name
                        const selectedOption = document.querySelector(`#babySelector option[value="${babyId}"]`);
                        document.getElementById('selectedBabyName').textContent = `${selectedOption.dataset.name}'s Growth Tracking`;

                        // Show the dashboard
                        document.getElementById('babyDashboard').style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error fetching growth data:', error);
                        alert('Failed to load growth data. Please try again.');
                    });
            };
        });
    </script>
</body>
</html>
