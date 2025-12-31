@extends('master.layout')
@section('content')
    {{-- Expert Page Content --}}
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius" style="color: #393d72; border-bottom: 1px solid #4a92d9 !important;">Our Expert Tips</h4>
                    <h1 class="mb-5 display-3">What Experts Say</h1>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
                    <div class="testimonial-item img-border-radius border border-primary p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9) !important;">
                        <div class="p-4 position-relative">
                            <i class="fa fa-quote-right fa-2x position-absolute" style="top: 15px; right: 15px; color: #393d72;"></i>
                            <div class="d-flex align-items-center">
                                <div class="border border-primary bg-white rounded-circle">
                                    <img src="img/doctor-maimunah.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: #393d72;" alt="">
                                </div>
                                <div class="ms-4">
                                    <h4 class="text-dark">Dr. Maimunah</h4>
                                    <p class="m-0 pb-3">Pediatrician</p>
                                </div>
                            </div>
                            <div class="border-top border-primary mt-4 pt-3">
                                <p class="mb-0">Keep regular vaccination schedules and contact your pediatrician if fever persists beyond 48 hours.</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius border border-primary p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9) !important;">
                        <div class="p-4 position-relative">
                            <i class="fa fa-quote-right fa-2x position-absolute" style="top: 15px; right: 15px; color: #393d72;"></i>
                            <div class="d-flex align-items-center">
                                <div class="border border-primary bg-white rounded-circle">
                                    <img src="img/rina.jpg" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: #393d72;" alt="">
                                </div>
                                <div class="ms-4">
                                    <h4 class="text-dark">Rina</h4>
                                    <p class="m-0 pb-3">Parent</p>
                                </div>
                            </div>
                            <div class="border-top border-primary mt-4 pt-3">
                                <p class="mb-0">Try to keep your baby's routine consistent — naps and feeding times help with better sleep and mood.</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius border border-primary p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9) !important;">
                        <div class="p-4 position-relative">
                            <i class="fa fa-quote-right fa-2x position-absolute" style="top: 15px; right: 15px; color: #393d72;"></i>
                            <div class="d-flex align-items-center">
                                <div class="border border-primary bg-white rounded-circle">
                                    <img src="img/nurse.webp" class="rounded-circle p-2" style="width: 80px; height: 80px; border-style: dotted; border-color: #393d72;" alt="">
                                </div>
                                <div class="ms-4">
                                    <h4 class="text-dark">Nurse Siti</h4>
                                    <p class="m-0 pb-3">Nurse</p>
                                </div>
                            </div>
                            <div class="border-top border-primary mt-4 pt-3">
                                <p class="mb-0">Gentle tummy massage after feeding can relieve gas; always burp the baby in an upright position.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

    {{--End Content--}}
@endsection
