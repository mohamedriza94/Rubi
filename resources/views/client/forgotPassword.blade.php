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
                <li>
                    <a href="{{ route('client.signin') }}">Signin</a>
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

<!-- Sign In Section Start -->
<div class="signin-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-3">
                <form class="signin-form" method="post" action="{{ route('verifyEmailAndSendOTP') }}">
                    @csrf
                    <div class="form-group">
                        <label>Enter Business Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Business Email" value="{{ old('email') }}">
                        
                        @if (session('error'))
                        <div class="help-block with-errors">{{ session('error') }}</div>
                        @enderror
                    </div>
                    
                    <div class="signin-btn text-center">
                        <button type="submit">Submit</button>
                    </div>
                    
                    <div class="create-btn text-center">
                        
                        <a href="{{ route('client.signin') }}">
                            Back
                        </a>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- Sign In Section End -->

@endsection