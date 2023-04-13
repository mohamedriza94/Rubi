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
            
            @foreach($vacancies as $vacancy)
            
            @php
            $business = \App\Models\Business::find($vacancy->business);
            @endphp
            
            <div class="col-lg-12">
                <div class="job-card-two">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <div class="company-logo">
                                <a>
                                    <img src="{{ $business->photo }}" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="job-info">
                                <h3>
                                    <a href="#">{{ $vacancy->position }}</a>
                                </h3>
                                <ul>                                          
                                    <li>
                                        <i class='bx bx-briefcase' ></i>
                                        {{ $vacancy->salaryRange }}
                                    </li>
                                    <li>
                                        <i class='bx bx-briefcase' ></i>
                                        {{ $vacancy->type }}
                                    </li>
                                    <li>
                                        <i class='bx bx-location-plus'></i>
                                        {{ $business->country }}
                                    </li>
                                    <li>
                                        <i class='bx bx-stopwatch' ></i>
                                        {{ \Carbon\Carbon::parse($vacancy->created_at)->format('Y-m-d') }}

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="theme-btn text-end">
                                <a href="{{ url('/Job+Details') }}/{{ $vacancy->id }}" class="default-btn">
                                    Browse Job
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
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