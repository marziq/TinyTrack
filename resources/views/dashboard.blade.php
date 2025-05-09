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
        }

        .baby-info-panel {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            text-align: center; /* Center text */
            gap: 15px; /* Add spacing between elements */
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 400px; /* Larger height for the chart */
            grid-column: span 2; /* Make the chart span two columns */
        }

        .chart-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centers the image horizontally */
            justify-content: center; /* Centers the image vertically */
            height: 100%; /* Ensures the placeholder takes up the full height of the container */
            text-align: center;
        }

        .chart-image {
            max-width: 70%; /* Resize the image to 70% of the container width */
            max-height: 70%; /* Ensure the image doesn't exceed 70% of the container height */
            object-fit: contain; /* Ensures the image scales proportionally */
            margin-bottom: 10px; /* Adds spacing between the image and the text */
        }

        /* Milestones Container */
.milestones-container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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
    background-color: #f9f9f9;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
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
    color: #1976d2;
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

.milestone-date {
    font-size: 14px;
    color: #666;
}

/* Vaccine Container */
.vaccine-container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    margin-top: 20px;
}

.vaccine-card {
    padding: 15px;
    border-left: 5px solid #1976d2;
    background-color: #f9f9f9;
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

/* Baby Tips Panel */
.baby-tips-panel {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    margin-top: 20px;
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
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <a href="{{route('mybaby')}}"><h2 >My Dashboard</h2></a>
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
            <h1>My Baby</h1>
            <div class="topbar-right">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>

                <div class="dropdown">
                    <button class="profile-btn dropdown-toggle" type="button" id="accountDropdown">
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
                <h2>Hi, {{ Auth::user()->name }}</h2>
                <p>Select a baby to view details</p>
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
        <option
            value="{{ $baby->id }}"
            data-name="{{ $baby->name }}"
            data-age="{{ \Carbon\Carbon::parse($baby->birth_date)->diff(\Carbon\Carbon::now())->format('%y years, %m months') }}"
            data-birthdate="{{ $baby->birth_date }}"
            data-gender="{{ ucfirst($baby->gender) }}"
            data-ethnicity="{{ $baby->ethnicity }}"
            data-photo="{{ asset('storage/' . $baby->baby_photo_path) }}"
            data-premature="{{ $baby->premature ? '1' : '0' }}"
        >
            {{ $baby->name }} ({{ ucfirst($baby->gender) }}, {{ \Carbon\Carbon::parse($baby->birth_date)->diff(\Carbon\Carbon::now())->format('%y years, %m months') }})
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
                        <img id="selectedBabyPhoto" src="" alt="Baby Photo" class="baby-photo">
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
                        <button class="btn btn-outline-danger" onclick="deleteSelectedBaby()">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>

                <div class="chart-container">
                    <h4>Height Growth Chart</h4>
                    <div class="chart-placeholder">
                        <img src="{{ asset('img/growth-chart.jpg') }}" alt="growth chart" class="chart-image">
                        <p>Height growth chart will be displayed here</p>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="milestones-container">
                    <h4>Recent Milestones Achieved</h4>
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
                            Rolled over
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
                </div>

                <div class="vaccine-container">
                    <h4>Next Vaccination</h4>
                    <div class="vaccine-card">
                        <div class="vaccine-name">Hepatitis B (3rd dose)</div>
                        <div class="vaccine-date">July 15, 2023</div>
                        <div class="vaccine-days">in 12 days</div>
                    </div>
                    <div class="vaccine-card" style="border-left-color: #4scaf50; opacity: 0.7;">
                        <div class="vaccine-name">DTaP (2nd dose)</div>
                        <div class="vaccine-date">August 5, 2023</div>
                        <div class="vaccine-days">in 33 days</div>
                    </div>
                </div>

                <!-- Additional card for the last row -->
                <div class="baby-tips-panel">
                    <h4>Baby Tips</h4>
                    <p>This is an extra card to ensure 3 cards in the last row.</p>
                </div>
            </div>
        </div>

        <!-- Add Baby Modal (same as before) -->
        <div class="modal fade" id="addBabyModal" tabindex="-1" aria-labelledby="addBabyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBabyModalLabel">Add New Baby</h5>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>


        // Initialize modal globally
        let addBabyModal;
        let currentBabyId = null;

        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modal
            addBabyModal = new bootstrap.Modal(document.getElementById('addBabyModal'));

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
            document.getElementById('selectedBabyProfileHeading').textContent = `${selectedOption.dataset.name}'s Profile`;

            // Extract data attributes and update the dashboard
            document.getElementById('selectedBabyName').textContent = selectedOption.dataset.name;
            document.getElementById('selectedBabyAge').textContent = selectedOption.dataset.age;
            document.getElementById('selectedBabyBirthDate').textContent = "Birth Date: " + selectedOption.dataset.birthdate;
            document.getElementById('selectedBabyGender').textContent = "Gender: " + selectedOption.dataset.gender;
            document.getElementById('selectedBabyEthnicity').textContent = "Ethnicity: " + selectedOption.dataset.ethnicity;
            document.getElementById('selectedBabyPremature').textContent = selectedOption.dataset.premature == '1' ? "Premature: Yes" : "Premature: No";
            document.getElementById('selectedBabyPhoto').src = selectedOption.dataset.photo;

            document.getElementById('babyDashboard').style.display = 'block';
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
            document.getElementById('addBabyModalLabel').textContent = 'Add New Baby';
            document.getElementById('photoPreview').innerHTML = '';

            // Clear any existing hidden _method field
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();

            addBabyModal.show();
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
        document.getElementById('addBabyModalLabel').textContent = 'Edit Baby';
        document.getElementById('babyId').value = baby.id;
        document.getElementById('babyName').value = baby.name;
        document.getElementById('babyBirthDate').value = baby.birth_date.split('T')[0];
        document.getElementById('babyGender').value = baby.gender;
        document.getElementById('babyEthnicity').value = baby.ethnicity || '';
        document.getElementById('babyPremature').checked = baby.premature == '1';

        // Set photo preview
        const photoPreview = document.getElementById('photoPreview');
        photoPreview.innerHTML = baby.baby_photo_path
            ? `<img src="/storage/${baby.baby_photo_path}" class="img-thumbnail rounded-circle" width="150" height="150">`
            : '';

        // Add hidden input for PUT method
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'PUT';

        addBabyModal.show();
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
</body>
</html>
