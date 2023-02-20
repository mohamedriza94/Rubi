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
                <li class="breadcrumb-item"><a href="{{ route('rubi.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i
                class="fa fa-plus-circle"></i> New Package</button>
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
                                    <th>Price</th>
                                    <th>Period</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="packageTable">
                            </tbody>
                        </table>
                        
                        <div class="btn-group m-b-10 m-r-10">
                            <button id="btnPrev" class="btn btn-outline-dark"><i class="fas fa-angle-double-left"></i></button>
                            <button id="btnNext" class="btn btn-outline-dark"><i class="fas fa-angle-double-right"></i></button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modals --}}
    {{-- create modal --}}
    <div class="modal bs-example-modal-lg animated fadeIn" id="createModal" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Create Package</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <form class="row" id="createForm" enctype="multipart/form-data" method="post">
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Duration</label>
                                            <input type="number" class="form-control" name="periodDuration">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Unit</label>
                                            <select class="form-select" name="periodUnit">
                                                <option value="Day">Day</option>
                                                <option value="Week">Week</option>
                                                <option value="Month">Month</option>
                                                <option value="Year">Year</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Price (USD)</label>
                                            <input type="number" class="form-control" name="price">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control textarea_editor" rows="8" id="description" name="description"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Upload Photo</label>
                                            <input type="file" id="input-file-now" class="dropify" name="photo">
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">View Package</h4>
                    <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <form class="row" id="updateForm" enctype="multipart/form-data" method="post">
                                        
                                        <input type="hidden" class="form-control" id="id" name="id">

                                        <div class="form-group col-12">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Duration</label>
                                            <input type="number" class="form-control" id="periodDuration" name="periodDuration">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Unit</label>
                                            <select class="form-select" id="periodUnit" name="periodUnit">
                                                <option value="Day">Day</option>
                                                <option value="Week">Week</option>
                                                <option value="Month">Month</option>
                                                <option value="Year">Year</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Price (USD)</label>
                                            <input type="number" class="form-control" id="price" name="price">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label" id="createdOn">Created On</label>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control textarea_editor" rows="8" id="edit_description" name="description"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-9">
                                            <label class="form-label">Upload Photo</label>
                                            <input type="file" id="input-file-now" class="dropify" name="photo">
                                        </div>
                                        
                                        <div class="form-group col-3">
                                            <label class="form-label">Current Photo</label>
                                            <img src="" id="viewPhoto" class="form-control" alt="">
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
            
            var url = "{{ url('rubi/dashboard/readPackage/:limit') }}";
            function configureUrl()
            {
                url = "{{ url('rubi/dashboard/readPackage/:limit') }}";
                url = url.replace(':limit', limit);
            }
            
            //configuration to limit the number of messages displayed
            var limit = 0;
            $(document).on('click', '#btnNext', function(e) {
                limit = limit + 12; readPackages();
            });
            $(document).on('click', '#btnPrev', function(e) {
                limit = limit - 12; if(limit < 0) { limit = 0; } readPackages();
            });
            
            readPackages();
            
            //read packages
            function readPackages()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#packageTable').html(''); 
                        
                        $.each(response.data,function(key,item){
                            //display badges
                            var status_badge = '';
                            var status_button = '';
                            
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
                            
                            //SORTING Data
                            var name = item.name.slice(0,15);
                            var price = item.price+' USD';
                            var period = item.periodDuration+' '+item.periodUnit;
                            
                            $('#packageTable').append('<tr>\
                                <td>'+name+'</td>\
                                <td>'+price+'</td>\
                                <td>'+period+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        '+status_button+'\
                                        <button id="btnView" value="'+item.id+'" class="btn btn-light"><i class="fas fa-eye"></i></button>\
                                        <button id="btnDelete" value="'+item.id+'" class="btn btn-dark"><i class="fas fa-trash"></i></button>\
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
                    type: "POST", url: "{{ url('rubi/dashboard/createPackage') }}",
                    data: formData, contentType:false, processData:false,
                    success: function(response){
                        if(response.status==600)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnCreate").prop("disabled", false).text("Create");
                        }
                        else if(response.status == 400)
                        {
                            $("#btnCreate").prop("disabled", false).text("Create");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnCreate").prop("disabled", false).text("Create");
                            $('#createForm')[0].reset(); //FORM RESET INPUT
                            readPackages();
                            
                            Swal.fire({ title: 'Success', text: "Package Created",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });

            //Delete
            $(document).on('click', '#btnDelete', function(e) {
                
                var id = $(this).val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: '',
                    icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) 
                    { 
                        //Delete ajax code
                        var data = { 'id':id }
                        $.ajax({
                            type:"PUT",
                            url: "{{ url('rubi/dashboard/deletePackage') }}",
                            data:data,
                            dataType:"json",
                            success: function(response){
                                if(response.status == 400)
                                {
                                    toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                                    readPackages();
                                }
                                else if(response.status == 200)
                                {
                                    toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                                    readPackages();
                                }
                            }
                        });
                    }
                })
            });

            //View
            $(document).on('click', '#btnView', function(e){
                e.preventDefault();
                var id = $(this).val(); //get message id
                var urlView = '{{ url("rubi/dashboard/readOnePackage/:id") }}'; urlView = urlView.replace(':id', id);
                $.ajax({
                    type:"GET", url:urlView, dataType:"json",
                    success: function(response)
                    {
                        $('#viewModal').modal('show');  //OPEN MODAL
                        
                        //format time
                        formatTime(response.data.created_at);
                        
                        $('#createdOn').html('Created On: <br> '+'<b>'+date+time+'</b>');
                        $('#name').val(response.data.name);
                        $('#id').val(response.data.id);
                        $('#periodDuration').val(response.data.periodDuration);
                        $('#periodUnit').val(response.data.periodUnit);
                        $('#price').val(response.data.price);
                        $('#description').val(response.data.description);
                        $('#viewPhoto').attr('src',response.data.photo);
                    }
                });
            });

            //update status
            $(document).on('click', '#btnChangeStatus', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var data = { 'id':id }
                $.ajax({
                    type:"PUT",
                    url: "{{ url('rubi/dashboard/updatePackageStatus') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readPackages();
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readPackages();
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
                    type: "POST", url: "{{ url('rubi/dashboard/updatePackage') }}",
                    data: formData, contentType:false, processData:false,
                    success: function(response){
                        if(response.status==600)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnUpdate").prop("disabled", false).text("Update");
                        }
                        else if(response.status == 400)
                        {
                            $("#btnUpdate").prop("disabled", false).text("Update");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnUpdate").prop("disabled", false).text("Update");
                            $('#updateForm')[0].reset(); //FORM RESET INPUT
                            readPackages();
                            $('#viewModal').modal('hide');  //CLOSE MODAL
                            
                            Swal.fire({ title: 'Success', text: "Package Updated",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                        }
                    }
                });
            });
        });
        </script>
        @endsection