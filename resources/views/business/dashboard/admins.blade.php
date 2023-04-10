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
                <li class="breadcrumb-item"><a href="{{ route('business.admins') }}">Admin</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i
                class="fa fa-plus-circle"></i> New Admin</button>
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
                                    <th>Photo</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="businessAdminTable">
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
                    <h4 class="modal-title" id="myLargeModalLabel">New Admin</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <form class="row" id="createForm" enctype="multipart/form-data" method="post">
                                        
                                        <div class="form-group col-9">
                                            <label class="form-label">Fullname</label>
                                            <input class="form-control" name="fullname">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input class="form-control" type="date" name="dob">
                                        </div>

                                        <div class="form-group col-4">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" name="email">
                                        </div>

                                        <div class="form-group col-4">
                                            <label class="form-label">Telephone</label>
                                            <input class="form-control" name="telephone">
                                        </div>
                                        
                                        <div class="form-group col-4">
                                            <label class="form-label">Choose Department</label>
                                            <select class="form-select" name="department" id="department">
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Password</label>
                                            <input class="form-control" type="password" id="password" name="password">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <img id="photoDisplay" class="col-12">
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
                    <h4 class="modal-title" id="myLargeModalLabel">View Business Admin</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <form class="row" id="updateForm" enctype="multipart/form-data" method="post">
                                        
                                        <input type="hidden" name="id">

                                        <div class="form-group col-12">
                                            <label class="form-label" id="registeredAt">Registered At</label>
                                        </div>

                                        <div class="form-group col-9">
                                            <label class="form-label">Fullname</label>
                                            <input class="form-control" id="fullname" name="fullname">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Date of Birth</label>
                                            <input class="form-control" type="date" id="dob" name="dob">
                                        </div>

                                        <div class="form-group col-4">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" readonly id="email" name="email">
                                        </div>

                                        <div class="form-group col-4">
                                            <label class="form-label">Telephone</label>
                                            <input class="form-control" id="telephone" name="telephone">
                                        </div>
                                        
                                        <div class="form-group col-4">
                                            <label class="form-label">Department</label>
                                            <select class="form-select" name="department" id="editDepartment">
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <img id="viewPhoto" class="col-12">
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center">
                                                <button type="submit" id="btnUpdate" class="col-12 btn btn-info">Update</button>
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
    
    @endsection
    
    
    
    
    
    @section('script')
    <script>
        $(document).ready(function(){

            var url = "{{ url('business/dashboard/readBusinessAdmins') }}";
            function configureUrl()
            {
                url = "{{ url('business/dashboard/readBusinessAdmins') }}";
            }

            readDepartments();
            readAdmins();
            
            //read departments into select option
            function readDepartments()
            {
                $.ajax({
                    type: "GET", url:"{{ url('business/dashboard/readActiveDepartments') }}", dataType:"json",
                    success:function(response){
                        $('#department').html(''); 
                        $('#editDepartment').html(''); 
                        
                        $.each(response.data,function(key,item){
                           
                            $('#department').append('<option value="'+item.id+'">'+item.name+'</option>'); 
                            $('#editDepartment').append('<option value="'+item.id+'">'+item.name+'</option>'); 
                            });
                        }
                    });
            }

            //read admins
            function readAdmins()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#businessAdminTable').html(''); 

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

                            $('#businessAdminTable').append('<tr>\
                                <td>'+item.fullname+'</td>\
                                <td><img src="'+item.photo+'" style="width:50px;"></td>\
                                <td>'+item.department+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        <button id="btnView" value="'+item.id+'" class="btn btn-primary">View</button>\
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
                    type: "POST", url: "{{ url('business/dashboard/createBusinessAdmin') }}",
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
                            readAdmins();
                            
                            Swal.fire({ title: 'Success', text: "Admin Account Created",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });
            
            //update
            $(document).on('click', '#btnUpdate', function(e) {
                e.preventDefault();
                
                $("#btnUpdate").prop("disabled", true).text("Updating...");
                
                let formData = new FormData($('#updateForm')[0]);
                $.ajax({
                    type: "POST", url: "{{ url('business/dashboard/updateBusinessAdmin') }}",
                    data: formData, contentType:false, processData:false,
                    success: function(response){
                        if(response.status==800)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnUpdate").prop("disabled", false).text("Update");
                        }
                        else if(response.status == 400 || response.status == 600)
                        {
                            $("#btnUpdate").prop("disabled", false).text("Update");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnUpdate").prop("disabled", false).text("Update");
                            $('#updateForm')[0].reset(); //FORM RESET INPUT
                            readAdmins();
                            
                            Swal.fire({ title: 'Success', text: "Admin Account Updated",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });

            //View
            $(document).on('click', '#btnView', function(e){
                e.preventDefault();
                var id = $(this).val(); //get message id
                var urlView = '{{ url("business/dashboard/readOneBusinessAdmin/:id") }}'; urlView = urlView.replace(':id', id);
                $.ajax({
                    type:"GET", url:urlView, dataType:"json",
                    success: function(response)
                    {
                        $('#viewModal').modal('show');  //OPEN MODAL
                        
                        //format time
                        formatTime(response.data.created_at);
                        
                        $('#registeredAt').html('<label class="form-label" id="registeredAt"><b>Registered At</b>: '+date+time+'</label>');
                        $('#fullname').val(response.data.fullname);
                        $('#dob').val(response.data.dob);
                        $('#email').val(response.data.email);
                        $('#telephone').val(response.data.telephone);
                        $('#editDepartment').val(response.data.department);
                        $('#viewPhoto').attr('src',response.data.photo);
                        $('#id').attr('src',response.data.id);

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
                    url: "{{ url('business/dashboard/updateBusinessAdminStatus') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readAdmins();
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readAdmins();
                        }
                    }
                });
            });
        });
    </script>
    @endsection