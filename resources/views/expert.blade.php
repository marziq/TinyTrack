@extends('master.layout')
@section('content')
    {{-- Expert Page Content --}}
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius" style="color: #393d72; border-bottom: 1px solid #4a92d9 !important;">Our Expert Tips</h4>
                    <h1 class="mb-5 display-3">What Experts Say</h1>
                </div>
                <div class="row g-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm img-border-radius border-0" style="border-radius:20px; overflow:hidden;">
                            <div class="card-body text-center p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9)">
                                <div class="mx-auto bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:200px;height:200px;border:4px dotted #393d72;">
                                    <img src="img/doctor-maimunah.jpg" class="rounded-circle" style="width:200px;height:200px;" alt="">
                                </div>
                                <h5 class="mt-3 mb-1 text-dark">Dr. Maimunah</h5>
                                <p class="text-muted small mb-3">Pediatrician</p>
                                <p class="card-text">Keep regular vaccination schedules and contact your pediatrician if fever persists beyond 48 hours.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm img-border-radius border-0" style="border-radius:20px; overflow:hidden;">
                            <div class="card-body text-center p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9)">
                                <div class="mx-auto bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:200px;height:200px;">
                                    <img src="img/rina.jpg" class="rounded-circle" style="width:200px;height:200px;" alt="">
                                </div>
                                <h5 class="mt-3 mb-1 text-dark">Rina</h5>
                                <p class="text-muted small mb-3">Parent</p>
                                <p class="card-text">Try to keep your baby's routine consistent — naps and feeding times help with better sleep and mood.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm img-border-radius border-0" style="border-radius:20px; overflow:hidden;">
                            <div class="card-body text-center p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9)">
                                <div class="mx-auto bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:200px;height:200px;border:4px dotted #393d72;">
                                    <img src="img/nurse.webp" class="rounded-circle" style="width:200px;height:200px;" alt="">
                                </div>
                                <h5 class="mt-3 mb-1 text-dark">Nurse Siti</h5>
                                <p class="text-muted small mb-3">Nurse</p>
                                <p class="card-text">Gentle tummy massage after feeding can relieve gas; always burp the baby in an upright position.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card h-100 shadow-sm img-border-radius border-0" style="border-radius:20px; overflow:hidden;">
                            <div class="card-body text-center p-4" style="background: linear-gradient(to right, #c1c8e4, #c4fff9)">
                                <div class="mx-auto bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:200px;height:200px;border:4px dotted #393d72;">
                                    <img src="img/nurse.webp" class="rounded-circle" style="width:200px;height:200px;" alt="">
                                </div>
                                <h5 class="mt-3 mb-1 text-dark">Nurse Rafidah</h5>
                                <p class="text-muted small mb-3">Nurse</p>
                                <p class="card-text">Spend time cuddling and holding your baby. This will help them feel cared for and secure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

    {{--End Content--}}
@endsection
