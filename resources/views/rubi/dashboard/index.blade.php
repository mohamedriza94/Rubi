@extends('layouts.rubiAdmin')

@section('content')

{{-- breadcrumb --}}
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{ $title }}</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="{{ route('rubi.dashboard') }}">Home</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="row g-0">
    <div class="col-lg-3">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">BUSINESSES</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-primary" id="totalBusiness">23</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">ACTIVE BUSINESSES</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-dark" id="activeBusiness">23</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">TODAY'S REGISTRATIONS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-success" id="TodayBusinessRegistrations">23</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-bubble"></i></h3>
                                <p class="text-muted">PENDING INQUIRIES</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="totalPendingInquiries">23</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    $(document).ready(function(){
        
        count();
        setInterval(() => { count(); }, 5000);

        function count()
        {
            $.ajax({
                type: "GET", url:"{{ url('rubi/dashboard/count') }}", dataType:"json",
                success:function(response){
                    $('#totalBusiness').text(response.totalBusiness);
                    $('#activeBusiness').text(response.activeBusiness);
                    $('#TodayBusinessRegistrations').text(response.TodayBusinessRegistrations);
                    $('#totalPendingInquiries').text(response.totalPendingInquiries);
                }
            });
        }
    })
</script>

@endsection