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
                <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i
                class="fa fa-plus-circle"></i> New Department</button>
            </div>
        </div>
    </div>
    
    {{-- content --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="dataCount"></h4>
                    <div class="table-responsive">
                        <table class="table color-table purple-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Nickname</th>
                                    <th>Since</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="departmentTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modals --}}
    {{-- create modal --}}
    <div class="modal bs-example-modal-sm animated fadeIn" id="createModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">New Department</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <form class="row" id="createForm" enctype="multipart/form-data" method="post">
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Choose Department</label>
                                            <select class="form-select" name="department" id="department">
                                                <option value="HR">HR Department</option>
                                                <option value="IT">IT Department</option>
                                                <option value="Marketing">Marketing Department</option>
                                                <option value="Finance">Finance Department</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Nickname (Optional)</label>
                                            <input class="form-control" id="nickname" name="nickname">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status" id="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
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
    <div class="modal bs-example-modal-sm animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">View Department</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row" id="viewForm" enctype="multipart/form-data" method="post">
                                        <div class="form-group col-6">
                                            <label class="form-label">Department</label>
                                            <input type="text" readonly class="form-control" id="viewDepartment">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Added On</label>
                                            <input type="text" readonly class="form-control" id="viewAddedOn">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Nickname</label>
                                            <input type="text" readonly class="form-control" id="viewNickname">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Active Employees</label>
                                            <input type="text" readonly class="form-control" id="viewActiveEmployees">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Inactive Employees</label>
                                            <input type="text" readonly class="form-control" id="viewInactiveEmployees">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Total Employees</label>
                                            <input type="text" readonly class="form-control" id="viewTotalEmployees">
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
    <script>
        $(document).ready(function(){
            
            var url = "{{ url('business/dashboard/readDepartments') }}";
            function configureUrl()
            {
                url = "{{ url('business/dashboard/readDepartments') }}";
            }

            readDepartments();
            
            //read packages
            function readDepartments()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#departmentTable').html(''); 
                        
                        $.each(response.data,function(key,item){
                            //display badges
                            var status_badge = ''; var status_button = ''; var nickname = '';
                            
                            //sorting STATUS
                            switch(item.status) {
                                case 'active':
                                status_badge = '<span class="label label-success">Active</span>'; //ACTIVE
                                status_button = '<button id="btnChangeStatus" value="'+item.id+'" class="btn btn-danger">Deactivate</button>';
                                break;
                                case 'inactive':
                                status_badge = '<span class="label label-danger">Inactive</span>'; //INACTIVE
                                status_button = '<button id="btnChangeStatus" value="'+item.id+'" class="btn btn-success">Activate</button>';
                                break;
                            }

                            if(item.nickname == null)
                            {
                                nickname = '-';
                            }else{
                                nickname = item.nickname;
                            }

                            //format time
                            formatTime(item.created_at);
                            
                            $('#departmentTable').append('<tr>\
                                <td>'+item.name+'</td>\
                                <td>'+nickname+'</td>\
                                <td>'+date+''+time+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        '+status_button+'\
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
                    type: "POST", url: "{{ url('business/dashboard/createDepartment') }}",
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
                            readDepartments();
                            
                            Swal.fire({ title: 'Success', text: "Department Created",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });

            //View
            $(document).on('click', '#btnView', function(e){
                e.preventDefault();
                var id = $(this).val(); //get message id
                var urlView = '{{ url("business/dashboard/readOneDepartment/:id") }}'; urlView = urlView.replace(':id', id);
                $.ajax({
                    type:"GET", url:urlView, dataType:"json",
                    success: function(response)
                    {
                        $('#viewModal').modal('show');  //OPEN MODAL
                        
                        //format time
                        formatTime(response.data.created_at);
                        
                        $('#viewDepartment').val(response.data.name);
                        $('#viewAddedOn').val(date+time);
                        $('#viewNickname').val(response.data.nickname);
                        $('#viewActiveEmployees').val(response.data.active);
                        $('#viewInactiveEmployees').val(response.data.inactive);
                        $('#viewTotalEmployees').val(response.data.total);
                    }
                });
            });

            //Update status
            $(document).on('click', '#btnChangeStatus', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var data = { 'id':id }
                $.ajax({
                    type:"PUT",
                    url: "{{ url('business/dashboard/updateDepartmentStatus') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readDepartments();
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readDepartments();
                        }
                    }
                });
            });
        });
    </script>
    @endsection