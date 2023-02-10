@extends('layouts.rubiAuth')

@section('content')
<div class="login-box card">
    <div class="card-body">
        
        {{-- Login --}}
        <form class="form-horizontal form-material text-center" id="loginform" action="{{ route('rubi.login.submit') }}" method="post">
            @csrf
            <p style="background: rgb(39, 39, 39); width:100%; padding: 10px; border-radius: 5px;"><img src="https://i.ibb.co/sv7c7d7/output-onlinepngtools.png" alt="Rubi" /></p>
            
            {{-- display error --}}
            @error('password')
            <div class="col-lg-12 col-md-12">
                <div class="alert alert-danger">{{ $message }}</div>
            </div>
            @enderror
            
            <div class="form-group m-t-40">
                <div class="col-xs-12">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck1">
                            <label class="form-check-label" for="customCheck1">Remember me</label>
                        </div> 
                        <div class="ms-auto">
                            <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot Password</a> 
                        </div>
                    </div>   
                </div>
            </div>
            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-info btn-lg w-100 text-uppercase btn-rounded text-white" type="submit">Signin</button>
                </div>
            </div>
        </form>
        
        {{-- Reset Password --}}
        <form class="form-horizontal" id="recoverform" method="post" action="">
            <div class="form-group ">
                <div class="col-xs-12">
                    <h3>Recover Password</h3>
                    <p class="text-muted">Enter your Email and you will receive an OTP! </p>
                </div>
            </div>
            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group text-center m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-lg w-100 text-uppercase waves-effect waves-light" type="submit">Reset</button>
                </div>
                <br>
                <div class="col-xs-12">
                    <a href="javascript:void(0)" id="back" class="text-muted"><i class="fas fa-angle-left m-r-5"></i>Back</a> 
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
