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
                                <h3><i class="icon-bubble"></i></h3>
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
                                <h3><i class="icon-bubble"></i></h3>
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


@endsection

@section('script')

<script>
    $(document).ready(function(){
        
        readStatisctics();
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
                            case '1':
                            status_badge = '<span class="label label-success">Opened</span>'; //ACTIVE
                            break;
                            case '0':
                            status_badge = '<span class="label label-warning">Unopened</span>'; //INACTIVE
                            break;
                        }
                        
                        //format time
                        formatTime(item.created_at);
                        
                        $('#notesTable').append('<tr>\
                            <td>'+item.subject+'</td>\
                            <td><img src="'+item.employeePhoto+' class="profile-pic"> &nbsp; '+item.employeeName+'</td>\
                            <td>'+status_badge+'</td>\
                            <td>'+date+''+time+'</td>\
                            <td><button id="btnViewNote" value="'+item.id+'" class="btn-sm btn btn-info">Open</button></td>\
                        </tr>'); 
                    });
                }
            });
        }
        
    })
</script>

@endsection