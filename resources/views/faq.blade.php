@extends('master.layout')
@section('content')

        <!-- FAQ Start -->
        <div class="container py-5">
            <div class="mx-auto text-center mb-5" style="max-width: 700px;">
                <h4 class="text-secondary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">FAQ</h4>
                <h1 class="mb-4 display-4">Frequently Asked Questions</h1>
                <p class="lead" style="color: black;">Find answers to the most common questions below.</p>
            </div>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                            What is TinyTrack?
                        </button>
                    </h2>
                    <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            The TinyTrack: Digital Baby Wellness and Growth Platform is designed to address the challenges faced by parents in monitoring the early development stages of their children.
                            The purpose of this project is to develop a user-friendly, web-based system that centralizes and simplifies baby wellness management.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                            How do I use the expert tips?
                        </button>
                    </h2>
                    <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            Browse the expert tips section, select a topic, and read the detailed advice. You can also save your favourite tips for quick access.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseEight" aria-expanded="false" aria-controls="faqCollapseEight">
                            Can I track multiple children with one account?
                        </button>
                    </h2>
                    <div id="faqCollapseEight" class="accordion-collapse collapse" aria-labelledby="faqHeadingEight" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            Yes, TinyTrack allows you to manage profiles for multiple children under a single account, making it easy to monitor each child's growth and wellness individually.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTen" aria-expanded="false" aria-controls="faqCollapseTen">
                            Can I export my child's progress data?
                        </button>
                    </h2>
                    <div id="faqCollapseTen" class="accordion-collapse collapse" aria-labelledby="faqHeadingTen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            No, TinyTrack does not provides an option to export your child's growth and wellness data.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingTwelve">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwelve" aria-expanded="false" aria-controls="faqCollapseTwelve">
                            Does TinyTrack support reminders for appointments or vaccinations?
                        </button>
                    </h2>
                    <div id="faqCollapseTwelve" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwelve" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            Absolutely! You can set reminders for upcoming pediatric appointments, vaccinations, and wellness check-ins directly from your dashboard.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                            Is TinyTrack free to use?
                        </button>
                    </h2>
                    <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            Yes, TinyTrack offers free access to all its core features and expert content.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingThirteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThirteen" aria-expanded="false" aria-controls="faqCollapseThirteen">
                            What kind of milestones can I track?
                        </button>
                    </h2>
                    <div id="faqCollapseThirteen" class="accordion-collapse collapse" aria-labelledby="faqHeadingThirteen" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            TinyTrack helps you monitor physical, cognitive, emotional, and social milestones from birth through toddler years.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                            Do I need to create an account to use TinyTrack?
                        </button>
                    </h2>
                    <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            No, you can browse expert tips and resources without an account. However, creating an account allows you to save your favourite tips and track your child's progress.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                            Is my data safe and private?
                        </button>
                    </h2>
                    <div id="faqCollapseFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            At TinyTrack, protecting your privacy is our top priority. All personal information you provide is securely stored using industry‑standard safeguards, and we never share your data with third parties without your explicit consent.
                            <br><br>
                            As a platform designed for Malaysian parents, TinyTrack complies with the <strong>Personal Data Protection Act (PDPA 2010)</strong>, which governs how personal data is collected, used, and safeguarded in Malaysia. This means:
                            <ul>
                                <li>Your data is only used for the purposes you agree to, such as improving your experience on TinyTrack.</li>
                                <li>You have the right to access, update, or request deletion of your personal information at any time.</li>
                                <li>We will never sell or misuse your data, and any sharing (for example, with healthcare partners) will only happen with your clear consent.</li>
                            </ul>
                            In short, your information is treated with the highest level of confidentiality and respect, in line with Malaysian law and our commitment to earning your trust.
                        </div>
                    </div>
                </div>
                                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseSix" aria-expanded="false" aria-controls="faqCollapseSix">
                            Can I access TinyTrack on my mobile device?
                        </button>
                    </h2>
                    <div id="faqCollapseSix" class="accordion-collapse collapse" aria-labelledby="faqHeadingSix" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            Absolutely! TinyTrack is fully responsive and works on smartphones, tablets, and desktops.
                        </div>
                    </div>
                </div>
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="faqHeadingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseSeven" aria-expanded="false" aria-controls="faqCollapseSeven">
                            Who writes the expert tips on TinyTrack?
                        </button>
                    </h2>
                    <div id="faqCollapseSeven" class="accordion-collapse collapse" aria-labelledby="faqHeadingSeven" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color: black;">
                            Our expert tips are written and reviewed by certified pediatricians, child development specialists, and experienced parents.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQ End -->
@endsection
