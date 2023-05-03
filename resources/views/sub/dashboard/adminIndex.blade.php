@extends('layouts.sub')

@section('content')

{{-- breadcrumb --}}
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{ $title }}</h4>
    </div>
    <div class="col-md-7 align-self-center text-end">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb justify-content-end">
                <li class="breadcrumb-item"><a href="{{ route('sub.dashboard') }}">Home</a></li>
            </ol>
            &nbsp;
            &nbsp;
            <button class="btn btn-dark" id="btnCreatePDF" >Download Report PDF</button>

        </div>
    </div>
</div>

<div class="row g-0" id="report">
    
    <div class="col-lg-3">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-screen-desktop"></i></h3>
                                <p class="text-muted">ONGOING TASKS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-dark" id="ongoingTasks">0</h2>
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
                                <p class="text-muted">PENDING TASKS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-success" id="pendingTasks">0</h2>
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
                                <h3><i class="icon-like"></i></h3>
                                <p class="text-muted">COMPLETED TASKS</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="completedTasks">0</h2>
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
                                <h3><i class="icon-note"></i></h3>
                                <p class="text-muted">UNOPENED NOTES</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="unopenedNotes">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ------ --}}
    
    <div class="col-lg-4">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-pin"></i></h3>
                                <p class="text-muted text-uppercase">Today's Attendance</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-info" id="todaysAttendance">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-people"></i></h3>
                                <p class="text-muted text-uppercase">Active Employees</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-success" id="activeEmployees">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-people"></i></h3>
                                <p class="text-muted text-uppercase">Total Employees</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-info" id="totalEmployees">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ------ --}}

    <div class="col-lg-4">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-user-follow"></i></h3>
                                <p class="text-muted text-uppercase">Active Vacancies</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-success" id="activeVacancies">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-book-open"></i></h3>
                                <p class="text-muted text-uppercase">Pending Applications</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="pendingApplications">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-book-open"></i></h3>
                                <p class="text-muted text-uppercase">Shortlisted Applications</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-primary" id="shortlistedApplications">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ------ --}}
    
    <div class="col-lg-6">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-briefcase"></i></h3>
                                <p class="text-muted text-uppercase">Pending Salary Payments</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-warning" id="pendingSalaryPayments">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-briefcase"></i></h3>
                                <p class="text-muted text-uppercase">Completed Salary Payments</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-success" id="completedSalaryPayments">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border bg-success text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-credit-card"></i></h3>
                                <p class="text-white text-uppercase">Total Due Salary Amount</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-white" id="totalDueSalaryAmount">LKR 0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border text-white bg-danger">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h3><i class="icon-user-follow"></i></h3>
                                <p class="text-uppercase text-white">Today's Total Petty Expense</p>
                            </div>
                            <div class="ms-auto">
                                <h2 class="counter text-white" id="todaysPettyExpenseAmount">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Employee Recruitment Rate</h4>
                <div>
                    <canvas id="recruitmentChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Petty Expense Rate</h4>
                <div>
                    <canvas id="pettyExpenseChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Applications Rate</h4>
                <div>
                    <canvas id="applicationChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    {{-- tasks started today table --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" id="dataCount">TASKS STARTED TODAY</h5>
                <div class="table-responsive">
                    <table class="text-center table color-table red-table">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Task No.</th>
                                <th>Title</th>
                                <th>Provided On</th>
                            </tr>
                        </thead>
                        <tbody id="taskTable">
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
    
    @php
    $user = auth('businessAdmin')->user();
    $department = \App\Models\Department::find($user->department);
    @endphp
    
    {{-- notes table --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase" id="dataCount">{{ $department->name }} DEPARTMENT NOTES</h5>
                <div class="table-responsive">
                    <table class="text-center table color-table red-table">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Subject</th>
                                <th>Employee</th>
                                <th>Status</th>
                                <th>Made On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="notesTable">
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>

{{-- view modal --}}
<div class="modal bs-example-modal-lg animated fadeIn" id="viewNoteModal" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">View Note</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="row">
                                    <div class="form-group col-12">
                                        <label class="form-label" id="noteDate">Noted On</label>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="form-label">Note No.</label>
                                        <input class="form-control" id="noteNo" readonly>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="form-label">Subject</label>
                                        <input class="form-control" id="noteSubject" readonly>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" id="noteDescription" readonly></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    $(document).ready(function(){
        
        readStatisctics();
        readChart();
        setInterval(() => { readStatisctics(); }, 5000);
        
        function readStatisctics()
        {
            $.ajax({
                type: "GET", url:"{{ url('sub/dashboard/readStatistics') }}", dataType:"json",
                success:function(response){
                    //show counts
                    $('#ongoingTasks').text(response.ongoingTaskCount);
                    $('#pendingTasks').text(response.pendingTaskCount);
                    $('#completedTasks').text(response.completedTaskCount);
                    $('#unopenedNotes').text(response.unopenedNotesCount);
                    
                    $('#todaysAttendance').text(response.todaysAttendanceCount);
                    $('#activeEmployees').text(response.activeEmployeesCount);
                    $('#totalEmployees').text(response.totalEmployeesCount);
                    
                    $('#activeVacancies').text(response.activeVacanciesCount);
                    $('#pendingApplications').text(response.pendingApplicationsCount);
                    $('#shortlistedApplications').text(response.shortlistedApplicationsCount);
                    
                    $('#pendingSalaryPayments').text(response.pendingSalaryPaymentsCount);
                    $('#completedSalaryPayments').text(response.completedSalaryPaymentsCount);
                    $('#totalDueSalaryAmount').text(response.totalDueSalaryAmountCount);
                    $('#todaysPettyExpenseAmount').text(response.todaysPettyExpenseAmountCount);

                    // show today's tasks
                    $('#taskTable').html(''); 
                    $.each(response.tasksStartedToday,function(key,item){
                        
                        //format time
                        formatTime(item.created_at);
                        
                        $('#taskTable').append('<tr>\
                            <td>'+item.no+'</td>\
                            <td>'+item.title+'</td>\
                            <td>'+date+''+time+'</td>\
                        </tr>'); 
                    });
                    
                    // show notes
                    $('#notesTable').html(''); 
                    $.each(response.notes,function(key,item){
                        var status_badge = '';
                        //sorting STATUS
                        switch(item.isViewed) {
                            case 1:
                            status_badge = '<span class="label label-success">Opened</span>'; //ACTIVE
                            break;
                            case 0:
                            status_badge = '<span class="label label-warning">Unopened</span>'; //INACTIVE
                            break;
                        }
                        
                        //format time
                        formatTime(item.created_at);
                        
                        $('#notesTable').append('<tr>\
                            <td>'+item.subject+'</td>\
                            <td>'+item.employeeName+'</td>\
                            <td>'+status_badge+'</td>\
                            <td>'+date+''+time+'</td>\
                            <td><button id="btnViewNote" value="'+item.id+'" class="btn-sm btn btn-info">Open</button></td>\
                        </tr>'); 
                    });
                }
            });
        }
        
        function readChart()
        {
            //fill chart
            $.ajax({
                        url: "{{ url('sub/dashboard/getChart') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(response) 
                        {
                            //recruitement chart
                            var recruitementLabels = [], recruitementCounts = [];
                            $.each(response.recruitmentRate, function(key, value){
                                recruitementLabels.push(value.monthYear);
                                recruitementCounts.push(value.count);
                            });
                           
                            new Chart(document.getElementById("recruitmentChart"),
                            {
                                "type":"bar",
                                "data":{"labels":recruitementLabels,
                                "datasets":[{
                                    "label":"",
                                    "data":recruitementCounts,
                                    "fill":false,
                                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                                    "borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                                    "borderWidth":1}
                                    ]},
                                    "options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}
                            });
                                
                            //petty expense chart
                            var pettyExpenseLabels = [], pettyExpenseTotals = [];
                            $.each(response.pettyExpenseSum, function(key, value){
                                pettyExpenseLabels.push(value.monthYear);
                                pettyExpenseTotals.push(value.total);
                            });
                        
                            new Chart(document.getElementById("pettyExpenseChart"),
                            {
                                "type":"line",
                                "data":{"labels":pettyExpenseLabels,
                                "datasets":[{
                                    "label":"",
                                    "data":pettyExpenseTotals,
                                    "fill":false,
                                    "borderColor":"rgb(75, 192, 192)",
                                    "lineTension":0.1
                                }]
                            },"options":{}});

                            //applications rate
                            var applicationsLabels = [], applicationsTotals = [];
                            $.each(response.applicationsRate, function(key, value){
                                applicationsLabels.push(value.monthYear);
                                applicationsTotals.push(value.count);
                            });
                            
                            new Chart(document.getElementById("applicationChart"),
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

        $(document).on('click', '#btnCreatePDF', function(e){ $('#report').printThis(); });

        $(document).on('click', '#btnViewNote', function(e){
            e.preventDefault();
            var id = $(this).val(); //get note id
            
            var urlView = '{{ url("sub/dashboard/readOneNote/:id") }}'; urlView = urlView.replace(':id', id);
            $.ajax({
                type:"GET", url:urlView, dataType:"json",
                success: function(response)
                {
                    $('#viewNoteModal').modal('show');  //OPEN MODAL
                    //format time
                    formatTime(response.data.created_at);
                    
                    $('#noteNo').val(response.data.no);
                    $('#noteDate').html('<label class="form-label" id="noteDate"><b>Noted On: </b>'+date+time+'</label>');
                    $('#noteSubject').val(response.data.subject);
                    $('#noteDescription').val(response.data.note);
                }
            });
        });
    })
</script>

@endsection