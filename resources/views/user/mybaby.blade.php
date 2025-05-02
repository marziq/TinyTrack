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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            padding: 10px 0;
            display: block;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #bbdefb;
            border-radius: 6px;
            padding-left: 10px;
        }

        .main {
            flex: 1;
            padding: 20px;
            position: relative;
            transition: margin-left 0.3s ease;
        }

        .sidebar.hidden + .main {
            margin-left: -250px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #1976d2;
            z-index: 20;
        }

        .topbar h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
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
        }

        .notification-icon i {
            font-size: 20px;
            color: #555;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
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
            padding: 0;
            display: flex;
            align-items: center;
            gap: 8px;
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
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 8px 0;
        }

        .text-danger {
            color: #dc3545 !important;
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
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 20px;
        }

        .baby-info-panel {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .baby-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .baby-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e3f2fd;
            margin-right: 20px;
        }

        .baby-details h3 {
            margin-bottom: 5px;
            color: #333;
        }

        .baby-details p {
            margin: 3px 0;
            color: #666;
        }

        .baby-age {
            font-weight: bold;
            color: #1976d2;
        }

        .chart-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .chart-placeholder {
            width: 100%;
            height: 200px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            border-radius: 8px;
            margin-top: 20px;
        }

        .milestones-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .milestone-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .milestone-item:last-child {
            border-bottom: none;
        }

        .milestone-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e3f2fd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #1976d2;
        }

        .milestone-text {
            flex: 1;
        }

        .milestone-date {
            color: #888;
            font-size: 14px;
        }

        .vaccine-container {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .vaccine-card {
            background-color: #f8fbfe;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            border-left: 4px solid #1976d2;
        }

        .vaccine-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .vaccine-date {
            color: #1976d2;
            font-weight: bold;
        }

        .vaccine-days {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>My Dashboard</h2>
        <a href="{{route('dashboard')}}"><i class="fa-solid fa-table-columns"></i> Overview</a>
        <a href="{{route('mybaby')}}"><i class="fas fa-child"></i> My Baby</a>
        <a href="#"><i class="fas fa-chart-line"></i> Growth</a>
        <a href="#"><i class="fa-solid fa-lightbulb"></i> Baby Tips</a>
        <a href="#"><i class="fa-solid fa-bullseye"></i> Milestone</a>
        <a href="#"><i class="fas fa-calendar"></i> Calendar</a>
        <a href="#"><i class="fas fa-cog"></i> Settings</a>
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
                        <li><a class="dropdown-item" href="#"><i class="fas fa-baby"></i> My Baby</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-address-card"></i> My Account</a></li>
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

        <div class="baby-selector-container">
            <div>
                <h2>Hi, {{ Auth::user()->name }}</h2>
                <p>Select a baby to view details</p>
            </div>
            <button class="add-baby-btn-top" onclick="openAddBabyModal()">
                <i class="fas fa-plus"></i> Add Baby
            </button>
        </div>

        <select class="baby-selector" id="babySelector" onchange="loadBabyData(this.value)">
            @foreach(Auth::user()->babies as $baby)
                <option
                    value="{{ $baby->id }}"
                    data-name="{{ $baby->name }}"
                    data-age="{{ \Carbon\Carbon::parse($baby->birth_date)->diff(\Carbon\Carbon::now())->format('%y years, %m months') }}"
                    data-birthdate="{{ $baby->birth_date }}"
                    data-gender="{{ ucfirst($baby->gender) }}"
                    data-ethnicity="{{ $baby->ethnicity }}"
                        data-photo="{{ asset('storage/' . $baby->baby_photo_path) }}"
                >
                    {{ $baby->name }} ({{ ucfirst($baby->gender) }}, {{ \Carbon\Carbon::parse($baby->birth_date)->diff(\Carbon\Carbon::now())->format('%y years, %m months') }})
                </option>
            @endforeach

        </select>
        <hr>
        <div id="babyDashboard" style="display: none;">
            <div class="dashboard-grid">
                <!-- Row 1 -->
                <div class="baby-info-panel">
                    <div class="baby-header">
                        <img id="selectedBabyPhoto" src="" alt="Baby Photo" class="baby-photo">
                        <div class="baby-details">
                            <h3 id="selectedBabyName"></h3>
                            <p><span class="baby-age" id="selectedBabyAge"></span></p>
                            <p id="selectedBabyBirthDate"></p>
                            <p id="selectedBabyGender"></p>
                            <p id="selectedBabyEthnicity"></p>
                        </div>
                    </div>
                    <div class="baby-actions" style="display: flex; gap: 10px;">
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
                    <div class="vaccine-card" style="border-left-color: #4caf50; opacity: 0.7;">
                        <div class="vaccine-name">DTaP (2nd dose)</div>
                        <div class="vaccine-date">August 5, 2023</div>
                        <div class="vaccine-days">in 33 days</div>
                    </div>
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
                                <input type="text" class="form-control" id="babyEthnicity" name="ethnicity">
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
            document.getElementById('babyForm')?.addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = e.target;
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                try {
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        ${submitBtn.textContent.includes('Save') ? 'Saving...' : 'Updating...'}
                    `;

                    const formData = new FormData(form);
                    const method = form.querySelector('input[name="_method"]')?.value || 'POST';

                    const response = await fetch(form.action, {
                        method: method,
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        let errorMsg = data.message || 'Server error occurred';
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).join('\n');
                        }
                        throw new Error(errorMsg);
                    }

                    if (data.success) {
                        addBabyModal.hide();
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Operation failed');
                    }
                } catch (error) {
                    console.error('Submission error:', error);
                    alert(`Error: ${error.message}\n\nCheck console for details.`);
                } finally {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        });

        // Load baby data when selected from dropdown
        function loadBabyData(babyId) {
            const selector = document.getElementById('babySelector');
            const selectedOption = selector.options[selector.selectedIndex];

            if (!babyId || !selectedOption) {
                document.getElementById('babyDashboard').style.display = 'none';
                return;
            }

            // Extract data attributes
            document.getElementById('selectedBabyName').textContent = selectedOption.dataset.name;
            document.getElementById('selectedBabyAge').textContent = selectedOption.dataset.age;
            document.getElementById('selectedBabyBirthDate').textContent = "Birth Date: " + selectedOption.dataset.birthdate;
            document.getElementById('selectedBabyGender').textContent = "Gender: " + selectedOption.dataset.gender;
            document.getElementById('selectedBabyEthnicity').textContent = "Ethnicity: " + selectedOption.dataset.ethnicity;
            document.getElementById('selectedBabyPhoto').src = selectedOption.dataset.photo;

            document.getElementById('babyDashboard').style.display = 'block';
        }


        // Edit the currently selected baby
        function editSelectedBaby() {
            if (!currentBabyId) return;
            editBaby(currentBabyId);
        }

        // Delete the currently selected baby
        function deleteSelectedBaby() {
            if (!currentBabyId) return;
            confirmDelete(currentBabyId);
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
                const response = await fetch(`/babies/${babyId}/edit`);
                if (!response.ok) throw new Error('Failed to load baby data');

                const baby = await response.json();
                const form = document.getElementById('babyForm');

                // Set form values
                form.action = `/babies/${baby.id}`;
                document.getElementById('addBabyModalLabel').textContent = 'Edit Baby';
                document.getElementById('babyId').value = baby.id;
                document.getElementById('babyName').value = baby.name;
                document.getElementById('babyBirthDate').value = baby.birth_date.split('T')[0];
                document.getElementById('babyGender').value = baby.gender;
                document.getElementById('babyEthnicity').value = baby.ethnicity || '';

                // Set photo preview
                const photoPreview = document.getElementById('photoPreview');
                photoPreview.innerHTML = baby.baby_photo_path ?
                    `<img src="/storage/${baby.baby_photo_path}" class="img-thumbnail rounded-circle" width="150" height="150">` :
                    '';

                // Set up PUT method
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
