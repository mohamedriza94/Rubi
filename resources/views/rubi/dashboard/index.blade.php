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
    {{-- chart --}}
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex m-b-40 align-items-center no-block">
                    <h5 class="card-title ">MONTHLY REGISTRATIONS</h5>
                    <div class="ms-auto">
                        <ul class="list-inline font-12">
                            <li><i class="fa fa-circle text-cyan"></i> Business Registration</li>
                        </ul>
                    </div>
                </div>
                <div id="morris-area-chart" style="height: 340px;"></div>
            </div>
        </div>
    </div>
    
    {{-- today registrations table --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" id="dataCount">TODAY'S REGISTRATIONS</h5>
                <div class="table-responsive">
                    <table class="text-center table color-table red-table">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Business</th>
                                <th>Type</th>
                                <th>Product</th>
                                <th>Country</th>
                                <th>Registered at</th>
                            </tr>
                        </thead>
                        <tbody id="businessTable">
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    $(document).ready(function(){
        
        count(); chart();
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
                    
                    $.each(response.todayRegistration,function(key,item){
                        $('#businessTable').html(''); formatTime(item.created_at);
                        
                        $('#businessTable').append('<tr>\
                            <td><img style="width:30px; border-radius:10px;" class="m-r-10" src="'+item.photo+'"></td>\
                            <td>'+item.name+'</td>\
                            <td>'+item.type+'</td>\
                            <td>'+item.product+'</td>\
                            <td>'+item.country+'</td>\
                            <td>'+time+'</td>\
                        </tr>'); 
                    });
                }
            });
        }
        
        function chart()
        {
            $.ajax({
                type: "GET", url:"{{ url('rubi/dashboard/count') }}", dataType:"json",
                success:function(response){
                    let data = response.businessesCountByMonth;
                    Morris.Area({
                        element: 'morris-area-chart',
                        data: data,
                        xkey: ['month'],
                        ykeys: ['count'],
                        labels: ['Business'],
                        pointSize: 3,
                        fillOpacity: 0,
                        pointStrokeColors: ['#00bfc7'],
                        behaveLikeLine: true,
                        gridLineColor: '#e0e0e0',
                        lineWidth: 3,
                        hideHover: 'auto',
                        lineColors: ['#00bfc7'],
                        resize: true
                    });
                }
            });
        }
    })
</script>

@endsection