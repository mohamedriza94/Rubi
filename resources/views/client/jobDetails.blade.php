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

<!-- Job Details Section Start -->
<section class="job-details ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="job-details-text">
                            <div class="job-card">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="company-logo">
                                            <img src="assets/img/company-logo/1.png" alt="logo">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="job-info">
                                            <h3>Web Designer, Graphic Designer, UI/UX Designer</h3>
                                            <ul>
                                                <li>
                                                    <i class='bx bx-location-plus'></i>
                                                    Wellesley Rd, London
                                                </li>
                                                <li>
                                                    <i class='bx bx-filter-alt' ></i>
                                                    Accountancy
                                                </li>
                                                <li>
                                                    <i class='bx bx-briefcase' ></i>
                                                    Freelance
                                                </li>
                                            </ul>
                                            
                                            <span>
                                                <i class='bx bx-paper-plane' ></i>
                                                Apply Before: June 01,2021
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="details-text">
                                <h3>Description</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,but also the leap into essentially unchanged.</p>

                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                            </div>
                            
                            <div class="details-text">
                                <h3>Requirements</h3>
                               <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                                <ul>
                                    <li>
                                        <i class='bx bx-check'></i>
                                        Work experience
                                    </li>
                                    <li>
                                        <i class='bx bx-check'></i>
                                        Skills (soft skills and/or technical skills)
                                    </li>
                                    <li>
                                        <i class='bx bx-check'></i>
                                        WPersonal qualities and attributes.
                                    </li>
                                    <li>
                                        <i class='bx bx-check'></i>
                                        Support software roll-outs to production.
                                    </li>
                                    <li>
                                        <i class='bx bx-check'></i>
                                        Guide and mentor junior engineers. Serve as team lead if appropriate.

                                    </li>
                                </ul>
                            </div>

                            <div class="details-text">
                                <h3>Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><span>Company</span></td>
                                                    <td>Tourt Design LTD</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Location</span></td>
                                                    <td>Wellesley Rd, London</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Job Type</span></td>
                                                    <td>Full Time</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Email</span></td>
                                                    <td><a href="mailto:hello@company.com">hello@company.com</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><span>Experince</span></td>
                                                    <td>2 Years</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Language</span></td>
                                                    <td>English</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Salary</span></td>
                                                    <td>$10,000</td>
                                                </tr>
                                                <tr>
                                                    <td><span>Website</span></td>
                                                    <td><a href="#">www.company.com</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="theme-btn">
                                <a href="#" class="default-btn">
                                    Apply Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="job-sidebar">
                    <h3>Posted By</h3>
                    <div class="posted-by">
                        <img src="assets/img/client-1.png" alt="client image">
                        <h4>John Doe</h4>
                        <span>CEO of Tourt Design LTD</span>
                    </div>
                </div>

                <div class="job-sidebar">
                    <h3>Keywords</h3>
                    <ul>
                        <li>
                            <a href="#">Web Design</a>
                        </li>
                        <li>
                            <a href="#">Data Sceince</a>
                        </li>
                        <li>
                            <a href="#">SEO</a>
                        </li>
                        <li>
                            <a href="#">Content Writter</a>
                        </li>
                        <li>
                            <a href="#">Finance</a>
                        </li>
                        <li>
                            <a href="#">Business</a>
                        </li>
                        <li>
                            <a href="#">Education</a>
                        </li>
                        <li>
                            <a href="#">Graphics</a>
                        </li>
                        <li>
                            <a href="#">Video</a>
                        </li>
                    </ul>
                </div>

                <div class="job-sidebar social-share">
                    <h3>Share In</h3>
                    <ul>
                        <li>
                            <a href="#" target="_blank">
                                <i class="bx bxl-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="bx bxl-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="bx bxl-pinterest"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="bx bxl-linkedin"></i>
                            </a>
                        </li>
                    </ul>
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