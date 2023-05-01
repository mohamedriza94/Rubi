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
            <button id="btnSortAll" class="btn btn-outline-primary font-18">All</button>
            <button id="btnSortShortlisted" class="btn btn-outline-info font-18">Shortlisted</button>
            <button id="btnSortRejected" class="btn btn-outline-danger font-18">Rejected</button>
            <input placeholder="Search" class="form-control" id="search">
        </div>

                <h4 class="card-title" id="dataCount"></h4>
                <div class="table-responsive">
                    <table class="table color-table purple-table">
                        <thead>
                            <tr>
                                <th>Vacancy</th>
                                <th>Name</th>
                                <th>Email</th>
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

{{-- view modal --}}
<div class="modal bs-example-modal-lg animated fadeIn" id="viewModal" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">View Application</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="row" id="updateForm" enctype="multipart/form-data" method="post">
                                    
                                    <div class="form-group col-12">
                                        <label class="form-label" id="sentOn"></label>
                                    </div>
                                    
                                    <div class="form-group col-12">
                                        <label class="form-label">Candidate Name</label>
                                        <input class="form-control" id="name" readonly>
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label class="form-label">Candidate Email</label>
                                        <input class="form-control" id="email" readonly>
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label class="form-label">Candidate Telephone</label>
                                        <input class="form-control" id="telephone" readonly>
                                    </div>
                                    
                                    <div class="form-group col-12">
                                        <label class="form-label">Cover Letter</label>
                                        <textarea class="form-control" id="coverLetter" readonly></textarea>
                                    </div>
                                    
                                    <div class="form-group col-12">
                                        <label class="form-label">Resume</label>
                                        <object data="" id="pdfView" type="application/pdf" width="100%" height="500px">
                                          </object>
                                        </div>
                                        
                                        <div class="form-group col-12 d-none" id="noteBox">
                                            <label class="form-label">Enter a Note</label>
                                            <textarea class="form-control" id="note"></textarea>
                                            </div>
                                            
                                            <div class="col-6">
                                                <div class="d-md-flex align-items-center">
                                                    <button id="btnShortlist" class="col-12 btn btn-info">Shortlist</button>
                                                </div>
                                            </div>
                                            
                                            <div class="col-6">
                                                <div class="d-md-flex align-items-center">
                                                    <button id="btnReject" class="col-12 btn btn-danger">Reject</button>
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
                
                var url = "{{ url('sub/dashboard/readApplication') }}";
                
                readApplication();
                
                //read applications
                function readApplication()
                {
                    $.ajax({
                        type: "GET", url:url, dataType:"json",
                        success:function(response){
                            $('#table').html(''); 
                            
                            $.each(response.data,function(key,item){
                                //display badges
                                var status_badge = '';
                                
                                //sorting STATUS
                                switch(item.status) {
                                    case 'shortlisted':
                                    status_badge = '<span class="label label-info">Shortlisted</span>'; //ACTIVE
                                    break;
                                    case 'rejected':
                                    status_badge = '<span class="label label-danger">Rejected</span>'; //ACTIVE
                                    break;
                                    case 'recruited':
                                    status_badge = '<span class="label label-success">Recruited</span>'; //INACTIVE
                                    break;
                                    case 'pending':
                                    status_badge = '<span class="label label-warning">Pending</span>'; //INACTIVE
                                    break;
                                }
                                
                                //format time
                                formatTime(item.created_at);
                                
                                $('#table').append('<tr>\
                                    <td>'+item.vacancy+'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.email+'</td>\
                                    <td>'+status_badge+'</td>\
                                    <td>\
                                        <div class="btn-group m-b-10 m-r-10">\
                                            <button id="btnView" value="'+item.id+'" class="btn btn-primary">Open</button>\
                                        </div>\
                                    </td>\
                                </tr>'); 
                            });
                        }
                    });
                }
                
                var applicationID = '';
                //View
                $(document).on('click', '#btnView', function(e){
                    e.preventDefault();
                    applicationID = $(this).val(); //get message id
                    var urlView = '{{ url("sub/dashboard/readOneApplication/:id") }}'; urlView = urlView.replace(':id', applicationID);
                    $.ajax({
                        type:"GET", url:urlView, dataType:"json",
                        success: function(response)
                        {
                            $('#viewModal').modal('show');  //OPEN MODAL
                            
                            //format time
                            formatTime(response.data.created_at);
                            
                            applicationID = response.data.id;
                            $('#sentOn').html('<label class="form-label" id="sentOn"><b>Received On:</b> '+date+time+'</label>');
                            $('#name').val(response.data.name);
                            $('#email').val(response.data.email);
                            $('#telephone').val(response.data.telephone);
                            $('#coverLetter').val(response.data.coverLetter);

                            $('#pdfView').attr('data',response.data.cv);
                            
                            //sorting STATUS
                            switch(response.data.status) {
                                case 'pending':
                                    $('#btnShortlist').removeClass('d-none');
                                    $('#btnReject').removeClass('d-none');
                                break;
                                default:
                                    $('#btnShortlist').addClass('d-none');
                                    $('#btnReject').addClass('d-none');
                                break;
                            }
                        }
                    });
                });
                
                //shortlist
                $(document).on('click', '#btnShortlist', function(e) {
                    e.preventDefault();
                    //check if note box is visible
                    var noteBox = document.getElementById("noteBox");
                    if (!noteBox.classList.contains("d-none")) 
                    {
                        $("#btnShortlist").prop("disabled", true).text("Shortlisting...");
                        var note = $('#note').val();
                        var data = { 'note':note, 'id':applicationID }
                        $.ajax({
                            type: "put", url: "{{ url('sub/dashboard/shortlistApplication') }}",
                            data: data,
                            success: function(response){
                                if(response.status==800)
                                {
                                    $.each(response.errors,function(key,error)
                                    {
                                        toastMessage = '';
                                        toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                                    });
                                    
                                    $("#btnShortlist").prop("disabled", false).text("Shortlist");
                                }
                                else if(response.status == 400 || response.status == 600)
                                {
                                    $("#btnShortlist").prop("disabled", false).text("Shortlist");
                                    toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                                }
                                else if(response.status == 200)
                                {
                                    $('#noteBox').addClass('d-none');
                                    $("#btnShortlist").prop("disabled", false).text("Shortlist");
                                    readApplication();
                                    
                                    Swal.fire({ title: 'Success', text: "Candidate Shortlisted",
                                    icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                                    
                                }
                            }
                        });
                    } 
                    else 
                    {
                        $('#noteBox').removeClass('d-none');
                    }
                });
                
                //reject
                $(document).on('click', '#btnReject', function(e) {
                    e.preventDefault();
                    //check if note box is visible
                    var noteBox = document.getElementById("noteBox");
                    if (noteBox.classList.contains("d-none")) 
                    {
                        $("#btnReject").prop("disabled", true).text("Rejecting...");
                        var note = $('#note').val();
                        var data = { 'note':note, 'id':applicationID }
                        $.ajax({
                            type: "put", url: "{{ url('sub/dashboard/rejectApplication') }}",
                            data: data,
                            success: function(response){
                                if(response.status==800)
                                {
                                    $.each(response.errors,function(key,error)
                                    {
                                        toastMessage = '';
                                        toastType = 'error'; toastMessage += error; showToast(); //TOAST ALERT
                                    });
                                    
                                    $("#btnReject").prop("disabled", false).text("Reject");
                                }
                                else if(response.status == 400 || response.status == 600)
                                {
                                    $("#btnReject").prop("disabled", false).text("Reject");
                                    toastType = 'error'; toastMessage = response.message; showToast(); //TOAST ALERT
                                }
                                else if(response.status == 200)
                                {
                                    $('#noteBox').addClass('d-none');
                                    $("#btnReject").prop("disabled", false).text("Reject");
                                    readApplication();
                                    
                                    Swal.fire({ title: 'Success', text: "Candidate Rejected",
                                    icon: 'success', confirmButtonColor: '#3085d6', confirmButtonText: 'OK' });
                                    
                                }
                            }
                        });
                    } 
                    else 
                    {
                        $('#noteBox').removeClass('d-none');
                    }
                });

                //sort all
                $(document).on('click','#btnSortAll',function(e){
                    e.preventDefault();
                    url = "{{ url('sub/dashboard/readApplication') }}";
                    readApplication();
                });
                //sort shortlisted
                $(document).on('click','#btnSortShortlisted',function(e){
                    e.preventDefault();
                    url = "{{ url('sub/dashboard/readApplication/:type') }}";
                    url = url.replace(":type","shortlisted");
                    readApplication();
                });
                //sort rejected
                $(document).on('click','#btnSortRejected',function(e){
                    e.preventDefault();
                    url = "{{ url('sub/dashboard/readApplication/:type') }}";
                    url = url.replace(":type","rejected");
                    readApplication();
                });
                //search
                $(document).on('keyup','#search',function(e){
                    e.preventDefault();
                    if($(this).val().length == 0)
                    {
                    url = "{{ url('sub/dashboard/readApplication') }}";
                    url = url.replace(":search",$(this).val());
                    }
                    else
                    {
                    url = "{{ url('sub/dashboard/searchApplication/:search') }}";
                    url = url.replace(":search",$(this).val());
                    }
                    readApplication();
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
        
        
