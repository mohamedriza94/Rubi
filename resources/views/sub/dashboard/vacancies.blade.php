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
            <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-info d-none d-lg-block m-l-15 text-white"><i
                class="fa fa-plus-circle"></i> Post a Vacancy</button>
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
                                    <th>Position</th>
                                    <th>Salary Range</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table">
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
                                            <label class="form-label">Position</label>
                                            <input class="form-control" id="position">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control mymce" id="description">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Salary Range (LKR) <b>From:</b></label>
                                            <input class="form-control" type="number" min="1" id="salaryFrom">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label"><b>To:</b></label>
                                            <input class="form-control" type="number" id="salaryTo">
                                        </div>
                                        
                                        <div class="form-group col-4">
                                            <label class="form-label">Type</label>
                                            <select class="form-select" id="type">
                                                <option value="Onsite">Onsite</option>
                                                <option value="Remote">Remote</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-4">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="status">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-4">
                                            <label class="form-label">End Date</label>
                                            <input class="form-control" type="date" id="end">
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center">
                                                <button type="submit" id="btnCreate" class="col-12 btn btn-info">Post</button>
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
                                    <form class="row" id="updateForm" enctype="multipart/form-data" method="post">
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label" id="postedOn"></label>
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Position</label>
                                            <input class="form-control" id="edit_position">
                                        </div>
                                        
                                        <div class="form-group col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control mymce" id="edit_description">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Salary Range (LKR) <b>From:</b></label>
                                            <input class="form-control" type="number" min="1" id="edit_salaryFrom">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label"><b>From:</b></label>
                                            <input class="form-control" type="number" id="edit_salaryTo">
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">Type</label>
                                            <select class="form-select" id="edit_type">
                                                <option value="Onsite">Onsite</option>
                                                <option value="Remote">Remote</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-6">
                                            <label class="form-label">End Date</label>
                                            <input class="form-control" type="date" id="edit_end">
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="d-md-flex align-items-center">
                                                <button type="submit" id="btnUpdate" class="col-12 btn btn-info">Save Changes</button>
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
            
            var url = "{{ url('sub/dashboard/readVacancies') }}";
            function configureUrl()
            {
                url = "{{ url('sub/dashboard/readVacancies') }}";
            }

            readVacancies();
            
            //read vacancies
            function readVacancies()
            {
                configureUrl();
                $.ajax({
                    type: "GET", url:url, dataType:"json",
                    success:function(response){
                        $('#table').html(''); 
                        
                        $.each(response.data,function(key,item){
                            //display badges
                            var status_badge = ''; var status_button = '';
                            
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

                            //format time
                            formatTime(item.created_at);
                            
                            $('#table').append('<tr>\
                                <td>'+item.title+'</td>\
                                <td>'+item.salaryRange+'</td>\
                                <td>'+item.type+'</td>\
                                <td>'+status_badge+'</td>\
                                <td>\
                                    <div class="btn-group m-b-10 m-r-10">\
                                        '+status_button+'\
                                        <button id="btnView" value="'+item.id+'" class="btn btn-primary">View</button>\
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
                
                $("#btnCreate").prop("disabled", true).text("Posting...");

                var position = $('#position').val();
                var description = $('#description').val();
                var type = $('#type').val();
                var status = $('#status').val();
                var end = $('#end').val();
                var salary = $('#salaryFrom').val() + ' - ' + $('#salaryTo').val();
                
                var data = { 'position':position, 'description':description, 'salary':salary, 'type':type, 'status':status, 'end':end }
                $.ajax({
                    type: "POST", url: "{{ url('sub/dashboard/createVacancy') }}",
                    data: data,
                    success: function(response){
                        if(response.status==800)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnCreate").prop("disabled", false).text("Post");
                        }
                        else if(response.status == 400 || response.status == 600)
                        {
                            $("#btnCreate").prop("disabled", false).text("Post");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnCreate").prop("disabled", false).text("Post");
                            $('#createForm')[0].reset(); //FORM RESET INPUT
                            readVacancies();
                            
                            Swal.fire({ title: 'Success', text: "Vacancy Posted",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
                    }
                });
            });

            var vacancyID = '';
            var updatedSalary = '';
            //View
            $(document).on('click', '#btnView', function(e){
                e.preventDefault();
                var vacancyID = $(this).val(); //get message id
                var urlView = '{{ url("sub/dashboard/readOneVacancy/:id") }}'; urlView = urlView.replace(':id', vacancyID);
                $.ajax({
                    type:"GET", url:urlView, dataType:"json",
                    success: function(response)
                    {
                        $('#viewModal').modal('show');  //OPEN MODAL
                        
                        //format time
                        formatTime(response.data.created_at);
                        
                        $('#edit_position').val(response.data.position);
                        $('#edit_description').val(response.data.description);
                        $('#edit_type').val(response.data.type);
                        $('#edit_end').val(response.data.end);
                        updatedSalary = response.data.salaryRange;
                        $('#postedOn').val(date+time);
                    }
                });
            });
            
            //Create
            $(document).on('click', '#btnUpdate', function(e) {
                e.preventDefault();
                
                $("#btnUpdate").prop("disabled", true).text("Saving...");
                var salary = '';
                var position = $('#edit_position').val();
                var description = $('#edit_description').val();
                var type = $('#edit_type').val();
                var end = $('#edit_end').val();

                //check if new salary range is entered
                if($('#edit_salaryFrom').val() != "" && $('#edit_salaryTo').val() != "")
                {
                    salary = $('#edit_salaryFrom').val() + ' - ' + $('#edit_salaryTo').val();
                }
                else
                {
                    salary = updatedSalary;
                }
                
                var data = { 'id':vacancyID, 'position':position, 'description':description, 'salary':salary, 'type':type, 'end':end }
                $.ajax({
                    type: "POST", url: "{{ url('sub/dashboard/updateVacancy') }}",
                    data: data,
                    success: function(response){
                        if(response.status==800)
                        {
                            $.each(response.errors,function(key,error)
                            {
                                toastMessage = '';
                                toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                            });
                            
                            $("#btnUpdate").prop("disabled", false).text("Save Changes");
                        }
                        else if(response.status == 400 || response.status == 600)
                        {
                            $("#btnUpdate").prop("disabled", false).text("Save Changes");
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        }
                        else if(response.status == 200)
                        {
                            $("#btnUpdate").prop("disabled", false).text("Save Changes");
                            $('#updateForm')[0].reset(); //FORM RESET INPUT
                            readVacancies();
                            
                            Swal.fire({ title: 'Success', text: "Vacancy Updated",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
                        }
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
                    url: "{{ url('sub/dashboard/updateVacancyStatus') }}",
                    data:data,
                    dataType:"json",
                    success: function(response){
                        if(response.status == 400)
                        {
                            toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readVacancies();
                        }
                        else if(response.status == 200)
                        {
                            toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                            readVacancies();
                        }
                    }
                });
            });
        });
    </script>



<script src="{{ asset('admin/assets/node_modules/tinymce/tinymce.min.js') }}"></script>
<script>
    $(document).ready(function() {

        if ($(".mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
    </script>
    @endsection


