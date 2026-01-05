@extends('master.layout')
@section('content')

    <style>
        .partner-card {
            border-radius: 16px; /* Rounded square effect */
            background-color: #f7f9fd;
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .partner-card:hover {
            transform: scale(1.05);
        }
        .partner-card img {
            max-width: 150px;
            height: auto;
        }
        .partner-card p {
            margin-top: auto;
            margin-bottom: 0;
            color: black;
        }

        .testimonial-item {
            height: 100%;
            min-height: 400px; /* Adjust based on your design */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .testimonial-item .p-4 {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .testimonial-bubble {
            position: relative;
            border-radius: 20px;
            background: linear-gradient(to right, #c1c8e4, #c4fff9);
        }
        .testimonial-bubble::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 40px;
            width: 0;
            height: 0;
            border: 20px solid transparent;
            border-top-color: #c4fff9;
        }

    </style>
        <!-- Hero Start -->
        <div class="container-fluid py-5 hero-header wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-7 col-md-12">
                        <h1 class="mb-3 text-white" style="font-weight: bold; font-size: 23px;">Track Your Baby's Growth with Confidence</h1>
                        <h1 class="mb-5 display-1 text-white" style="font-weight: bold; font-size: 65px !important;">All-in-One Wellness Platform for Malaysian Parents</h1>
                        <a href="{{ route('register') }}" class="btn btn-primary px-4 py-3 px-md-5  me-4 btn-border-radius b" style="background: linear-gradient(to right, #c1c8e4, #c4fff9) !important; color: #4D65F9  !important;">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->

        <!-- About Start -->
        <div class="container-fluid py-5 about" style="background-color: white; !important">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                        <div class="video border">
                            <button type="button" class="btn btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                                <span></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                        <h4 class="mb-4 border-bottom border-2 d-inline-block p-2 title-border-radius" style="color: #393d72; border-bottom: 1px solid #4a92d9 !important;">About Us</h4>
                        <h1 class="text-dark mb-4 display-5">Empowering Parents, Nurturing Growth</h1>
                        <p class="text-dark mb-4">At TinyTrack, we believe every child deserves the best start in life.
                            Our platform is designed to support Malaysian parents with smart, reliable tools to track baby wellness,
                            growth, and developmental milestones — all in one place. From health metrics to doctor visits,
                            TinyTrack makes parenting easier, informed, and more confident.
                        </p>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Height & Weight Monitoring</h6>
                                <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Developmental Milestones Tracking</h6>
                                <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Check-up & Vaccination Reminders</h6>
                            </div>
                            <div class="col-lg-6">
                                <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Friendly & Safe User Experience</h6>
                                <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Expert-Backed Tips & Resources</h6>
                                <h6><i class="fas fa-check-circle me-2 text-secondary"></i>Secure Data Protection</h6>
                            </div>
                        </div>
                        <button button type="button" class="btn btn-primary px-5 py-3 btn-border-radius" data-bs-toggle="modal" data-bs-target="#moreDetailsModal" style="background: linear-gradient(to right, #c1c8e4, #c4fff9) !important;">More Details</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Video -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">TinyTrack Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- 16:9 aspect ratio -->
                        <div class="ratio ratio-16x9">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/wMQQ0N_5bmM?si=AzWjUaKWGkMq7Uli" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Service Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius" style="border-bottom: 1px solid #4a92d9 !important;">What We Do</h4>
                    <h1 class="mb-5 display-3">Empowering Parenthood with TinyTrack</h1>
                </div>
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                        <div class="text-center border-primary border bg-white service-item">
                            <div class="service-content d-flex align-items-center justify-content-center p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="h4">Baby Growth Tracker</a>
                                    <p class="my-3" style="color: black">Easily track your baby's height, weight, and growth progress. TinyTrack simplifies wellness monitoring with clear visuals and organized records.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.3s">
                        <div class="text-center border-primary border bg-white service-item">
                            <div class="service-content d-flex align-items-center justify-content-center p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="h4">Health Check Reminders</a>
                                    <p class="my-3" style="color: black">Never miss a check-up again. Get timely reminders for vaccinations, doctor visits, and routine baby care appointments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.5s">
                        <div class="text-center border-primary border bg-white service-item">
                            <div class="service-content d-flex align-items-center justify-content-center p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="h4">Expert Insights</a>
                                    <p class="my-3" style="color: black">Access credible advice and tips from health professionals and parenting experts — all in one place.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.7s">
                        <div class="text-center border-primary border bg-white service-item">
                            <div class="service-content d-flex align-items-center justify-content-center p-4">
                                <div class="service-content-inner">
                                    <a href="#" class="h4">Learn & Grow</a>
                                    <p class="my-3" style="color: black">Explore a library of bite-sized educational resources, curated to guide you through your baby's early milestones and needs.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->

        <!-- Partners Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius" style="color: #393d72; border-bottom: 1px solid #4a92d9 !important;">Our Partners</h4>
                </div>

                <div class="row g-4 justify-content-center wow fadeIn" data-wow-delay="0.3s">

                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <a href="https://www.moh.gov.my/" target="_blank" style="text-decoration: none;">
                            <div class="p-3 border border-primary img-border-radius partner-card" style="background-color: #f7f9fd;">
                                <img src="img/moh.png" class="img-fluid p-2" style="max-width: 150px; height: auto;" alt="Ministry of Health Malaysia Logo">
                                <p class="mt-2 mb-0 fw-bold">Kementerian Kesihatan <br> Malaysia</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <a href="https://www.who.int/" target="_blank" style="text-decoration: none;">
                            <div class="p-3 border border-primary img-border-radius partner-card" style="background-color: #f7f9fd;">
                                <img src="img/who.png" class="img-fluid p-2" style="max-width: 150px; height: auto;" alt="World Health Organization Logo">
                                <p class="mt-2 mb-0 fw-bold">World Health Organization (WHO)</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <a href="https://www.unicef.org/" target="_blank" style="text-decoration: none;">
                            <div class="p-3 border border-primary img-border-radius partner-card" style="background-color: #f7f9fd;">
                                <img src="img/unicef.png" class="img-fluid p-2" style="max-width: 150px; height: auto;" alt="UNICEF Logo">
                                <p class="mt-2 mb-0 fw-bold">UNICEF</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 text-center">
                        <a href="https://mpaeds.my/" target="_blank" style="text-decoration: none;">
                            <div class="p-3 border border-primary img-border-radius partner-card" style="background-color: #f7f9fd;">
                                <img src="img/mpa.png" class="img-fluid p-2" style="max-width: 150px; height: auto;" alt="Malaysian Paediatric Association Logo">
                                <p class="mt-2 mb-0 fw-bold">Malaysian Paediatric<br> Association</p>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- Partners End -->

        <!-- Testimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius" style="color: #393d72; border-bottom: 1px solid #4a92d9 !important;">Our Testimonials</h4>
                    <h1 class="mb-5 display-3">Parents Say About Us</h1>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
                    <div class="testimonial-item img-border-radius border border-primary p-4 testimonial-bubble">
                        <div class="p-4 position-relative">
                            <i class="fa fa-quote-right fa-2x position-absolute" style="top: 15px; right: 15px; color: #393d72;"></i>
                            <div class="d-flex align-items-center">
                                <div class="border border-primary bg-white rounded-circle">
                                    <img src="img/testimonial-1.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: #393d72;" alt="">
                                </div>
                                <div class="ms-4">
                                    <h4 class="text-dark">Zarinah</h4>
                                    <p class="m-0 pb-3">Teacher</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top border-primary mt-4 pt-3">
                                <p class="mb-0">TinyTrack has been a game changer for me as a new mom. I can easily track my baby's growth and never miss a check-up. The reminders are super helpful and the dashboard is so easy to understand!,
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius border border-primary p-4 testimonial-bubble">
                        <div class="p-4 position-relative">
                            <i class="fa fa-quote-right fa-2x position-absolute" style="top: 15px; right: 15px; color: #393d72;"></i>
                            <div class="d-flex align-items-center">
                                <div class="border border-primary bg-white rounded-circle">
                                    <img src="img/testimonial-2.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: #393d72;" alt="">
                                </div>
                                <div class="ms-4">
                                    <h4 class="text-dark">Dr. Amir</h4>
                                    <p class="m-0 pb-3">Pediatrician</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top border-primary mt-4 pt-3">
                                <p class="mb-0">As a healthcare professional, I love recommending TinyTrack to parents. It promotes early awareness and proactive care. The educational resources are well-structured and trustworthy.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius border border-primary p-4 testimonial-bubble">
                        <div class="p-4 position-relative">
                            <i class="fa fa-quote-right fa-2x position-absolute" style="top: 15px; right: 15px; color: #393d72;"></i>
                            <div class="d-flex align-items-center">
                                <div class="border border-primary bg-white rounded-circle">
                                    <img src="img/testimonial-3.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: #393d72;" alt="">
                                </div>
                                <div class="ms-4">
                                    <h4 class="text-dark">Nurul Aina</h4>
                                    <p class="m-0 pb-3">Engineer</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                        <i class="fas fa-star" style="color: yellow;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top border-primary mt-4 pt-3">
                                <p class="mb-0">With a busy schedule, TinyTrack makes it easier for me to stay on top of my child's development. It's like having a baby wellness assistant right in my pocket!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

        <!-- Hidden Modal -->
        <div class="modal fade" id="moreDetailsModal" tabindex="-1" aria-labelledby="moreDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

            <!-- Header with Close Button -->
            <div class="modal-header">
                <h5 class="modal-title" id="moreDetailsModalLabel">TinyTrack Features & Benefits</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <ul class="list-unstyled">
                <li><i class="fa fa-check text-primary me-2"></i> Centralized growth tracking (height, weight, milestones)</li>
                <li><i class="fa fa-check text-primary me-2"></i> Vaccination & appointment reminders</li>
                <li><i class="fa fa-check text-primary me-2"></i> Personalized dashboards for multiple children</li>
                <li><i class="fa fa-check text-primary me-2"></i> Expert-backed parenting tips aligned with MOH guidelines</li>
                <li><i class="fa fa-check text-primary me-2"></i> Interactive growth charts with AI recommendations</li>
                <li><i class="fa fa-check text-primary me-2"></i> Secure data protection & user-friendly design</li>
                </ul>

                <h4 class="mt-4">📊 Comparison with Existing Apps</h4>
                <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>Feature</th>
                    <th>TinyTrack</th>
                    <th>Other Apps</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Localized for Malaysian families</td><td>✅ Yes</td><td>❌ Mostly generic</td></tr>
                    <tr><td>MOH guideline integration</td><td>✅ Yes</td><td>❌ No</td></tr>
                    <tr><td>Multiple child profiles</td><td>✅ Supported</td><td>❌ Limited</td></tr>
                    <tr><td>AI-driven recommendations</td><td>✅ Available</td><td>❌ Rare</td></tr>
                </tbody>
                </table>

                <h4 class="mt-4">📸 Screenshots</h4>
                <div class="row">
                <div class="col-md-4">
                    <img src="img/dashboard.png" class="img-fluid rounded shadow" alt="TinyTrack Dashboard">
                    <p class="text-center mt-2">Dashboard Overview</p>
                </div>
                <div class="col-md-4">
                    <img src="img/growth-chart.png" class="img-fluid rounded shadow" alt="Growth Chart">
                    <p class="text-center mt-2">Growth Chart</p>
                </div>
                <div class="col-md-4">
                    <img src="img/milestones.png" class="img-fluid rounded shadow" alt="Milestones Tracker">
                    <p class="text-center mt-2">Milestones Tracker</p>
                </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
        </div>
        <!-- End of Hidden Modal -->

    <script>
    function toggleDetails() {
        var content = document.getElementById("moreDetailsContent");
        if (content.style.display === "none") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
    </script>
@endsection
