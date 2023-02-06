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

<!-- About Section Start -->
<section class="about-section ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-text">
                    <div class="section-title">
                        <h2>How We Started</h2>
                    </div>

                    <p>At RUBI, we believe that managing the operational and middle-level functions of a business 
                        should be simple and seamless. That's why we've created a comprehensive platform that brings 
                        together IT, HR, marketing, and finance under one roof. Our platform is designed to be 
                        user-friendly and intuitive, making it easier than ever for businesses to streamline 
                        their processes and improve efficiency. With a commitment to exceptional customer support, 
                        we are dedicated to helping businesses succeed.</p>
                        
                        <p>Our brand trademark, "RUBI: The central 
                        hub of business operations", and our slogan, "Unlock efficiency with RUBI", reflect our 
                        mission to empower businesses and help them reach their full potential. Join the RUBI 
                        revolution today!</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="assets/img/about.jpg" alt="about image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Counter Section Start -->
<section>
        <div class="counter-section pt-100 pb-70">
            <div class="container">
                <div class="row counter-area">
                    <div class="col-lg-3 col-6">
                        <div class="counter-text">
                            <i class="flaticon-resume"></i>
                            <h2><span>1225</span></h2>
                            <p>Businesses</p>
                        </div>
                    </div>
        
                    <div class="col-lg-3 col-6">
                        <div class="counter-text">
                            <i class="flaticon-recruitment"></i>
                            <h2><span>145</span></h2>
                            <p>Employees</p>
                        </div>
                    </div>
        
                    <div class="col-lg-3 col-6">
                        <div class="counter-text">
                            <i class="flaticon-portfolio"></i>
                            <h2><span>170</span></h2>
                            <p>Vacancies</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Counter Section End --> 

@endsection