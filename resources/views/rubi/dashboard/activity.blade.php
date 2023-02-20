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
            </div>
        </div>
    </div>
    
    {{-- content --}}
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <input type="text" class="form-control" placeholder="Search here">
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title" id="dataCount"></h4>
                    <div class="table-responsive">
                        <table class="table color-table purple-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>User Type</th>
                                    <th>Activity</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="activityTable">
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
            
            var url = "{{ url('rubi/dashboard/readActivities/:limit') }}";
            function configureUrl()
            {
                url = "{{ url('rubi/dashboard/readActivities/:limit') }}";
                url = url.replace(':limit', limit);
            }
            
            //configuration to limit the number of messages displayed
            var limit = 0;
            $(document).on('click', '#btnNext', function(e) {
                limit = limit + 20; readActivities();
            });
            $(document).on('click', '#btnPrev', function(e) {
                limit = limit - 20; if(limit < 0) { limit = 0; } readActivities();
            });
            
            readActivities();
            
            //read packages
            function readActivities()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#activityTable').html(''); 
                        
                        $.each(response.data,function(key,item){
                            
                            $('#activityTable').append('<tr>\
                                <td>'+item.+'</td>\
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
        });
        </script>
        @endsection