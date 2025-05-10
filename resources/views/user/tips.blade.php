<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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
            height: 150px;
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
            padding: 10px;
            font-size: 14px;
            color: #1976d2;
            background-color: #e3f2fd;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .topic-card ul li button:hover {
            background-color: #bbdefb;
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
            <h1 style="font-weight: bold">Baby Tips</h1>
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
        {{-- Main content goes here --}}
        <div class="explore-header">
            <h2>Tips for your Baby</h2>
            <select>
                <option value="0">Less Than Year</option>
                <option value="1-2">1-2 Years</option>
                <option value="3-4">3-4 Years</option>
                <option value="5-6">5-6 Years</option>

            </select>
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
                            <li><button onclick="showInfo('bonding1')">What is the "Fourth Trimester"?</button></li>
                            <li><button onclick="showInfo('bonding2')">Skin-to-Skin & Baby Massage Tips</button></li>
                            <li><button onclick="showInfo('bonding3')">Tips to Help Baby Communicate</button></li>
                            <li><button onclick="showInfo('bonding4')">Play Ideas at 1 Month</button></li>
                            <li><button onclick="showInfo('bonding5')">Help Baby Learn Language</button></li>
                            <li><button onclick="showInfo('bonding6')">How to Build Trust with Your Baby</button></li>
                        </ul>
                    </div>

                    <!-- Early Sensory Topic -->
                    <div class="topic-card">
                        <img src="path/to/sensory-image.jpg" alt="Early Sensory" class="topic-image">
                        <h3>Early Sensory</h3>
                        <ul class="topic-list">
                            <li><button onclick="showInfo('sensory1')">Are Baby's Eyes Crossed?</button></li>
                            <li><button onclick="showInfo('sensory2')">WATCH: The 8 Senses</button></li>
                            <li><button onclick="showInfo('sensory3')">Baby's Sense of Smell</button></li>
                            <li><button onclick="showInfo('sensory4')">Baby's Hearing Tests</button></li>
                            <li><button onclick="showInfo('sensory5')">The "Balance" Sense</button></li>
                            <li><button onclick="showInfo('sensory6')">How to Stimulate Baby's Vision</button></li>
                        </ul>
                    </div>

                    <!-- Sleep and Routines Topic -->
                    <div class="topic-card">
                        <img src="path/to/bonding-image.jpg" alt="Bonding" class="topic-image">
                        <h3>Sleep and Routines</h3>
                        <ul class="topic-list">
                            <li><button onclick="showInfo('sleep1')">How Much Sleep Does Baby Need?</button></li>
                            <li><button onclick="showInfo('sleep2')">Creating a Bedtime Routine</button></li>
                            <li><button onclick="showInfo('sleep3')">Safe Sleep Practices</button></li>
                            <li><button onclick="showInfo('sleep4')">Dealing with Sleep Regression</button></li>
                            <li><button onclick="showInfo('sleep5')">Daytime Naps: Tips and Tricks</button></li>
                        </ul>
                    </div>

                    <!-- Feeding and Nutrition Topic -->
                    <div class="topic-card">
                        <img src="path/to/bonding-image.jpg" alt="Bonding" class="topic-image">
                        <h3>Feeding and Nutrition</h3>
                        <ul class="topic-list">
                            <li><button onclick="showInfo('feeding1')">Breastfeeding Basics</button></li>
                            <li><button onclick="showInfo('feeding2')">Introducing Solid Foods</button></li>
                            <li><button onclick="showInfo('feeding3')">Signs of Hunger and Fullness</button></li>
                            <li><button onclick="showInfo('feeding4')">Formula Feeding Tips</button></li>
                            <li><button onclick="showInfo('feeding5')">Foods to Avoid for Babies</button></li>
                        </ul>
                    </div>

                    <!-- Developmental Milestones Topic -->
                    <div class="topic-card">
                        <img src="path/to/bonding-image.jpg" alt="Bonding" class="topic-image">
                        <h3>Developmental Milestones</h3>
                        <ul class="topic-list">
                            <li><button onclick="showInfo('milestone1')">Tracking Baby's Growth</button></li>
                            <li><button onclick="showInfo('milestone2')">When Will Baby Start Crawling?</button></li>
                            <li><button onclick="showInfo('milestone3')">Baby's First Words</button></li>
                            <li><button onclick="showInfo('milestone4')">Encouraging Motor Skills</button></li>
                            <li><button onclick="showInfo('milestone5')">Understanding Social Development</button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <button class="slider-btn next-btn" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <!-- Section to display more information -->
        <div id="info-section" class="info-section">
            <h3 id="info-title"></h3>
            <p id="info-content"></p>
        </div>
        {{--Main  content ends here--}}
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
            const infoSection = document.getElementById('info-section');
            const infoTitle = document.getElementById('info-title');
            const infoContent = document.getElementById('info-content');

            // Define the content for each topic
            const topics = {
                bonding1: {
                    title: 'What is the "Fourth Trimester"?',
                    content: 'The "Fourth Trimester" refers to the first three months after birth when your baby is adjusting to life outside the womb.'
                },
                bonding2: {
                    title: 'Skin-to-Skin & Baby Massage Tips',
                    content: 'Skin-to-skin contact helps regulate your baby’s temperature and heartbeat. Baby massage can soothe and relax your baby.'
                },
                sensory1: {
                    title: 'Are Baby\'s Eyes Crossed?',
                    content: 'It is normal for a newborn’s eyes to appear crossed occasionally. However, consult a pediatrician if it persists beyond 3 months.'
                },
                sensory2: {
                    title: 'WATCH: The 8 Senses',
                    content: 'Learn about the 8 senses that play a crucial role in your baby’s development, including sight, hearing, and balance.'
                },
                sleep1: {
                    title: 'How Much Sleep Does Baby Need?',
                    content: 'Babies need varying amounts of sleep depending on their age. Newborns sleep 14-17 hours a day.'
                },
                sleep2: {
                    title: 'Creating a Bedtime Routine',
                    content: 'Establishing a consistent bedtime routine helps your baby recognize when it’s time to sleep.'
                },
                feeding1: {
                    title: 'Breastfeeding Basics',
                    content: 'Breastfeeding provides essential nutrients and antibodies for your baby’s growth and immunity.'
                },
                milestone1: {
                    title: 'Tracking Baby\'s Growth',
                    content: 'Regular checkups with your pediatrician help track your baby’s growth and development milestones.'
                }
                // Add more topics as needed
            };

            // Update the info section with the selected topic
            if (topics[topicId]) {
                infoTitle.textContent = topics[topicId].title;
                infoContent.textContent = topics[topicId].content;
                infoSection.style.display = 'block'; // Show the info section
            }
        }
    </script>
</body>
</html>
