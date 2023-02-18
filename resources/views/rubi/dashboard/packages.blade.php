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
                                            <textarea class="textarea_editor form-control" rows="5" name="description"></textarea>
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
                                status_button = '<button id="btnChangeStatus" class="btn btn-danger">Deactivate</button>';
                                break;
                                case 'inactive':
                                status_badge = '<span class="label label-danger">Inactive</span>'; //INACTIVE
                                status_button = '<button id="btnChangeStatus" class="btn btn-success">Activate</button>';
                                break;
                            }
                            
                            //SORTING Data
                            var name = item.name.slice(0,15);
                            var price = item.price;
                            var period = item.periodDuration+' '+item.periodUnit;
                            
                            $('#packageTable').append('<tr>\
                                <td>'+name+'</td>\
                                <td>'+price+'</td>\
                                <td>'+period+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        '+status_button+'\
                                        <button id="btnView" class="btn btn-light"><i class="fas fa-eye"></i></button>\
                                        <button id="btnDelete" class="btn btn-dark"><i class="fas fa-trash"></i></button>\
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
                                $("#btnCreate").prop("disabled", false).text("Send");
                                $('#createForm')[0].reset(); //FORM RESET INPUT
                                readPackages();
                                
                                Swal.fire({ title: 'Success', text: "Package Created",
                                icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                                
                            }
                        }
                    });
                });
            });
        </script>
        @endsection