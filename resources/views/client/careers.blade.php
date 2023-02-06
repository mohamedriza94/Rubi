@extends('layouts.client')

@section('content')

<!-- Page Title Start -->
<section class="page-title title-bg23">
    <div class="d-table">
        <div class="d-table-cell">
            <h2>{{ $title }}</h2>
            <ul>
                <li>
                    <a href="{{ route('client.home') }}">Home</a>
                </li>
                <li>{{ $title }}</li>
            </ul>
        </div>
    </div>
    <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</section>
<!-- Page Title End -->

<!-- Job Section End -->   
<section class="job-style-two job-list-section pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <h2>Careers</h2>
            <p>Work with our businesses</p>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="job-card-two">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <div class="company-logo">
                                <a href="job-details.html">
                                    <img src="assets/img/company-logo/1.png" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="job-info">
                                <h3>
                                    <a href="#">Web Designer, Graphic Designer, UI/UX Designer </a>
                                </h3>
                                <ul>                                          
                                    <li>
                                        <i class='bx bx-briefcase' ></i>
                                        Graphics Designer
                                    </li>
                                    <li>
                                        <i class='bx bx-briefcase' ></i>
                                        $35000-$38000
                                    </li>
                                    <li>
                                        <i class='bx bx-location-plus'></i>
                                        Wellesley Rd, London
                                    </li>
                                    <li>
                                        <i class='bx bx-stopwatch' ></i>
                                        9 days ago
                                    </li>
                                </ul>
                                
                                <div>
                                    <span>Full Time</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="theme-btn text-end">
                                <a href="{{ route('client.jobDetails') }}" class="default-btn">
                                    Browse Job
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                
                <li class="page-item">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                        <i class='bx bx-chevrons-left bx-fade-left'></i>
                    </a>
                </li>
                
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class='bx bx-chevrons-right bx-fade-right'></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</section>
<!-- Job Section End -->  

@endsection