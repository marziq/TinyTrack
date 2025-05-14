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
                            TinyTrack is a platform designed to help parents track and support their child's early development with expert tips and resources.
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
                            Yes, TinyTrack values your privacy. Your data is securely stored and never shared with third parties without your consent.
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
