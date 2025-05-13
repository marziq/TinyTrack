@extends('master.layout')
@section('content')
    <style>
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
    <h1 style="text-align: center; font-weight: bold; padding: 32px 0 24px 0; letter-spacing: 1px; color: #1976d2;">Our Experts Tips</h1>
    <div class="topics-section">
        <button class="slider-btn prev-btn" onclick="moveSlide(-1)">&#10094;</button>
        <div class="slider-container">
            <div class="slider-track">
                <!-- Bonding Topic -->
                <div class="topic-card">
                    <img src="{{ asset('img/bonding.jpg') }}" alt="Bonding" class="topic-image">
                    <h3>Bonding</h3>
                    <ul class="topic-list">
                        <li><button onclick="showInfo('bonding1')">Skin-to-Skin Cuddles</button></li>
                        <li><button onclick="showInfo('bonding2')">Gentle Baby Massage</button></li>
                        <li><button onclick="showInfo('bonding3')">Talk & Sing to Baby</button></li>
                        <li><button onclick="showInfo('bonding4')">Tummy Time Play</button></li>
                        <li><button onclick="showInfo('bonding5')">Help Baby Learn Language</button></li>
                        <li><button onclick="showInfo('bonding6')">How to Build Trust with Your Baby</button></li>
                    </ul>
                </div>

                <!-- Early Sensory Topic -->
                <div class="topic-card">
                    <img src="{{ asset('img/earlysensory.jpg') }}" alt="Early Senses" class="topic-image">
                    <h3>Early Sensory</h3>
                    <ul class="topic-list">
                        <li><button onclick="showInfo('sensory1')">Eye Contact & Smiles</button></li>
                        <li><button onclick="showInfo('sensory2')">Respond to Sounds</button></li>
                        <li><button onclick="showInfo('sensory3')">Touch & Texture Play</button></li>
                        <li><button onclick="showInfo('sensory4')">Watch for Jaundice</button></li>
                        <li><button onclick="showInfo('sensory5')">The "Balance" Sense</button></li>
                        <li><button onclick="showInfo('sensory6')">How to Stimulate Baby's Vision</button></li>
                    </ul>
                </div>

                <!-- Sleep and Routines Topic -->
                <div class="topic-card">
                    <img src="{{ asset('img/sleep.jpeg') }}" alt="sleep" class="topic-image">
                    <h3>Sleep and Routines</h3>
                    <ul class="topic-list">
                        <li><button onclick="showInfo('sleep1')">How Much Sleep Does Baby Need?</button></li>
                        <li><button onclick="showInfo('sleep2')">Creating a Bedtime Routine</button></li>
                        <li><button onclick="showInfo('sleep3')">Back is Best</button></li>
                        <li><button onclick="showInfo('sleep4')">Avoid Baby Walkers</button></li>
                        <li><button onclick="showInfo('sleep5')">Create Calm Nights</button></li>
                    </ul>
                </div>

                <!-- Feeding and Nutrition Topic -->
                <div class="topic-card">
                    <img src="{{ asset('img/feeding.jpg') }}" alt="feeding" class="topic-image">
                    <h3>Feeding and Nutrition</h3>
                    <ul class="topic-list">
                        <li><button onclick="showInfo('feeding1')">Breastfeeding Basics</button></li>
                        <li><button onclick="showInfo('feeding2')">Exclusive Breastfeeding (0–6 Months)</button></li>
                        <li><button onclick="showInfo('feeding3')">Feed on Demand</button></li>
                        <li><button onclick="showInfo('feeding4')">Start Solids at 6 Months</button></li>
                        <li><button onclick="showInfo('feeding5')">No Sugar, No Honey</button></li>
                    </ul>
                </div>

                <!-- Safety and Hygiene Topic -->
                <div class="topic-card">
                    <img src="{{ asset('img/hygiene.jpg') }}" alt="Safety and Hygiene" class="topic-image">
                    <h3>Safety & Hygiene</h3>
                    <ul class="topic-list">
                        <li><button onclick="showInfo('safety1')">Wash Hands Often</button></li>
                        <li><button onclick="showInfo('safety2')">Bathe with Care</button></li>
                        <li><button onclick="showInfo('safety3')">No Baby Alone</button></li>
                        <li><button onclick="showInfo('safety4')">Choose Safe Toys</button></li>
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
                    title: 'Skin-to-Skin Cuddles',
                    content: 'Explore the science and tradition behind skin-to-skin cuddles — a beautiful first step in bonding that supports your baby’s health, emotional well-being and development from the very first hours of life.',
                    additionalText: 'Skin-to-skin contact also helps regulate your baby’s temperature, heart rate, and breathing. It promotes bonding and can even help with breastfeeding success.',
                    heroImage: '{{ asset("img/skintoskin2.jpeg") }}', // Replace with actual image path
                    videoUrl: 'https://www.youtube.com/embed/VOjGhwMuWFU?si=EEowDG50bdKRLGHo', // Replace with actual video URL
                    title2: '</br>What Is Skin-to-Skin Contact?',
                    additionalText2: 'Skin-to-skin contact, also known as kangaroo care, is when a newborn (usually wearing just a diaper) is placed directly against the bare chest of a parent. This natural method is recommended right after birth and can be practiced daily during the baby’s first year. It helps babies feel safe, warm, and calm — and encourages parents to feel more confident in caring for their newborn.',
                    title3: '</br>Why It Matters for Malaysian Parents',
                    additionalText3: 'According to the Child Health Record Book issued by the Ministry of Health Malaysia, early care and close bonding are essential for your baby’s development. Although the book may not use the exact phrase "skin-to-skin," it strongly encourages immediate closeness after birth and exclusive breastfeeding for the first six months — both of which are supported by skin-to-skin cuddles. This practice is also aligned with public health advice in Malaysia to promote breastfeeding, bonding, and safer sleep patterns in babies.',
                    title4:'</br>Benefits of Skin-to-Skin Cuddles',
                    additionalText4: '- Regulates your baby’s body temperature, heartbeat and breathing <br/> - Encourages exclusive breastfeeding by triggering natural milk supply. </br> - Reduces crying, supports better sleep, and lowers stress for both baby and parent. </br> - Boosts baby immune system and healthy weight gain </br> Strengthens emotional bonding and early brain development.',
                    title5: '</br> Expert Tip From Malaysian Healthcare',
                    additionalText5: '“Skin-to-skin care, even for a few minutes a day, can help parents feel more connected and confident, while giving babies a better start in life.” </br> — Nurse Supervisor, Klinik Kesihatan Selangor'
                },
                bonding2: {
                    title: 'Skin-to-Skin & Baby Massage Tips',
                    content: 'Skin-to-skin contact helps regulate your baby’s temperature and heartbeat. Baby massage can soothe and relax your baby.',
                    heroImage: '{{ asset("img/baby-massage.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL

                },
                bonding3: {
                    title: 'Skin-to-Skin & Baby Massage Tips',
                    content: 'Skin-to-skin contact helps regulate your baby’s temperature and heartbeat. Baby massage can soothe and relax your baby.',
                    heroImage: '{{ asset("img/baby-massage.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL

                },
                bonding4: {
                    title: 'Tummy Time Play',
                    content: 'Tummy time is important for your baby’s development. It helps strengthen their neck, shoulders, and back muscles.',
                    heroImage: '{{ asset("img/tummy-time.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                bonding5: {
                    title: 'Help Baby Learn Language',
                    content: 'Talking and singing to your baby helps them learn language. It’s never too early to start reading to your baby!',
                    heroImage: '{{ asset("img/language-learning.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                bonding6: {
                    title: 'How to Build Trust with Your Baby',
                    content: 'Building trust with your baby is important for their emotional development. Responding to their needs helps build this trust.',
                    heroImage: '{{ asset("img/build-trust.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory1: {
                    title: 'Eye Contact & Smiles',
                    content: 'From the very first gaze to their very first smile — learn how your baby uses these powerful early interactions to bond with you, grow emotionally and develop key brain functions during their first year.',
                    heroImage: '{{ asset("img/eye-contact.jpg") }}',
                    additionalText: 'This Malaysian parenting segment explains how eye contact and facial expressions help babies recognise, connect and communicate. Watch how small actions can spark big developments in your little one.',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id', // Replace with actual video URL
                    title2: 'What Is Eye Contact and Smiling in Baby Development?',
                    additionalText2: 'Eye contact and smiling are two of the very first ways your baby interacts with the world. As early as a few weeks old, babies begin to focus on faces — especially those of parents and caregivers. Smiling is often their first social behaviour.',
                    additionalText3: 'The Child Health Record Book by the Ministry of Health Malaysia includes these milestones in its early screening checklist: <br/> <ul><li> Does your child look at your face when you speak?</li><li>Does your child look into your eyes?</li> <li> Does your child smile in response to your face or voice?</li></ul> These actions are important indicators of emotional growth and healthy brain development.',
                },
                sensory2: {
                    title: 'Respond to Sounds',
                    content: 'Your baby is learning to recognize your voice and other sounds around them. Responding to sounds helps your baby learn about their world.',
                    additionalText: 'Play soft music or talk to your baby. This helps them learn to recognize different sounds and voices.',
                    heroImage: '{{ asset("img/respond-to-sounds.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory3: {
                    title: 'Touch & Texture Play',
                    content: 'Your baby is learning about the world through touch. Different textures can help stimulate your baby’s senses.',
                    heroImage: '{{ asset("img/touch-texture.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory4: {
                    title: 'Watch for Jaundice',
                    content: 'Jaundice is common in newborns. It’s important to monitor your baby for signs of jaundice and seek medical advice if necessary.',
                    heroImage: '{{ asset("img/jaundice.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory5: {
                    title: 'The "Balance" Sense',
                    content: 'Your baby is learning to balance and coordinate their movements. This is an important part of their physical development.',
                    heroImage: '{{ asset("img/balance-sense.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sensory6: {
                    title: 'How to Stimulate Baby\'s Vision',
                    content: 'Your baby’s vision is developing rapidly. There are many ways to stimulate your baby’s vision and help them learn.',
                    heroImage: '{{ asset("img/stimulate-vision.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep1: {
                    title: 'How Much Sleep Does Baby Need?',
                    content: 'Newborns sleep a lot! They need about 14-17 hours of sleep a day. This includes naps and nighttime sleep.',
                    heroImage: '{{ asset("img/sleep-needs.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep2: {
                    title: 'Creating a Bedtime Routine',
                    content: 'A consistent bedtime routine can help your baby learn when it’s time to sleep. This can include activities like bathing, reading, and cuddling.',
                    heroImage: '{{ asset("img/bedtime-routine.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep3: {
                    title: 'Back is Best',
                    content: 'Always place your baby on their back to sleep. This helps reduce the risk of Sudden Infant Death Syndrome (SIDS).',
                    heroImage: '{{ asset("img/back-is-best.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep4: {
                    title: 'Avoid Baby Walkers',
                    content: 'Baby walkers can be dangerous. They can lead to falls and injuries. It’s best to avoid using them.',
                    heroImage: '{{ asset("img/avoid-walkers.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                sleep5: {
                    title: 'Create Calm Nights',
                    content: 'Creating a calm and quiet environment can help your baby sleep better. This includes dimming the lights and reducing noise.',
                    heroImage: '{{ asset("img/calm-nights.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding1: {
                    title: 'Breastfeeding Basics',
                    content: 'Breastfeeding is the best way to feed your baby. It provides all the nutrients your baby needs.',
                    heroImage: '{{ asset("img/breastfeeding.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding2: {
                    title: 'Exclusive Breastfeeding (0–6 Months)',
                    content: 'Exclusive breastfeeding is recommended for the first 6 months. This means no other foods or drinks, not even water.',
                    heroImage: '{{ asset("img/exclusive-breastfeeding.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding3: {
                    title: 'Feed on Demand',
                    content: 'Feed your baby whenever they show signs of hunger. This helps ensure they get enough milk.',
                    heroImage: '{{ asset("img/feed-on-demand.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding4: {
                    title: 'Start Solids at 6 Months',
                    content: 'Introduce solid foods around 6 months. Start with single-grain cereals and pureed fruits and vegetables.',
                    heroImage: '{{ asset("img/start-solids.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                feeding5: {
                    title: 'No Sugar, No Honey',
                    content: 'Avoid giving your baby sugar and honey. These can be harmful to their health.',
                    heroImage: '{{ asset("img/no-sugar.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety1: {
                    title: 'Wash Hands Often',
                    content: 'Washing hands often helps prevent the spread of germs. Make sure to wash your hands before handling your baby.',
                    heroImage: '{{ asset("img/wash-hands.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety2: {
                    title: 'Bathe with Care',
                    content: 'Bathing your  baby is important for hygiene. Make sure to use gentle products and be careful with water temperature.',
                    heroImage: '{{ asset("img/bathe-with-care.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety3: {
                    title: 'No Baby Alone',
                    content: 'Never leave your baby alone on a high surface. Always keep an eye on them to prevent falls.',
                    heroImage: '{{ asset("img/no-baby-alone.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                },
                safety4: {
                    title: 'Choose Safe Toys',
                    content: 'Make sure to choose age-appropriate toys for your baby. Avoid toys with small parts that can be a choking hazard.',
                    heroImage: '{{ asset("img/safe-toys.jpg") }}',
                    videoUrl: 'https://www.youtube.com/embed/example-video-id' // Replace with actual video URL
                }

            };

            // Update the info section with the selected topic
            if (topics[topicId]) {
                const topic = topics[topicId];

                // Check if the topic is already in favourites
                const favourites = JSON.parse(localStorage.getItem('favourites')) || [];
                const isFavourite = favourites.includes(topicId);


                // Build the content dynamically
                infoContent.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="color: #1976d2; margin: 0;">${topic.title}</h3>
                        <button id="favouriteButton" class="btn btn-primary" style="margin-left: 20px;">
                            ${isFavourite ? 'Remove from Favourites' : 'Add to Favourites'}
                        </button>
                    </div>
                    <p><br>${topic.content}</p>
                    ${topic.additionalText ? `
                        <div style="margin: 0 auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            </br> ${topic.additionalText}
                        </div>` : ''}
                    ${topic.heroImage ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center;">
                            <img src="${topic.heroImage}" alt="${topic.title}" style="width:100%; border-radius:10px;">
                        </div>` : ''}
                    ${topic.videoUrl ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center;">
                            <iframe width="100%" height="315" src="${topic.videoUrl}" frameborder="0" allowfullscreen style="border-radius:10px;"></iframe>
                        </div>` : ''}
                    ${topic.title2 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title2}</h3>` : ''}
                    ${topic.additionalText2 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            ${topic.additionalText2}
                        </div>` : ''}
                    ${topic.title3 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title3}</h3>` : ''}
                    ${topic.additionalText3 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            ${topic.additionalText3}
                        </div>` : ''}
                    ${topic.title4 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title4}</h3>` : ''}
                    ${topic.additionalText4 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: justify; line-height: 1.6; color: #555;">
                            ${topic.additionalText4}
                        </div>` : ''}
                    ${topic.title5 ? `<h3 style="color: #1976d2; text-align: center;">${topic.title5}</h3>` : ''}
                    ${topic.additionalText5 ? `
                        <div style="margin: 20px auto; max-width: 600px; text-align: center; line-height: 1.6; color: #555;">
                            ${topic.additionalText5}
                        </div>` : ''}
                `;

                infoSection.style.display = 'block'; // Show the info section
                // Add event listener for the favourite button
                const favouriteButton = document.getElementById('favouriteButton');
                favouriteButton.addEventListener('click', function () {
                    const favourites = JSON.parse(localStorage.getItem('favourites')) || [];
                    const index = favourites.indexOf(topicId);

                    if (index === -1) {
                        // Add to favourites
                        favourites.push(topicId);
                        favouriteButton.textContent = 'Remove from Favourites';
                    } else {
                        // Remove from favourites
                        favourites.splice(index, 1);
                        favouriteButton.textContent = 'Add to Favourites';
                    }

                    // Update local storage
                    localStorage.setItem('favourites', JSON.stringify(favourites));
                });
            }
        }
    </script>
@endsection
