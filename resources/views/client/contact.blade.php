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

<!-- Contact Section Start -->
<div class="contact-card-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="contact-card">
                            <i class='bx bx-phone-call'></i>
                            <ul>
                                <li>
                                    <a href="#">
                                        +94 72 9353 066
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="contact-card">
                            <i class='bx bx-mail-send' ></i>
                            <ul>
                                <li>
                                    <a href="#">
                                        bir06720@gmail.com
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6 offset-sm-3 offset-md-0">
                        <div class="contact-card">
                            <i class='bx bx-location-plus' ></i>
                            <ul>
                                <li>
                                    123, Denver, USA
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Section End -->

<!-- Contact Form Start -->
<section class="contact-form-section pb-100">
    <div class="container">
        <div class="contact-area">
            <h3>Submit your inquiry here</h3>
            <form method="post" action="{{ route('contactPOST') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}">
                            
                            @error('name')
                            <div class="help-block with-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" value="{{ old('email') }}">
                            
                            @error('email')
                            <div class="help-block with-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="number" id="number" class="form-control" placeholder="Phone Number" value="{{ old('number') }}">
                            
                            @error('number')
                            <div class="help-block with-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Your Subject" value="{{ old('subject') }}">
                            
                            @error('subject')
                            <div class="help-block with-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <textarea name="message" class="form-control message-field" id="message" cols="30" rows="7" placeholder="Write Message">{{ old('message') }}</textarea>
                            
                            @error('message')
                            <div class="help-block with-errors">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12 text-center">
                        <button type="submit" class="col-md-12 default-btn contact-btn"> Submit </button>
                    </div>
                    
                    @if (session('success'))
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <div class="help-block" style="color:green"><b>{{ session('success') }}</b></div> 
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Contact Form End -->

@endsection