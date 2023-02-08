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

<!-- Registration Section Start -->
<div class="job-post ptb-100">
    <div class="container">
        <form class="job-post-from" action="{{ route('registrationPOST') }}" method="post">
            @csrf
            <h2>Registration - Step Two</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Business Name</label>
                        <input type="text" class="form-control" name="name">
                        
                        @error('name')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="category" name="type">
                            <option value="Sole Proprietorship">Sole Proprietorship</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Non-profit organization">Non-profit organization</option>
                            <option value="Cooperative">Cooperative</option>
                            <option value="Franchise">Franchise</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Type</label>
                        <select class="category" name="product">
                            <option value="Goods">Goods</option>
                            <option value="Services">Services</option>
                            <option value="Both">Both</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Business Email</label>
                        <input type="email" class="form-control" name="email" placeholder="e.g. hello@company.com">
                        
                        @error('email')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Business Website (Optional)</label>
                        <input type="text" class="form-control" name="website" placeholder="e.g www.companyname.com">
                        
                        @error('website')
                        <div class="help-block with-errors">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Country of Origin</label>
                        <input type="text" class="form-control" name="country" placeholder="e.g. London">
                    </div>
                </div>
                
                <div class="col-md-1">
                    <div class="form-group">
                        <label>Logo</label>
                        <img src="assets/img/company-logo/1.png" alt="logo" id="logoDisplay">
                    </div>
                </div>
                
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Business Logo</label>
                        <input type="file" class="form-control" name="logo" id="logo">
                    </div>
                </div>
                
                <div class="col-md-12 text-center">
                    <button type="submit" class="post-btn">Register</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    //display the browsed and chosen thumbnail
    $("#logo").change(function(){
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('logoDisplay');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>
<!-- Registration Section End -->
@endsection