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
        </div>
    </div>
</div>

{{-- content --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                
                <div class="btn-group m-b-10 m-r-10">
                    <button id="btnSortApplications" class="btn btn-outline-info font-18">Shortlisted Applicants</button>
                    <button id="btnSortEmployees" class="btn btn-outline-danger font-18">Employees</button>
                </div>
                
                <div class="table-responsive">
                    <table class="table color-table purple-table">
                        <thead id="tableHeader">
                            
                        </thead>
                        <tbody id="tableData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Register Modal --}}
<div class="modal bs-example-modal-lg animated fadeIn" id="createModal" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Register New Employee</h4>
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
                                        <input class="form-control" readonly id="email" name="email">
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
                                    
                                    <div class="form-group col-12">
                                        <label class="form-label">Photo</label>
                                        <input class="form-control" type="file" id="photo" name="photo">
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

{{-- View Employee Modal --}}
<div class="modal bs-example-modal-lg animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Employee Details</h4>
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
                                        <input class="form-control" id="view_fullname" readonly>
                                    </div>
                                    
                                    <div class="form-group col-3">
                                        <label class="form-label">Date of Birth</label>
                                        <input class="form-control" readonly id="view_dob">
                                    </div>
                                    
                                    <div class="form-group col-4">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" readonly id="view_email">
                                    </div>
                                    
                                    <div class="form-group col-4">
                                        <label class="form-label">Telephone</label>
                                        <input class="form-control" readonly id="view_telephone">
                                    </div>
                                    
                                    <div class="form-group col-4">
                                        <label class="form-label">Choose Department</label>
                                        <input class="form-control" readonly id="view_department">
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-12">
                                        <img id="view_photo" class="col-12">
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
        
        var url = "{{ url('sub/dashboard/readApplication/:type') }}";
        url = url.replace(':type','shortlisted');
        
        readApplication();
        readDepartments();
        
        //read applications
        function readApplication()
        {
            url = "{{ url('sub/dashboard/readApplication/:type') }}";
            url = url.replace(':type','shortlisted');
            
            $('#tableHeader').html('<tr>\
                <th>Vacancy</th>\
                <th>Name</th>\
                <th>Email</th>\
                <th>Action</th>\
            </tr>');
            
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#tableData').html(''); 
                    
                    $.each(response.data,function(key,item){
                        //format time
                        formatTime(item.created_at);
                        
                        $('#tableData').append('<tr>\
                            <td>'+item.vacancy+'</td>\
                            <td>'+item.name+'</td>\
                            <td>'+item.email+'</td>\
                            <td>\
                                <div class="btn-group m-b-10 m-r-10">\
                                    <button id="btnView" value="'+item.email+'" class="btn btn-success">Register as Employee</button>\
                                </div>\
                            </td>\
                        </tr>'); 
                    });
                }
            });
        }
        
        //read employees
        function readEmployees()
        {
            url = "{{ url('sub/dashboard/readEmployees') }}";
            
            $('#tableHeader').html('<tr>\
                <th>Fullname</th>\
                <th>Photo</th>\
                <th>Department</th>\
                <th>Employed On</th>\
                <th>Status</th>\
                <th>Action</th>\
            </tr>');
            
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    $('#tableData').html(''); 
                    
                    //display badges
                    var status_badge = ''; var status_button = '';
                    
                    $.each(response.data,function(key,item){
                        //format time
                        formatTime(item.created_at);
                        
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
                        
                        $('#tableData').append('<tr>\
                            <td>'+item.fullname+'</td>\
                            <td><img src="'+item.photo+'" style="border-radius:200px; width:50px;"></td>\
                            <td>'+item.department+'</td>\
                            <td>'+date+time+'</td>\
                            <td>'+status_badge+'</td>\
                            <td>\
                                <div class="btn-group m-b-10 m-r-10">\
                                    '+status_button+'\
                                    <button id="btnViewEmployee" value="'+item.id+'" class="btn btn-primary">View</button>\
                                </div>\
                            </td>\
                        </tr>'); 
                    });
                }
            });
        }
        
        //read departments into select option
        function readDepartments()
        {
            $.ajax({
                type: "GET", url:"{{ url('sub/dashboard/readActiveDepartments') }}", dataType:"json",
                success:function(response){
                    $('#department').html(''); 
                    
                    $.each(response.data,function(key,item){
                        
                        $('#department').append('<option value="'+item.id+'">'+item.name+'</option>'); 
                    });
                }
            });
        }
        
        //sort shortlisted applicants
        $(document).on('click','#btnSortApplications',function(e){
            e.preventDefault();
            
            readApplication();
        });
        //sort employees
        $(document).on('click','#btnSortEmployees',function(e){
            e.preventDefault();
            
            readEmployees();
        });
        //Update status
        $(document).on('click', '#btnChangeStatus', function(e) {
            e.preventDefault();
            var id = $(this).val();
            var data = { 'id':id }
            $.ajax({
                type:"PUT",
                url: "{{ url('sub/dashboard/updateEmployeeStatus') }}",
                data:data,
                dataType:"json",
                success: function(response){
                    if(response.status == 400)
                    {
                        toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                        readEmployees();
                    }
                    else if(response.status == 200)
                    {
                        toastType = 'success'; toastMessage = response.message; showToast(); //TOAST ALERT
                        readEmployees();
                    }
                }
            });
        });
        //open register employee modal
        $(document).on('click', '#btnView', function(e){
            e.preventDefault();
            var email = $(this).val(); //get email
            $('#email').val(email);
            $('#createModal').modal('show');  //OPEN MODAL
        });
        //open employee details modal
        $(document).on('click', '#btnViewEmployee', function(e){
            e.preventDefault();
            var id = $(this).val(); //get id
            $('#viewModal').modal('show');  //OPEN MODAL

            url = "{{ url('sub/dashboard/readOneEmployee/:id') }}";
            url = url.replace(":id",id);
            
            $.ajax({
                type: "GET", url:url, dataType:"json",
                success:function(response){
                    
                    $('#view_department').val(response.data.department);
                    $('#view_fullname').val(response.data.fullname);
                    $('#view_dob').val(response.data.dob);
                    $('#view_email').val(response.data.email);
                    $('#view_photo').attr('src',response.data.photo);
                    $('#view_telephone').val(response.data.telephone);
                }
            });
        });
        //Create
        $(document).on('click', '#btnCreate', function(e) {
                e.preventDefault();
                
                $("#btnCreate").prop("disabled", true).text("Creating...");
                
                let formData = new FormData($('#createForm')[0]);
                $.ajax({
                    type: "POST", url: "{{ url('sub/dashboard/createEmployee') }}",
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
                            
                            Swal.fire({ title: 'Success', text: "Employee Registered",
                            icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                            
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
                selector: "textarea.mymce",
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


