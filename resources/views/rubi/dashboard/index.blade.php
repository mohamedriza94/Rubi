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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">BUSINESS REGISTRATIONS</h4>
                <div>
                    <canvas id="businessRegistrationChart" height="150"></canvas>
                </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="{{ asset('admin/assets/node_modules/Chart.js/chartjs.init.js') }}"></script>
<script src="{{ asset('admin/assets/node_modules/Chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/node_modules/sparkline/jquery.sparkline.min.js') }}"></script>

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
                    var applicationsLabels = [], applicationsTotals = [];
                    $.each(response.businessesCountByMonth, function(key, value){
                        applicationsLabels.push(value.monthYear);
                        applicationsTotals.push(value.count);
                    });
                    
                    new Chart(document.getElementById("businessRegistrationChart"),
                    {
                        "type":"line",
                        "data":{"labels":applicationsLabels,
                        "datasets":[{
                            "label":"",
                            "data":applicationsTotals,
                            "fill":false,
                            "borderColor":"rgb(252, 69, 3)",
                            "lineTension":0.1
                        }]
                    },"options":{}});
                }
            });
        }
    })
</script>

@endsection