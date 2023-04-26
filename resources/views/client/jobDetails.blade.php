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

@php
$business = \App\Models\Business::find($vacancy->business);
@endphp

<!-- Job Details Section Start -->
<section class="job-details ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="job-details-text">
                            <div class="job-card">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="company-logo">
                                            <img src="{{ $business->photo }}" alt="logo">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="job-info">
                                            <h3>{{ $vacancy->position }}</h3>
                                            <ul>
                                                <li>
                                                    <i class='bx bx-location-plus'></i>
                                                    {{ $business->country }}
                                                </li>
                                                <li>
                                                    <i class='bx bx-filter-alt' ></i>
                                                    {{ $vacancy->type }}
                                                </li>
                                                <li>
                                                    <i class='bx bx-briefcase' ></i>
                                                    {{ $vacancy->salaryRange }}
                                                </li>
                                            </ul>
                                            
                                            <span>
                                                <i class='bx bx-paper-plane' ></i>
                                                Apply Before: {{ $vacancy->end }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="details-text">
                                <h3>Description</h3>
                                <p>{{ $vacancy->description }}</p>
                            </div>
                            <hr>
                            <div class="details-text">
                                <h3>Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><span>Company :&nbsp;</span></td>
                                                    <td>{{ $business->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Location :&nbsp;</span></td>
                                                    <td>{{ $business->country }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Website :&nbsp;</span></td>
                                                    <td>{{ $business->website }}</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Email :&nbsp;</span></td>
                                                    <td><a href="mailto:{{ $business->email }}">{{ $business->email }}</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="contact-area">
                                    <h3>Submit your CV here to apply</h3>
                                    <form method="post" enctype="multipart/form-data" action="{{ route('applyJobPOST') }}">
                                        @csrf
                                        
                                        @if (session('success'))
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <div class="help-block" style="color:green"><b>{{ session('success') }}</b></div> 
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            
                                            <input type="hidden" name="vacancy" readonly value="{{ $vacancy->id }}">
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" required placeholder="Enter your name here">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" required placeholder="Enter your email here">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="telephone" required placeholder="Enter your mobile no. here">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="5" name="coverLetter" placeholder="Cover Letter"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Upload CV: </label>
                                                    <input type="file" class="form-control-file" name="cv" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12 text-center">
                                                <button type="submit" class="col-md-12 default-btn contact-btn"> Submit </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Job Details Section End -->


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
    </div>
</section>
<!-- Job Section End -->    

@endsection