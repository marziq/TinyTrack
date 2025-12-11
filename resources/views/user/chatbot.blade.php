<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat With Sage</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
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

        .sidebar a.active {
            background-color: #1976d2;
            color: #fff !important;
            font-weight: bold;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.18); /* stronger shadow for active */
            border: 2px solid #1976d2; /* darker outline for active */
        }

        /*Chatbot*/
        .chat-container {
            background: #fff;
            width: 75%;              /* slightly narrower width */
            max-width: 1200px;       /* reduced max width */
            height: 85vh;            /* shorter height */
            display: flex;
            flex-direction: column;
            border-radius: 15px;     /* fully rounded */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: auto;            /* ensure it centers */
        }
		.chat-header {
            background: #1976d2;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: flex-start; /* ⬅️ align left */
            flex-shrink: 0;
        }
		.chat-header img {
			width: 32px;
			height: 32px;
			border-radius: 50%;
			margin-right: 10px;
		}
		#chatbox {
            flex: 1; /* fill remaining space */
            overflow-y: auto;
            padding: 10px;
            background: #fefefe;
            border-top: 1px solid #ccc;
            border-bottom: none;
        }

        .chat-input {
            background: #fff;
            flex-shrink: 0;
            margin: 0;
            padding: 8px; /* add slight breathing space */
            border-top: 1px solid #ccc; /* separate from chatbox */
        }

        .chat-input .form-control {
            flex: 1;
            min-height: 45px;
            border-radius: 8px 0 0 8px;
            border-right: none;
            text-align: left;          /* ✅ text starts from left */
            text-justify: inter-word;  /* ✅ justify long text */
            padding-left: 10px;        /* small padding for neat look */
        }
        .message {
            display: flex;
            align-items: flex-end; /* avatars align to bottom of bubble */
            margin: 10px 0;
        }

        /* Bot messages on the left */
        .message.bot {
            flex-direction: row;           /* bubble on left */
            justify-content: flex-start;
        }
        .message.bot .avatar {
            margin-right: 8px;
            margin-left: 0;
        }

        /* User messages on the right */
        .message.user {
            flex-direction: row;   /* bubble on right */
            justify-content: flex-end;     /* avatar stays on the right */
            text-align: right;
        }
        .message.user .avatar {
            margin-left: 8px;  /* space between bubble and avatar */
            margin-right: 0;
        }

        .bubble {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
        }
        .bot .bubble {
            background: #e3f2fd;
            color: #000;
            border-top-left-radius: 0;
        }
        .user .bubble {
            background: #1976d2;
            color: white;
            border-top-right-radius: 0;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .input-group .btn {
            border-radius: 0 8px 8px 0;
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
        .dark input::placeholder {
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
        <a href="{{route('chatbot')}}"  class="active"><i class="fas fa-robot" style="color: orangered"></i> Chat With Sage</a>
        <a href="{{route('settings')}}"><i class="fas fa-cog" style="color: #666"></i> Settings</a>
    </div>


    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1 style="font-weight: bold">What can Sage help you?</h1>
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
       <div class="chat-container">
            <!-- Header -->
            <div class="chat-header">
                <img src="{{ asset('img/sage.ico') }}" alt="Sage Avatar">
                <h4 class="m-0">Sage</h4>
            </div>

            <!-- Chat Area -->
            <div id="chatbox"></div>

            <!-- Input -->
            <div class="chat-input">
                <div class="input-group">
                    <input type="text" class="form-control" id="userInput" placeholder="Enter your message" />
                    <button class="btn" onclick="sendMessage()" style="color: white; background-color: #1976d2; border-color: #1976d2;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
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
    <script>
        // Global conversation history
        let conversationHistory = [
            { role: "system", content: "You are Sage, a friendly baby health assistant chatbot. Only answer questions related to baby health, growth, nutrition, and care. If asked unrelated questions, politely refuse and redirect to baby topics." }
        ];

        let summaryMemory = ""; // running summary of old messages

        async function sendMessage() {
            const inputField = document.getElementById("userInput");
            const input = inputField.value.trim();
            if (!input) return;

            const chatbox = document.getElementById("chatbox");

            // User message with avatar
            const userMessage = document.createElement("div");
            userMessage.className = "message user";
            userMessage.innerHTML = `
                <div class="bubble">${input}</div>
                <img src="{{ Auth::user()->profile_photo_url }}" class="avatar" alt="User" />
            `;
            chatbox.appendChild(userMessage);
            chatbox.scrollTop = chatbox.scrollHeight;

            inputField.value = "";

            // Add user input to conversation history
            conversationHistory.push({ role: "user", content: input });

            // Bot typing placeholder
            const botMessage = document.createElement("div");
            botMessage.className = "message bot";
            botMessage.innerHTML = `
                <img src="{{ asset('img/sage.ico') }}" alt="Sage Avatar" class="avatar">
                <div class="bubble">Typing...</div>
            `;
            chatbox.appendChild(botMessage);
            chatbox.scrollTop = chatbox.scrollHeight;

            try {
                //Summarize if conversation gets too long
                if (conversationHistory.length > 12) {
                    const oldMessages = conversationHistory.slice(1, conversationHistory.length - 6);

                    const summaryResponse = await fetch("{{ url('/proxy/openrouter/summarize') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            model: "openai/gpt-oss-20b:free",
                            messages: [
                                { role: "system", content: "Summarize this baby-related conversation into a structured memory. Focus on baby's age, weight, height, diet, health goals, and other important details. Ignore chit-chat." },
                                { role: "user", content: JSON.stringify(oldMessages) }
                            ]
                        })
                    });

                    const summaryData = await summaryResponse.json();
                    const newSummary = summaryData.choices?.[0]?.message?.content || "";

                    // merge summaries
                    summaryMemory = (summaryMemory ? summaryMemory + " " : "") + newSummary;

                    // rebuild history with summary + recent messages
                    conversationHistory = [
                        conversationHistory[0], // system
                        { role: "system", content: "Conversation memory so far: " + summaryMemory },
                        ...conversationHistory.slice(-6) // keep only latest 6
                    ];
                }

                //Call main AI for answer
                const response = await fetch("{{ url('/proxy/openrouter/chat') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        model: "openai/gpt-oss-20b:free",
                        messages: conversationHistory
                    })
                });

                const data = await response.json();
                console.log("Raw API response:", data);

                // Error handling
                if (!response.ok) {
                    let errorMessage = "⚠️ Something went wrong.";
                    if (response.status === 429) {
                        errorMessage = "⚠️ Rate limit exceeded. Please wait and try again.";
                    } else if (response.status === 401) {
                        errorMessage = "⚠️ Unauthorized (check your API key).";
                    } else if (response.status >= 500) {
                        errorMessage = "⚠️ Server error. Please try again later.";
                    }
                    botMessage.querySelector(".bubble").innerText = errorMessage;
                    return;
                }

                if (data.error) {
                    let errorMessage = "⚠️ " + (data.error.message || "Unknown error from AI service.");
                    botMessage.querySelector(".bubble").innerText = errorMessage;
                    return;
                }

                // ✅ Success case
                const markdownText =
                    data.choices?.[0]?.message?.content ||
                    data.choices?.[0]?.content ||
                    "⚠️ No response received.";

                botMessage.querySelector(".bubble").innerHTML = marked.parse(markdownText);

                // Save bot reply to history
                conversationHistory.push({ role: "assistant", content: markdownText });

            } catch (error) {
                botMessage.querySelector(".bubble").innerText = "Error: " + error.message;
            }

            chatbox.scrollTop = chatbox.scrollHeight;
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

