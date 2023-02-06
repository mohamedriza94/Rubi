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

<!-- Pricing Section Start -->
<section class="pricing-section pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <h2>Subscribe To a Package</h2>
            <p>We offer flexible packages to meet your business needs - 
                Basic, Standard, or Premium. Get started with essential 
                features or upgrade for advanced solutions and dedicated support.</p>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="price-card">
                    <div class="price-top">
                        <h3>Basic</h3>
                        <i class='bx bx-user'></i>
                        <h2>5$ /<sub>Month</sub></h2>
                    </div>

                    <div class="price-feature">
                        <ul>
                            <li>
                                <i class='bx bx-check'></i>
                                Appear in results
                            </li>
                            <li>
                                <i class='bx bx-check'></i>
                                <strong>Accept mobile app</strong>
                            </li>
                            <li>
                                <i class='bx bx-check'></i>
                                Manage canditates directly
                            </li>
                        </ul>
                    </div>

                <div class="price-btn">
                    <a href="{{ route('client.registrationStepTwo') }}">Subscribe</a>
                </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="price-card">
                    <div class="price-top">
                        <h3>Standard</h3>
                        <i class='bx bx-user'></i>
                        <h2>5$ /<sub>Month</sub></h2>
                    </div>

                    <div class="price-feature">
                        <ul>
                            <li>
                                <i class='bx bx-check'></i>
                                Appear in results
                            </li>
                            <li>
                                <i class='bx bx-check'></i>
                                <strong>Accept mobile app</strong>
                            </li>
                            <li>
                                <i class='bx bx-check'></i>
                                Manage canditates directly
                            </li>
                        </ul>
                    </div>

                <div class="price-btn">
                    <a href="{{ route('client.registrationStepTwo') }}">Subscribe</a>
                </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="price-card">
                    <div class="price-top">
                        <h3>Premium</h3>
                        <i class='bx bx-user'></i>
                        <h2>5$ /<sub>Month</sub></h2>
                    </div>

                    <div class="price-feature">
                        <ul>
                            <li>
                                <i class='bx bx-check'></i>
                                Appear in results
                            </li>
                            <li>
                                <i class='bx bx-check'></i>
                                <strong>Accept mobile app</strong>
                            </li>
                            <li>
                                <i class='bx bx-check'></i>
                                Manage canditates directly
                            </li>
                        </ul>
                    </div>

                <div class="price-btn">
                    <a href="{{ route('client.registrationStepTwo') }}">Subscribe</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Pricing Section End -->

@endsection