@extends('layouts.client')

@section('content')
<!-- Banner Section Start -->
<div class="banner-style-three banner-style-four">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="banner-text">
                    <span>RUBI: The central hub of business operations"</span>
                    <h1>Unlock efficiency with RUBI</h1>
                    <p>Empower your business operations with the power of RUBI</p>

                    <div class="theme-btn">
                        <a href="#" class="default-btn active">Continue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="banner-img">
        <img src="{{ asset('assets/img/banner/banner-img.png') }}" alt="banner image">
    </div>
</div>
<!-- Banner Section End -->
@endsection