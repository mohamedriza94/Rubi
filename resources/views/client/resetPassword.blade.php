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
                <li>
                    <a href="{{ route('client.forgotPassword') }}">Forgot Password</a>
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
                <form class="signin-form" method="post" action="{{ route('resetPassword') }}">
                    @csrf

                    @if (session('success'))
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <div class="help-block" style="color:green"><b>{{ session('success') }}</b></div> 
                        </div>
                    </div>
                    @else
                        <p>We've sent an OTP to your Email. Enter the OTP and reset your password. OTP is valid only for 10 minutes</p>
                    @endif
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" readonly class="form-control" value="{{ $email }}">
                        @error('email')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>OTP</label>
                        <input type="password" name="otp" class="form-control">
                        @error('otp')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        @error('password_confirmation')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="signin-btn text-center">
                        <button type="submit">Submit</button>
                    </div>

                    @if (session('error'))
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <div class="help-block" style="color:red"><b>{{ session('error') }}</b></div> 
                        </div>
                    </div>
                    @endif
                    
                    <div class="create-btn text-center">
                        
                        <a href="{{ route('client.forgotPassword') }}">
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