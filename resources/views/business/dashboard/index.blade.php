@extends('layouts.business')

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
                                <p class="text-muted">DEPARTMENTS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-dark" id="departments">0</h2>
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
                                <p class="text-muted">ADMINISTRATORS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-success" id="administrators">0</h2>
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
                                <p class="text-muted">EMPLOYEES</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="employees">0</h2>
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
                                <p class="text-muted">PENDING TASKS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="pendingTasks">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    {{-- today activities table --}}
    {{-- <div class="col-md-12">
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
    </div> --}}
</div>


@endsection

@section('script')

<script>
    $(document).ready(function(){
        
        readStatisctics();
        setInterval(() => { readStatisctics(); }, 5000);
        
        function readStatisctics()
        {
            $.ajax({
                type: "GET", url:"{{ url('business/dashboard/readStatistics') }}", dataType:"json",
                success:function(response){
                    $('#departments').text(response.departmentCount);
                    $('#administrators').text(response.businessAdminCount);
                    $('#employees').text(response.businessEmployeeCount);
                    $('#pendingTasks').text(response.pendingTasksCount);
                    
                    
                }
            });
        }
        
    })
</script>
    
@endsection