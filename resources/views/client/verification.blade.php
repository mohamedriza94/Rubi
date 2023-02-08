@extends('layouts.client')

@section('content')
<!-- Error Section Start -->
<div class="error-section ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="error-img">
                    
                    <h1 style="text-align: center">{{ $message }}</h1>
                    <h5 style="text-align: center">{{ $message2 }}</h5>
                    <br>
                    <div class="theme-btn text-center">
                        <a href="{{ route('client.home') }}" class="default-btn">Go To Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Error Section End -->
@endsection