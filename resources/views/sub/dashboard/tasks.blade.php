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
                <li class="breadcrumb-item"><a href="{{ route('sub.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-info d-none d-lg-block m-l-15 text-white">
                <i class="fa fa-plus-circle"></i> New Task</button>
            </div>
        </div>
    </div>
    
    {{-- admin elements --}}
    @if(auth('businessAdmin')->user()->role == 'admin')
    
    {{-- content --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="dataCount"></h4>
                    <div class="table-responsive">
                        <table class="table color-table purple-table text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Provided On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="taskTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modals --}}
    {{-- create modal --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="createModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">New Task</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <form class="row" id="createForm" enctype="multipart/form-data" method="post">
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Title</label>
                                            <input class="form-control" name="title">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="10" name="description"></textarea>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center">
                                                <button type="submit" id="btnCreate" class="col-12 btn btn-info">Create</button>
                                            </div>
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
    
    {{-- view modal --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Task Details</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row" id="viewForm" enctype="multipart/form-data" method="post">
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label" id="providedOn"></label>
                                        </div>
                                        
                                        <div class="form-group col-9">
                                            <label class="form-label">Title</label>
                                            <input readonly class="form-control" id="title">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Status</label>
                                            <input readonly class="form-control" id="status">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Description</label>
                                            <textarea readonly class="form-control" id="description"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Start</label>
                                            <input readonly class="form-control" id="start">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">End</label>
                                            <input readonly class="form-control" id="End">
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
    
    @endif
    
    {{-- employee elements --}}
    @if(auth('businessAdmin')->user()->role == 'employee')
    
    {{-- content --}}
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="row" id="taskForm" enctype="multipart/form-data" method="post">
                        
                        <div class="form-group col-9">
                            <label class="form-label">Title</label>
                            <input readonly class="form-control" id="title">
                        </div>
                        
                        <div class="form-group col-3">
                            <label class="form-label">Status</label>
                            <input readonly class="form-control" id="status">
                        </div>
                        
                        <div class="form-group col-12">
                            <label class="form-label">Description</label>
                            <textarea readonly class="form-control" id="description"></textarea>
                        </div>
                        
                        <div class="form-group col-12">
                            <label class="form-label" id="providedOn">Provided On</label>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-md-flex align-items-center">
                                <button type="submit" id="btnStart" class="col-12 btn btn-info">Start</button>
                                <button type="submit" id="btnEnd" class="col-12 btn btn-danger" style="display:none">End</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @endif
    
    
    @endsection
    
    
    
    
    
    @section('script')
    
    {{-- admin scripts --}}
    @if(auth('businessAdmin')->user()->role == 'admin')
    
    <script>
        $(document).ready(function(){
            
            var url = "{{ url('sub/dashboard/readTasks') }}";
            function configureUrl()
            {
                url = "{{ url('sub/dashboard/readTasks') }}";
            }
            
            readTasks();
            
            //read packages
            function readTasks()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#taskTable').html(''); 
                        
                        $.each(response.data,function(key,item){
                            //display badges
                            var status_badge = ''; var status_button = ''; var nickname = '';
                            
                            //sorting STATUS
                            switch(item.status) {
                                case 'pending':
                                status_badge = '<span class="label label-warning">Pending</span>'; //ACTIVE
                                break;
                                case 'started':
                                status_badge = '<span class="label label-primary">Started</span>'; //INACTIVE
                                break;
                                case 'completed':
                                status_badge = '<span class="label label-success">Complete</span>'; //INACTIVE
                                break;
                                case 'incomplete':
                                status_badge = '<span class="label label-danger">Incomplete</span>'; //INACTIVE
                                break;
                            }
                            
                            //format time
                            formatTime(item.created_at);
                            
                            $('#taskTable').append('<tr>\
                                <td>'+item.no+'</td>\
                                <td>'+item.title+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>'+date+''+time+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        <button id="btnView" value="'+item.id+'" class="btn btn-info d-none d-lg-block m-l-15 text-white">View</button>\
                                    </div>\
                                </td>\
                            </tr>'); 
                        });
                    }
                });
            }
            
            //Create
            $(document).on('click', '#btnCreate', function(e) {
                e.preventDefault();
                
                $("#btnCreate").prop("disabled", true).text("Creating...");
                
                let formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: "POST", url: "{{ url('sub/dashboard/createTask') }}",
                    data: formData, contentType:false, processData:false,
                    success: function(response){
                        if(response.status==800)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnCreate").prop("disabled", false).text("Create");
                        }
                        else if(response.status == 400 || response.status == 600)
                        {
                            $("#btnCreate").prop("disabled", false).text("Create");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnCreate").prop("disabled", false).text("Create");
                            $('#createForm')[0].reset(); //FORM RESET INPUT
                            readTasks();
                            
                            Swal.fire({ title: 'Success', text: "Task Created",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });
            
            //View
            $(document).on('click', '#btnView', function(e){
                e.preventDefault();
                var id = $(this).val(); //get message id
                var urlView = '{{ url("sub/dashboard/readOneTask/:id") }}'; urlView = urlView.replace(':id', id);
                $.ajax({
                    type:"GET", url:urlView, dataType:"json",
                    success: function(response)
                    {
                        $('#viewModal').modal('show');  //OPEN MODAL
                        
                        //format time
                        formatTime(response.data.created_at);
                        
                        $('#title').val(response.data.title);
                        $('#status').val(response.data.status);
                        $('#description').val(response.data.description);
                        $('#providedOn').html('<label class="form-label" id="providedOn"><b>Provided On: </b>'+date+time+'</label>');
                        $('#start').val(response.data.start);
                        $('#End').val(response.data.end);
                    }
                });
            });
        });
    </script>
    
    @endif
    
    {{-- employee scripts --}}
    @if(auth('businessAdmin')->user()->role == 'employee')
    
    <script>
        $(document).ready(function(){
            
            viewTopTask();
            
            //Start task
            $(document).on('click', '#btnStart', function(e) {
                e.preventDefault();
                var data = { 'id':taskID }
                $.ajax({
                    type:"PUT",
                    url: "{{ url('sub/dashboard/startOrEndTask') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                            viewTopTask();
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            $('#btnStart').hide();
                            $('#btnEnd').show();
                            viewTopTask();
                        }
                    }
                });
            });
            
            //End task
            $(document).on('click', '#btnEnd', function(e) {
                e.preventDefault();
                var data = { 'id':taskID }
                $.ajax({
                    type:"PUT",
                    url: "{{ url('sub/dashboard/startOrEndTask') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            
                            $('#btnStart').show();
                            $('#btnEnd').hide();
                            viewTopTask();
                        }
                    }
                });
            });
            
            var taskID = '';
            //View topmost task
            function viewTopTask()
            {
                $.ajax({
                    type:"GET", url:'{{ url("sub/dashboard/readTopTask") }}', dataType:"json",
                    success: function(response)
                    {
                        $('#viewModal').modal('show');  //OPEN MODAL
                        
                        //format time
                        formatTime(response.data.created_at);
                        
                        taskID = response.data.id;
                        $('#title').val(response.data.title);
                        $('#status').val(response.data.status);
                        $('#description').val(response.data.description);
                        $('#providedOn').html('<label class="form-label" id="providedOn"><b>Provided On:</b>&nbsp; '+date+time+'</label>');
                        $('#start').val(response.data.start);
                        $('#End').val(response.data.End);
                        
                        switch(response.data.status){
                            case 'pending':
                            $('#btnStart').show(); $('#btnEnd').hide();
                            break;
                            case 'started':
                            $('#btnStart').hide(); $('#btnEnd').show();
                            break;
                        }
                    }
                });
            }
            
        });
    </script>
    
    @endif
    
    @endsection