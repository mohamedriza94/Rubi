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

<!-- Sign In Section Start -->
<div class="signin-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-3">
                <form class="signin-form" method="post" action="{{ route('business.login.submit') }}">
                    @csrf
                    
                    @error('password')
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <div class="help-block" style="color:rgb(211, 0, 0)"><b>{{ $message }}</b></div> 
                        </div>
                    </div>
                    @enderror
                    
                    @error('status')
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <div class="help-block" style="color:rgb(211, 0, 0)"><b>{{ $message }}</b></div> 
                        </div>
                    </div>
                    @enderror
                    
                    <div class="form-group">
                        <label>Enter Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    </div>
                    
                    <div class="signin-btn text-center">
                        <button type="submit">Sign In</button>
                    </div>
                    
                    <div class="create-btn text-center">
                        
                        <a href="{{ route('client.forgotPassword') }}">
                            Forgot Password
                        </a>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- Sign In Section End -->

@endsection